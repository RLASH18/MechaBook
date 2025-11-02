<?php

namespace App\Livewire\Employee\Schedule;

use App\Http\Requests\employee\StoreScheduleChangeRequest;
use App\Services\employee\ScheduleChangeRequestService;
use App\Services\employee\ScheduleService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RequestChangeModal extends Component
{
    public $showModal = false;

    public $schedules;
    public $selectedDay = '';
    public $requestType = 'time_change';
    public $requestedDay = '';
    public $requestedStartTime = '';
    public $requestedEndTime = '';
    public $reason = '';

    public $daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    protected $listeners = ['openRequestChangeModal'];

    protected $scheduleService;
    protected $requestService;

    /**
     * Inject services
     */
    public function boot(
        ScheduleService $scheduleService,
        ScheduleChangeRequestService $requestService
    ) {
        $this->scheduleService = $scheduleService;
        $this->requestService = $requestService;
    }

    /**
     * Initialize component
     */
    public function mount()
    {
        $this->loadSchedules();
    }

    /**
     * Open the request change modal
     */
    public function openRequestChangeModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    /**
     * Close the modal
     */
    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    /**
     * Load employee schedules
     */
    public function loadSchedules()
    {
        $user = Auth::user();
        $this->schedules = $this->scheduleService->getEmployeeSchedules($user->id);
    }

    /**
     * Get current schedule for selected day
     */
    public function getCurrentSchedule()
    {
        if (! $this->selectedDay) {
            return null;
        }

        return $this->schedules->where('day_of_week', $this->selectedDay)->first();
    }

    /**
     * Submit the schedule change request
     */
    public function submitRequest()
    {
        $request = new StoreScheduleChangeRequest();
        $validated = $this->validate($request->rules(), $request->messages());

        $currentSchedule = $this->getCurrentSchedule();

        $requestedDay = $this->requestType === 'day_change' ? $this->requestedDay : null;
        $requestedStartTime = $this->requestType === 'time_change' ? $this->requestedStartTime : null;
        $requestedEndTime = $this->requestType === 'time_change' ? $this->requestedEndTime : null;

        $data = [
            'employee_id' => Auth::id(),
            'request_type' => $this->requestType,
            'current_day_of_week' => $this->selectedDay,
            'current_start_time' => $currentSchedule?->start_time,
            'current_end_time' => $currentSchedule?->end_time,
            'requested_day_of_week' => $requestedDay,
            'requested_start_time' => $requestedStartTime,
            'requested_end_time' => $requestedEndTime,
            'reason' => $this->reason,
            'status' => 'pending',
        ];

        $this->requestService->createRequest($data);

        notyf()->success('Schedule change request submitted successfully!');
        $this->closeModal();
    }

    /**
     * Reset form fields
     */
    public function resetForm()
    {
        $this->selectedDay = '';
        $this->requestType = 'time_change';
        $this->requestedDay = '';
        $this->requestedStartTime = '';
        $this->requestedEndTime = '';
        $this->reason = '';
        $this->resetValidation();
    }

    public function render()
    {
        $currentSchedule = $this->getCurrentSchedule();

        return view('livewire.employee.schedule.request-change-modal', [
            'currentSchedule' => $currentSchedule
        ]);
    }
}
