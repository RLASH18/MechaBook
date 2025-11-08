<?php

namespace App\Repositories;

use App\Interfaces\EmployeeInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class EmployeeRepository implements EmployeeInterface
{
    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function find(int $id): ?User
    {
        return User::find($id);
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * Update an existing user with new data.
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    /**
     * Delete a user.
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Get base query for employees with relations.
     *
     * @param array $relations
     * @return Builder
     */
    public function getBaseQuery(array $relations = []): Builder
    {
        $query = User::where('role', 'employee');

        if (! empty($relations)) {
            $query->with($relations);
        }

        return $query;
    }
}
