<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin')]
class Profile extends Component
{
    public $name;
    public $phone;
    public $sex;
    public $password;
    public $password_confirmation;

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->sex = $user->sex;
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|size:9',
            'sex' => 'required|in:m,z',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->phone = $this->phone;
        $user->sex = $this->sex;

        if ($this->password) {
            $user->password = $this->password;
        }

        $user->save();

        $this->dispatch('alert', 'Профиль обновлен.');
        $this->reset('password', 'password_confirmation');
    }

    public function render()
    {
        return view('livewire.admin.profile');
    }
}
