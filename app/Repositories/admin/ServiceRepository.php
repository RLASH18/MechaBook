<?php

namespace App\Repositories\admin;

use App\Interfaces\admin\ServiceInterface;
use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    /**
     * Get services paginated with search filter.
     *
     * @param string|null $search
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getServicesPaginated(?string $search, int $perPage = 10): LengthAwarePaginator
    {
        return Service::when($search, function ($query) use ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
