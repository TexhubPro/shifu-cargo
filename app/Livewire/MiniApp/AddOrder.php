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
        // Проверка на соответствие требованиям
        if (!preg_match('/^[A-Za-z0-9]{1,20}$/', $this->trackcode)) {
            $this->dispatch('alert', '❌ Трек-код должен содержать только латинские буквы и цифры (до 20 символов)');
            return;
        }

        $code = Trackcode::where('code', $this->trackcode)->first();

        if ($code) {
            $code->user_id = Auth::id();
            $code->save();

            $this->dispatch('alert', '⚠️ Трек-код уже существует, информация обновлена!');
            $this->reset('trackcode');
            return;
        }

        Trackcode::create([
            'code' => $this->trackcode,
            'user_id' => Auth::id(),
        ]);

        $this->reset('trackcode');
        $this->dispatch('alert', '✅ Трек-код успешно добавлен!');
    }


    public function render()
    {
        return view('livewire.mini-app.add-order');
    }
}
