<?php

namespace App\Interfaces\shared;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

interface AppointmentInterface
{
    public function findById(int $id, array $relations = []): ?Appointment;
    public function update(Appointment $appointment, array $data): bool;
    public function getBaseQuery(array $relations = []): Builder;
    public function getEmployeeAppointmentsQuery(int $employeeId, array $relations = []): Builder;
    public function countByStatus(?string $status = null, ?int $employeeId = null): int;
    public function getAllEmployees(): Collection;
}
