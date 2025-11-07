<?php

namespace App\Livewire\Admin\ScheduleChangeRequest;

use App\Livewire\Traits\WithFiltersAndPagination;
use App\Services\ScheduleChangeRequestService;
use Livewire\Component;

class RequestIndex extends Component
{
    use WithFiltersAndPagination;

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
