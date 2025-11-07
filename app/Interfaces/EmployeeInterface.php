<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface EmployeeInterface
{
    public function find(int $id): ?User;
    public function create(array $data): User;
    public function update(User $user, array $data): User;
    public function delete(User $user): bool;
    public function getBaseQuery(array $relations = []): Builder;
}
