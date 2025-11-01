<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Services\employee\ScheduleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Inject the ScheduleService
     *
     * @param ScheduleService $scheduleService
     */
    public function __construct(
        protected ScheduleService $scheduleService
    ) {}

    /**
     * Display employee's personal schedule page
     */
    public function index()
    {
        $user = Auth::user();
        $currentDay = now()->format('D');

        // Get all schedules fo the employee
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

        return view('pages.employee.schedules', [
            'title' => 'MechaBook | Employee - Schedules',
            'currentDay' => $currentDay,
            'schedules' => $schedules,
            'todaySchedule' => $todaySchedule,
            'nextSchedule' => $nextSchedule,
            'totalHours' => $totalHours,
            'averageHours' => $averageHours,
            'daysOfWeek' => $daysOfWeek
        ]);
    }
}
