<?php

namespace App\Livewire\MiniApp;

use Livewire\Component;

class CheckOrder extends Component
{
    public function check()
    {
        $this->dispatch('alert', 'Данные пока не найдено!');
    }
    public function render()
    {
        return view('livewire.mini-app.check-order');
    }
}
