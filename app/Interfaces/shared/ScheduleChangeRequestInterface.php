<?php

namespace App\Interfaces\shared;

use App\Models\ScheduleChangeRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

interface ScheduleChangeRequestInterface
{
    public function find(int $id, array $relations = []): ?ScheduleChangeRequest;
    public function create(array $data): ScheduleChangeRequest;
    public function update(ScheduleChangeRequest $request, array $data): bool;
    public function getBaseQuery(array $relations = []): Builder;
    public function getEmployeeRequests(int $employeeId): Collection;
}
