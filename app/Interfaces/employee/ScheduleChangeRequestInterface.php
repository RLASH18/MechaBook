<?php

namespace App\Interfaces\employee;

use App\Models\ScheduleChangeRequest;
use Illuminate\Database\Eloquent\Collection;

interface ScheduleChangeRequestInterface
{
    public function getEmployeeRequests(int $employeeId): Collection;
    public function createRequest(array $data): ScheduleChangeRequest;
}
