<?php

namespace App\Repositories\employee;

use App\Interfaces\employee\ScheduleChangeRequestInterface;
use App\Models\ScheduleChangeRequest;
use Illuminate\Database\Eloquent\Collection;

class ScheduleChangeRequestRepository implements ScheduleChangeRequestInterface
{
    /**
     * Get all schedule change requests for a specific employee
     *
     * @param int $employeeId
     * @return Collection
     */
    public function getEmployeeRequests(int $employeeId): Collection
    {
        return ScheduleChangeRequest::where('employee_id', $employeeId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Create a new schedule change request
     *
     * @param array $data
     * @return ScheduleChangeRequest
     */
    public function createRequest(array $data): ScheduleChangeRequest
    {
        return ScheduleChangeRequest::create($data);
    }

    /**
     * Get pending requests for a specific employee
     *
     * @param int $employeeId
     * @return Collection
     */
    public function getPendingRequests(int $employeeId): Collection
    {
        return ScheduleChangeRequest::where('employee_id', $employeeId)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
