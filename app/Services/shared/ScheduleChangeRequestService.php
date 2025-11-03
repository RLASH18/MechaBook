<?php

namespace App\Services\shared;

use App\Interfaces\shared\ScheduleChangeRequestInterface;
use App\Models\ScheduleChangeRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ScheduleChangeRequestService
{
    /**
     * Inject the ScheduleChangeRequestInterface (Repository)
     *
     * @param ScheduleChangeRequestInterface $requestInterface
     */
    public function __construct(
        protected ScheduleChangeRequestInterface $requestInterface
    ) {}

    /**
     * Find a request by ID
     *
     * @param int $id
     * @return ScheduleChangeRequest|null
     */
    public function getRequestById(int $id): ?ScheduleChangeRequest
    {
        return $this->requestInterface->find($id);
    }

    /**
     * Approve a schedule change request
     *
     * @param ScheduleChangeRequest $request
     * @param array $data
     * @return bool
     */
    public function approveRequest(ScheduleChangeRequest $request, array $data): bool
    {
        return $this->requestInterface->approveRequest($request, $data);
    }

    /**
     * Reject a schedule change request
     *
     * @param ScheduleChangeRequest $request
     * @param array $data
     * @return bool
     */
    public function rejectRequest(ScheduleChangeRequest $request, array $data): bool
    {
        return $this->requestInterface->rejectRequest($request, $data);
    }

    /**
     * Get schedule change requests paginated with search and status filters.
     *
     * @param string|null $search
     * @param string|null $status
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getRequestsPaginated(?string $search, ?string $status, int $perPage = 10): LengthAwarePaginator
    {
        return $this->requestInterface->getRequestsPaginated($search, $status, $perPage);
    }

    /**
     * Get all schedule change requests for a specific employee
     *
     * @param int $employeeId
     * @return Collection
     */
    public function getEmployeeRequests(int $employeeId): Collection
    {
        return $this->requestInterface->getEmployeeRequests($employeeId);
    }

    /**
     * Create a new schedule change request
     *
     * @param array $data
     * @return ScheduleChangeRequest
     */
    public function createRequest(array $data): ScheduleChangeRequest
    {
        return $this->requestInterface->createRequest($data);
    }
}
