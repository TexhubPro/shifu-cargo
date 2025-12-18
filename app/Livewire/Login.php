<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[Layout('components.layouts.empty')]
class Login extends Component
{
    public $phone;
    public $password;
    public $remember = false;

    public function login()
    {
        $this->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('phone', $this->phone)->first();

        if ($user && Hash::check($this->password, $user->password)) {
            Auth::login($user, true);
            $this->dispatch(
                'alert',
                'Вы успешно вошли в систему!'
            );
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            if ($user->role === 'deliver') {
                return redirect()->route('deliver');
            }
            if ($user->role === 'applicant') {
                return redirect()->route('applicant');
            }
            if ($user->role === 'manager') {
                return redirect()->route('admin.dashboard');
            }
            if ($user->role === 'cashier') {
                return redirect()->route('cashier');
            }

            return redirect()->route('admin.dashboard');
        }

        $this->dispatch(
            'alert',
            'Неверный номер телефона или пароль!'
        );
    }

    public function render()
    {
        return view('livewire.login');
    }
}
