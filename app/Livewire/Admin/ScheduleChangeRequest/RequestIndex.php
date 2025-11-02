<?php

namespace App\Livewire\Admin\ScheduleChangeRequest;

use App\Models\ScheduleChangeRequest;
use Livewire\Component;
use Livewire\WithPagination;

class RequestIndex extends Component
{
    use WithPagination;

    public $status = 'pending';
    public $search = '';

    protected $queryString = ['search', 'status'];
    protected $listeners = ['requestReviewed' => '$refresh'];

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
        $requests = ScheduleChangeRequest::with(['employee', 'reviewer'])
            ->when($this->status !== 'all', function ($q) {
                $q->where('status', $this->status);
            })
            ->when($this->search, function ($q) {
                $q->whereHas('employee', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.schedule-change-request.request-index', [
            'requests' => $requests
        ]);
    }
}
