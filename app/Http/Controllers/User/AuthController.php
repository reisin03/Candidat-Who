<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // Redirect if already authenticated and verified
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->isVerified()) {
                return redirect()->route('user.home');
            }
        }
        
        return view('user.login');
    }

    public function showRegisterForm()
    {
        // Redirect if already authenticated and verified
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user->isVerified()) {
                return redirect()->route('user.home');
            }
        }
        
        return view('user.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'id_document' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120', // 5MB max
            'terms_agreement' => 'required|accepted',
            'privacy_agreement' => 'required|accepted',
        ]);

        // Handle ID document upload
        $idDocumentPath = null;
        if ($request->hasFile('id_document')) {
            $idDocumentPath = $request->file('id_document')->store('id_documents', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'id_document' => $idDocumentPath,
            'verification_status' => 'pending',
        ]);

        // Don't auto-login - user must be verified first
        return redirect()->route('user.login')->with('success', 'Registration submitted successfully! Your account is pending verification. An admin will review your ID document and approve your account. You will receive notification once verified.');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials, true)) {
            $user = Auth::guard('web')->user();
            
            // Check if user is verified
            if (!$user->isVerified()) {
                Auth::guard('web')->logout();
                
                $message = match($user->verification_status) {
                    'pending' => 'Your account is pending verification. Please wait for admin approval.',
                    'rejected' => 'Your account verification was rejected. Hmph >,,<.',
                    default => 'Your account is not verified. Please be patient.'
                };
                
                return back()->withErrors(['email' => $message])->onlyInput('email');
            }
            
            $request->session()->regenerate();
            return redirect()->route('user.home');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('user.login');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::guard('web')->user();

        if (!password_verify($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return back()->with('success', 'Password changed successfully');
    }

    public function setRemember()
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->login(Auth::guard('web')->user(), true);
            return back()->with('success', 'Remember me enabled for your session');
        }

        return redirect()->route('user.login');
    }
}
