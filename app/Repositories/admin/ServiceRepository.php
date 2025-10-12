<?php

namespace App\Repositories\admin;

use App\Interfaces\admin\ServiceInterface;
use App\Models\Service;

class ServiceRepository implements ServiceInterface
{
    /**
     * Find a service by ID.
     *
     * @param int $id
     * @return Service|null
     */
    public function find(int $id): ?Service
    {
        return Service::find($id);
    }

    /**
     * Create a new service.
     *
     * @param array $data
     * @return Service
     */
    public function create(array $data): Service
    {
        return Service::create($data);
    }

    /**
     * Update an existing service with new data.
     *
     * @param Service $service
     * @param array $data
     * @return Service
     */
    public function update(Service $service, array $data): Service
    {
        $service->update($data);
        return $service;
    }

    /**
     * Delete a service.
     *
     * @param Service $service
     * @return bool
     */
    public function delete(Service $service): bool
    {
        return $service->delete();
    }
}
