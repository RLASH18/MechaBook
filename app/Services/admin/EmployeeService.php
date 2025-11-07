<?php

namespace App\Services\admin;

use App\Interfaces\admin\EmployeeInterface;
use App\UserRole;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EmployeeService
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
        if (! $user) {
            return null;
        }

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
        if (! $user)  {
            return false;
        }

        return $this->employeeInterface->delete($user);
    }

    /**
     * Get employees paginated with search filter.
     *
     * @param string|null $search
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getEmployeesPaginated(?string $search, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->employeeInterface->getBaseQuery();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $query->orderBy('created_at', 'desc');

        return $query->paginate($perPage);
    }
}
