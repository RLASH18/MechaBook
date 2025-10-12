<?php

namespace App\Interfaces\admin;

use App\Models\Service;

interface ServiceInterface
{
    public function find(int $id): ?Service;
    public function create(array $data): Service;
    public function update(Service $service, array $data): Service;
    public function delete(Service $service): bool;
}
