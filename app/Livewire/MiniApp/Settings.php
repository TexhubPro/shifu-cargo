<?php

namespace App\Livewire\MiniApp;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Settings extends Component
{
    public $name;
    public $phone;
    public $sex;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->sex = $user->sex;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|size:9',
            'sex' => 'required|in:m,z',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'sex' => $this->sex,
        ]);

        $this->dispatch('alert', 'Данные профиля успешно обновлены ✅');
    }
    public function render()
    {
        return view('livewire.mini-app.settings');
    }
}
