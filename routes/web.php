<?php

use App\Http\Controllers\AuthController;
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
        Route::get('auth/google', 'googleRedirect')->name('google.redirect');
        Route::get('auth/google/callback', 'googleCallback')->name('google.callback');
    });
});

/**
 * Email Verification Route
 */
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed'])
    ->name('verification.verify');

require __DIR__ . '/admin.php';
require __DIR__ . '/employee.php';
require __DIR__ . '/customer.php';
