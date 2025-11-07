<?php

namespace App\Providers;

use App\Interfaces\EmployeeInterface;
use App\Interfaces\ServiceInterface;
use App\Interfaces\SettingsInterface;
use App\Interfaces\AppointmentInterface;
use App\Interfaces\EmployeeScheduleInterface;
use App\Interfaces\ScheduleChangeRequestInterface;
use App\Repositories\EmployeeRepository;
use App\Repositories\ServiceRepository;
use App\Repositories\SettingsRepository;
use App\Repositories\AppointmentRepository;
use App\Repositories\EmployeeScheduleRepository;
use App\Repositories\ScheduleChangeRequestRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(EmployeeInterface::class, EmployeeRepository::class);
        $this->app->bind(EmployeeScheduleInterface::class, EmployeeScheduleRepository::class);
        $this->app->bind(ScheduleChangeRequestInterface::class, ScheduleChangeRequestRepository::class);
        $this->app->bind(ServiceInterface::class, ServiceRepository::class);
        $this->app->bind(AppointmentInterface::class, AppointmentRepository::class);
        $this->app->bind(SettingsInterface::class, SettingsRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
