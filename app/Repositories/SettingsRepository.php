<?php

namespace App\Repositories;

use App\Interfaces\SettingsInterface;
use App\Models\User;

class SettingsRepository implements SettingsInterface
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
     * Update user profile information.
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateProfile(User $user, array $data): User
    {
        $user->update($data);
        return $user->fresh();
    }

    /**
     * Delete a user account.
     *
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
