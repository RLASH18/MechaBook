<?php

namespace App\Repositories\employee;

use App\Interfaces\employee\AppointmentInterface;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;

class AppointmentRepository implements AppointmentInterface
{
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
