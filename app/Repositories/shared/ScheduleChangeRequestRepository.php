<?php

namespace App\Repositories\shared;

use App\Interfaces\shared\ScheduleChangeRequestInterface;
use App\Models\ScheduleChangeRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ScheduleChangeRequestRepository implements ScheduleChangeRequestInterface
{
    /**
     * Find a request by ID with optional relations.
     *
     * @param int $id
     * @param array $relations
     * @return ScheduleChangeRequest|null
     */
    public function find(int $id, array $relations = []): ?ScheduleChangeRequest
    {
        $query = ScheduleChangeRequest::query();

        if (! empty($relations)) {
            $query->with($relations);
        }

        return $query->find($id);
    }

    /**
     * Create a new schedule change request.
     *
     * @param array $data
     * @return ScheduleChangeRequest
     */
    public function create(array $data): ScheduleChangeRequest
    {
        return ScheduleChangeRequest::create($data);
    }

    /**
     * Update a schedule change request.
     *
     * @param ScheduleChangeRequest $request
     * @param array $data
     * @return bool
     */
    public function update(ScheduleChangeRequest $request, array $data): bool
    {
        return $request->update($data);
    }

    /**
     * Get the base query for schedule change requests.
     *
     * @param array $relations
     * @return Builder
     */
    public function getBaseQuery(array $relations = []): Builder
    {
        $query = ScheduleChangeRequest::query();

        if (! empty($query)) {
            $query->with($relations);
        }

        return $query;
    }

    /**
     * Get all schedule change requests for a specific employee.
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
}
