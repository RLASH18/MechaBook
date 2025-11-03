<?php

namespace App\Interfaces\shared;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface AppointmentInterface
{
    // Admin queries
    public function find(int $id): ?Appointment;
    public function update(Appointment $appointment, array $data): Appointment;
    public function updateStatus(Appointment $appointment, string $status): Appointment;
    public function getAllAppointmentsPaginated(?string $search, ?string $status, int $perPage = 10): LengthAwarePaginator;
    public function getStatusCounts(): array;

    // Employee queries
    public function getAppointmentById(int $appointmentId): ?Appointment;
    public function updateStatusWithProof(int $appointmentId, string $status, ?string $proofImagePath): bool;
    public function getEmployeeAppointmentsPaginated(int $employeeId, ?string $search, ?string $status, int $perPage = 10): LengthAwarePaginator;
    public function getEmployeeStatusCounts(int $employeeId): array;
}
