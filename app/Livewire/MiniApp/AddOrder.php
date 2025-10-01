<?php

namespace App\Livewire\MiniApp;

use Livewire\Component;

class AddOrder extends Component
{
    public $trackcode;
    public function add()
    {
        $this->dispatch('alert', 'hello');
    }

    public function render()
    {
        return view('livewire.mini-app.add-order');
    }
}
