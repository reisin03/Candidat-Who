<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle the main landing page with authentication checks
     */
    public function landing()
    {
        // Check if admin is authenticated and verified
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            if ($admin->isVerified()) {
                return redirect()->route('admin.home');
            }
        }
        
        // Check if user is authenticated and verified
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->isVerified()) {
                return redirect()->route('user.home');
            }
        }
        
        // If no authenticated user or user not verified, show landing page
        return $this->showLandingPage();
    }
    
    /**
     * Show the landing page
     */
    public function showLandingPage()
    {
        return view('admin.new-landing');
    }
    
    /**
     * Handle authentication status check for AJAX requests
     */
    public function checkAuthStatus()
    {
        $response = [
            'authenticated' => false,
            'user_type' => null,
            'redirect_url' => null
        ];
        
        // Check admin authentication
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            if ($admin->isVerified()) {
                $response = [
                    'authenticated' => true,
                    'user_type' => 'admin',
                    'redirect_url' => route('admin.home')
                ];
            }
        }
        
        // Check user authentication (if admin not authenticated)
        if (!$response['authenticated'] && Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->isVerified()) {
                $response = [
                    'authenticated' => true,
                    'user_type' => 'user',
                    'redirect_url' => route('user.home')
                ];
            }
        }
        
        return response()->json($response);
    }
    
    /**
     * Handle logout for both admin and user
     */
    public function logout(Request $request)
    {
        // Logout admin if authenticated
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }
        
        // Logout user if authenticated
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('landing');
    }
}