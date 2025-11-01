<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\employee\EmployeeController as EmployeeMainController;
use App\Http\Controllers\admin\AppointmentController;
use App\Http\Controllers\admin\EmployeeController as AdminEmployeeController;
use App\Http\Controllers\admin\ScheduleController;
use App\Http\Controllers\admin\ServiceController;
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
            Route::get('settings', 'settings')->name('settings');
            Route::post('logout', 'logout')->name('logout');
        });

        Route::resource('employee', AdminEmployeeController::class);

        Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');

        Route::resource('service', ServiceController::class);

        Route::get('appointment', [AppointmentController::class, 'index'])->name('appointment.index');
    });

/**
 * Employee Route
 */
Route::prefix('employee')->name('employee.')
    ->middleware(['auth', 'role:employee'])
    ->group(function () {

        Route::controller(EmployeeMainController::class)->group(function () {
            Route::get('dashboard', 'dashboard')->name('dashboard');
            Route::get('settings', 'settings')->name('settings');
            Route::post('logout', 'logout')->name('logout');
        });
    });
