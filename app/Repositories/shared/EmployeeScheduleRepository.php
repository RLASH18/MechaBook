<?php

namespace App\Repositories\shared;

use App\Interfaces\shared\EmployeeScheduleInterface;
use App\Models\EmployeeSchedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class EmployeeScheduleRepository implements EmployeeScheduleInterface
{
    /**
     * Find a schedule by ID.
     *
     * @param int $id
     * @return EmployeeSchedule|null
     */
    public function find(int $id): ?EmployeeSchedule
    {
        return EmployeeSchedule::find($id);
    }

    /**
     * Create a new schedule.
     *
     * @param array $data
     * @return EmployeeSchedule
     */
    public function create(array $data): EmployeeSchedule
    {
        return EmployeeSchedule::create($data);
    }

    /**
     * Update an existing schedule.
     *
     * @param EmployeeSchedule $schedule
     * @param array $data
     * @return bool
     */
    public function update(EmployeeSchedule $schedule, array $data): bool
    {
        return $schedule->update($data);
    }

    /**
     * Delete a schedule.
     *
     * @param EmployeeSchedule $schedule
     * @return bool
     */
    public function delete(EmployeeSchedule $schedule): bool
    {
        return $schedule->delete();
    }

    /**
     * Get the base query for employees with their schedules.
     *
     * @return Builder
     */
    public function getEmployeesBaseQuery(): Builder
    {
        return User::where('role', 'employee')
            ->with(['employeeSchedules' => function ($query) {
                $query->orderByRaw("FIELD(day_of_week, 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun')");
            }]);
    }

    /**
     * Get all schedules for a specific employee, sorted by day of the week.
     *
     * @param int $employeeId
     * @return Collection
     */
    public function getEmployeeSchedules(int $employeeId): Collection
    {
        return EmployeeSchedule::where('employee_id', $employeeId)
            ->orderByRaw("FIELD(day_of_week, 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun')")
            ->get();
    }

    /**
     * Get today's schedule for a specific employee.
     *
     * @param int $employeeId
     * @param string $dayOfWeek
     * @return EmployeeSchedule|null
     */
    public function getTodaySchedule(int $employeeId, string $dayOfWeek): ?EmployeeSchedule
    {
        return EmployeeSchedule::where('employee_id',$employeeId)
            ->where('day_of_week', $dayOfWeek)
            ->first();
    }
}
