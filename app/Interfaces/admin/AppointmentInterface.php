<?php

namespace App\Interfaces\admin;

use App\Models\Appointment;

interface AppointmentInterface
{
    public function find(int $id): ?Appointment;
    public function update(Appointment $appointment, array $data): Appointment;
    public function updateStatus(Appointment $appointment, string $status): Appointment;
}
