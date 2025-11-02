<?php

namespace App\Livewire\Employee\Schedule;

use App\Services\employee\ScheduleService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CalendarModal extends Component
{
    public $showModal = false;
    public $currentMonth;
    public $currentYear;
    public $calendarDays = [];
    public $schedules;

    protected $listeners = ['openCalendarModal'];

    protected $scheduleService;

    /**
     * Inject the schedule service
     */
    public function boot(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    /**
     * Initialize component
     */
    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->loadSchedules();
    }

    /**
     * Open the calendar modal
     */
    public function openCalendarModal()
    {
        $this->showModal = true;
        $this->loadSchedules();
        $this->generateCalendar();
    }

    /**
     * Close the modal
     */
    public function closeModal()
    {
        $this->showModal = false;
    }

    /**
     * Navigate to previous month
     */
    public function previousMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->generateCalendar();
    }

    /**
     * Navigate to next month
     */
    public function nextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->generateCalendar();
    }

    /**
     * Go to current month
     */
    public function goToToday()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->generateCalendar();
    }

    /**
     * Load employee schedule
     */
    public function loadSchedules()
    {
        $user = Auth::user();
        $this->schedules = $this->scheduleService->getEmployeeSchedules($user->id);
    }

    /**
     * Generate calendar grid for current month
     */
    public function generateCalendar()
    {
        $firstDay = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $daysInMonth = $firstDay->daysInMonth;
        $startDayOfWeek = $firstDay->dayOfWeek; // 0 = Sunday, 6 = Saturday

        // Adjust so monday is 0
        $startDayOfWeek = ($startDayOfWeek === 0) ? 6 : $startDayOfWeek - 1;

        $this->calendarDays = [];
        $dayCounter = 1;

        // Generate 6 weeks (max needed for any month)
        for ($week = 0; $week < 6; $week++) {
            $weekDays = [];

            for ($day = 0; $day < 7; $day++) {
                if (($week === 0 && $day < $startDayOfWeek) || $dayCounter > $daysInMonth) {
                    $weekDays[] = null; // Empty cell
                } else {
                    $date = Carbon::create($this->currentYear, $this->currentMonth, $dayCounter);
                    $dayOfWeek = $date->format('D'); // Mon, Tue, etc.

                    // Find schedule for this day of week
                    $schedule = $this->schedules->where('day_of_week', $dayOfWeek)->first();

                    $weekDays[] = [
                        'day' => $dayCounter,
                        'date' => $date,
                        'isToday' => $date->isToday(),
                        'isCurrentMonth' => true,
                        'dayOfWeek' => $dayOfWeek,
                        'schedule' => $schedule,
                    ];

                    $dayCounter++;
                }
            }

            $this->calendarDays[] = $weekDays;

            // Break if we've filled all days
            if ($dayCounter > $daysInMonth) {
                break;
            }
        }
    }

    public function render()
    {
        return view('livewire.employee.schedule.calendar-modal');
    }
}
