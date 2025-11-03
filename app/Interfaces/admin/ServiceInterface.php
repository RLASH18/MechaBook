<?php

namespace App\Interfaces\admin;

use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ServiceInterface
{
    public function find(int $id): ?Service;
    public function create(array $data): Service;
    public function update(Service $service, array $data): Service;
    public function delete(Service $service): bool;
    public function getServicesPaginated(?string $search, int $perPage = 10): LengthAwarePaginator;
}
