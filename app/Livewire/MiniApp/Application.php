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
    public function save()
    {
        $order = ModelsApplication::where('user_id', Auth::id())->where('status', "В ожидании")->first();
        if ($order) {
            $this->dispatch('alert', 'У вас есть заказ, который ожидается или скоро доставляется. ❌ Создать новый заказ пока невозможно.');
            Flux::modals()->close();
            $this->reset(['phone', 'address']);
            return;
        }
        ModelsApplication::create([
            'user_id' => Auth::id(),
            'phone' => $this->phone,
            'address' => $this->address,
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
