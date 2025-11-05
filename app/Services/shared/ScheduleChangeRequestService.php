<?php

namespace App\Services\shared;

use App\Interfaces\shared\ScheduleChangeRequestInterface;
use App\Models\EmployeeSchedule;
use App\Models\ScheduleChangeRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

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
     * Find a request by ID with its relations.
     *
     * @param int $id
     * @return ScheduleChangeRequest|null
     */
    public function getRequestById(int $id): ?ScheduleChangeRequest
    {
        return $this->requestInterface->find($id, ['employee', 'reviewer']);
    }

    /**
     * Approve a schedule change request and apply the changes.
     *
     * @param ScheduleChangeRequest $request
     * @param array $data
     * @return bool
     */
    public function approveRequest(ScheduleChangeRequest $request, array $data): bool
    {
        return DB::transaction(function () use ($request, $data) {
            $this->requestInterface->update($request, [
                'status' => 'approved',
                'admin_notes' => $data['admin_notes'],
                'reviewed_by' => $data['reviewed_by'],
                'reviewed_at' => now(),
            ]);

            if ($request->request_type === 'time_change') {
                EmployeeSchedule::where('employee_id', $request->employee_id)
                    ->where('day_of_week', $request->current_day_of_week)
                    ->update([
                        'start_time' => $request->requested_start_time,
                        'end_time' => $request->requested_end_time,
                    ]);
            } elseif ($request->request_type === 'day_change') {
                $oldSchedule = EmployeeSchedule::where('employee_id', $request->employee_id)
                    ->where('day_of_week', $request->current_day_of_week)
                    ->first();

                if ($oldSchedule) {
                    EmployeeSchedule::create([
                        'employee_id' => $request->employee_id,
                        'day_of_week' => $request->requested_day_of_week,
                        'start_time' => $oldSchedule->start_time,
                        'end_time' => $oldSchedule->end_time,
                    ]);

                    $oldSchedule->delete();
                }
            } elseif ($request->request_type === 'day_off') {
                EmployeeSchedule::where('employee_id', $request->employee_id)
                    ->where('day_of_week', $request->current_day_of_week)
                    ->delete();
            }

            return true;
        });
    }

    /**
     * Reject a schedule change request.
     *
     * @param ScheduleChangeRequest $request
     * @param array $data
     * @return bool
     */
    public function rejectRequest(ScheduleChangeRequest $request, array $data): bool
    {
        return $this->requestInterface->update($request, [
            'status' => 'rejected',
            'admin_notes' => $data['admin_notes'] ?? null,
            'reviewed_by' => $data['reviewed_by'],
            'reviewed_at' => now(),
        ]);
    }

    /**
     * Get paginated schedule change requests with optional search and status filters.
     *
     * @param string|null $search
     * @param string|null $status
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getRequestsPaginated(?string $search, ?string $status, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->requestInterface->getBaseQuery(['employee', 'reviewer']);

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($search) {
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        return $query->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get all schedule change requests for a specific employee.
     *
     * @param int $employeeId
     * @return Collection
     */
    public function getEmployeeRequests(int $employeeId): Collection
    {
        return $this->requestInterface->getEmployeeRequests($employeeId);
    }

    /**
     * Create a new schedule change request.
     *
     * @param array $data
     * @return ScheduleChangeRequest
     */
    public function createRequest(array $data): ScheduleChangeRequest
    {
        return $this->requestInterface->create($data);
    }
}
