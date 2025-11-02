<?php

namespace App\Services\employee;

use App\Interfaces\employee\ScheduleChangeRequestInterface;
use App\Models\ScheduleChangeRequest;
use Illuminate\Database\Eloquent\Collection;

class ScheduleChangeRequestService
{
    /**
     * Inject the ScheduleChangeRequestInterface (Repository).
     *
     * @param ScheduleChangeRequestInterface $scheduleChangeRequestInterface
     */
    public function __construct(
        protected ScheduleChangeRequestInterface $scheduleChangeRequestInterface
    ) {}

    /**
     * Get all schedule change requests for a specific employee
     *
     * @param int $employeeId
     * @return Collection
     */
    public function getEmployeeRequests(int $employeeId): Collection
    {
        return $this->scheduleChangeRequestInterface->getEmployeeRequests($employeeId);
    }

    /**
     * Create a new schedule change request
     *
     * @param array $data
     * @return ScheduleChangeRequest
     */
    public function createRequest(array $data): ScheduleChangeRequest
    {
        return $this->scheduleChangeRequestInterface->createRequest($data);
    }

    /**
     * Get pending requests for a specific employee
     *
     * @param int $employeeId
     * @return Collection
     */
    public function getPendingRequests(int $employeeId): Collection
    {
        return $this->scheduleChangeRequestInterface->getPendingRequests($employeeId);
    }
}
