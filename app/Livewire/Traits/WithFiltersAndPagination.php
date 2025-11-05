<?php

namespace App\Livewire\Traits;

use Livewire\WithPagination;

trait WithFiltersAndPagination
{
    use WithPagination;

    public $search = '';
    public $status = 'all';

    protected $queryString = ['search', 'status'];

    /**
     * Resets pagination when the search input is updated
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Resets pagination when the status is updated
     */
    public function updatingStatus()
    {
        $this->resetPage();
    }
}
