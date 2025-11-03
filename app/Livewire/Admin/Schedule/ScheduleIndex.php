<?php

namespace App\Livewire\Admin\Schedule;

use App\Models\User;
use App\Services\shared\EmployeeScheduleService;
use Livewire\Component;
use Livewire\WithPagination;

class ScheduleIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

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

    /**
     * Resets pagination when the search input is updated
     */
    public function updatingSearch()
    {
        $this->resetPage();
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
