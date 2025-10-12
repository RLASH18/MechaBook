<?php

namespace App\Services\admin;

use App\Interfaces\admin\ServiceInterface;

class ServiceManager
{
    /**
     * Inject the ServiceInterface (Repository).
     *
     * @param ServiceInterface $serviceInterface
     */
    public function __construct(
        protected ServiceInterface $serviceInterface
    ) {}

    /**
     * Retrieve a service by its ID.
     *
     * @param int $id
     * @return \App\Models\Service|null
     */
    public function getServiceById(int $id)
    {
        return $this->serviceInterface->find($id);
    }

    /**
     * Create a new service.
     *
     * @param array $data
     * @return \App\Models\Service
     */
    public function createService(array $data)
    {
        return $this->serviceInterface->create($data);
    }

    /**
     * Update service details by ID.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\Service|null
     */
    public function updateService(int $id, array $data)
    {
        $service = $this->serviceInterface->find($id);
        if (! $service) return null;

        return $this->serviceInterface->update($service, $data);
    }

    /**
     * Delete a service by ID.
     *
     * @param int $id
     * @return bool
     */
    public function deleteService(int $id)
    {
        $service = $this->serviceInterface->find($id);
        if (! $service) return false;

        return $this->serviceInterface->delete($service);
    }
}
