<?php

namespace App\Livewire\MiniApp;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.empty')]

class Register extends Component
{
    public $name;
    public $phone;
    public $sex;
    public $chat_id;
    public $message;
    public function save()
    {
        $user = User::where('phone', $this->phone)->first();
        if ($user) {
            $this->dispatch(['alert', "Аккаунт с этим номером уже существует. Войдите или используйте другой номер."]);
        }
        $user = User::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'sex' => $this->sex,
            'chat_id' => $this->chat_id,
        ]);

        Auth::login($user, true);
        return redirect()->route('profile');
    }
    public function mount($id = null)
    {
        $this->chat_id = $id;
    }
    public function render()
    {
        return view('livewire.mini-app.register');
    }
}
