<?php

use App\Http\Controllers\AdminAuthController;

// Login routes
Route::get('/', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// Register routes
Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');

// Logout route
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
