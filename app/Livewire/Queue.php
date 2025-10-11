<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Queue as ModelsQueue;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.empty')]
class Queue extends Component
{
    public $navbats;
    public $code;
    public function mount()
    {
        $this->updateData();
    }

    public function updateData()
    {
        $code = Setting::where('name', 'queue')->first();
        $code->content = rand(10000, 99999); // исправил rand (нужно числа, не строки)
        $code->save();
        $this->code = $code;

        $this->navbats = ModelsQueue::whereDate('created_at', Carbon::today())->orderBy('created_at', 'asc')->get();
    }
    public function render()
    {
        return view('livewire.queue');
    }
}
