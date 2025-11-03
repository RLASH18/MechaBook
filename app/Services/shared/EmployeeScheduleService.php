<?php

namespace App\Services\shared;

use App\Interfaces\shared\EmployeeScheduleInterface;
use App\Models\EmployeeSchedule;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EmployeeScheduleService
{
    /**
     * Inject the EmployeeScheduleInterface (Repository).
     *
     * @param EmployeeScheduleInterface $scheduleInterface
     */
    public function __construct(
        protected EmployeeScheduleInterface $scheduleInterface
    ) {}

    /**
     * Retrieve a schedule by ID.
     *
     * @param int $id
     * @return \App\Models\EmployeeSchedule|null
     */
    public function getScheduleById(int $id)
    {
        return $this->scheduleInterface->find($id);
    }

    /**
     * Create a new schedule.
     *
     * @param array $data
     * @return \App\Models\EmployeeSchedule
     */
    public function createSchedule(array $data)
    {
        return $this->scheduleInterface->create($data);
    }

    /**
     * Update schedule details by ID.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\EmployeeSchedule|null
     */
    public function updateSchedule(int $id, array $data)
    {
        $schedule = $this->scheduleInterface->find($id);
        if (! $schedule) return null;

        return $this->scheduleInterface->update($schedule, $data);
    }

    /**
     * Delete a schedule by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteSchedule(int $id)
    {
        $schedule = $this->scheduleInterface->find($id);
        if (! $schedule) return false;

        return $this->scheduleInterface->delete($schedule);
    }

    public function getEmployeesWithSchedulesPaginated(?string $search, int $perPage = 10): LengthAwarePaginator
    {
        return $this->scheduleInterface->getEmployeesWithSchedulesPaginated($search, $perPage);
    }

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
        foreach ($schedules as $schedule) {
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
