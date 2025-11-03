<?php

namespace App\Repositories\shared;

use App\Interfaces\shared\EmployeeScheduleInterface;
use App\Models\EmployeeSchedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EmployeeScheduleRepository implements EmployeeScheduleInterface
{
    /**
     * Find a schedule by ID
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
     * @return EmployeeSchedule
     */
    public function update(EmployeeSchedule $schedule, array $data): EmployeeSchedule
    {
        $schedule->update($data);
        return $schedule;
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
     * Get employees with their schedules paginated with search filter
     *
     * @param string|null $search
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getEmployeesWithSchedulesPaginated(?string $search, int $perPage = 10): LengthAwarePaginator
    {
        return User::where('role', 'employee')
            ->with(['employeeSchedules' => function ($query) {
                $query->orderByRaw("FIELD(day_of_week, 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun')");
            }])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('name')
            ->paginate($perPage);
    }

    /**
     * Get all schedules for a specific employee, sorted by day of week
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
     * Get today's schedule for a specific employee
     *
     * @param int $employeeId
     * @param string $dayOfWeek
     * @return \App\Models\EmployeeSchedule|null
     */
    public function getTodaySchedule(int $employeeId, string $dayOfWeek): ?EmployeeSchedule
    {
        return EmployeeSchedule::where('employee_id', $employeeId)
            ->where('day_of_week', $dayOfWeek)
            ->first();
    }

    /**
     * Get next upcoming schedule for a specific employee
     *
     * @param int $employeeId
     * @param string $currentDay
     * @return \App\Models\EmployeeSchedule|null
     */
    public function getNextSchedule(int $employeeId, string $currentDay): ?EmployeeSchedule
    {
        $dayOrder = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        $currentIndex = array_search($currentDay, $dayOrder);

        // Get all schedules for the employee
        $schedules = $this->getEmployeeSchedules($employeeId);

        // Look for next schedule in the week
        for ($i = 1; $i <= 7; $i++) {
            $nextIndex = ($currentIndex + $i) % 7;
            $nextDay = $dayOrder[$nextIndex];
            $nextSchedule = $schedules->where('day_of_week', $nextDay)->first();
            if ($nextSchedule) {
                return $nextSchedule;
            }
        }

        return null;
    }
}
