<?php

namespace App\Livewire\MiniApp;

use App\Models\Trackcode;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddOrder extends Component
{
    public $trackcode;
    public function add()
    {
        $code = Trackcode::where('code', $this->trackcode)->first();
        if ($code) {
            $this->dispatch('alert', 'Трек-код уже сушествует!');
            return;
        }
        Trackcode::create([
            'code' => $this->trackcode,
            'user_id' => Auth::id(),
        ]);
        $this->reset('trackcode');
        $this->dispatch('alert', 'Трек-код успешно добавлено!');
    }

    public function render()
    {
        return view('livewire.mini-app.add-order');
    }
}
