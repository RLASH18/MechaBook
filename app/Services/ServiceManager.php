<?php

namespace App\Services;

use App\Interfaces\ServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
     * @param UploadedFile|null $image
     * @return \App\Models\Service
     */
    public function createService(array $data, ?UploadedFile $image = null)
    {
        // Upload service image if provided
        if ($image) {
            $data['service_img'] = $this->uploadImage($image);
        }

        return $this->serviceInterface->create($data);
    }

    /**
     * Update service details by ID.
     *
     * @param int $id
     * @param array $data
     * @param UploadedFile|null $image
     * @return \App\Models\Service|null
     */
    public function updateService(int $id, array $data, ?UploadedFile $image = null)
    {
        $service = $this->serviceInterface->find($id);
        if (! $service) {
            return null;
        }

        // Replace old image with new one if uploaded
        if ($image) {
            if ($service->service_img) {
                $this->deleteImage($service->service_img);
            }
            $data['service_img'] = $this->uploadImage($image);
        }

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
        if (! $service) {
            return false;
        }

        // Delete existing service image if present
        if ($service->service_img) {
            $this->deleteImage($service->service_img);
        }

        return $this->serviceInterface->delete($service);
    }

    /**
     * Get services paginated with search and status filters.
     *
     * @param string|null $search
     * @param string|null $status
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function getServicesPaginated(?string $search, ?string $status = 'all', int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->serviceInterface->getBaseQuery();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($status && $status !== 'all') {
            $query->where('category', ucfirst(strtolower($status)));
        }

        $query->orderBy('created_at', 'desc');

        return $query->paginate($perPage);
    }

    /**
     * Upload service image with custom filename.
     *
     * @param UploadedFile $file
     * @return string
     */
    private function uploadImage(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $filename = 'service_img_' . time() . '_' . uniqid() . '.' . $extension;
        return $file->storeAs('services', $filename, 'public');
    }

    /**
     * Delete service image from storage.
     *
     * @param string $path
     * @return bool
     */
    private function deleteImage(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }
}
