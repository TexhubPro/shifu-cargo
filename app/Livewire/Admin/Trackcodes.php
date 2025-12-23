<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Trackcode;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]

class Trackcodes extends Component
{
    use WithPagination;
    public $user_code;
    public $search = null;
    public $status = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $user_id = null;
    #[Computed]
    public function trackcodes()
    {
        $query = Trackcode::query();

        if (!empty($this->search)) {
            $query->where('code', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->user_code)) {
            $query->where('user_id', $this->user_id);
        }

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        return $query->orderBy($this->getSortField(), $this->getSortDirection())
            ->paginate(50);
    }
    public function search_form() {}
    protected function getSortField(): string
    {
        $allowed = ['created_at', 'code', 'status', 'user_id'];
        return in_array($this->sortField, $allowed, true) ? $this->sortField : 'created_at';
    }

    protected function getSortDirection(): string
    {
        return $this->sortDirection === 'asc' ? 'asc' : 'desc';
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedUserCode(): void
    {
        $this->user_id = null;
        $this->resetPage();
    }

    public function updatedStatus(): void
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

    public function checkUser(): void
    {
        $this->user_id = null;
        if (!$this->user_code) {
            return;
        }

        $user = \App\Models\User::where('code', $this->user_code)->first();
        if ($user) {
            $this->user_id = $user->id;
        } else {
            $this->dispatch('alert', 'Пользователь не найден!');
        }
    }
    public function delete($id)
    {
        Trackcode::find($id)->delete();
    }
    public function render()
    {
        return view('livewire.admin.trackcodes');
    }
}
