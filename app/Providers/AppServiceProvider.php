<?php

namespace App\Providers;

use App\Repositories\admin\EmployeeRepository;
use App\Interfaces\admin\EmployeeInterface;
use App\Interfaces\admin\EmployeeScheduleInterface;
use App\Interfaces\admin\ServiceInterface;
use App\Repositories\admin\EmployeeScheduleRepository;
use App\Repositories\admin\ServiceRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
