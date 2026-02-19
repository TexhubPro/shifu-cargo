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
    private const WAREHOUSE_REQUIRED_ROLES = ['admin', 'manager', 'cashier'];

    public $phone;
    public $password;
    public $remember = false;

    public function mount()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()?->role);
        }
    }

    public function login()
    {
        $this->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);
        $user = User::where('phone', $this->phone)->first();

        if ($user && Hash::check($this->password, $user->password)) {
            if (!$user->status) {
                $this->dispatch(
                    'alert',
                    'Учетная запись отключена.'
                );

                return;
            }

            if (in_array($user->role, self::WAREHOUSE_REQUIRED_ROLES, true) && !$user->warehouse_id) {
                $this->dispatch(
                    'alert',
                    'Для этой роли требуется назначить склад.'
                );

                return;
            }

            Auth::login($user, (bool) $this->remember);
            $this->dispatch(
                'alert',
                'Вы успешно вошли в систему!'
            );
            return $this->redirectByRole($user->role);
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

    protected function redirectByRole(?string $role)
    {
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'deliver' => redirect()->route('deliver.orders'),
            'applicant' => redirect()->route('applicant'),
            'manager' => redirect()->route('manager'),
            'cashier' => redirect()->route('cashier'),
            default => redirect()->route('cashier'),
        };
    }
}
