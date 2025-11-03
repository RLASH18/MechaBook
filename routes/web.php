<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Auth Route
 */
Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('signin', 'showSigninForm')->name('signin');
        Route::get('signup', 'showSignupForm')->name('signup');
        Route::post('signin', 'signin')->name('signin.store');
        Route::post('signup', 'signup')->name('signup.store');
    });
});

require __DIR__.'/admin.php';
require __DIR__.'/employee.php';
