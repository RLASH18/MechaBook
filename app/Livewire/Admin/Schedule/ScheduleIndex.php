<?php

namespace App\Livewire\Admin\Schedule;

use App\Livewire\Traits\WithFiltersAndPagination;
use App\Services\EmployeeScheduleService;
use Livewire\Component;

class ScheduleIndex extends Component
{
    use WithFiltersAndPagination;

    // Refreshes the component when a schedule is updated
    protected $listeners = ['scheduleUpdated' => '$refresh'];

    protected $scheduleService;

    /**
     * Inject the schedule service
     */
    public function boot(EmployeeScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function render()
    {
        // Fetch employees with schedules using service
        $employees = $this->scheduleService->getEmployeesWithSchedulesPaginated($this->search, 8);

        return view('livewire.admin.schedule.schedule-index', [
            'employees' => $employees
        ]);
    }
}
