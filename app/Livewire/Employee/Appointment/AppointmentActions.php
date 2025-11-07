<?php

namespace App\Livewire\Employee\Appointment;

use App\Services\AppointmentService;
use Livewire\Component;
use Livewire\WithFileUploads;

class AppointmentActions extends Component
{
    use WithFileUploads;

    public $showStartModal = false;
    public $showCompleteModal = false;

    public $appointmentId;
    public $proofImage;

    protected $listeners = ['openStartModal', 'openCompleteModal'];

    protected $appointmentService;

    public function boot(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Open start appointment modal
     */
    public function openStartModal($appointmentId)
    {
        $this->resetForm();
        $this->appointmentId = $appointmentId;
        $this->showStartModal = true;
    }

    /**
     * Open complete appointment modal
     */
    public function openCompleteModal($appointmentId)
    {
        $this->resetForm();
        $this->appointmentId = $appointmentId;
        $this->showCompleteModal = true;
    }

    /**
     * Close all modals
     */
    public function closeModal()
    {
        $this->showStartModal = false;
        $this->showCompleteModal = false;
        $this->resetForm();
    }

    /**
     * Start appointment with proof image
     */
    public function startAppointment()
    {
        $this->validate([
            'proofImage' => 'required|image|max:2048',
        ], [
            'proofImage.required' => 'Please upload a proof image.',
            'proofImage.image' => 'The file must be an image.',
            'proofImage.max' => 'The image must not exceed 2MB.',
        ]);

        $result = $this->appointmentService->updateStatusWithProof(
            $this->appointmentId,
            'started',
            $this->proofImage
        );

        if ($result) {
            notyf()->success('Appointment started successfully!');
            $this->closeModal();
            $this->dispatch('appointmentUpdated');
        } else {
            notyf()->error('Failed to start appointment.');
        }
    }

    /**
     * Complete appointment with proof image
     */
    public function completeAppointment()
    {
        $this->validate([
            'proofImage' => 'required|image|max:2048', // 2MB max
        ], [
            'proofImage.required' => 'Please upload a proof image.',
            'proofImage.image' => 'The file must be an image.',
            'proofImage.max' => 'The image must not exceed 2MB.',
        ]);

        $result = $this->appointmentService->updateStatusWithProof(
            $this->appointmentId,
            'completed',
            $this->proofImage
        );

        if ($result) {
            notyf()->success('Appointment completed successfully!');
            $this->closeModal();
            $this->dispatch('appointmentUpdated');
        } else {
            notyf()->error('Failed to complete appointment.');
        }
    }

    /**
     * Reset form fields
     */
    public function resetForm()
    {
        $this->appointmentId = null;
        $this->proofImage = null;
        $this->resetValidation();
    }

    public function render()
    {
        $appointment = null;
        if ($this->appointmentId) {
            $appointment = $this->appointmentService->getAppointmentById($this->appointmentId);
        }

        return view('livewire.employee.appointment.appointment-actions', [
            'appointment' => $appointment
        ]);
    }
}
