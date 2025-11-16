<?php

namespace App\Livewire\MiniApp;

use App\Models\Trackcode;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AddOrder extends Component
{
    public $trackcode;
    public function add()
    {
        // Проверка на соответствие требованиям
        // Разделяем по пробелу, запятой, точке с запятой и переносам строк
        $codes = preg_split('/[\s,;]+/', trim($this->trackcode));

        // Убираем пустые элементы
        $codes = array_filter($codes, fn($c) => trim($c) !== '');

        $added = 0;
        $updated = [];
        $invalid = [];

        foreach ($codes as $code) {
            $code = trim($code);

            // Проверка формата
            if (!preg_match('/^[A-Za-z0-9]{1,20}$/', $code)) {
                $invalid[] = $code;
                continue;
            }

            // Проверка существования
            $existing = Trackcode::where('code', $code)->first();

            if ($existing) {
                $existing->user_id = Auth::id();
                $existing->save();

                $updated[] = $code;
                continue;
            }

            // Создание нового
            Trackcode::create([
                'code' => $code,
                'user_id' => Auth::id(),
            ]);

            $added++;
        }

        // Сообщение
        $message = "✅ Добавлено: {$added} трек-кодов.";

        if (!empty($updated)) {
            $message .= " ♻️ Обновлено: " . count($updated) . " ( " . implode(', ', $updated) . " ).";
        }

        if (!empty($invalid)) {
            $message .= " ❌ Неправильные: " . count($invalid) . " ( " . implode(', ', $invalid) . " ). Исправьте и добавьте снова.";
        }

        $this->dispatch('alert', $message);

        $this->reset('trackcode');
    }


    public function render()
    {
        return view('livewire.mini-app.add-order');
    }
}
