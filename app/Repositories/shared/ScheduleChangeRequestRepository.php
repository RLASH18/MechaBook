<?php

namespace App\Repositories\shared;

use App\Interfaces\shared\ScheduleChangeRequestInterface;
use App\Models\EmployeeSchedule;
use App\Models\ScheduleChangeRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ScheduleChangeRequestRepository implements ScheduleChangeRequestInterface
{
    /**
     * Find a request by ID
     *
     * @param int $id
     * @return ScheduleChangeRequest|null
     */
    public function find(int $id): ?ScheduleChangeRequest
    {
        return ScheduleChangeRequest::with(['employee', 'reviewer'])->find($id);
    }

    /**
     * Approve a schedule change request and update employee schedule
     *
     * @param ScheduleChangeRequest $request
     * @param array $data
     * @return bool
     */
    public function approveRequest(ScheduleChangeRequest $request, array $data): bool
    {
        return DB::transaction(function () use ($request, $data) {
            // Update the request status
            $request->update([
                'status' => 'approved',
                'admin_notes' => $data['admin_notes'],
                'reviewed_by' => $data['reviewed_by'],
                'reviewed_at' => now()
            ]);

            // Apply the schedule change based on request type
            if ($request->request_type === 'time_change') {
                // Update existing schedule with new time
                EmployeeSchedule::where('employee_id', $request->employee_id)
                    ->where('day_of_week', $request->current_day_of_week)
                    ->update([
                        'start_time' => $request->requested_start_time,
                        'end_time' => $request->requested_end_time
                    ]);
            } elseif ($request->request_type === 'day_change') {
                // Delete old day schedule and create new one
                $oldSchedule = EmployeeSchedule::where('employee_id', $request->employee_id)
                    ->where('day_of_week', $request->current_day_of_week)
                    ->first();

                if ($oldSchedule) {
                    EmployeeSchedule::create([
                        'employee_id' => $request->employee_id,
                        'day_of_week' => $request->requested_day_of_week,
                        'start_time' => $oldSchedule->start_time,
                        'end_time' => $oldSchedule->end_time
                    ]);

                    $oldSchedule->delete();
                }
            } elseif ($request->request_type === 'day_off') {
                // Delete the schedule for that day
                EmployeeSchedule::where('employee_id', $request->employee_id)
                    ->where('day_of_week', $request->current_day_of_week)
                    ->delete();
            }

            return true;
        });
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
        return $request->update([
            'status' => 'rejected',
            'admin_notes' => $data['admin_notes'] ?? null,
            'reviewed_by' => $data['reviewed_by'],
            'reviewed_at' => now(),
        ]);
    }

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
}
