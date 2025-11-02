<?php

namespace App\Interfaces\employee;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;

interface AppointmentInterface
{
    public function getEmployeeAppointments(int $employeeId): Collection;
    public function getAppointmentById(int $appointmentId): ?Appointment;
    public function updateStatusWithProof(int $appointmentId, string $status, ?string $proofImagePath): bool;
}
