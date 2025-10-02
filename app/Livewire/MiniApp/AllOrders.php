<?php

namespace App\Livewire\MiniApp;

use Livewire\Component;

class AllOrders extends Component
{
    public $orders;
    public function render()
    {
        return view('livewire.mini-app.all-orders');
    }
}
