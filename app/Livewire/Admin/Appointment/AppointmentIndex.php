<?php

namespace App\Livewire\Admin\Appointment;

use App\Livewire\Traits\WithFiltersAndPagination;
use App\Services\shared\AppointmentService;
use Livewire\Component;

class AppointmentIndex extends Component
{
    use WithFiltersAndPagination;

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

    public function render()
    {
        // Fetch appointments using service
        $appointments = $this->appointmentService->getAllAppointmentsPaginated(
            $this->search,
            $this->status,
            10
        );

        // Get status counts using service
        $statusCounts = $this->appointmentService->getStatusCounts();

        return view('livewire.admin.appointment.appointment-index', [
            'appointments' => $appointments,
            'statusCounts' => $statusCounts,
        ]);
    }
}
