<?php

namespace App\Interfaces\admin;

use App\Models\User;

interface EmployeeInterface
{
    public function find(int $id): ?User;
    public function create(array $data): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
}
