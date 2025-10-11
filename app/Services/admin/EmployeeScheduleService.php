<?php

namespace App\Services\admin;

use App\Interfaces\admin\EmployeeScheduleInterface;

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
     * Get all schedules for a specific employee.
     *
     * @param int $employeeId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getEmployeeSchedules(int $employeeId)
    {
        return $this->scheduleInterface->getByEmployee($employeeId);
    }

    /**
     * Get all schedules with employees grouped.
     *
     * @return mixed
     */
    public function getAllSchedulesWithEmployees()
    {
        return $this->scheduleInterface->getAllWithEmployees();
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
}
