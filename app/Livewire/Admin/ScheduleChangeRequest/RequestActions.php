<?php

namespace App\Livewire\Admin\ScheduleChangeRequest;

use App\Services\ScheduleChangeRequestService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RequestActions extends Component
{
    public $showApproveModal = false;
    public $showRejectModal = false;

    public $requestId;
    public $request;
    public $adminNotes = '';

    protected $listeners = ['openApproveModal', 'openRejectModal'];

    protected $requestService;

    /**
     * Inject the service
     */
    public function boot(ScheduleChangeRequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    /**
     * Open approve modal
     */
    public function openApproveModal($requestId)
    {
        $this->requestId = $requestId;
        $this->request = $this->requestService->getRequestById($requestId);
        $this->adminNotes = '';
        $this->showApproveModal = true;
    }

    /**
     * Open reject modal
     */
    public function openRejectModal($requestId)
    {
        $this->requestId = $requestId;
        $this->request = $this->requestService->getRequestById($requestId);
        $this->adminNotes = '';
        $this->showRejectModal = true;
    }

    /**
     * Close all modals
     */
    public function closeModal()
    {
        $this->showApproveModal = false;
        $this->showRejectModal = false;
        $this->resetForm();
    }

    /**
     * Approve the request
     */
    public function approveRequest()
    {
        $this->validate([
            'adminNotes' => 'nullable|string|max:500'
        ]);

        $data = [
            'admin_notes' => $this->adminNotes,
            'reviewed_by' => Auth::id()
        ];

        $this->requestService->approveRequest($this->request, $data);

        notyf()->success('Schedule change request approved successfully!');
        $this->closeModal();
        $this->dispatch('requestReviewed');
    }

    /**
     * Reject the request
     */
    public function rejectRequest()
    {
        $this->validate([
            'adminNotes' => 'required|string|min:10|max:500',
        ], [
            'adminNotes.required' => 'Please provide a reason for rejection.',
            'adminNotes.min' => 'Reason must be at least 10 characters.',
        ]);

        $data = [
            'admin_notes' => $this->adminNotes,
            'reviewed_by' => Auth::id(),
        ];

        $this->requestService->rejectRequest($this->request, $data);

        notyf()->success('Schedule change request rejected.');
        $this->closeModal();
        $this->dispatch('requestReviewed');
    }

    /**
     * Reset form
     */
    public function resetForm()
    {
        $this->requestId = null;
        $this->request = null;
        $this->adminNotes = '';
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.schedule-change-request.request-actions');
    }
}
