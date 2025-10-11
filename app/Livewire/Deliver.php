<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;


#[Layout('components.layouts.empty')]
class Deliver extends Component
{
    public function render()
    {
        return view('livewire.deliver');
    }
}
