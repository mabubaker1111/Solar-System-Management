<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Business\Business;

class BusinessAuthController extends Controller
{
    // SHOW REGISTER PAGE
    public function showRegister()
    {
        return view('business.auth.register');
    }

    // HANDLE REGISTRATION
    public function register(Request $request)
    {
        $request->validate([
            'owner_name'     => 'required|string|max:255',
            'owner_email'    => 'required|email|unique:users,email',
            'owner_phone'    => 'required|string|max:20',
            'password'       => 'required|min:5|confirmed',
            'business_name'  => 'required|string|max:255',
            'business_Owner' => 'required|string|max:255',
            'description'    => 'nullable|string',
            'address'        => 'required|string',
            'city'           => 'required|string|max:100',
        ]);

        // Create business owner in users table
        $user = User::create([
            'name'     => $request->owner_name,
            'email'    => $request->owner_email,
            'phone'    => $request->owner_phone,
            'address'  => $request->address,
            'role'     => 'business',
            'status'   => 'pending',   // default pending
            'password' => Hash::make($request->password),
        ]);

        // Create business
        Business::create([
            'owner_id'       => $user->id,
            'business_name'  => $request->business_name,
            'business_Owner' => $request->business_Owner,
            'description'    => $request->description ?? null,
            'address'        => $request->address,
            'city'           => $request->city,
            'slots'          => 0,
            'status'         => 'pending',   // default pending
        ]);

        return redirect()->route('business.login')->with('success', 'Business registered successfully! Wait for admin approval.');
    }

    // SHOW LOGIN PAGE
    public function showLogin()
    {
        return view('business.auth.login');
    }

    // HANDLE LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Invalid credentials.');
        }

        if ($user->role !== 'business') {
            return back()->with('error', 'This is not a business account.');
        }

        if ($user->status !== 'approved') {
            return redirect('/')->with('error', 'Your account is not approved yet.');
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            return redirect()->route('business.dashboard');
        }

        return back()->with('error', 'Invalid credentials.');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('business.login')->with('success', 'Logged out successfully!');
    }
}
