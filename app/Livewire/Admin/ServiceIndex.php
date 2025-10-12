<?php

namespace App\Livewire\Admin;

use App\Models\Service;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        // Fetch services with search and pagination
        $services = Service::when($this->search, function($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('description', 'like', '%' . $this->search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('livewire.admin.service-index', [
            'services' => $services
        ]);
    }
}
