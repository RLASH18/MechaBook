<?php

namespace App\Interfaces\shared;

use App\Models\EmployeeSchedule;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface EmployeeScheduleInterface
{
    // Admin queries
    public function find(int $id): ?EmployeeSchedule;
    public function create(array $data): EmployeeSchedule;
    public function update(EmployeeSchedule $schedule, array $data): EmployeeSchedule;
    public function delete(EmployeeSchedule $schedule): bool;
    public function getEmployeesWithSchedulesPaginated(?string $search, int $perPage = 10): LengthAwarePaginator;

    // Employee queries
    public function getEmployeeSchedules(int $employeeId): Collection;
    public function getTodaySchedule(int $employeeId, string $dayOfWeek): ?EmployeeSchedule;
    public function getNextSchedule(int $employeeId, string $currentDay): ?EmployeeSchedule;
}
