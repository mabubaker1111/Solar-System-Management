<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Client\Client;
use App\Models\Business\Business;
use App\Models\Client\ServiceRequest;
use App\Models\Business\Service;
use App\Models\Worker\Worker;
// use App\Models\Worker\WorkerShift;
use App\Models\Worker\WorkerShiftBooking;
use App\Models\Worker\WorkerShift;
use App\Notifications\UserRegistered;
use App\Notifications\NewBusinessRegistered;
use App\Notifications\WorkerApproved;
use App\Notifications\NewServiceRequest;

class BusinessController extends Controller
{

    public function create()
    {
        // Workers with shifts and bookings loaded
        $workers = Worker::with('shifts.bookings', 'user')->get();

        // All services
        $services = Service::all();

        // Default date for booking check
        $request_date = now()->toDateString(); // ya jo date chahiye

        return view('business.client.add', compact('workers', 'services', 'request_date'));
    }
    // Show register form
    public function showRegisterForm()
    {
        try {
            return view('business.auth.register');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load registration form: ' . $e->getMessage());
        }
    }

    // Show Add Client Form
    public function showAddClientForm()
    {
        try {
            // Logged in business
            $business = \App\Models\Business\Business::where('owner_id', Auth::id())
                ->firstOrFail();

            // Business ki services
            $services = $business->services()->get();

            // Approved workers
            $workers = \App\Models\Worker\Worker::where('business_id', $business->id)
                ->where('status', 'approved')
                ->with('user')   // worker ka name
                ->get();

            // ⚠️ Add Client page par date abhi exist nahi hoti
            $request_date = null;

            return view('business.clients.add', compact(
                'services',
                'workers',
                'request_date'
            ));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function storeClient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'service_id' => 'required|exists:services,id',
            'deadline' => 'required|date',
            'worker_shift_id' => 'required|exists:worker_shifts,id',
        ]);

        // 1️⃣ Create USER (client)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client',
        ]);

        // 2️⃣ Create CLIENT
        $client = Client::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
        ]);

        // 3️⃣ Create SERVICE REQUEST
        $serviceRequest = ServiceRequest::create([
            'client_id' => $client->id,
            'service_id' => $request->service_id,
            'deadline' => $request->deadline,
            'description' => $request->description,
        ]);

        // 4️⃣ Assign WORKER SHIFT
        WorkerShiftBooking::create([
            'worker_shift_id' => $request->worker_shift_id,
            'client_request_id' => $serviceRequest->id,
            'booking_date' => $request->deadline,
        ]);

        return redirect()
            ->route('business.dashboard')
            ->with('success', 'Client added & worker assigned successfully');
    }

    public function store(Request $request)
    {
        return $this->storeClient($request);
    }



    // Show all clients of this business
    // public function clientsList()
    // {
    //     try {
    //         $business = \App\Models\Business\Business::where('owner_id', Auth::id())->firstOrFail();
    //         $clients = user::where('role', 'client')
    //             ->where('status', 'approved') // optional: only approved clients
    //             ->get();

    //         return view('business.clients.list', compact('clients'));
    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Failed to load clients: ' . $e->getMessage());
    //     }
    // }


    // Handle business registration
    public function register(Request $request)
    {
        try {
            $request->validate([
                'owner_name'    => 'required|string|max:255',
                'email'         => 'required|email|unique:users,email',
                'password'      => 'required|min:5|confirmed',
                'business_name' => 'required|string|max:255',
                'address'       => 'nullable|string',
                'city'          => 'nullable|string',
                'slots'         => 'nullable|integer|min:0',
                'business_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // 1️⃣ Create the business owner user
            $user = User::create([
                'name'     => $request->owner_name,
                'email'    => $request->email,
                'phone'    => $request->phone ?? null,
                'address'  => $request->address ?? null,
                'role'     => 'business',
                'status'   => 'pending',
                'password' => Hash::make($request->password),
            ]);

            $user->notify(new UserRegistered($user));

            // 2️⃣ Create business
            $business = new Business();
            $business->owner_id       = $user->id;
            $business->business_name  = $request->business_name;
            $business->business_Owner = $request->owner_name;
            $business->description    = $request->description ?? null;
            $business->address        = $request->address ?? null;
            $business->city           = $request->city ?? null;
            $business->slots          = $request->slots ?? 0;
            $business->status         = 'pending';

            // Handle image upload
            if ($request->hasFile('business_image')) {
                $image = $request->file('business_image');
                $imageName = time() . '_' . $image->getClientOriginalName();

                if (!file_exists(storage_path('app/public/business_images'))) {
                    mkdir(storage_path('app/public/business_images'), 0777, true);
                }

                $image->storeAs('public/business_images', $imageName);
                $business->image = 'business_images/' . $imageName;
            }

            $business->save();

            // Notify all SuperAdmins
            $superAdmins = User::where('role', 'superadmin')->get();
            foreach ($superAdmins as $admin) {
                $admin->notify(new NewBusinessRegistered($business));
            }

            return redirect('/')
                ->with('success', 'Your request is in process. Wait for approval.');
        } catch (\Exception $e) {
            return back()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    // Show login form
    public function showLoginForm()
    {
        try {
            return view('business.auth.login');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load login form: ' . $e->getMessage());
        }
    }

    // Handle login
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email'    => 'required|email',
                'password' => 'required',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user || $user->role !== 'business') {
                return back()->withErrors(['email' => 'Invalid business credentials.']);
            }

            if ($user->status !== 'approved') {
                return redirect('/')->with('error', 'Your request is in pending.');
            }

            $business = Business::where('owner_id', $user->id)->first();
            if (!$business || $business->status !== 'approved') {
                return back()->withErrors(['email' => 'Superadmin has not approved your business yet.']);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'business'])) {
                $request->session()->regenerate();
                return redirect()->route('business.dashboard');
            }

            return back()->withErrors(['email' => 'Invalid credentials.']);
        } catch (\Exception $e) {
            return back()->with('error', 'Login failed: ' . $e->getMessage());
        }
    }

    // Logout
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Logged out successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Logout failed: ' . $e->getMessage());
        }
    }

    // Dashboard
    public function dashboard()
    {
        try {
            $business = Business::where('owner_id', Auth::id())->firstOrFail();

            $totalRequests = ServiceRequest::where('business_id', $business->id)->count();
            $pending       = ServiceRequest::where('business_id', $business->id)
                ->where('status', 'pending')
                ->count();

            $latestRequests = ServiceRequest::where('business_id', $business->id)
                ->with(['client', 'service', 'worker'])
                ->latest()
                ->take(30)
                ->paginate(8);

            $notifications = auth()->user()->notifications()->latest()->take(10)->get();
            $unreadCount = auth()->user()->unreadNotifications()->count();

            return view('business.dashboard', compact(
                'business',
                'totalRequests',
                'pending',
                'latestRequests',
                'notifications',
                'unreadCount'
            ))->with('slots', $business->slots);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load dashboard: ' . $e->getMessage());
        }
    }

    // Show all client requests
    public function clientRequests()
    {
        try {
            $business = Business::where('owner_id', Auth::id())->firstOrFail();

            $requests = ServiceRequest::where('business_id', $business->id)
                ->with(['client', 'service', 'worker'])
                ->latest()
                ->orderBy('created_at', 'desc')
                ->paginate(8);

            $workers = Worker::where('business_id', $business->id)
                ->where('status', 'approved')
                ->get();

            $notifications = auth()->user()->notifications()->latest()->take(10)->get();
            $unreadCount = auth()->user()->unreadNotifications()->count();

            return view('business.requests', compact(
                'business',
                'requests',
                'workers',
                'notifications',
                'unreadCount'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load client requests: ' . $e->getMessage());
        }
    }

    // Approve client request
    public function acceptRequest($id)
    {
        try {
            $business = Business::where('owner_id', Auth::id())->firstOrFail();
            $req = ServiceRequest::where('id', $id)
                ->where('business_id', $business->id)
                ->firstOrFail();

            $req->status = 'approved';
            $req->save();

            return back()->with('success', 'Request approved.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve request: ' . $e->getMessage());
        }
    }

    // Reject client request
    public function rejectRequest($id)
    {
        try {
            $business = Business::where('owner_id', Auth::id())->firstOrFail();
            $req = ServiceRequest::where('id', $id)
                ->where('business_id', $business->id)
                ->firstOrFail();

            $req->status = 'rejected';
            $req->save();

            return back()->with('success', 'Request rejected.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject request: ' . $e->getMessage());
        }
    }

    // Show all workers
    public function workers()
    {
        try {
            $business = Business::where('owner_id', Auth::id())->firstOrFail();
            $workers = Worker::where('business_id', $business->id)
                ->with('user')
                ->get();

            return view('business.workers', compact('business', 'workers'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load workers: ' . $e->getMessage());
        }
    }

    // Assign worker to request
    public function assignWorker(Request $request)
    {
        try {
            $request->validate([
                'request_id' => 'required|exists:service_requests,id',
                'worker_id'  => 'required|exists:workers,id',
            ]);

            $business = Business::where('owner_id', Auth::id())->firstOrFail();
            $sr = ServiceRequest::where('id', $request->request_id)
                ->where('business_id', $business->id)
                ->firstOrFail();

            $worker = Worker::findOrFail($request->worker_id);
            if ($worker->status !== 'approved') {
                return back()->with('error', 'This worker is not approved.');
            }

            $sr->worker_id = $worker->id;
            $sr->status = 'assigned';
            $sr->save();

            if ($sr->client) {
                $sr->client->notify(new \App\Notifications\WorkerAssignedToClient($sr));
            }
            if ($worker->user) {
                $worker->user->notify(new \App\Notifications\AssignedRequestToWorker($sr));
            }

            return back()->with('success', 'Worker assigned successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to assign worker: ' . $e->getMessage());
        }
    }

    // Worker requests
    public function workersRequests()
    {
        try {
            $business = Business::where('owner_id', Auth::id())->firstOrFail();
            $workers = Worker::where('business_id', $business->id)
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->paginate(8);

            return view('business.workers.requests', compact('workers'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load worker requests: ' . $e->getMessage());
        }
    }

    public function approveWorker($id)
    {
        try {
            $worker = Worker::findOrFail($id);
            $business = Business::findOrFail($worker->business_id);

            if ($business->slots <= 0) {
                return back()->with('error', 'No available slots for this business.');
            }

            $this->updateWorkerStatus($worker, 'approved');
            $business->decrement('slots');
            $worker->user->notify(new WorkerApproved($worker));

            return redirect()->back()->with('success', 'Worker approved successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve worker: ' . $e->getMessage());
        }
    }

    public function rejectWorker($id)
    {
        try {
            $worker = Worker::findOrFail($id);
            $this->updateWorkerStatus($worker, 'rejected');

            return redirect()->back()->with('success', 'Worker rejected successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject worker: ' . $e->getMessage());
        }
    }

    // Helper to update worker + user status
    private function updateWorkerStatus(Worker $worker, $status)
    {
        try {
            $worker->status = $status;
            $worker->save();

            $user = $worker->user;
            $user->status = $status;
            $user->save();
        } catch (\Exception $e) {
            throw new \Exception('Failed to update worker status: ' . $e->getMessage());
        }
    }

    // Services CRUD
    public function services()
    {
        try {
            $business = Business::where('owner_id', Auth::id())->firstOrFail();
            $services = Service::where('business_id', $business->id)->orderBy('created_at', 'desc')->paginate(8);

            return view('business.services', compact('business', 'services'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load services: ' . $e->getMessage());
        }
    }

    public function addService(Request $request)
    {
        try {
            $request->validate([
                'name'  => 'required|string|max:255',
                'price' => 'required|numeric',
            ]);

            $business = Business::where('owner_id', Auth::id())->firstOrFail();

            Service::create([
                'business_id' => $business->id,
                'name'        => $request->name,
                'price'       => $request->price,
                'description' => $request->description ?? null,
            ]);

            return back()->with('success', 'Service added successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add service: ' . $e->getMessage());
        }
    }

    public function editService($id)
    {
        try {
            $service = Service::findOrFail($id);
            return view('business.services.edit', compact('service'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to edit service: ' . $e->getMessage());
        }
    }

    public function updateService(Request $request, $id)
    {
        try {
            $request->validate([
                'name'  => 'required|string|max:255',
                'price' => 'required|numeric',
            ]);

            $service = Service::findOrFail($id);
            $service->name = $request->name;
            $service->description = $request->description;
            $service->price = $request->price;
            $service->save();

            return redirect()->route('business.services')->with('success', 'Service updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update service: ' . $e->getMessage());
        }
    }

    public function deleteService($id)
    {
        try {
            $business = Business::where('owner_id', Auth::id())->firstOrFail();

            $service = Service::where('id', $id)
                ->where('business_id', $business->id)
                ->firstOrFail();

            $service->delete();

            return back()->with('success', 'Service deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete service: ' . $e->getMessage());
        }
    }

    public function assignedRequests()
    {
        try {
            $business = Business::where('owner_id', Auth::id())->firstOrFail();
            $requests = ServiceRequest::where('business_id', $business->id)
                ->whereNotNull('worker_id')
                ->with(['client', 'worker', 'service'])
                ->latest()
                ->get();

            return view('business.assigned_requests', compact('requests', 'business'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load assigned requests: ' . $e->getMessage());
        }
    }

    // Notifications
    public function notifications()
    {
        try {
            $notifications = auth()->user()->notifications()->latest()->orderBy('created_at', 'desc')->paginate(15);
            $unreadCount = auth()->user()->unreadNotifications()->count();

            return view('business.notifications.index', compact('notifications', 'unreadCount'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load notifications: ' . $e->getMessage());
        }
    }

    public function markAllNotificationsRead()
    {
        try {
            auth()->user()->unreadNotifications->markAsRead();
            return back()->with('success', 'All notifications marked as read.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to mark notifications as read: ' . $e->getMessage());
        }
    }

    public function completeRequest($id)
    {
        try {
            $business = Business::where('owner_id', Auth::id())->firstOrFail();
            $req = ServiceRequest::where('id', $id)
                ->where('business_id', $business->id)
                ->firstOrFail();

            $req->status = 'completed';
            $req->save();

            return back()->with('success', 'Request marked as completed.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to complete request: ' . $e->getMessage());
        }
    }

    public function completedRequests()
    {
        try {
            $business = Business::where('owner_id', Auth::id())->firstOrFail();
            $requests = ServiceRequest::where('business_id', $business->id)
                ->where('status', 'completed')
                ->with(['client', 'service', 'worker'])
                ->latest()
                ->paginate(8);

            return view('business.completed_requests', compact('requests', 'business'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load completed requests: ' . $e->getMessage());
        }
    }
}
