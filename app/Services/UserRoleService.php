<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;

class UserRoleService
{
    /**
     * Determine if the current authenticated user is an admin
     */
    public static function isAdmin(): bool
    {
        // Check if authenticated via admin guard
        if (Auth::guard('admin')->check()) {
            return true;
        }

        // Check if authenticated via web guard with admin role
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            return $user && $user->role === 'admin';
        }

        return false;
    }

    /**
     * Determine if the current authenticated user is a regular user
     */
    public static function isUser(): bool
    {
        // Check if authenticated via web guard with user role
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            return $user && $user->role === 'user';
        }

        return false;
    }

    /**
     * Get the current user's role
     */
    public static function getCurrentUserRole(): ?string
    {
        // Check admin guard first
        if (Auth::guard('admin')->check()) {
            return 'admin';
        }

        // Check web guard
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            return $user ? $user->role : null;
        }

        return null;
    }

    /**
     * Get the current authenticated user (from any guard)
     */
    public static function getCurrentUser()
    {
        // Check admin guard first
        if (Auth::guard('admin')->check()) {
            return Auth::guard('admin')->user();
        }

        // Check web guard
        if (Auth::guard('web')->check()) {
            return Auth::guard('web')->user();
        }

        return null;
    }

    /**
     * Check if any user is authenticated
     */
    public static function isAuthenticated(): bool
    {
        return Auth::guard('admin')->check() || Auth::guard('web')->check();
    }

    /**
     * Get the guard name for the current authenticated user
     */
    public static function getCurrentGuard(): ?string
    {
        if (Auth::guard('admin')->check()) {
            return 'admin';
        }

        if (Auth::guard('web')->check()) {
            return 'web';
        }

        return null;
    }

    /**
     * Redirect user based on their role
     */
    public static function getRedirectPath(): string
    {
        if (self::isAdmin()) {
            return '/admin/home';
        }

        if (self::isUser()) {
            return '/user/home';
        }

        return '/';
    }
}