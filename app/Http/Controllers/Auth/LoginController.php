<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Find user
        $user = User::where('email', $request->email)->first();

        if (!$user || !Auth::validate(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/')
                ->with('error', 'The Fields you entered are not match.');
        }

        // ─────────────── STATUS CHECK ───────────────
        if ($user->status !== 'approved') {

            return redirect('/')
                ->with('error', 'Your account is not approved yet.');
        }
        // ─────────────────────────────────────────────

        // Attempt login
        if (Auth::attempt([
            'email'    => $request->email,
            'password' => $request->password,
            'role'     => $user->role
        ])) {

            $request->session()->regenerate();

            // Redirect based on user role
            switch ($user->role) {
                case 'superadmin':
                    return redirect()->route('superadmin.dashboard');

                case 'business':
                    return redirect()->route('business.dashboard');

                case 'worker':
                    return redirect()->route('worker.dashboard');

                default: // client
                    return redirect()->route('client.dashboard');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully!');
    }
}
