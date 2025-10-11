<?php

namespace App\Livewire\Admin\Schedule;

use App\Http\Requests\admin\schedule\StoreScheduleRequest;
use App\Http\Requests\admin\schedule\UpdateScheduleRequest;
use App\Services\admin\EmployeeScheduleService;
use Livewire\Component;

class ScheduleForm extends Component
{
    // Modal States
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showDeleteModal = false;

    // Form fields
    public $scheduleId;
    public $employee_id;
    public $day_of_week;
    public $start_time;
    public $end_time;

    // Days of week
    public $daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    protected $scheduleService;

    protected $listeners = [
        'openCreateModal',
        'openEditModal',
        'openDeleteModal',
    ];

    /**
     * Inject the schedule service for handling business logic
     */
    public function boot(EmployeeScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    /**
     * Open create modal and set employee ID
     */
    public function openCreateModal($employeeId)
    {
        $this->resetForm();
        $this->employee_id = $employeeId;
        $this->showCreateModal = true;
    }

    /**
     * Open edit modal and load schedule data
     * Formats time from database (H:i:s) to form format (H:i)
     */
    public function openEditModal($scheduleId)
    {
        $schedule = $this->scheduleService->getScheduleById($scheduleId);

        if ($schedule) {
            $this->scheduleId = $schedule->id;
            $this->employee_id = $schedule->employee_id;
            $this->day_of_week = $schedule->day_of_week;
            $this->start_time = date('H:i', strtotime($schedule->start_time));
            $this->end_time = date('H:i', strtotime($schedule->end_time));
            $this->showEditModal = true;
        }
    }

    /**
     * Open delete confirmation modal
     */
    public function openDeleteModal($scheduleId)
    {
        $this->scheduleId = $scheduleId;
        $this->showDeleteModal = true;
    }

    /**
     * Close all modals and reset form
     */
    public function closeModal()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    /**
     * Reset form fields and clear validation errors
     */
    public function resetForm()
    {
        $this->scheduleId = null;
        $this->employee_id = null;
        $this->day_of_week = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->resetValidation();
    }

    /**
     * Create new schedule and notify parent component to refresh
     */
    public function createSchedule()
    {
        $request = new StoreScheduleRequest();
        $validated = $this->validate($request->rules(), $request->messages());

        $this->scheduleService->createSchedule($validated);

        notyf()->success('Schedule created successfully!');
        $this->closeModal();
        $this->dispatch('scheduleUpdated');
    }

    /**
     * Update existing schedule and notify parent component to refresh
     */
    public function updateSchedule()
    {
        $request = new UpdateScheduleRequest();
        $validated = $this->validate($request->rules(), $request->messages());

        $this->scheduleService->updateSchedule($this->scheduleId, $validated);

        notyf()->success('Schedule updated successfully!');
        $this->closeModal();
        $this->dispatch('scheduleUpdated');
    }

    /**
     * Delete schedule and notify parent component to refresh
     */
    public function deleteSchedule()
    {
        $this->scheduleService->deleteSchedule($this->scheduleId);

        notyf()->success('Schedule deleted successfully!');
        $this->closeModal();
        $this->dispatch('scheduleUpdated');
    }

    /**
     * Render the component view
     */
    public function render()
    {
        return view('livewire.admin.schedule.schedule-form');
    }
}
