<?php

namespace App\Livewire\MiniApp;

use App\Models\Trackcode;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CheckOrder extends Component
{
    public $trackcode;
    public function check()
    {
        $code = Trackcode::where('code', $this->trackcode)->first();

        if ($code) {
            $code->user_id = Auth::id();
            $code->save();
            switch ($code->status) {
                case 'В ожидании':
                    $this->dispatch('alert', 'Ваш заказ в ожидании. ⏳');
                    break;

                case 'Получено в Иву':
                    $this->dispatch('alert', 'Ваш товар уже на складе в Иву. 📦 Мы сообщим вам о дальнейших действиях.');
                    break;

                case 'В пункте выдачи':
                    $this->dispatch('alert', 'Ваш заказ в пункте выдачи. 🚚');
                    break;

                case 'Получено':
                    $this->dispatch('alert', 'Вы уже получили свой заказ. ✅');
                    break;

                default:
                    $this->dispatch('alert', 'Статус заказа уточняется. ℹ️');
                    break;
            }
        } else {
            $this->dispatch('alert', 'Данные пока не найдены! ❌ Добавьте трек-код для отслеживания, если заказ ожидается или находится на складе в Иву.');
        }
    }
    public function render()
    {
        return view('livewire.mini-app.check-order');
    }
}
