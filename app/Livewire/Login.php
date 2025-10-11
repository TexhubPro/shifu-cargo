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
            Auth::login($user, $this->remember);
            $this->dispatch(
                'alert',
                'Вы успешно вошли в систему!'
            );
            return match ($user->role) {
                'admin'    => redirect()->route('admin.dashboard'),
                'deliver'  => redirect()->route('deliver'),
                'applicant'  => redirect()->route('applicant'),
                'manager'  => redirect()->route('manager'),
                'cashier'  => redirect()->route('cashier'),
                default    => redirect()->route('admin.dashboard'), // customer
            };
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
