<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]

class Trackcodes extends Component
{
    public function render()
    {
        return view('livewire.admin.trackcodes');
    }
}
