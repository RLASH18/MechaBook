<?php

namespace App\Livewire\Employee\Appointment;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
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
        $appointments = Appointment::with(['customer', 'service'])
            ->where('employee_id', Auth::id())
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
            ->orderBy('appointment_date', 'asc')
            ->orderBy('start_time', 'asc')
            ->paginate(10);

        $statusCounts = [
            'all' => Appointment::where('employee_id', Auth::id())->count(),
            'approved' => Appointment::where('employee_id', Auth::id())->where('status', 'approved')->count(),
            'started' => Appointment::where('employee_id', Auth::id())->where('status', 'started')->count(),
            'completed' => Appointment::where('employee_id', Auth::id())->where('status', 'completed')->count(),
        ];

        return view('livewire.employee.appointment.appointment-index', [
            'appointments' => $appointments,
            'statusCounts' => $statusCounts,
        ]);
    }
}
