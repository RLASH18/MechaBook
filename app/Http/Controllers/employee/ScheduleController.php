<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Services\ScheduleChangeRequestService;
use App\Services\EmployeeScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Inject the shared services
     *
     * @param EmployeeScheduleService $scheduleService
     * @param ScheduleChangeRequestService $requestService
     */
    public function __construct(
        protected EmployeeScheduleService $scheduleService,
        protected ScheduleChangeRequestService $requestService
    ) {}

    /**
     * Display employee's personal schedule page
     */
    public function index()
    {
        $user = Auth::user();
        $currentDay = now()->format('D');

        // Get all schedules for the employee
        $schedules = $this->scheduleService->getEmployeeSchedules($user->id);

        // Get today's schedule
        $todaySchedule = $this->scheduleService->getTodaySchedule($user->id, $currentDay);

        // Get next upcoming schedule
        $nextSchedule = $this->scheduleService->getNextSchedule($user->id, $currentDay);

        // Calculate statistics
        $totalHours = $this->scheduleService->calculateTotalHours($schedules);
        $averageHours = $this->scheduleService->calculateAverageHours($schedules);

        // Days of week mapping
        $daysOfWeek = [
            'Mon' => 'Monday',
            'Tue' => 'Tuesday',
            'Wed' => 'Wednesday',
            'Thu' => 'Thursday',
            'Fri' => 'Friday',
            'Sat' => 'Saturday',
            'Sun' => 'Sunday'
        ];

        // Get employee's schedule change requests
        $requests = $this->requestService->getEmployeeRequests($user->id);

        return view('pages.employee.schedules', [
            'title' => 'MechaBook | Employee - Schedules',
            'currentDay' => $currentDay,
            'schedules' => $schedules,
            'todaySchedule' => $todaySchedule,
            'nextSchedule' => $nextSchedule,
            'totalHours' => $totalHours,
            'averageHours' => $averageHours,
            'daysOfWeek' => $daysOfWeek,
            'requests' => $requests
        ]);
    }
}
