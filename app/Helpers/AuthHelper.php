<?php

namespace App\Helpers;

use App\Services\UserRoleService;
use Illuminate\Support\Facades\Auth;

class AuthHelper
{
    /**
     * Check if the current user is an admin
     */
    public static function isAdmin(): bool
    {
        return UserRoleService::isAdmin();
    }

    /**
     * Check if the current user is a regular user
     */
    public static function isUser(): bool
    {
        return UserRoleService::isUser();
    }

    /**
     * Get the current user's role
     */
    public static function getUserRole(): ?string
    {
        return UserRoleService::getCurrentUserRole();
    }

    /**
     * Get the current authenticated user
     */
    public static function getCurrentUser()
    {
        return UserRoleService::getCurrentUser();
    }

    /**
     * Check if any user is authenticated
     */
    public static function isAuthenticated(): bool
    {
        return UserRoleService::isAuthenticated();
    }

    /**
     * Get appropriate redirect path based on user role
     */
    public static function getRedirectPath(): string
    {
        return UserRoleService::getRedirectPath();
    }

    /**
     * Get user type as string for display purposes
     */
    public static function getUserTypeDisplay(): string
    {
        if (self::isAdmin()) {
            return 'Administrator';
        }

        if (self::isUser()) {
            return 'User';
        }

        return 'Guest';
    }

    /**
     * Check if user has specific role
     */
    public static function hasRole(string $role): bool
    {
        $currentRole = self::getUserRole();
        return $currentRole === $role;
    }

    /**
     * Get user's name for display
     */
    public static function getUserName(): ?string
    {
        $user = self::getCurrentUser();
        return $user ? $user->name : null;
    }

    /**
     * Get user's email
     */
    public static function getUserEmail(): ?string
    {
        $user = self::getCurrentUser();
        return $user ? $user->email : null;
    }

    /**
     * Logout user from appropriate guard
     */
    public static function logout(): void
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
    }
}