<?php

namespace App\Services\admin;

use App\Interfaces\admin\EmployeeInterface;
use App\UserRole;

class EmployeeServices
{
    /**
     * Inject the EmployeeInterface (Repository).
     *
     * @param EmployeeInterface $employeeInterface
     */
    public function __construct(
        protected EmployeeInterface $employeeInterface
    ) {}

    /**
     * Retrieve an employee by their ID.
     *
     * @param int $id
     * @return \App\Models\User|null
     */
    public function getEmployeeById(int $id)
    {
        return $this->employeeInterface->find($id);
    }

    /**
     * Create a new employee with default role = Employee.
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function createEmployee(array $data)
    {
        $data['role'] = UserRole::Employee;
        return $this->employeeInterface->create($data);
    }

    /**
     * Update employee details by ID.
     * If no password is provided, keep the old password.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\User|null
     */
    public function updateEmployee(int $id, array $data)
    {
        $user = $this->employeeInterface->find($id);
        if (!$user) return null;

        if (empty($data['password'])) {
            unset($data['password']);
        }

        return $this->employeeInterface->update($user, $data);
    }

    /**
     * Delete an employee by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteEmployee(int $id)
    {
        $user = $this->employeeInterface->find($id);
        if (!$user) return false;

        return $this->employeeInterface->delete($user);
    }
}
