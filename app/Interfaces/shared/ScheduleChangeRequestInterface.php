<?php

namespace App\Interfaces\shared;

use App\Models\ScheduleChangeRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ScheduleChangeRequestInterface
{
    // Admin methods
    public function find(int $id): ?ScheduleChangeRequest;
    public function approveRequest(ScheduleChangeRequest $request, array $data): bool;
    public function rejectRequest(ScheduleChangeRequest $request, array $data): bool;
    public function getRequestsPaginated(?string $search, ?string $status, int $perPage = 10): LengthAwarePaginator;

    // Employee methods
    public function getEmployeeRequests(int $employeeId): Collection;
    public function createRequest(array $data): ScheduleChangeRequest;
}
