<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Worker\Worker;
use App\Models\User;
use App\Models\Business\Business;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserRegistered;
use App\Models\Client\ServiceRequest;
use App\Notifications\WorkerRequest;
use App\Notifications\WorkerAcceptedRequest;
use App\Notifications\WorkerCancelledRequest;

class WorkerController extends Controller
{
    public function acceptRequest($id)
    {
        try {
            $worker = Worker::where('user_id', Auth::id())->firstOrFail();
            $req = ServiceRequest::where('id', $id)
                ->where('worker_id', $worker->id)
                ->firstOrFail();

            $req->status = 'approved';
            $req->save();

            if ($req->business && $req->business->owner) {
                $req->business->owner->notify(new WorkerAcceptedRequest($req));
            }

            return back()->with('success', 'Request accepted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to accept request: ' . $e->getMessage());
        }
    }

    public function cancelRequest(Request $request, $id)
    {
        try {
            $request->validate(['reason' => 'required|string|max:500']);

            $worker = Worker::where('user_id', Auth::id())->firstOrFail();
            $req = ServiceRequest::where('id', $id)
                ->where('worker_id', $worker->id)
                ->firstOrFail();

            $req->status = 'pending';
            $req->message = $request->reason;
            $req->save();

            if ($req->business && $req->business->owner) {
                $req->business->owner->notify(new WorkerCancelledRequest($req));
            }

            return back()->with('success', 'Request cancelled successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to cancel request: ' . $e->getMessage());
        }
    }

    public function completeRequest(Request $request, $id)
    {
        try {
            $worker = Worker::where('user_id', Auth::id())->firstOrFail();
            $req = ServiceRequest::where('id', $id)
                ->where('worker_id', $worker->id)
                ->firstOrFail();

            // Validate modal inputs
            $request->validate([
                'full_payment' => 'required|numeric',
                'discount'     => 'nullable|numeric',
                'received_amount' => 'nullable|numeric',
                'comment' => 'nullable|string',
            ]);

            // Calculate remaining amount
            $remaining = $request->full_payment - ($request->discount ?? 0) - ($request->received_amount ?? 0);

            // Save Payment Details in new table
            \DB::table('service_payments')->insert([
                'service_request_id' => $req->id,
                'worker_id'          => $worker->id,
                'service_name'       => $req->service->name,
                'full_payment'       => $request->full_payment,
                'discount'           => $request->discount,
                'received_amount'    => $request->received_amount,
                'remaining_amount'   => $remaining,
                'comment'            => $request->comment,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);

            // Mark request as completed
            $req->status = 'completed';
            $req->save();

            return back()->with('success', 'Task completed and payment recorded successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to complete request: ' . $e->getMessage());
        }
    }

    public function completedRequests()
    {
        try {
            $worker = Worker::where('user_id', Auth::id())->firstOrFail();

            $requests = ServiceRequest::where('worker_id', $worker->id)
                ->where('status', 'completed')
                ->with(['client', 'service', 'business'])
                ->latest()
                ->paginate(8);

            return view('worker.completed_requests', compact('worker', 'requests'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load completed requests: ' . $e->getMessage());
        }
    }

    public function showRegisterForm()
    {
        try {
            $businesses = Business::where('status', 'approved')->get();
            return view('worker.auth.register', compact('businesses'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load registration form: ' . $e->getMessage());
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name'        => 'required|string|max:255',
                'email'       => 'required|email|unique:users,email',
                'phone'       => 'required|string|max:20',
                'address'     => 'required|string',
                'password'    => 'required|min:5|confirmed',
                'business_id' => 'required|exists:businesses,id',
                'skill'       => 'required|string|max:255',
                'experience'  => 'required|string|max:255',
                'photo'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $business = Business::findOrFail($request->business_id);
            $currentWorkers = Worker::where('business_id', $business->id)
                ->where('status', 'approved')
                ->count();

            if ($currentWorkers >= $business->slots) {
                return redirect('/')->with('error', 'All slots for this business are full.')->withInput();
            }

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'address'  => $request->address,
                'role'     => 'worker',
                'status'   => 'pending',
                'password' => Hash::make($request->password),
            ]);

            $photoPath = $request->hasFile('photo')
                ? $request->file('photo')->store('workers', 'public')
                : null;

            $worker = Worker::create([
                'user_id'     => $user->id,
                'business_id' => $request->business_id,
                'skill'       => $request->skill,
                'experience'  => $request->experience,
                'status'      => 'pending',
                'photo'       => $photoPath,
            ]);

            $user->notify(new UserRegistered($user));

            if ($business->owner) {
                $business->owner->notify(new WorkerRequest($worker, $business));
            }

            return redirect('/')->with('success', 'Your request has been sent. Wait for business approval.');
        } catch (\Exception $e) {
            return back()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    public function showLoginForm()
    {
        try {
            return view('worker.auth.login');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load login form: ' . $e->getMessage());
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email', 'password' => 'required']);

            $user = User::where('email', $request->email)
                ->where('role', 'worker')
                ->first();

            if (!$user) {
                return back()->withErrors(['email' => 'Worker not found.']);
            }

            if ($user->status !== 'approved') {
                return back()->withErrors(['email' => 'Your registration is still pending approval.']);
            }

            $worker = Worker::where('user_id', $user->id)->first();
            if (!$worker) {
                return back()->withErrors(['email' => 'Worker profile not found.']);
            }

            $business = Business::find($worker->business_id);
            if (!$business || $business->status !== 'approved') {
                return back()->withErrors(['email' => 'Your associated business is not approved yet.']);
            }

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'worker'])) {
                $request->session()->regenerate();
                return redirect()->route('worker.dashboard');
            }

            return back()->withErrors(['email' => 'Invalid credentials']);
        } catch (\Exception $e) {
            return back()->with('error', 'Login failed: ' . $e->getMessage());
        }
    }

    public function dashboard()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('worker.login')->withErrors('Please login first.');
            }

            $worker = Worker::where('user_id', $user->id)->first();
            if (!$worker) {
                return redirect()->route('worker.login')->withErrors('Worker profile not found.');
            }

            $notifications = $user->notifications()->latest()->get();
            $user->unreadNotifications->markAsRead();

            return view('worker.dashboard', compact('worker', 'user', 'notifications'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load dashboard: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        try {
            if (Auth::check()) {
                Auth::logout();
            }
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/')->with('success', 'Logged out successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Logout failed: ' . $e->getMessage());
        }
    }

    public function notifications()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('worker.login')->withErrors('Please login first.');
            }

            $notifications = $user->notifications()->latest()->get();
            $user->unreadNotifications->markAsRead();

            return view('worker.notifications', compact('user', 'notifications'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load notifications: ' . $e->getMessage());
        }
    }

    public function assignedRequests()
    {
        try {
            $user = Auth::user();
            $worker = Worker::where('user_id', $user->id)->firstOrFail();

            $requests = ServiceRequest::where('worker_id', $worker->id)
                ->with(['client', 'service', 'business'])
                ->latest()
                ->get();

            $notifications = $user->notifications()->latest()->get();

            return view('worker.assigned_requests', compact('worker', 'requests', 'notifications', 'user'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load assigned requests: ' . $e->getMessage());
        }
    }

    public function profile($id)
    {
        try {
            $worker = Worker::with('user', 'business')->findOrFail($id);
            return view('worker.profile', compact('worker'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load profile: ' . $e->getMessage());
        }
    }

    public function myRequests()
    {
        try {
            $worker = Worker::where('user_id', Auth::id())->firstOrFail();

            $requests = ServiceRequest::where('worker_id', $worker->id)
                ->with(['client', 'service', 'business'])
                ->latest()
                ->paginate(8);

            return view('worker.my_requests', compact('requests', 'worker'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load requests: ' . $e->getMessage());
        }
    }
}
