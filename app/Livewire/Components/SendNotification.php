<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Jobs\SendTelegramNotification;
use App\Models\Notifyqueue;

class SendNotification extends Component
{
    public $user_id;
    public $content;

    public function save()
    {
        $this->validate([
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string|min:3',
        ]);


        $notification = Notifyqueue::create([
            'user_id' => $this->user_id,
            'content' => $this->content,
        ]);
        for ($i = 1; $i <= 50; $i++) {
            $notification = Notifyqueue::create([
                'user_id' => $this->user_id,
                'content' => "Сообшени $i",
            ]);
            SendTelegramNotification::dispatch($notification);
        }

        $this->reset(['user_id', 'content']);
        $this->dispatch('alert', '✅ Уведомление добавлено в очередь!');
    }
    public function render()
    {
        return view('livewire.components.send-notification');
    }
}
