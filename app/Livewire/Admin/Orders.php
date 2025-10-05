<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

#[Layout('components.layouts.admin')]
class Orders extends Component
{
    use WithPagination;
    #[Computed]
    public function orders()
    {
        $query = Order::query();


        return $query->orderByDesc('created_at')
            ->paginate(50);
    }
    public function render()
    {
        return view('livewire.admin.orders');
    }
}
