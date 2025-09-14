<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\AuthHelper;
use App\Services\UserRoleService;

class RoleTestController extends Controller
{
    /**
     * Test the role determination system
     */
    public function testRoles()
    {
        $data = [
            'is_authenticated' => AuthHelper::isAuthenticated(),
            'is_admin' => AuthHelper::isAdmin(),
            'is_user' => AuthHelper::isUser(),
            'user_role' => AuthHelper::getUserRole(),
            'user_type_display' => AuthHelper::getUserTypeDisplay(),
            'user_name' => AuthHelper::getUserName(),
            'user_email' => AuthHelper::getUserEmail(),
            'redirect_path' => AuthHelper::getRedirectPath(),
            'current_guard' => UserRoleService::getCurrentGuard(),
        ];

        return response()->json([
            'message' => 'Role determination test results',
            'data' => $data,
            'current_user' => AuthHelper::getCurrentUser(),
        ]);
    }

    /**
     * Show role information in a view
     */
    public function showRoleInfo()
    {
        $roleInfo = [
            'authenticated' => AuthHelper::isAuthenticated(),
            'is_admin' => AuthHelper::isAdmin(),
            'is_user' => AuthHelper::isUser(),
            'role' => AuthHelper::getUserRole(),
            'display_type' => AuthHelper::getUserTypeDisplay(),
            'name' => AuthHelper::getUserName(),
            'email' => AuthHelper::getUserEmail(),
            'guard' => UserRoleService::getCurrentGuard(),
        ];

        return view('role-test', compact('roleInfo'));
    }

    /**
     * Test role-based access
     */
    public function adminOnly()
    {
        if (!AuthHelper::isAdmin()) {
            abort(403, 'Admin access required');
        }

        return response()->json([
            'message' => 'Admin access granted',
            'user' => AuthHelper::getCurrentUser(),
        ]);
    }

    /**
     * Test user-only access
     */
    public function userOnly()
    {
        if (!AuthHelper::isUser()) {
            abort(403, 'User access required');
        }

        return response()->json([
            'message' => 'User access granted',
            'user' => AuthHelper::getCurrentUser(),
        ]);
    }
}