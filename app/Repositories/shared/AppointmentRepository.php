<?php

namespace App\Repositories\shared;

use App\Interfaces\shared\AppointmentInterface;
use App\Models\Appointment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
     * Get all appointments paginated with search and status filters (Admin)
     *
     * @param string|null $search
     * @param string|null $status
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getAllAppointmentsPaginated(?string $search, ?string $status, int $perPage = 10): LengthAwarePaginator
    {
        return Appointment::with(['customer', 'employee', 'service'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('customer', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('service', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->when($status && $status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get status counts for all appointments (Admin)
     *
     * @return array
     */
    public function getStatusCounts(): array
    {
        return [
            'all' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'approved' => Appointment::where('status', 'approved')->count(),
            'started' => Appointment::where('status', 'started')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'rejected' => Appointment::where('status', 'rejected')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];
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
        return Appointment::with(['customer', 'service'])
            ->where('employee_id', $employeeId)
            ->when($search, function ($query) use ($search) {
                $query->whereHas('customer', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('service', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            })
            ->when($status && $status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('appointment_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->paginate($perPage);
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
            'all' => Appointment::where('employee_id', $employeeId)->count(),
            'approved' => Appointment::where('employee_id', $employeeId)->where('status', 'approved')->count(),
            'started' => Appointment::where('employee_id', $employeeId)->where('status', 'started')->count(),
            'completed' => Appointment::where('employee_id', $employeeId)->where('status', 'completed')->count(),
        ];
    }
}
