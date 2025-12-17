<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::post('/otp/send', [AuthController::class, 'sendOtp'])->name('otp.send');

    Route::get('/verify-otp', [AuthController::class, 'showOtpVerifyForm'])->name('otp.verify.form');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/otp/resend', [AuthController::class, 'resendOtp'])->name('otp.resend');

    Route::post('/check-availability', [AuthController::class, 'checkAvailability'])->name('check.availability');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/password/reset', function () {
    return view('auth.forgot-password');
})->name('password.request');
