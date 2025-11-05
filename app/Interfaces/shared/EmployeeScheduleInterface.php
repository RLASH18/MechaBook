<?php

namespace App\Interfaces\shared;

use App\Models\EmployeeSchedule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface EmployeeScheduleInterface
{
    public function find(int $id): ?EmployeeSchedule;
    public function create(array $data): EmployeeSchedule;
    public function update(EmployeeSchedule $schedule, array $data): bool;
    public function delete(EmployeeSchedule $schedule): bool;
    public function getEmployeesBaseQuery(): Builder;
    public function getEmployeeSchedules(int $employeeId): Collection;
    public function getTodaySchedule(int $employeeId, string $dayOfWeek): ?EmployeeSchedule;
}
