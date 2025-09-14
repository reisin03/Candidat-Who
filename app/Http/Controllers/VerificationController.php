<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    /**
     * Show pending user verifications
     */
    public function userVerifications()
    {
        $pendingUsers = User::where('verification_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.verifications.users', compact('pendingUsers'));
    }

    /**
     * Show pending admin verifications (only for super admins)
     */
    public function adminVerifications()
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        if (!$currentAdmin->isSuperAdmin()) {
            return redirect()->route('admin.home')->with('error', 'Access denied. Only Super Admins can verify other admins.');
        }
        
        $pendingAdmins = Admin::where('verification_status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.verifications.admins', compact('pendingAdmins'));
    }

    /**
     * Show user verification details
     */
    public function showUserVerification(User $user)
    {
        if ($user->verification_status !== 'pending') {
            return redirect()->route('admin.verifications.users')->with('error', 'This user is not pending verification.');
        }
        
        return view('admin.verifications.user-detail', compact('user'));
    }

    /**
     * Show admin verification details (only for super admins)
     */
    public function showAdminVerification(Admin $admin)
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        if (!$currentAdmin->isSuperAdmin()) {
            return redirect()->route('admin.home')->with('error', 'Access denied. Only Super Admins can verify other admins.');
        }
        
        if ($admin->verification_status !== 'pending') {
            return redirect()->route('admin.verifications.admins')->with('error', 'This admin is not pending verification.');
        }
        
        return view('admin.verifications.admin-detail', compact('admin'));
    }

    /**
     * Approve user verification
     */
    public function approveUser(Request $request, User $user)
    {
        $request->validate([
            'notes' => 'nullable|string|max:500'
        ]);

        $user->update([
            'verification_status' => 'approved',
            'verification_notes' => $request->notes,
            'verified_at' => now(),
            'verified_by' => Auth::guard('admin')->id(),
        ]);

        return redirect()->route('admin.verifications.users')->with('success', 'User verification approved successfully.');
    }

    /**
     * Reject user verification
     */
    public function rejectUser(Request $request, User $user)
    {
        $request->validate([
            'notes' => 'required|string|max:500'
        ]);

        $user->update([
            'verification_status' => 'rejected',
            'verification_notes' => $request->notes,
            'verified_at' => now(),
            'verified_by' => Auth::guard('admin')->id(),
        ]);

        return redirect()->route('admin.verifications.users')->with('success', 'User verification rejected.');
    }

    /**
     * Approve admin verification (only for super admins)
     */
    public function approveAdmin(Request $request, Admin $admin)
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        if (!$currentAdmin->isSuperAdmin()) {
            return redirect()->route('admin.home')->with('error', 'Access denied. Only Super Admins can verify other admins.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:500',
            'is_super_admin' => 'boolean'
        ]);

        $admin->update([
            'verification_status' => 'approved',
            'verification_notes' => $request->notes,
            'verified_at' => now(),
            'verified_by' => Auth::guard('admin')->id(),
            'is_super_admin' => $request->boolean('is_super_admin', false),
        ]);

        return redirect()->route('admin.verifications.admins')->with('success', 'Admin verification approved successfully.');
    }

    /**
     * Reject admin verification (only for super admins)
     */
    public function rejectAdmin(Request $request, Admin $admin)
    {
        $currentAdmin = Auth::guard('admin')->user();
        
        if (!$currentAdmin->isSuperAdmin()) {
            return redirect()->route('admin.home')->with('error', 'Access denied. Only Super Admins can verify other admins.');
        }

        $request->validate([
            'notes' => 'required|string|max:500'
        ]);

        $admin->update([
            'verification_status' => 'rejected',
            'verification_notes' => $request->notes,
            'verified_at' => now(),
            'verified_by' => Auth::guard('admin')->id(),
        ]);

        return redirect()->route('admin.verifications.admins')->with('success', 'Admin verification rejected.');
    }

    /**
     * View ID document in browser
     */
    public function viewIdDocument($type, $id)
    {
        if ($type === 'user') {
            $model = User::findOrFail($id);
        } elseif ($type === 'admin') {
            $currentAdmin = Auth::guard('admin')->user();
            if (!$currentAdmin->isSuperAdmin()) {
                abort(403, 'Access denied. Only Super Admins can access admin documents.');
            }
            $model = Admin::findOrFail($id);
        } else {
            abort(404);
        }

        if (!$model->id_document || !Storage::disk('public')->exists($model->id_document)) {
            abort(404, 'ID document not found.');
        }

        $filePath = Storage::disk('public')->path($model->id_document);
        $mimeType = Storage::disk('public')->mimeType($model->id_document);
        
        return response()->file($filePath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($model->id_document) . '"'
        ]);
    }

    /**
     * Download ID document
     */
    public function downloadIdDocument($type, $id)
    {
        if ($type === 'user') {
            $model = User::findOrFail($id);
        } elseif ($type === 'admin') {
            $currentAdmin = Auth::guard('admin')->user();
            if (!$currentAdmin->isSuperAdmin()) {
                abort(403, 'Access denied. Only Super Admins can access admin documents.');
            }
            $model = Admin::findOrFail($id);
        } else {
            abort(404);
        }

        if (!$model->id_document || !Storage::disk('public')->exists($model->id_document)) {
            abort(404, 'ID document not found.');
        }

        return Storage::disk('public')->download($model->id_document);
    }
}