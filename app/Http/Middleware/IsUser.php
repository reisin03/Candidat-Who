<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Services\UserRoleService;

class IsUser
{
    public function handle($request, Closure $next)
    {
        if (UserRoleService::isUser()) {
            return $next($request);
        }
        return redirect('/'); // Redirect if not user
    }
}