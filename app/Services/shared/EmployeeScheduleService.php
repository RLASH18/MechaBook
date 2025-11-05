<?php

namespace App\Services\shared;

use App\Interfaces\shared\EmployeeScheduleInterface;
use App\Models\EmployeeSchedule;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EmployeeScheduleService
{
    /**
     * The list of days in a week.
     *
     * @var array
     */
    private const DAYS_OF_WEEK = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    /**
     * Inject the EmployeeScheduleInterface (Repository).
     *
     * @param EmployeeScheduleInterface $scheduleInterface
     */
    public function __construct(
        protected EmployeeScheduleInterface $scheduleInterface
    ) {}

    /**
     * Retrieve a schedule by its ID.
     *
     * @param int $id
     * @return EmployeeSchedule|null
     */
    public function getScheduleById(int $id): ?EmployeeSchedule
    {
        return $this->scheduleInterface->find($id);
    }

    /**
     * Create a new schedule.
     *
     * @param array $data
     * @return EmployeeSchedule
     */
    public function createSchedule(array $data): EmployeeSchedule
    {
        return $this->scheduleInterface->create($data);
    }

    /**
     * Update schedule details by ID.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateSchedule(int $id, array $data): bool
    {
        $schedule = $this->scheduleInterface->find($id);

        if (! $schedule) {
            return false;
        }

        return $this->scheduleInterface->update($schedule, $data);
    }

    /**
     * Delete a schedule by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteSchedule(int $id): bool
    {
        $schedule = $this->scheduleInterface->find($id);

        if (! $schedule) {
            return false;
        }

        return $this->scheduleInterface->delete($schedule);
    }

    /**
     * Get employees with their schedules paginated, with an optional search filter.
     *
     * @param string|null $search
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getEmployeesWithSchedulesPaginated(?string $search, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->scheduleInterface->getEmployeesBaseQuery();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        return $query->orderBy('name')->paginate($perPage);
    }

    /**
     * Get all schedules for a specific employee.
     *
     * @param int $employeeId
     * @return Collection
     */
    public function getEmployeeSchedules(int $employeeId): Collection
    {
        return $this->scheduleInterface->getEmployeeSchedules($employeeId);
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
        return $this->scheduleInterface->getTodaySchedule($employeeId, $dayOfWeek);
    }

    /**
     * Get the next upcoming schedule for a specific employee.
     *
     * @param int $employeeId
     * @param string $currentDay
     * @return EmployeeSchedule|null
     */
    public function getNextSchedule(int $employeeId, string $currentDay): ?EmployeeSchedule
    {
        $currentIndex = array_search($currentDay, self::DAYS_OF_WEEK);
        $schedules = $this->scheduleInterface->getEmployeeSchedules($employeeId);

        for ($i = 1; $i <= 7; $i++) {
            $nextIndex = ($currentIndex + $i) % 7;
            $nextDay = self::DAYS_OF_WEEK[$nextIndex];
            $nextSchedule = $schedules->where('day_of_week', $nextDay)->first();

            if ($nextSchedule) {
                return $nextSchedule;
            }
        }

        return null;
    }

    /**
     * Calculate the total weekly hours for an employee.
     *
     * @param Collection $schedules
     * @return float
     */
    public function calculateTotalHours(Collection $schedules): float
    {
        return $schedules->reduce(function ($carry, $schedule) {
            $start = strtotime($schedule->start_time);
            $end = strtotime($schedule->end_time);
            return $carry + (($end - $start) / 3600);
        }, 0);
    }

    /**
     * Calculate the average hours per working day.
     *
     * @param Collection $schedules
     * @return float
     */
    public function calculateAverageHours(Collection $schedules): float
    {
        $totalHours = $this->calculateTotalHours($schedules);
        $workingDays = $schedules->count();
        $averageHoursPerDay = $averageHoursPerDay = $workingDays > 0 ? $totalHours / $workingDays : 0;

        return $averageHoursPerDay;
    }
}
