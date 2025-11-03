<?php

namespace App\Livewire\Admin\Appointment;

use App\Models\User;
use App\Services\shared\AppointmentService;
use App\UserRole;
use Livewire\Component;

class AppointmentActions extends Component
{
    // Modal States
    public $showShowModal = false;
    public $showApproveModal = false;
    public $showRejectModal = false;

    // Form Fields
    public $appointmentId;
    public $selectedEmployee;
    public $rejectNotes = '';

    protected $listeners = [
        'openShowModal',
        'openApproveModal',
        'openRejectModal',
        'updateStatus'
    ];

    protected $appointmentService;

    /**
     * Inject the appointment service for handling business logic
     */
    public function boot(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Open approve modal and load appointment data
     */
    public function openApproveModal($appointmentId)
    {
        $this->resetForm();
        $this->appointmentId = $appointmentId;

        $appointment = $this->appointmentService->getAppointmentById($appointmentId);
        if ($appointment && $appointment->employee_id) {
            $this->selectedEmployee = $appointment->employee_id;
        }

        $this->showApproveModal = true;
    }

    /**
     * Open reject modal
     */
    public function openRejectModal($appointmentId)
    {
        $this->resetForm();
        $this->appointmentId = $appointmentId;
        $this->showRejectModal = true;
    }

    /**
     * Open show/view details modal
     */
    public function openShowModal($appointmentId)
    {
        $this->resetForm();
        $this->appointmentId = $appointmentId;
        $this->showShowModal = true;
    }

    /**
     * Close all modals and reset form
     */
    public function closeModal()
    {
        $this->showApproveModal = false;
        $this->showRejectModal = false;
        $this->showShowModal = false;
        $this->resetForm();
    }

    /**
     * Reset form fields and clear validation errors
     */
    public function resetForm()
    {
        $this->appointmentId = null;
        $this->selectedEmployee = null;
        $this->rejectNotes = '';
        $this->resetValidation();
    }

    /**
     * Approve appointment and assign employee
     */
    public function approveAppointment()
    {
        $this->validate([
            'selectedEmployee' => 'required|exists:users,id',
        ], [
            'selectedEmployee.required' => 'Please select an employee to assign.',
            'selectedEmployee.exists' => 'Selected employee does not exist.',
        ]);

        $result = $this->appointmentService->approveAppointment(
            $this->appointmentId,
            $this->selectedEmployee
        );

        if ($result) {
            notyf()->success('Appointment approved and employee assigned successfully!');
            $this->closeModal();
            $this->dispatch('appointmentUpdated');
        } else {
            notyf()->error('Failed to approve appointment.');
        }
    }

    /**
     * Reject appointment with notes
     */
    public function rejectAppointment()
    {
        $this->validate([
            'rejectNotes' => 'nullable|string|max:500'
        ]);

        $result = $this->appointmentService->rejectAppointment(
            $this->appointmentId,
            $this->rejectNotes
        );

        if ($result) {
            notyf()->success('Appointment rejected successfully.');
            $this->closeModal();
            $this->dispatch('appointmentUpdated');
        } else {
            notyf()->error('Failed to reject appointment.');
        }
    }

    /**
     * Update appointment status (for started, completed, cancelled)
     */
    public function updateStatus($appointmentId, $status)
    {
        $result = $this->appointmentService->updateStatus($appointmentId, $status);

        if ($result) {
            notyf()->success('Appointment status updated to ' . ucfirst($status) . '!');
            $this->dispatch('appointmentUpdated');
        } else {
            notyf()->error('Failed to update appointment status.');
        }
    }

    public function render()
    {
        $employees = User::where('role', UserRole::Employee)
            ->orderBy('name')
            ->get();

        $appointment = null;
        if ($this->appointmentId) {
            $appointment = $this->appointmentService->getAppointmentById($this->appointmentId);
        }

        return view('livewire.admin.appointment.appointment-actions', [
            'employees' => $employees,
            'appointment' => $appointment
        ]);
    }
}
