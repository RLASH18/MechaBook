<?php

use App\Http\Controllers\auth\ResetPasswordController;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\auth\OAuthController;
use App\Http\Controllers\auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Auth Routes
 */
Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::get('register', 'showRegisterForm')->name('register');
        Route::post('login', 'login')->name('login.store');
        Route::post('register', 'register')->name('register.store');
    });

    Route::controller(OAuthController::class)->group(function () {
        Route::get('auth/google', 'googleRedirect')->name('google.redirect');
        Route::get('auth/google/callback', 'googleCallback')->name('google.callback');
    });

    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('forgot-password', 'requestForm')->name('password.request');
        Route::post('forgot-password', 'sendResetLink')->name('password.email');
        Route::get('reset-password/{token}', 'resetForm')->name('password.reset');
        Route::post('reset-password', 'resetPassword')->name('password.update');
    });
});

/**
 * Email Verification Route
 */
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');

/**
 * Resend verification Route
 */
Route::controller(VerifyEmailController::class)
    ->middleware('guest')
    ->group(function () {
        Route::get('/resend-verification', 'showResendForm')
            ->name('verification.resend.form');

        Route::post('/email/resend-verification', 'resendByEmail')
            ->middleware('throttle:3,1')
            ->name('verification.resend');
    });

require __DIR__ . '/admin.php';
require __DIR__ . '/employee.php';
require __DIR__ . '/customer.php';
