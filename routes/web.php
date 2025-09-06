<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstitutionController;

// Public routes
Route::get('/', [GuestController::class, 'index'])->name('home');
Route::get('/assessments', [GuestController::class, 'assessments'])->name('assessments');
Route::get('/blog', [GuestController::class, 'blog'])->name('blog');
Route::get('/pricing', [GuestController::class, 'pricing'])->name('pricing');
Route::get('/faq', [GuestController::class, 'faq'])->name('faq');
Route::get('/help', [GuestController::class, 'help'])->name('help');
Route::get('/cookie-policy', [GuestController::class, 'cookiePolicy'])->name('cookie-policy');
Route::get('/refund-policy', [GuestController::class, 'refundPolicy'])->name('refund-policy');
Route::get('/terms', [GuestController::class, 'terms'])->name('terms');
Route::get('/privacy', [GuestController::class, 'privacy'])->name('privacy');
Route::get('/contact', [GuestController::class, 'contact'])->name('contact');
Route::get('/system-status', [GuestController::class, 'systemStatus'])->name('system-status');

// API routes
Route::prefix('api')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/register-institution', [AuthController::class, 'registerInstitution']);
    Route::post('/login', [AuthController::class, 'login']);
    
    // Institution routes
    Route::prefix('institution')->group(function () {
        Route::get('/dashboard', [InstitutionController::class, 'dashboard']);
        Route::get('/learners', [InstitutionController::class, 'getLearners']);
        Route::post('/learners', [InstitutionController::class, 'addLearner']);
        Route::put('/learners/{learnerId}/tokens', [InstitutionController::class, 'updateLearnerTokens']);
        Route::put('/learners/{learnerId}/toggle-status', [InstitutionController::class, 'toggleLearnerStatus']);
        Route::post('/learners/bulk-upload', [InstitutionController::class, 'bulkUploadLearners']);
    });
});

// User routes (will need authentication middleware later)
Route::get('/dashboard', [GuestController::class, 'dashboard'])->name('dashboard');
Route::get('/institution-dashboard', [GuestController::class, 'institutionDashboard'])->name('institution-dashboard');
Route::get('/transactions', [GuestController::class, 'transactions'])->name('transactions');
