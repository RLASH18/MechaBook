<?php

use App\Http\Controllers\customer\AppointmentController;
use App\Http\Controllers\customer\CustomerController;
use Illuminate\Support\Facades\Route;

/**
 * Customer Route
 */
Route::prefix('customer')->name('customer.')
    ->middleware(['auth', 'role:customer', 'verified'])
    ->group(function () {

        Route::controller(CustomerController::class)->group(function () {
            Route::get('dashboard', 'dashboard')->name('dashboard');
            Route::get('settings', 'settings')->name('settings');
            Route::post('logout', 'logout')->name('logout');
        });

        Route::controller(AppointmentController::class)->group(function () {
            Route::get('appointments/book', 'book')->name('appointments.book');
            Route::get('appointments', 'index')->name('appointments.index');
        });


    });
