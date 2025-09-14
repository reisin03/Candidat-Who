<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        // Redirect if already authenticated and verified
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            if ($admin->isVerified()) {
                return redirect()->route('admin.home');
            }
        }
        
        return view('admin.login');
    }

    public function showLandingForm()
    {
        return view('admin.new-landing');
    }

    /**
     * Handle the admin login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials, true)) {
            $admin = Auth::guard('admin')->user();
            
            // Check if admin is verified
            if (!$admin->isVerified()) {
                Auth::guard('admin')->logout();
                
                $message = match($admin->verification_status) {
                    'pending' => 'Your admin account is pending verification by a Super Admin. Please wait for approval.',
                    'rejected' => 'Your admin account verification was rejected. Please contact a Super Admin.',
                    default => 'Your admin account is not verified. Please contact a Super Admin.'
                };
                
                return back()->withErrors(['email' => $message])->onlyInput('email');
            }
            
            $request->session()->regenerate();
            return redirect()->route('admin.home');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }

    /**
     * Show the admin registration form.
     */
    public function showRegisterForm()
    {
        // Redirect if already authenticated and verified
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            if ($admin->isVerified()) {
                return redirect()->route('admin.home');
            }
        }
        
        return view('admin.register');
    }

    /**
     * Handle admin registration with secret code verification.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6|confirmed',
            'id_document' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120', // 5MB max
        ]);

        // Handle ID document upload
        $idDocumentPath = null;
        if ($request->hasFile('id_document')) {
            $idDocumentPath = $request->file('id_document')->store('admin_id_documents', 'public');
        }

        // Create admin with pending verification status
        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_document' => $idDocumentPath,
            'verification_status' => 'pending',
        ]);

        // Don't auto-login - admin must be verified first
        return redirect()->route('admin.login')->with('success', 'Admin registration submitted successfully! Your account is pending verification by a Super Admin. You will be notified once your ID document is reviewed and approved.');
    }

    /**
     * Handle admin logout.
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function setRemember()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->login(Auth::guard('admin')->user(), true);
            return back()->with('success', 'Remember me enabled for your session');
        }

        return redirect()->route('admin.login');
    }

    protected function redirectTo()
    {
        return route('user.home');
    }
}
