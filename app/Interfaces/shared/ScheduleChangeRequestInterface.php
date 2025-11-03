<?php

namespace App\Interfaces\shared;

use App\Models\ScheduleChangeRequest;
use Illuminate\Database\Eloquent\Collection;

interface ScheduleChangeRequestInterface
{
    public function find(int $id): ?ScheduleChangeRequest;
    public function approveRequest(ScheduleChangeRequest $request, array $data): bool;
    public function rejectRequest(ScheduleChangeRequest $request, array $data): bool;

    public function getEmployeeRequests(int $employeeId): Collection;
    public function createRequest(array $data): ScheduleChangeRequest;
}
