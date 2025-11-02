<?php

namespace App\Services\admin;

use App\Interfaces\admin\ScheduleChangeRequestInterface;
use App\Models\ScheduleChangeRequest;

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
}
