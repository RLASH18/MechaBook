<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\service\StoreServiceRequest;
use App\Http\Requests\admin\service\UpdateServiceRequest;
use App\Services\admin\ServiceManager;

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
        return view('pages.admin.services.index', [
            'title' => 'MechaBook | Admin - Services Management'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.services.create', [
            'title' => 'MechaBook | Admin - New Service'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequest $request)
    {
        $data = $request->validated();
        $image = $request->hasFile('service_img') ? $request->file('service_img') : null;

        $this->serviceManager->createService($data, $image);
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

        return view('pages.admin.services.show', [
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

        return view('pages.admin.services.update', [
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
        $image = $request->hasFile('service_img') ? $request->file('service_img') : null;

        $service = $this->serviceManager->updateService((int) $id, $data, $image);
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
        $deleted = $this->serviceManager->deleteService((int) $id);
        if (! $deleted) {
            return $this->serviceNotFound();
        }

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
}
