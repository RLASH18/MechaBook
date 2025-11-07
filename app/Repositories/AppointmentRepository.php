<?php

namespace App\Repositories;

use App\Interfaces\AppointmentInterface;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class AppointmentRepository implements AppointmentInterface
{
    /**
     * Find an appointment by ID with optional relations.
     *
     * @param int $id
     * @param array $relations
     * @return Appointment|null
     */
    public function findById(int $id, array $relations = []): ?Appointment
    {
        $query = Appointment::query();

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query->find($id);
    }

    /**
     * Create a new appointment.
     *
     * @param array $data
     * @return Appointment
     */
    public function create(array $data): Appointment
    {
        return Appointment::create($data);
    }

    /**
     * Update an appointment with given data.
     *
     * @param Appointment $appointment
     * @param array $data
     * @return bool
     */
    public function update(Appointment $appointment, array $data): bool
    {
        return $appointment->update($data);
    }

    /**
     * Get base query for appointments with relations.
     *
     * @param array $relations
     * @return Builder
     */
    public function getBaseQuery(array $relations = []): Builder
    {
        $query = Appointment::query();

        if (!empty($relations)) {
            $query->with($relations);
        }

        return $query;
    }

    /**
     * Get appointments query filtered by employee.
     *
     * @param int $employeeId
     * @param array $relations
     * @return Builder
     */
    public function getEmployeeAppointmentsQuery(int $employeeId, array $relations = []): Builder
    {
        return $this->getBaseQuery($relations)->where('employee_id', $employeeId);
    }

    /**
     * Count appointments by status.
     *
     * @param string|null $status
     * @param int|null $employeeId
     * @return int
     */
    public function countByStatus(?string $status = null, ?int $employeeId = null): int
    {
        $query = Appointment::query();

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        return $query->count();
    }

    /**
     * Get all employees with employee role.
     *
     * @return Collection
     */
    public function getAllEmployees(): Collection
    {
        return User::where('role', 'employee')
            ->orderBy('name')
            ->get();
    }
}
