<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in AND role is superadmin
        if(Auth::check() && Auth::user()->role === 'superadmin'){
            return $next($request);
        }

        // Otherwise redirect to home
        return redirect('/')->with('error', 'Access denied.');
    }
}
