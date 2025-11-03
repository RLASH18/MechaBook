<?php

namespace App\Repositories\shared;

use App\Interfaces\shared\AppointmentInterface;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;

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

    /**
     * Get all appointments for a specific employee
     *
     * @param int $employeeId
     * @return Collection
     */
    public function getEmployeeAppointments(int $employeeId): Collection
    {
        return Appointment::where('employee_id', $employeeId)
            ->with(['customer', 'service'])
            ->whereIn('status', ['approved', 'started'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->get();
    }

    /**
     * Get appointment by ID
     *
     * @param int $appointmentId
     * @return \App\Models\Appointment|null
     */
    public function getAppointmentById(int $appointmentId): ?Appointment
    {
        return Appointment::with(['customer', 'service', 'employee'])->find($appointmentId);
    }

    /**
     * Update appointment status with proof image
     *
     * @param int $appointmentId
     * @param string $status
     * @param string|null $proofImagePath
     * @return bool
     */
    public function updateStatusWithProof(int $appointmentId, string $status, ?string $proofImagePath): bool
    {
        $appointment = Appointment::find($appointmentId);

        if (! $appointment) {
            return false;
        }

        $updateData = ['status' => $status];

        if ($status === 'started' && $proofImagePath) {
            $updateData['started_proof_image'] = $proofImagePath;
        } elseif ($status === 'completed' && $proofImagePath) {
            $updateData['started_proof_image'] = $proofImagePath;
        }

        return $appointment->update($updateData);
    }
}
