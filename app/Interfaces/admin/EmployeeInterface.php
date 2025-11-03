<?php

namespace App\Interfaces\admin;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface EmployeeInterface
{
    public function find(int $id): ?User;
    public function create(array $data): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
    public function getEmployeesPaginated(?string $search, int $perPage = 10): LengthAwarePaginator;
}
