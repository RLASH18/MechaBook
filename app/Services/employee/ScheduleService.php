<?php

namespace App\Services\employee;

use App\Interfaces\employee\ScheduleInterface;
use App\Models\EmployeeSchedule;
use Illuminate\Database\Eloquent\Collection;

class ScheduleService
{
    /**
     * Inject the ScheduleInterface (Repository).
     *
     * @param ScheduleInterface $scheduleInterface
     */
    public function __construct(
        protected ScheduleInterface $scheduleInterface
    ) {}

    /**
     * Get all schedules for a specific employee
     *
     * @param int $employeeId
     * @return Collection
     */
    public function getEmployeeSchedules(int $employeeId): Collection
    {
        return $this->scheduleInterface->getEmployeeSchedules($employeeId);
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
        return $this->scheduleInterface->getTodaySchedule($employeeId, $dayOfWeek);
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
        return $this->scheduleInterface->getNextSchedule($employeeId, $currentDay);
    }

    /**
     * Calculate total weekly hours for an employee
     *
     * @param Collection $schedules
     * @return float
     */
    public function calculateTotalHours(Collection $schedules): float
    {
        $totalHours = 0;
        foreach($schedules as $schedule) {
            $start = strtotime($schedule->start_time);
            $end = strtotime($schedule->end_time);
            $totalHours += ($end - $start) / 3600;
        }

        return $totalHours;
    }

    /**
     * Calculate average hours per working day
     *
     * @param Collection $schedules
     * @return float
     */
    public function calculateAverageHours(Collection $schedules): float
    {
        if ($schedules->count() === 0) {
            return 0;
        }

        return $this->calculateTotalHours($schedules) / $schedules->count();
    }
}
