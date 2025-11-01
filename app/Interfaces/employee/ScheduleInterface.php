<?php

namespace App\Interfaces\employee;

use App\Models\EmployeeSchedule;
use Illuminate\Database\Eloquent\Collection;

interface ScheduleInterface
{
    public function getEmployeeSchedules(int $employeeId): Collection;
    public function getTodaySchedule(int $employeeId, string $dayOfWeek): ?EmployeeSchedule;
    public function getNextSchedule(int $employeeId, string $currentDay): ?EmployeeSchedule;
}
