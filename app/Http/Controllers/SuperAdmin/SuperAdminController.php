<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Business\Business;
use App\Models\Client\ServiceRequest;
use App\Models\Worker\Worker;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewBusinessRegistered;
use App\Notifications\NewWorkerRegistered;
use App\Notifications\BusinessApproved;

class SuperAdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        try {
            $clients        = User::where('role', 'client')->get();
            $businesses     = Business::all();
            $workers        = Worker::with('user')->get();
            $clientRequests = ServiceRequest::with(['client', 'service', 'worker', 'business'])->latest()->paginate(8);
            $workerRequests = Worker::where('status', 'pending')->get();

            // Super Admin notifications
            $notifications = auth()->user()->notifications()->latest()->get();

            return view('superadmin.dashboard', compact(
                'clients',
                'businesses',
                'workers',
                'clientRequests',
                'workerRequests',
                'notifications'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Dashboard data load failed: ' . $e->getMessage());
        }
    }

    // Clients
    public function clients()
    {
        try {
            $clients = User::where('role', 'client')->orderBy('created_at', 'desc')->paginate(8);
            return view('superadmin.clients.index', compact('clients'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load clients: ' . $e->getMessage());
        }
    }

    public function deleteClient($id)
    {
        try {
            $client = User::findOrFail($id);
            $client->delete();

            return back()->with('success', 'Client deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete client: ' . $e->getMessage());
        }
    }

    // Businesses
    public function businesses()
    {
        try {
            $businesses = Business::with('owner')->orderBy('created_at', 'desc')->paginate(8);
            return view('superadmin.businesses.index', compact('businesses'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load businesses: ' . $e->getMessage());
        }
    }

    public function pendingBusinesses()
    {
        try {
            $businesses = Business::with('owner')->where('status', 'pending')->get();
            return view('superadmin.businesses.pending', compact('businesses'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load pending businesses: ' . $e->getMessage());
        }
    }

    public function approveBusiness($id)
    {
        try {
            $business = Business::findOrFail($id);
            $business->status = 'approved';
            $business->save();

            if ($business->owner) {
                $business->owner->status = 'approved';
                $business->owner->save();
                $business->owner->notify(new BusinessApproved($business));
            }

            return back()->with('success', 'Business approved successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve business: ' . $e->getMessage());
        }
    }

    public function rejectBusiness($id)
    {
        try {
            $business = Business::findOrFail($id);
            $business->status = 'rejected';
            $business->save();

            if ($business->owner) {
                $business->owner->status = 'rejected';
                $business->owner->save();
            }

            return back()->with('success', 'Business rejected successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject business: ' . $e->getMessage());
        }
    }

    public function deleteBusiness($id)
    {
        try {
            $business = Business::findOrFail($id);
            $business->delete();

            return back()->with('success', 'Business deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete business: ' . $e->getMessage());
        }
    }

    // Workers
    public function workers()
    {
        try {
            $workers = Worker::with('user')->orderBy('created_at', 'desc')->paginate(8);
            return view('superadmin.workers.index', compact('workers'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load workers: ' . $e->getMessage());
        }
    }

    public function approveWorker($id)
    {
        try {
            $worker = Worker::findOrFail($id);
            $worker->status = 'approved';
            $worker->save();

            if ($worker->user) {
                $worker->user->status = 'approved';
                $worker->user->save();
            }

            return back()->with('success', 'Worker approved successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to approve worker: ' . $e->getMessage());
        }
    }

    public function rejectWorker($id)
    {
        try {
            $worker = Worker::findOrFail($id);
            $worker->status = 'rejected';
            $worker->save();

            if ($worker->user) {
                $worker->user->status = 'rejected';
                $worker->user->save();
            }

            return back()->with('success', 'Worker rejected successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reject worker: ' . $e->getMessage());
        }
    }

    public function markRequestComplete($id)
    {
        try {
            $request = ServiceRequest::findOrFail($id);
            $request->status = 'completed';
            $request->save();

            return back()->with('success', 'Request marked as completed.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to mark request as completed: ' . $e->getMessage());
        }
    }

    public function completedRequests()
    {
        try {
            $completedRequests = ServiceRequest::where('status', 'completed')
                ->with(['client', 'service', 'business', 'worker'])
                ->latest()
                ->paginate(8);

            return view('superadmin.requests.completed', compact('completedRequests'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load completed requests: ' . $e->getMessage());
        }
    }

    // Client Requests
    public function clientRequests()
    {
        try {
            $requests = ServiceRequest::with(['client', 'service', 'worker', 'business'])->latest()->orderBy('created_at', 'desc')->paginate(8);
            return view('superadmin.requests.client', compact('requests'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load client requests: ' . $e->getMessage());
        }
    }

    // Worker Requests
    public function workerRequests()
    {
        try {
            $requests = Worker::with('user')->where('status', 'pending')->orderBy('created_at', 'desc')->paginate(8);
            return view('superadmin.requests.worker', compact('requests'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load worker requests: ' . $e->getMessage());
        }
    }

    // View single client
    public function viewClient($id)
    {
        try {
            $client = User::where('role', 'client')->findOrFail($id);
            $requests = ServiceRequest::where('client_id', $client->id)
                ->with(['service', 'business', 'worker'])
                ->get();

            return view('superadmin.client.view', compact('client', 'requests'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to view client: ' . $e->getMessage());
        }
    }

    // View single business
    public function viewBusiness($id)
    {
        try {
            $business = Business::findOrFail($id);
            $services = $business->services;
            $requests = ServiceRequest::where('business_id', $business->id)
                ->with(['client', 'worker'])
                ->get();

            return view('superadmin.businesses.view', compact('business', 'services', 'requests'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to view business: ' . $e->getMessage());
        }
    }

    // Logout
    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('frontend.home');
        } catch (\Exception $e) {
            return back()->with('error', 'Logout failed: ' . $e->getMessage());
        }
    }

    public function notifications()
    {
        try {
            $notifications = auth()->user()->notifications()->latest()->paginate(15);
            return view('superadmin.includes.notifications', compact('notifications'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load notifications: ' . $e->getMessage());
        }
    }

    // Mark all as read
    public function markAllNotificationsRead()
    {
        try {
            $user = auth()->user();
            $user->unreadNotifications->markAsRead();

            return back()->with('success', 'All notifications marked as read.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to mark notifications as read: ' . $e->getMessage());
        }
    }
}
