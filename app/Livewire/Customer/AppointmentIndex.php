<?php

namespace App\Livewire\Customer;

use App\Livewire\Traits\WithFiltersAndPagination;
use App\Services\AppointmentService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AppointmentIndex extends Component
{
    use WithFiltersAndPagination;

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
        $customerId = Auth::id();

        // Fetch customers appointments
        $appointments = $this->appointmentService->getCustomerAppointmentsPaginated(
            $customerId,
            $this->search,
            $this->status,
            10,
        );

        // Get status counts using service
        $statusCounts = $this->appointmentService->getCustomerStatusCounts($customerId);

        return view('livewire.customer.appointment-index', [
            'appointments' => $appointments,
            'statusCounts' => $statusCounts
        ]);
    }
}
