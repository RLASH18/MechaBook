<?php

namespace App\Providers;

use App\Interfaces\admin\EmployeeInterface;
use App\Interfaces\admin\ServiceInterface;
use App\Interfaces\shared\SettingsInterface;
use App\Interfaces\shared\AppointmentInterface;
use App\Interfaces\shared\EmployeeScheduleInterface;
use App\Interfaces\shared\ScheduleChangeRequestInterface;
use App\Repositories\admin\EmployeeRepository;
use App\Repositories\admin\ServiceRepository;
use App\Repositories\shared\SettingsRepository;
use App\Repositories\shared\AppointmentRepository;
use App\Repositories\shared\EmployeeScheduleRepository;
use App\Repositories\shared\ScheduleChangeRequestRepository;
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
