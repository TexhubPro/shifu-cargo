<?php

namespace App\Livewire\MiniApp;

use Livewire\Component;

class Application extends Component
{
    public $applications;
    public function render()
    {
        return view('livewire.mini-app.application');
    }
}
