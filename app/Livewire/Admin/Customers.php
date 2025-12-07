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

    public $search = null;
    public function updatedSearch(): void
    {
        $this->resetPage();
    }
    #[Computed]
    public function customers()
    {
        $query = User::query()
            ->where('role', 'customer')
            ->withCount('trackcodes')
            ->withSum('orders as orders_sum_total', 'total');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('code', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        return $query->orderByDesc('created_at')
            ->paginate(50);
    }

    public function check_user() {}
    public function delete($id)
    {
        User::find($id)->delete();
    }
    public function render()
    {
        return view('livewire.admin.customers');
    }
}
