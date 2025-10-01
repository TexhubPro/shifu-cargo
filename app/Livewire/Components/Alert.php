<?php

namespace App\Livewire\Components;

use Livewire\Component;

class Alert extends Component
{
    public $message;
    protected $listeners = ["alert" => "updatedAlert"];
    public function updatedAlert($data)
    {
        $this->reset('message');
        $this->message = $data;
    }
    public function render()
    {
        return view('livewire.components.alert');
    }
}
