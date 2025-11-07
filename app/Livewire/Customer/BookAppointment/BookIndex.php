<?php

namespace App\Livewire\Customer\BookAppointment;

use App\Livewire\Traits\WithFiltersAndPagination;
use App\Services\AppointmentService;
use App\Services\ServiceManager;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookIndex extends Component
{
    use WithFiltersAndPagination;

    protected $listeners = ['appointmentCreated' => '$refresh'];

    protected $serviceManager;
    protected $appointmentService;

    /**
     * Inject the service manager and appointment service
     */
    public function boot(
        ServiceManager $serviceManager,
        AppointmentService $appointmentService
    ) {
        $this->serviceManager = $serviceManager;
        $this->appointmentService = $appointmentService;
    }

    public function render()
    {
        $services = $this->serviceManager->getServicesPaginated($this->search, $this->status, 12);
        $activeAppointmentServiceIds = $this->appointmentService->getCustomerActiveAppointmentServiceIds(Auth::id());

        return view('livewire.customer.book-appointment.book-index', [
            'services' => $services,
            'activeAppointmentServiceIds' => $activeAppointmentServiceIds,
        ]);
    }
}
