<?php

namespace App\Repositories\admin;

use App\Interfaces\admin\EmployeeScheduleInterface;
use App\Models\EmployeeSchedule;

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
}
