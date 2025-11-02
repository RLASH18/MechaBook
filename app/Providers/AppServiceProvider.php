<?php

namespace App\Providers;

use App\Interfaces\admin\AppointmentInterface;
use App\Repositories\admin\EmployeeRepository;
use App\Interfaces\admin\EmployeeInterface;
use App\Interfaces\admin\EmployeeScheduleInterface;
use App\Interfaces\admin\ServiceInterface;
use App\Interfaces\employee\ScheduleChangeRequestInterface;
use App\Interfaces\employee\ScheduleInterface;
use App\Interfaces\SettingsInterface;
use App\Repositories\admin\AppointmentRepository;
use App\Repositories\admin\EmployeeScheduleRepository;
use App\Repositories\admin\ServiceRepository;
use App\Repositories\employee\ScheduleChangeRequestRepository;
use App\Repositories\employee\ScheduleRepository;
use App\Repositories\SettingsRepository;
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
        $this->app->bind(ServiceInterface::class, ServiceRepository::class);
        $this->app->bind(SettingsInterface::class, SettingsRepository::class);
        $this->app->bind(AppointmentInterface::class, AppointmentRepository::class);

        $this->app->bind(ScheduleInterface::class, ScheduleRepository::class);
        $this->app->bind(ScheduleChangeRequestInterface::class, ScheduleChangeRequestRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
