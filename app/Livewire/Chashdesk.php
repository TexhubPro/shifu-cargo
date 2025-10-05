<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.empty')]
class Chashdesk extends Component
{
    public function render()
    {
        return view('livewire.chashdesk');
    }
}
