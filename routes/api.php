<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SearchController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Admin search endpoint
Route::middleware(['auth:web'])->prefix('admin')->group(function () {
    Route::get('/search', [SearchController::class, 'search'])->name('admin.search');
});

// OTP Verification API Routes
Route::prefix('otp')->name('api.otp.')->group(function () {
    Route::post('/send', [App\Http\Controllers\OtpVerificationController::class, 'sendOtp'])
        ->middleware('throttle:5,1')
        ->name('send');
    
    Route::post('/verify', [App\Http\Controllers\OtpVerificationController::class, 'verifyOtp'])
        ->middleware('throttle:10,1')
        ->name('verify');
    
    Route::post('/resend', [App\Http\Controllers\OtpVerificationController::class, 'resendOtp'])
        ->middleware('throttle:3,1')
        ->name('resend');
});
