<?php

use App\Http\Controllers\employee\AppointmentController;
use App\Http\Controllers\employee\EmployeeController;
use App\Http\Controllers\employee\ScheduleController;
use Illuminate\Support\Facades\Route;

/**
 * Employee Route
 */
Route::prefix('employee')->name('employee.')
    ->middleware(['auth', 'role:employee'])
    ->group(function () {

        Route::controller(EmployeeController::class)->group(function () {
            Route::get('dashboard', 'dashboard')->name('dashboard');
            Route::get('settings', 'settings')->name('settings');
            Route::post('logout', 'logout')->name('logout');
        });

        Route::get('schedule', [ScheduleController::class, 'index'])->name('schedule.index');

        Route::get('appointment', [AppointmentController::class, 'index'])->name('appointment.index');
    });
