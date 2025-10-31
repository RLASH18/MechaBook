<?php

namespace App\Repositories\admin;

use App\Interfaces\admin\AppointmentInterface;
use App\Models\Appointment;

class AppointmentRepository implements AppointmentInterface
{
    /**
     * Find an appointment by ID.
     *
     * @param int $id
     * @return Appointment|null
     */
    public function find(int $id): ?Appointment
    {
        return Appointment::with(['customer', 'employee', 'service'])->find($id);
    }

    /**
     * Update an existing appointment.
     *
     * @param Appointment $appointment
     * @param array $data
     * @return Appointment
     */
    public function update(Appointment $appointment, array $data): Appointment
    {
        $appointment->update($data);
        return $appointment->fresh(['customer', 'employee', 'service']);
    }

    /**
     * Update appointment status.
     *
     * @param Appointment $appointment
     * @param string $status
     * @return Appointment
     */
    public function updateStatus(Appointment $appointment, string $status): Appointment
    {
        $appointment->update(['status' => $status]);
        return $appointment->fresh(['customer', 'employee', 'service']);
    }
}
