<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\service\StoreServiceRequest;
use App\Http\Requests\admin\service\UpdateServiceRequest;
use App\Services\admin\ServiceManager;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * ServiceManager dependency injection.
     */
    public function __construct(
        protected ServiceManager $serviceManager
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.services.index', [
            'title' => 'MechaBook | Admin - Services Management'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.services.create', [
            'title' => 'MechaBook | Admin - New Service'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $data = $request->validated();

        // Upload service image if provided
        if ($request->hasFile('service_img')) {
            $data['service_img'] = $this->uploadImage($request->file('service_img'));
        }

        $this->serviceManager->createService($data);
        return $this->serviceSuccess('Service added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = $this->serviceManager->getServiceById((int) $id);
        if (! $service) {
            return $this->serviceNotFound();
        }

        return view('admin.services.show', [
            'title' => 'MechaBook | Admin - View Service',
            'service' => $service
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $service = $this->serviceManager->getServiceById((int) $id);
        if (! $service) {
            return $this->serviceNotFound();
        }

        return view('admin.services.update', [
            'title' => 'MechaBook | Admin - Edit Service',
            'service' => $service
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequest $request, string $id)
    {
        $data = $request->validated();

        // Replace old image with new one if uploaded
        if ($request->hasFile('service_img')) {
            $oldService = $this->serviceManager->getServiceById((int) $id);

            if ($oldService && $oldService->service_img) {
                $this->deleteImage($oldService->service_img);
            }

            $data['service_img'] = $this->uploadImage($request->file('service_img'));
        }

        $service = $this->serviceManager->updateService((int) $id, $data);
        if (! $service) {
            return $this->serviceNotFound();
        }

        return $this->serviceSuccess('Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = $this->serviceManager->getServiceById((int) $id);
        if (! $service) {
            return $this->serviceNotFound();
        }

        // Delete existing service image if present
        if ($service->service_img) {
            $this->deleteImage($service->service_img);
        }

        $this->serviceManager->deleteService((int) $id);
        return $this->serviceSuccess('Service deleted successfully');
    }

    /**
     * Redirect with success notification.
     *
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function serviceSuccess(string $message)
    {
        notyf()->success($message);
        return redirect()->route('admin.service.index');
    }

    /**
     * Redirect with service not found error notification.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function serviceNotFound()
    {
        notyf()->error('Service not found!');
        return redirect()->route('admin.service.index');
    }

    /**
     * Upload service image with custom filename.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    private function uploadImage($file): string
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
