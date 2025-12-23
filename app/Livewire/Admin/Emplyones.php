<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Hash;
use Flux\Flux;

#[Layout('components.layouts.admin')]
class Emplyones extends Component
{
    public $name;
    public $phone;
    public $chat_id;
    public $password;
    public $role = 'manager';
    public $editId;
    public $editName;
    public $editPhone;
    public $editChatId;
    public $editRole = 'manager';
    public $editPassword;

    public function saveEmployee()
    {
        $this->validate([
            'name' => 'required|string|min:3',
            'phone' => 'required|string|unique:users,phone,',
            'password' => 'required|string|min:6',
            'chat_id' => 'nullable|string',
            'role' => 'required|in:admin,deliver,customer,manager,cashier,applicant',
        ], [
            'name.required' => 'Введите имя сотрудника.',
            'phone.required' => 'Введите номер телефона.',
            'phone.unique' => 'Пользователь с таким номером уже существует.',
            'password.required' => 'Введите пароль.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',
            'role.required' => 'Выберите должность.',
        ]);

        $user = User::where('phone', $this->phone)->first();

        if ($user) {
            $user->update([
                'name' => $this->name,
                'chat_id' => $this->chat_id,
                'role' => $this->role,
                'password' => Hash::make($this->password),
            ]);
        } else {
            User::create([
                'name' => $this->name,
                'phone' => $this->phone,
                'chat_id' => $this->chat_id ?? null,
                'password' => Hash::make($this->password),
                'role' => $this->role,
            ]);
        }


        $this->reset(['name', 'phone', 'password', 'role']);

        $this->dispatch('alert', 'Сотрудник успешно добавлен!');
        Flux::modals()->close();
    }

    public function openEdit(int $id): void
    {
        $user = User::findOrFail($id);
        $this->editId = $user->id;
        $this->editName = $user->name;
        $this->editPhone = $user->phone;
        $this->editChatId = $user->chat_id;
        $this->editRole = $user->role;
        $this->editPassword = null;
    }

    public function updateEmployee(): void
    {
        $this->validate([
            'editName' => 'required|string|min:3',
            'editPhone' => 'required|string|unique:users,phone,' . $this->editId,
            'editRole' => 'required|in:admin,deliver,customer,manager,cashier,applicant',
            'editChatId' => 'nullable|string',
            'editPassword' => 'nullable|string|min:6',
        ], [
            'editName.required' => 'Введите имя сотрудника.',
            'editPhone.required' => 'Введите номер телефона.',
            'editPhone.unique' => 'Пользователь с таким номером уже существует.',
            'editPassword.min' => 'Пароль должен содержать минимум 6 символов.',
            'editRole.required' => 'Выберите должность.',
        ]);

        $user = User::findOrFail($this->editId);
        $data = [
            'name' => $this->editName,
            'phone' => $this->editPhone,
            'chat_id' => $this->editChatId,
            'role' => $this->editRole,
        ];

        if (!empty($this->editPassword)) {
            $data['password'] = Hash::make($this->editPassword);
        }

        $user->update($data);

        $this->reset(['editId', 'editName', 'editPhone', 'editChatId', 'editRole', 'editPassword']);
        $this->dispatch('alert', 'Данные сотрудника обновлены!');
        Flux::modals()->close();
    }
    #[Computed]
    public function users()
    {
        $query = User::query()->where('role', '!=', 'customer');


        return $query->orderByDesc('created_at')
            ->paginate(50);
    }
    public function delete($id)
    {
        $user = User::find($id)->delete();
        return redirect()->route('admin.emplyones');
    }
    public function notifications($id)
    {
        $user = User::find($id);
        if ($user->status == true) {
            $user->status = false;
        } else {
            $user->status = true;
        }
        $user->save();
    }
    public function render()
    {
        return view('livewire.admin.emplyones');
    }
}
