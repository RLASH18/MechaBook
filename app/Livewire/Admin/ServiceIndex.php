<?php

namespace App\Livewire\Admin;

use App\Services\admin\ServiceManager;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceIndex extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    protected $serviceManager;

    /**
     * Inject the service manager
     */
    public function boot(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * Resets pagination when the search input is updated
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Fetch services using service manager
        $services = $this->serviceManager->getServicesPaginated($this->search, 10);

        return view('livewire.admin.service-index', [
            'services' => $services
        ]);
    }
}
