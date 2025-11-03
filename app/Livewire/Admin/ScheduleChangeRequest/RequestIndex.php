<?php

namespace App\Livewire\Admin\ScheduleChangeRequest;

use App\Services\shared\ScheduleChangeRequestService;
use Livewire\Component;
use Livewire\WithPagination;

class RequestIndex extends Component
{
    use WithPagination;

    public $status = 'pending';
    public $search = '';

    protected $queryString = ['search', 'status'];
    protected $listeners = ['requestReviewed' => '$refresh'];

    protected $requestService;

    /**
     * Inject the request service
     */
    public function boot(ScheduleChangeRequestService $requestService)
    {
        $this->requestService = $requestService;
    }

    /**
     * Reset pagination when filters change
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    /**
     * Get badge color based on status
     */
    public function getStatusColor($status)
    {
        return match ($status) {
            'pending' => 'bg-yellow-100 text-yellow-700',
            'approved' => 'bg-green-100 text-green-700',
            'rejected' => 'bg-red-100 text-red-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }

    /**
     * Get request type label
     */
    public function getRequestTypeLabel($type)
    {
        return match ($type) {
            'time_change' => 'Time Change',
            'day_change' => 'Day Change',
            'day_off' => 'Day Off',
            default => ucfirst($type)
        };
    }

    public function render()
    {
        // Fetch requests using service
        $requests = $this->requestService->getRequestsPaginated($this->search, $this->status, 5);

        return view('livewire.admin.schedule-change-request.request-index', [
            'requests' => $requests
        ]);
    }
}
