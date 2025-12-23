<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin')]
class OrderShow extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        $this->order = Order::query()
            ->with(['user:id,code,name,phone,sex', 'deliver:id,name,phone'])
            ->findOrFail($order->id);
    }

    public function render()
    {
        return view('livewire.admin.order-show');
    }
}
