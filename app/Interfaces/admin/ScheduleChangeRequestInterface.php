<?php

namespace App\Interfaces\admin;

use App\Models\ScheduleChangeRequest;

interface ScheduleChangeRequestInterface
{
    public function find(int $id): ?ScheduleChangeRequest;
    public function approveRequest(ScheduleChangeRequest $request, array $data): bool;
    public function rejectRequest(ScheduleChangeRequest $request, array $data): bool;
}
