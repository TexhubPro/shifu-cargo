<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

#[Layout('components.layouts.admin')]
class Customers extends Component
{
    use WithPagination;

    public $nameSearch = '';
    public $phoneSearch = '';
    public $codeSearch = '';
    public $sex = '';
    public $dateFrom;
    public $dateTo;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 200;
    public $customerToDelete = null;
    public $customerToDeleteName = null;
    public $customerToDeleteCode = null;
    public function updatedNameSearch(): void
    {
        $this->resetPage();
    }

    public function updatedPhoneSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCodeSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSex(): void
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
    #[Computed]
    public function customers()
    {
        $query = User::query()
            ->select(['id', 'code', 'name', 'phone', 'sex', 'created_at']);

        if (!empty($this->nameSearch)) {
            $query->where('name', 'like', '%' . $this->nameSearch . '%');
        }

        if (!empty($this->phoneSearch)) {
            $query->where('phone', 'like', '%' . $this->phoneSearch . '%');
        }

        if (!empty($this->codeSearch)) {
            $query->where('code', 'like', '%' . $this->codeSearch . '%');
        }

        if (!empty($this->sex)) {
            $query->where('sex', $this->sex);
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

    public function check_user()
    {
        $this->resetPage();
    }

    public function confirmDelete(int $id): void
    {
        $user = User::select(['id', 'name', 'code'])->find($id);

        if (! $user) {
            return;
        }

        $this->customerToDelete = $user->id;
        $this->customerToDeleteName = $user->name;
        $this->customerToDeleteCode = $user->code;
    }

    public function clearDeleteSelection(): void
    {
        $this->customerToDelete = null;
        $this->customerToDeleteName = null;
        $this->customerToDeleteCode = null;
    }

    public function deleteSelected(): void
    {
        if (! $this->customerToDelete) {
            return;
        }

        User::whereKey($this->customerToDelete)->delete();
        $this->clearDeleteSelection();
    }

    protected function getSortField(): string
    {
        $allowed = ['created_at', 'name', 'code'];
        return in_array($this->sortField, $allowed, true) ? $this->sortField : 'created_at';
    }

    protected function getSortDirection(): string
    {
        return $this->sortDirection === 'asc' ? 'asc' : 'desc';
    }
    public function render()
    {
        return view('livewire.admin.customers');
    }
}
