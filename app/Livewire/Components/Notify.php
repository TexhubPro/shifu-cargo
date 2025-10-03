<?php

namespace App\Livewire\Components;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notify extends Component
{
    public $notify;
    public function mount()
    {
        $this->notify = Notification::where('user_id', Auth::id())->where('status', false)->get();
    }
    public function render()
    {
        return view('livewire.components.notify');
    }
}
