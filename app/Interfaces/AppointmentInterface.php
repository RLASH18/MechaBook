<?php

namespace App\Interfaces;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

interface AppointmentInterface
{
    public function findById(int $id, array $relations = []): ?Appointment;
    public function create(array $data): Appointment;
    public function update(Appointment $appointment, array $data): bool;
    public function getBaseQuery(array $relations = []): Builder;
    public function getEmployeeAppointmentsQuery(int $employeeId, array $relations = []): Builder;
    public function getCustomerAppointmentsQuery(int $customerId, array $relations = []): Builder;
    public function countByStatus(?string $status = null, ?int $employeeId = null, ?int $customerId = null): int;
    public function getAllEmployees(): Collection;
}
