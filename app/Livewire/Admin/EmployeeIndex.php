<?php

namespace App\Livewire\Admin;

use App\Livewire\Traits\WithFiltersAndPagination;
use App\Services\admin\EmployeeService;
use Livewire\Component;

class EmployeeIndex extends Component
{
    use WithFiltersAndPagination;

    protected $employeeService;

    /**
     * Inject the employee service
     */
    public function boot(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
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
