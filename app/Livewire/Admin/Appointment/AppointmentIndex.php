<?php

namespace App\Livewire\Admin\Appointment;

use App\Models\Appointment;
use Livewire\Component;
use Livewire\WithPagination;

class AppointmentIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'all';

    protected $queryString = ['search', 'status'];

    // Refreshes the component when an appointment is updated
    protected $listeners = ['appointmentUpdated' => '$refresh'];

    /**
     * Resets pagination when the search input is updated
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Resets pagination when the status filter is updated
     */
    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Fetch appointments with relationships and filters
        $appointments = Appointment::with(['customer', 'employee', 'service'])
            ->when($this->search, function ($query) {
                $query->whereHas('customer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('service', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->orderBy('appointment_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        // Get status counts for filter tabs
        $statusCounts = [
            'all' => Appointment::count(),
            'pending' => Appointment::where('status', 'pending')->count(),
            'approved' => Appointment::where('status', 'approved')->count(),
            'started' => Appointment::where('status', 'started')->count(),
            'completed' => Appointment::where('status', 'completed')->count(),
            'rejected' => Appointment::where('status', 'rejected')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
        ];

        return view('livewire.admin.appointment.appointment-index', [
            'appointments' => $appointments,
            'statusCounts' => $statusCounts,
        ]);
    }
}
