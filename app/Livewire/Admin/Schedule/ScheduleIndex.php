<?php

namespace App\Livewire\Admin\Schedule;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ScheduleIndex extends Component
{
    use WithPagination;

    public $search = '';

    // Refreshes the component when a schedule is updated
    protected $listeners = ['scheduleUpdated' => '$refresh'];

    /**
     * Render the component view
     */
    public function render()
    {
        $employees = User::where('role', 'employee')
            ->with(['employeeSchedules' => function ($query) {
                $query->orderByRaw("FIELD(day_of_week, 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun')");
            }])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy('name')
            ->paginate(8);

        return view('livewire.admin.schedule.schedule-index', [
            'employees' => $employees
        ]);
    }
}
