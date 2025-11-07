<?php

namespace App\Livewire\Customer\BookAppointment;

use App\Http\Requests\customer\StoreAppointmentRequest;
use App\Services\AppointmentService;
use App\Services\ServiceManager;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class BookActions extends Component
{
    public $showDetailsModal = false;
    public $showBookModal = false;

    public $serviceId;
    public $service;

    public $appointment_date;
    public $start_time;
    public $end_time;
    public $notes;

    protected $listeners = ['openDetailsModal', 'openBookModal'];

    protected $appointmentService;
    protected $serviceManager;

    public function boot(
        AppointmentService $appointmentService,
        ServiceManager $serviceManager
    ) {
        $this->appointmentService = $appointmentService;
        $this->serviceManager = $serviceManager;
    }

    /**
     * Open service details modal
     */
    public function openDetailsModal($serviceId)
    {
        $this->resetForm();
        $this->serviceId = $serviceId;
        $this->loadService();
        $this->showDetailsModal = true;
    }

    /**
     * Open book appointment modal
     */
    public function openBookModal($serviceId)
    {
        $this->resetForm();
        $this->serviceId = $serviceId;
        $this->loadService();
        $this->showBookModal = true;
    }

    /**
     * Load service details
     */
    public function loadService()
    {
        $this->service = $this->serviceManager->getServiceById($this->serviceId);
    }

    /**
     * Close all modals
     */
    public function closeModal()
    {
        $this->showDetailsModal = false;
        $this->showBookModal = false;
        $this->resetForm();
    }

    /**
     * Create appointment
     */
    public function createAppointment()
    {
        // Check if customer already has an active appointment for this service
        $hasActiveAppointment = $this->appointmentService->hasActiveAppointmentForService(Auth::id(), $this->serviceId);
        if ($hasActiveAppointment) {
            notyf()->error('You already have an active appointment for this service. Please wait until it is completed.');
            $this->closeModal();
            return;
        }

        $request = new StoreAppointmentRequest();
        $validated = $this->validate($request->rules(), $request->messages());

        $result = $this->appointmentService->createAppointment([
            'customer_id' => Auth::id(),
            'service_id' => $this->serviceId,
            'appointment_date' => $this->appointment_date,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'notes' => $this->notes,
            'status' => 'pending',
        ]);

        if ($result) {
            notyf()->success('Appointment booked successfully! Waiting for admin approval.');
            $this->closeModal();
            $this->dispatch('appointmentCreated');
        } else {
            notyf()->error('Failed to book appointment. Please try again.');
        }
    }

    /**
     * Reset form fields
     */
    public function resetForm()
    {
        $this->serviceId = null;
        $this->service = null;
        $this->appointment_date = null;
        $this->start_time = null;
        $this->end_time = null;
        $this->notes = null;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.customer.book-appointment.book-actions');
    }
}
