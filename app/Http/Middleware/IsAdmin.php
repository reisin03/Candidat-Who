<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the admin guard is authenticated
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Redirect to admin login if not authenticated
        return redirect('/admin/login')->with('error', 'Access denied.');
    }
}
