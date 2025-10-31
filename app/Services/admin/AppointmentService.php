<?php

namespace App\Services\admin;

use App\Interfaces\admin\AppointmentInterface;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;

class AppointmentService
{
    /**
     * Inject the AppointmentInterface (Repository).
     *
     * @param AppointmentInterface $appointmentInterface
     */
    public function __construct(
        protected AppointmentInterface $appointmentInterface
    ) {}

    /**
     * Retrieve an appointment by its ID.
     *
     * @param int $id
     * @return Appointment|null
     */
    public function getAppointmentById(int $id): ?Appointment
    {
        return $this->appointmentInterface->find($id);
    }

    /**
     * Update appointment status.
     *
     * @param int $appointmentId
     * @param string $status
     * @return Appointment|null
     */
    public function updateStatus(int $appointmentId, string $status): ?Appointment
    {
        $appointment = $this->appointmentInterface->find($appointmentId);
        if (! $appointment) return null;

        return $this->appointmentInterface->updateStatus($appointment, $status);
    }

    /**
     * Approve appointment and optionally assign employee.
     *
     * @param int $appointmentId
     * @param int|null $employeeId
     * @return Appointment|null
     */
    public function approveAppointment(int $appointmentId, ?int $employeeId = null): ?Appointment
    {
        $appointment = $this->appointmentInterface->find($appointmentId);
        if (! $appointment) return null;

        $data = ['status' => 'approved'];
        if ($employeeId) {
            $data['employee_id'] = $employeeId;
        }

        return $this->appointmentInterface->update($appointment, $data);
    }

    /**
     * Reject appointment with optional notes.
     *
     * @param int $appointmentId
     * @param string|null $notes
     * @return Appointment|null
     */
    public function rejectAppointment(int $appointmentId, ?string $notes = null): ?Appointment
    {
        $appointment = $this->appointmentInterface->find($appointmentId);
        if (! $appointment) return null;

        $data = ['status' => 'rejected'];
        if ($notes) {
            $data['notes'] = $notes;
        }

        return $this->appointmentInterface->update($appointment, $data);
    }
}
