<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Application;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('components.layouts.admin')]
class Applications extends Component
{
    use WithPagination;
    public $searchName = '';
    public $searchPhone = '';
    public $status = '';
    public $dateFrom;
    public $dateTo;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 25;
    #[Computed]
    public function orders()
    {
        $query = Application::query();

        if (!empty($this->searchName)) {
            $query->where('name', 'like', '%' . $this->searchName . '%');
        }

        if (!empty($this->searchPhone)) {
            $query->where('phone', 'like', '%' . $this->searchPhone . '%');
        }

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        if (!empty($this->dateFrom)) {
            $query->where('created_at', '>=', $this->dateFrom . ' 00:00:00');
        }

        if (!empty($this->dateTo)) {
            $query->where('created_at', '<=', $this->dateTo . ' 23:59:59');
        }

        return $query->orderBy($this->getSortField(), $this->getSortDirection())
            ->paginate($this->perPage);
    }
    public function delete($id)
    {
        Application::find($id)->delete();
    }
    public function cleanInvalid()
    {
        Application::where('status', 'Отменено')->delete();

        Application::where(function ($query) {
            $query->whereNull('phone')
                ->orWhere('phone', '')
                ->orWhereRaw("phone REGEXP '[^0-9+]'")
                ->orWhereRaw('LENGTH(phone) < 7')
                ->orWhereNull('address')
                ->orWhere('address', '')
                ->orWhereRaw('LENGTH(address) < 8')
                ->orWhereRaw("address REGEXP '^[0-9]+$'");
        })->delete();

        $this->dispatch('alert', 'Неверные заявки удалены.');
        $this->resetPage();
    }

    protected function getSortField(): string
    {
        $allowed = ['created_at', 'name', 'status', 'phone'];
        return in_array($this->sortField, $allowed, true) ? $this->sortField : 'created_at';
    }

    protected function getSortDirection(): string
    {
        return $this->sortDirection === 'asc' ? 'asc' : 'desc';
    }

    public function updatedSearchName(): void
    {
        $this->resetPage();
    }

    public function updatedSearchPhone(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function updatedDateFrom(): void
    {
        $this->resetPage();
    }

    public function updatedDateTo(): void
    {
        $this->resetPage();
    }

    public function updatedSortField(): void
    {
        $this->resetPage();
    }

    public function updatedSortDirection(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }
    public function render()
    {
        return view('livewire.admin.applications');
    }
}
