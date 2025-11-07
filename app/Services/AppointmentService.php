<?php

namespace App\Services;

use App\Interfaces\AppointmentInterface;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class AppointmentService
{
    /**
     * Inject the AppointmentInterface (Interface).
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
        return $this->appointmentInterface->findById($id, ['customer', 'employee', 'service']);
    }

    /**
     * Create a new appointment.
     *
     * @param array $data
     * @return Appointment|null
     */
    public function createAppointment(array $data): Appointment
    {
        return $this->appointmentInterface->create($data);
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
        $appointment = $this->findAppointmentWithRealations($appointmentId);

        if (! $appointment) {
            return null;
        }

        $this->appointmentInterface->update($appointment, ['status' => $status]);

        return $appointment->fresh(['customer', 'employee', 'service']);
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
        $appointment = $this->findAppointmentWithRealations($appointmentId);

        if (! $appointment) {
            return null;
        }

        $data = ['status' => 'approved'];

        if ($employeeId) {
            $data['employee_id'] = $employeeId;
        }

        $this->appointmentInterface->update($appointment, $data);

        return $appointment->fresh(['customer', 'employee', 'service']);
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
        $appointment = $this->findAppointmentWithRealations($appointmentId);

        if (! $appointment) {
            return null;
        }

        $data = ['status' => 'rejected'];

        if ($notes) {
            $data['notes'] = $notes;
        }

        $this->appointmentInterface->update($appointment, $data);

        return $appointment->fresh(['customer', 'employee', 'service']);
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
        $query = $this->appointmentInterface->getBaseQuery(['customer', 'employee', 'service']);

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($customerQuery) use ($search) {
                    $customerQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('service', function ($serviceQuery) use ($search) {
                        $serviceQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Apply status filter
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // Apply ordering
        $query->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc');

        return $query->paginate($perPage);
    }

    /**
     * Get status counts for all appointments (Admin)
     *
     * @return array
     */
    public function getStatusCounts(): array
    {
        return [
            'all' => $this->appointmentInterface->countByStatus(),
            'pending' => $this->appointmentInterface->countByStatus('pending'),
            'approved' => $this->appointmentInterface->countByStatus('approved'),
            'started' => $this->appointmentInterface->countByStatus('started'),
            'completed' => $this->appointmentInterface->countByStatus('completed'),
            'rejected' => $this->appointmentInterface->countByStatus('rejected'),
            'cancelled' => $this->appointmentInterface->countByStatus('cancelled'),
        ];
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
        $query = $this->appointmentInterface->getEmployeeAppointmentsQuery($employeeId, ['customer', 'service']);

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($customerQuery) use ($search) {
                    $customerQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('service', function ($serviceQuery) use ($search) {
                        $serviceQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Apply status filter
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // Apply ordering (ascending for employees - upcoming appointments first)
        $query->orderBy('appointment_date', 'asc')
            ->orderBy('start_time', 'asc');

        return $query->paginate($perPage);
    }

    /**
     * Get status counts for employee appointments (Employee)
     *
     * @param int $employeeId
     * @return array
     */
    public function getEmployeeStatusCounts(int $employeeId): array
    {
        return [
            'all' => $this->appointmentInterface->countByStatus(null, $employeeId),
            'approved' => $this->appointmentInterface->countByStatus('approved', $employeeId),
            'started' => $this->appointmentInterface->countByStatus('started', $employeeId),
            'completed' => $this->appointmentInterface->countByStatus('completed', $employeeId),
        ];
    }

    /**
     * Get customer appointments paginated with search and status filters (Customer)
     *
     * @param int $customerId
     * @param string|null $search
     * @param string|null $status
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getCustomerAppointmentsPaginated(int $customerId, ?string $search, ?string $status, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->appointmentInterface->getCustomerAppointmentsQuery($customerId, ['employee', 'service']);

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('service', function ($serviceQuery) use ($search) {
                    $serviceQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('category', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('employee', function ($employeeQuery) use ($search) {
                        $employeeQuery->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Apply status filter
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        // Apply ordering (descending - recent appointments first)
        $query->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc');

        return $query->paginate($perPage);
    }

    /**
     * Get status counts for customer appointments (Customer)
     *
     * @param int $customerId
     * @return array
     */
    public function getCustomerStatusCounts(int $customerId): array
    {
        return [
            'all' => $this->appointmentInterface->countByStatus(null, null, $customerId),
            'pending' => $this->appointmentInterface->countByStatus('pending', null, $customerId),
            'approved' => $this->appointmentInterface->countByStatus('approved', null, $customerId),
            'started' => $this->appointmentInterface->countByStatus('started', null, $customerId),
            'completed' => $this->appointmentInterface->countByStatus('completed', null, $customerId),
            'rejected' => $this->appointmentInterface->countByStatus('rejected', null, $customerId),
            'cancelled' => $this->appointmentInterface->countByStatus('cancelled', null, $customerId),
        ];
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
        $appointment = $this->appointmentInterface->findById($appointmentId);

        if (! $appointment) {
            return false;
        }

        $updateData = ['status' => $status];

        // Handle file upload if proof image is provided
        if ($proofImage) {
            $proofImagePath = $this->storeProofImage($proofImage);

            if ($status === 'started') {
                $updateData['started_proof_image'] = $proofImagePath;
            } elseif ($status === 'completed') {
                $updateData['completed_proof_image'] = $proofImagePath;
            }
        }

        return $this->appointmentInterface->update($appointment, $updateData);
    }

    /**
     * Store proof image and return the path.
     *
     * @param mixed $proofImage
     * @return string|null
     */
    private function storeProofImage($proofImage): ?string
    {
        $extension = $proofImage->getClientOriginalExtension();
        $proofImageName = 'proof_img_' . time() . '_' . uniqid() . '.' . $extension;

        return $proofImage->storeAs('appointment-proofs', $proofImageName, 'public');
    }

    /**
     * Check if customer has an active appointment for a specific service.
     * Active statuses: pending, approved, started
     *
     * @param int $customerId
     * @param int $serviceId
     * @return bool
     */
    public function hasActiveAppointmentForService(int $customerId, int $serviceId): bool
    {
        $query = $this->appointmentInterface->getBaseQuery();

        return $query->where('customer_id', $customerId)
            ->where('service_id', $serviceId)
            ->whereIn('status', ['pending', 'approved', 'started'])
            ->exists();
    }

    /**
     * Get all service IDs where customer has active appointments.
     * Active statuses: pending, approved, started
     *
     * @param int $customerId
     * @return array
     */
    public function getCustomerActiveAppointmentServiceIds(int $customerId): array
    {
        $query = $this->appointmentInterface->getBaseQuery();

        return $query->where('customer_id', $customerId)
            ->whereIn('status', ['pending', 'approved', 'started'])
            ->pluck('service_id')
            ->toArray();
    }

    /**
     * Find appointment with default relations or return null.
     *
     * @param int $id
     * @return Appointment|null
     */
    private function findAppointmentWithRealations(int $id): ?Appointment
    {
        return $this->appointmentInterface->findById($id, ['customer', 'employee', 'service']);
    }
}
