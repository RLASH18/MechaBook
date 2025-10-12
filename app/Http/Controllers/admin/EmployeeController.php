<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\employee\StoreEmployeeRequest;
use App\Http\Requests\admin\employee\UpdateEmployeeRequest;
use App\Services\admin\EmployeeService;
use Illuminate\Http\RedirectResponse;

class EmployeeController extends Controller
{
    /**
     * EmployeeService dependency injection.
     */
    public function __construct(
        protected EmployeeService $employeeService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.employees.index', [
            'title' => 'MechaBook | Admin - Employee Management'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.employees.create', [
            'title' => 'MechaBook | Admin - New Employee'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEmployeeRequest $request)
    {
        $this->employeeService->createEmployee($request->validated());
        return $this->employeeSuccess('Employee added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = $this->employeeService->getEmployeeById((int) $id);
        if (!$employee) {
            return $this->employeeNotFound();
        }

        return view('admin.employees.show', [
            'title' => 'MechaBook | Admin - View Employee',
            'employee' => $employee
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = $this->employeeService->getEmployeeById((int) $id);
        if (!$employee) {
            return $this->employeeNotFound();
        }

        return view('admin.employees.update', [
            'title' => 'MechaBook | Admin - Edit Employee',
            'employee' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEmployeeRequest $request, string $id)
    {
        $employee = $this->employeeService->updateEmployee((int) $id, $request->validated());
        if (!$employee) {
            return $this->employeeNotFound();
        }

        return $this->employeeSuccess('Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = $this->employeeService->deleteEmployee((int) $id);
        if (!$employee) {
            return $this->employeeNotFound();
        }

        return $this->employeeSuccess('Employee deleted successfully');
    }

    /**
     * Show success notification and redirect to employee list
     */
    private function employeeSuccess(string $message): RedirectResponse
    {
        notyf()->success($message);
        return redirect()->route('admin.employee.index');
    }

    /**
     * Show error notification for missing employee and redirect
     */
    private function employeeNotFound(): RedirectResponse
    {
        notyf()->error('Employee not found!');
        return redirect()->route('admin.employee.index');
    }
}
