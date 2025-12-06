<?php

namespace App\Livewire\MiniApp;

use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Application as ModelsApplication;

class Application extends Component
{
    use WithPagination;
    public $phone;
    public $address;
    protected $rules = [
        'phone' => ['required', 'regex:/^\+?[0-9]{7,15}$/'],
        'address' => ['required', 'min:8'],
    ];

    protected $messages = [
        'phone.required' => 'Введите номер телефона.',
        'phone.regex' => 'Номер телефона должен содержать только цифры и может начинаться с +.',
        'address.required' => 'Введите адрес доставки.',
        'address.min' => 'Адрес должен содержать не менее 8 символов.',
    ];
    public function save()
    {
        $this->validate();
        $phone = trim($this->phone);
        $address = trim($this->address);

        $order = ModelsApplication::where('user_id', Auth::id())->where('status', "В ожидании")->first();
        if ($order) {
            $this->dispatch('alert', 'У вас есть заказ, который ожидается или скоро доставляется. ❌ Создать новый заказ пока невозможно.');
            Flux::modals()->close();
            $this->reset(['phone', 'address']);
            return;
        }
        ModelsApplication::create([
            'user_id' => Auth::id(),
            'phone' => $phone,
            'address' => $address,
        ]);
        $this->dispatch('alert', 'Ваш заказ успешно получен ✅ Проверим, есть ли у вас товар на складе — скоро доставим.');
        Flux::modals()->close();

        $this->reset(['phone', 'address']);
    }
    public function render()
    {
        $applications = ModelsApplication::where('user_id', Auth::id())
            ->orderByDesc('id')
            ->paginate(50);
        return view('livewire.mini-app.application', ['applications' => $applications]);
    }
}
