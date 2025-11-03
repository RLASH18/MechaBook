<?php

namespace App\Interfaces\shared;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;

interface AppointmentInterface
{
    public function find(int $id): ?Appointment;
    public function update(Appointment $appointment, array $data): Appointment;
    public function updateStatus(Appointment $appointment, string $status): Appointment;

    public function getEmployeeAppointments(int $employeeId): Collection;
    public function getAppointmentById(int $appointmentId): ?Appointment;
    public function updateStatusWithProof(int $appointmentId, string $status, ?string $proofImagePath): bool;
}
