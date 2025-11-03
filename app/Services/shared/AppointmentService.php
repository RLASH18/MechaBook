<?php

namespace App\Services\shared;

use App\Interfaces\shared\AppointmentInterface;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    /**
     * Get all appointments paginated with search and status filters (Admin)
     *
     * @param string|null $search
     * @param string|null $status
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllAppointmentsPaginated(?string $search, ?string $status, int $perPage = 10): LengthAwarePaginator
    {
        return $this->appointmentInterface->getAllAppointmentsPaginated($search, $status, $perPage);
    }

    /**
     * Get status counts for all appointments (Admin)
     *
     * @return array
     */
    public function getStatusCounts(): array
    {
        return $this->appointmentInterface->getStatusCounts();
    }

    /**
     * Get all employees ordered by name for appointment assignment.
     *
     * @return Collection
     */
    public function getAllEmployees(): Collection
    {
        return $this->appointmentInterface->getAllEmployees();
    }

    /**
     * Get employee appointments paginated with search and status filters (Employee)
     *
     * @param int $employeeId
     * @param string|null $search
     * @param string|null $status
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getEmployeeAppointmentsPaginated(int $employeeId, ?string $search, ?string $status, int $perPage = 10): LengthAwarePaginator
    {
        return $this->appointmentInterface->getEmployeeAppointmentsPaginated($employeeId, $search, $status, $perPage);
    }

    /**
     * Get status counts for employee appointments (Employee)
     *
     * @param int $employeeId
     * @return array
     */
    public function getEmployeeStatusCounts(int $employeeId): array
    {
        return $this->appointmentInterface->getEmployeeStatusCounts($employeeId);
    }

    /**
     * Update appointment status with proof image
     *
     * @param int $appointmentId
     * @param string $status
     * @param mixed $proofImage
     * @return bool
     */
    public function updateStatusWithProof(int $appointmentId, string $status, $proofImage): bool
    {
        $proofImagePath = null;

        if ($proofImage) {
            $extension = $proofImage->getClientOriginalExtension();
            $proofImageName = 'proof_img_' . time() . '_' . uniqid() . '.' . $extension;
            $proofImagePath = $proofImage->storeAs('appointment-proofs', $proofImageName, 'public');
        }

        return $this->appointmentInterface->updateStatusWithProof($appointmentId, $status, $proofImagePath);
    }
}
