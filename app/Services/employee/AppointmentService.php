<?php

namespace App\Services\employee;

use App\Repositories\employee\AppointmentRepository;
use Illuminate\Database\Eloquent\Collection;

class AppointmentService
{
    /**
     * Inject the AppointmentRepository.
     *
     * @param AppointmentRepository $appointmentRepository
     */
    public function __construct(
        protected AppointmentRepository $appointmentRepository
    ) {}

    /**
     * Get all appointments for employee
     *
     * @param int $employeeId
     * @return Collection
     */
    public function getEmployeeAppointments(int $employeeId): Collection
    {
        return $this->appointmentRepository->getEmployeeAppointments($employeeId);
    }

    /**
     * Get appointment by ID
     *
     * @param int $appointmentId
     * @return \App\Models\Appointment|null
     */
    public function getAppointmentById(int $appointmentId)
    {
        return $this->appointmentRepository->getAppointmentById($appointmentId);
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
            $proofImagePath = $proofImage->store('appointment-proofs', 'public');
        }

        return $this->appointmentRepository->updateStatusWithProof($appointmentId, $status, $proofImagePath);
    }
}
