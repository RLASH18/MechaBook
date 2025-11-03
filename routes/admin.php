<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AppointmentController;
use App\Http\Controllers\admin\EmployeeController;
use App\Http\Controllers\admin\ScheduleChangeRequest;
use App\Http\Controllers\admin\ScheduleController;
use App\Http\Controllers\admin\ServiceController;
use Illuminate\Support\Facades\Route;

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

        Route::resource('employee', EmployeeController::class);

        Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');
        Route::get('schedule/requests', [ScheduleChangeRequest::class, 'index'])->name('schedule.requests');

        Route::resource('service', ServiceController::class);

        Route::get('appointment', [AppointmentController::class, 'index'])->name('appointment.index');
    });
