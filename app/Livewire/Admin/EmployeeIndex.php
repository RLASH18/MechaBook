<?php

namespace App\Livewire\Admin;

use App\Services\admin\EmployeeService;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    protected $employeeService;

    /**
     * Inject the employee service
     */
    public function boot(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Resets pagination when the search input is updated
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Fetch employees using service
        $employees = $this->employeeService->getEmployeesPaginated($this->search, 10);

        return view('livewire.admin.employee-index', [
            'employees' => $employees
        ]);
    }
}
