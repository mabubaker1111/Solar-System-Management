<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Client\Client;
use App\Models\User;
use App\Models\Client\ServiceRequest;
use App\Models\Business\Business;
use App\Notifications\UserRegistered;

class ClientController extends Controller
{
    public function showRegisterForm()
    {
        try {
            return view('client.auth.register');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load registration form: ' . $e->getMessage());
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|unique:users',
                'phone'    => 'required|string|max:30',
                'address'  => 'required|string',
                'password' => 'required|min:5|confirmed',
            ]);

            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'phone'    => $request->phone,
                'address'  => $request->address,
                'role'     => 'client',
                'status'   => 'approved',
                'password' => Hash::make($request->password),
            ]);

            // ✅ Client table me record lazmi create karo
            Client::create([
                'user_id' => $user->id,
                'phone'   => $request->phone,
                'address' => $request->address,
                'city'    => 'N/A',
            ]);




            $user->notify(new UserRegistered($user));

            return redirect()->route('frontend.home')->with('success', 'You are registered successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    public function showLoginForm()
    {
        try {
            return view('client.auth.login');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load login form: ' . $e->getMessage());
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate(['email' => 'required|email', 'password' => 'required']);

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'role' => 'client'])) {
                $request->session()->regenerate();
                return redirect()->route('client.dashboard');
            }

            return back()->with('error', 'Invalid credentials or not a client account.');
        } catch (\Exception $e) {
            return back()->with('error', 'Login failed: ' . $e->getMessage());
        }
    }

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

    public function dashboard()
    {
        try {
            $user = Auth::user();

            // User notifications
            $notifications = $user->notifications()->latest()->get();

            // ✅ Correct client reference (NOT user_id)
            $client = $user->client;

            // Latest query of this client
            $latestQuery = $client
                ? \App\Models\Query::where('client_id', $client->id)->latest()->first()
                : null;

            // Check unread replies
            $unreadReplies = $latestQuery && $latestQuery->response ? 1 : 0;

            return view('client.dashboard', compact(
                'user',
                'notifications',
                'latestQuery',
                'unreadReplies'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load dashboard: ' . $e->getMessage());
        }
    }

    public function browseBusinesses()
    {
        try {
            $businesses = Business::where('status', 'approved')->get();
            return view('client.businesses', compact('businesses'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load businesses: ' . $e->getMessage());
        }
    }

    public function businessDetails($id)
    {
        try {
            $business = Business::with(['services', 'owner'])->findOrFail($id);
            return view('client.business_details', compact('business'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load business details: ' . $e->getMessage());
        }
    }

    public function requests()
    {
        try {
            $requests = ServiceRequest::where('client_id', Auth::id())
                ->with(['service', 'business', 'worker.user'])
                ->latest()
                ->orderBy('created_at', 'desc')
                ->paginate(8);
            return view('client.request_status', compact('requests'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load requests: ' . $e->getMessage());
        }
    }

    public function notifications()
    {
        try {
            $user = Auth::user();
            $notifications = $user->notifications()->latest()->orderBy('created_at', 'desc')->paginate(8);

            return view('client.notifications', compact('notifications'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load notifications: ' . $e->getMessage());
        }
    }

    public function markAllNotificationsRead()
    {
        try {
            $user = Auth::user();
            $user->unreadNotifications->markAsRead();

            return back()->with('success', 'All notifications marked as read.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to mark notifications as read: ' . $e->getMessage());
        }
    }
    public function index()
    {
        // Only approved businesses
        $businesses = Business::where('status', 'approved')->get();

        return view('frontend.services', compact('businesses'));
    }
}
