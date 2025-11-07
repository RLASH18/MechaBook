<?php

namespace App\Interfaces;

use App\Models\User;

interface SettingsInterface
{
    public function find(int $id): ?User;
    public function updateProfile(User $user, array $data): User;
    public function delete(User $user): bool;
}
