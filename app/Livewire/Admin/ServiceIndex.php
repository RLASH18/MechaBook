<?php

namespace App\Livewire\Admin;

use App\Livewire\Traits\WithFiltersAndPagination;
use App\Services\ServiceManager;
use Livewire\Component;

class ServiceIndex extends Component
{
    use WithFiltersAndPagination;

    protected $serviceManager;

    /**
     * Inject the service manager
     */
    public function boot(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    public function render()
    {
        // Fetch services using service manager
        $services = $this->serviceManager->getServicesPaginated($this->search, $this->status, 10);

        return view('livewire.admin.service-index', [
            'services' => $services
        ]);
    }
}
