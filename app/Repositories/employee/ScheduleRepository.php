<?php

namespace App\Repositories\employee;

use App\Interfaces\employee\ScheduleInterface;
use App\Models\EmployeeSchedule;
use Illuminate\Database\Eloquent\Collection;

class ScheduleRepository implements ScheduleInterface
{
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
