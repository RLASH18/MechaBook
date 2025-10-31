<?php

namespace App\Interfaces\admin;

use App\Models\EmployeeSchedule;
use Illuminate\Database\Eloquent\Collection;

interface EmployeeScheduleInterface
{
    public function find(int $id): ?EmployeeSchedule;
    public function create(array $data): EmployeeSchedule;
    public function update(EmployeeSchedule $schedule, array $data): EmployeeSchedule;
    public function delete(EmployeeSchedule $schedule): bool;
}
