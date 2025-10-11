<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\EmployeeController as AdminEmployeeController;
use App\Http\Controllers\admin\ScheduleController;
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

/**
 * Admin Route
 */
Route::prefix('admin')->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::controller(AdminController::class)->group(function () {
            Route::get('dashboard', 'dashboard')->name('dashboard');
            Route::post('logout', 'logout')->name('logout');
        });

        Route::resource('employee', AdminEmployeeController::class);

        Route::resource('schedule', ScheduleController::class);
    });
