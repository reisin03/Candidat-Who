<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;

// Root → Landing Page
Route::get('/', [AdminAuthController::class, 'showLandingForm'])->name('new-landing');

// Optional: direct /landing to same page
Route::get('/new-landing', [AdminAuthController::class, 'showLandingForm'])->name('new-landing.page');
