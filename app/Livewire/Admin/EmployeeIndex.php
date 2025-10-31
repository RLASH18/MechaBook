<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    /**
     * Resets pagination when the search input is updated
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Fetch employees filtered by search term and ordered by newest
        $employees = User::where('role', 'employee')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.employee-index', [
            'employees' => $employees
        ]);
    }
}
