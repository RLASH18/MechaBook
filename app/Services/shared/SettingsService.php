<?php

namespace App\Services\shared;

use App\Interfaces\shared\SettingsInterface;
use Illuminate\Support\Facades\Hash;

class SettingsService
{
    /**
     * Inject the SettingsInterface (Repository).
     *
     * @param SettingsInterface $settingsInterface
     */
    public function __construct(
        protected SettingsInterface $settingsInterface
    ) {}

    /**
     * Update user profile information.
     *
     * @param int $userId
     * @param array $data
     * @return \App\Models\User|null
     */
    public function updateUserProfile(int $userId, array $data)
    {
        $user = $this->settingsInterface->find($userId);
        if (! $user) return null;

        // Filter only allowed fields
        $allowedFields = ['name', 'email', 'phone'];
        $filteredData = array_intersect_key($data, array_flip($allowedFields));

        return $this->settingsInterface->updateProfile($user, $filteredData);
    }

    /**
     * Update user password.
     *
     * @param int $userId
     * @param string $currentPassword
     * @param string $newPassword
     * @return array
     */
    public function updatePassword(int $userId, string $currentPassword, string $newPassword): array
    {
        $user = $this->settingsInterface->find($userId);
        if (! $user) {
            return ['success' => false, 'message' => 'User not found'];
        }

        // Verify current password
        if (!Hash::check($currentPassword, $user->password)) {
            return ['success' => false, 'message' => 'Current password is incorrect'];
        }

        // Update password
        $this->settingsInterface->updateProfile($user, [
            'password' => Hash::make($newPassword)
        ]);

        return ['success' => true, 'message' => 'Password updated successfully'];
    }

    /**
     * Delete user account.
     *
     * @param int $userId
     * @param string $password
     * @return array
     */
    public function deleteAccount(int $userId, string $password): array
    {
        $user = $this->settingsInterface->find($userId);
        if (! $user) {
            return ['success' => false, 'message' => 'User not found'];
        }

        // Verify password before deletion
        if (!Hash::check($password, $user->password)) {
            return ['success' => false, 'message' => 'Password is incorrect'];
        }

        // Delete the account
        $deleted = $this->settingsInterface->delete($user);
        if ($deleted) {
            return ['success' => true, 'message' => 'Account deleted successfully'];
        }

        return ['success' => false, 'message' => 'Failed to delete account'];
    }
}
