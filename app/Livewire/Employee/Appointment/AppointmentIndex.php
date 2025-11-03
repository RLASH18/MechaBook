<?php

namespace App\Livewire\Employee\Appointment;

use App\Services\shared\AppointmentService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class AppointmentIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'all';

    protected $queryString = ['search', 'status'];

    // Refreshes the component when an appointment is updated
    protected $listeners = ['appointmentUpdated' => '$refresh'];

    protected $appointmentService;

    /**
     * Inject the appointment service
     */
    public function boot(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Resets pagination when the search input is updated
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Resets pagination when the status filter is updated
     */
    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Fetch employee appointments using service
        $appointments = $this->appointmentService->getEmployeeAppointmentsPaginated(
            Auth::id(),
            $this->search,
            $this->status,
            10
        );

        // Get status counts using service
        $statusCounts = $this->appointmentService->getEmployeeStatusCounts(Auth::id());

        return view('livewire.employee.appointment.appointment-index', [
            'appointments' => $appointments,
            'statusCounts' => $statusCounts,
        ]);
    }
}
