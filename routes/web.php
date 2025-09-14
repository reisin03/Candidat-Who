<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\Auth\AuthController as MainAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ObjectivesController;
use App\Http\Controllers\BrgyOfficialController;
use App\Http\Controllers\RunningOfficialController;
use App\Http\Controllers\CurrentSkController;
use App\Http\Controllers\RunningSkController;
use App\Http\Controllers\AddOfficialController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\RoleTestController;
use App\Http\Controllers\VerificationController;

// Landing & Objectives with Authentication Check
Route::get('/', [MainAuthController::class, 'landing'])->name('landing');
Route::get('/landing', [MainAuthController::class, 'landing'])->name('landing.page');
Route::get('/auth/status', [MainAuthController::class, 'checkAuthStatus'])->name('auth.status');
Route::post('/auth/logout', [MainAuthController::class, 'logout'])->name('auth.logout');
Route::get('/objectives', [ObjectivesController::class, 'show'])->name('objectives.show');

// Public Officials
Route::get('/brgyofficials', [BrgyOfficialController::class, 'index'])->name('brgyofficials.index');
Route::get('/brgyofficials/{id}', [BrgyOfficialController::class, 'show'])->whereNumber('id')->name('brgyofficials.show');
Route::get('/runningofficials', [RunningOfficialController::class, 'index'])->name('runningofficials.index');
Route::get('/runningofficials/{id}', [RunningOfficialController::class, 'show'])->whereNumber('id')->name('runningofficials.show');
Route::get('/currentsk', [CurrentSkController::class, 'index'])->name('currentsk.index');
Route::get('/currentsk/{id}', [CurrentSkController::class, 'show'])->whereNumber('id')->name('currentsk.show');
Route::get('/runningsk', [RunningSkController::class, 'index'])->name('runningsk.index');
Route::get('/runningsk/{id}', [RunningSkController::class, 'show'])->whereNumber('id')->name('runningsk.show');

// Public Search
Route::get('/search', [CandidateController::class, 'index'])->name('search');

// Public Feedback Routes
Route::get('/feedback', [FeedbackController::class, 'create'])->name('feedback.create');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

// Legal Pages
Route::get('/terms', function () { return view('legal.terms'); })->name('legal.terms');
Route::get('/privacy', function () { return view('legal.privacy'); })->name('legal.privacy');

// Admin Authentication Routes
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Admin Routes (protected)
Route::prefix('admin')
    ->middleware(['auth:admin', 'is_admin'])
    ->as('admin.')
    ->group(function () {
        Route::get('/home', [AdminController::class, 'index'])->name('home');

        // Barangay Officials
        Route::resource('brgyofficials', BrgyOfficialController::class);

        // Running Officials
        Route::resource('runningofficials', RunningOfficialController::class);
        Route::post('runningofficials/{id}/mark-winner', [RunningOfficialController::class, 'markAsWinner'])->name('runningofficials.mark-winner');

        // Current SK Officials
        Route::resource('currentsk', CurrentSkController::class);

        // Running SK Officials
        Route::resource('runningsk', RunningSkController::class);
        Route::post('runningsk/{id}/mark-winner', [RunningSkController::class, 'markAsWinner'])->name('runningsk.mark-winner');

        Route::resource('addofficials', AddOfficialController::class);

        // ✅ Profile Routes
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
        Route::get('/profile/edit', [AdminController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

        Route::get('/candidates', [CandidateController::class, 'index'])->name('candidates.index');

        Route::resource('feedback', FeedbackController::class);
        Route::post('feedback/{id}/verify', [FeedbackController::class, 'verify'])->name('feedback.verify');

        // Verification Routes
        Route::prefix('verifications')->as('verifications.')->group(function () {
            // User Verifications
            Route::get('/users', [VerificationController::class, 'userVerifications'])->name('users');
            Route::get('/users/{user}', [VerificationController::class, 'showUserVerification'])->name('user.show');
            Route::post('/users/{user}/approve', [VerificationController::class, 'approveUser'])->name('user.approve');
            Route::post('/users/{user}/reject', [VerificationController::class, 'rejectUser'])->name('user.reject');
            
            // Admin Verifications (Super Admin only)
            Route::get('/admins', [VerificationController::class, 'adminVerifications'])->name('admins');
            Route::get('/admins/{admin}', [VerificationController::class, 'showAdminVerification'])->name('admin.show');
            Route::post('/admins/{admin}/approve', [VerificationController::class, 'approveAdmin'])->name('admin.approve');
            Route::post('/admins/{admin}/reject', [VerificationController::class, 'rejectAdmin'])->name('admin.reject');
            
            // View and Download ID Documents
            Route::get('/view/{type}/{id}', [VerificationController::class, 'viewIdDocument'])->name('view');
            Route::get('/download/{type}/{id}', [VerificationController::class, 'downloadIdDocument'])->name('download');
        });

        Route::get('/set-remember', [AdminAuthController::class, 'setRemember'])->name('set-remember');
    });

// User Authentication Routes
Route::get('/user/login', [AuthController::class, 'showLoginForm'])->name('user.login');
Route::post('/user/login', [AuthController::class, 'login'])->name('user.login.submit');
Route::get('/user/register', [AuthController::class, 'showRegisterForm'])->name('user.register');
Route::post('/user/register', [AuthController::class, 'register'])->name('user.register.submit');
Route::match(['get', 'post'], '/user/logout', [AuthController::class, 'logout'])->name('user.logout');

// User Routes (protected)
Route::prefix('user')->middleware(['auth:web', 'is_user'])->group(function () {
    Route::get('/home', [UserController::class, 'index'])->name('user.home');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/set-remember', [AuthController::class, 'setRemember'])->name('user.set-remember');
});

// Role Testing Routes (for development/testing purposes)
Route::prefix('test-roles')->group(function () {
    Route::get('/api', [RoleTestController::class, 'testRoles'])->name('test.roles.api');
    Route::get('/info', [RoleTestController::class, 'showRoleInfo'])->name('test.roles.info');
    Route::get('/admin-only', [RoleTestController::class, 'adminOnly'])->name('test.roles.admin');
    Route::get('/user-only', [RoleTestController::class, 'userOnly'])->name('test.roles.user');
});
