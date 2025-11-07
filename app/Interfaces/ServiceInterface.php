<?php

namespace App\Interfaces;

use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;

interface ServiceInterface
{
    public function find(int $id): ?Service;
    public function create(array $data): Service;
    public function update(Service $service, array $data): Service;
    public function delete(Service $service): bool;
    public function getBaseQuery(array $relations = []): Builder;
}
