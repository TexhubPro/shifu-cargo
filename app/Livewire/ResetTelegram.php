<?php

namespace App\Livewire;

use App\Jobs\TelegramStart;
use Livewire\Component;
use DefStudio\Telegraph\Models\TelegraphChat;

class ResetTelegram extends Component
{
    public function refresh()
    {
        $users = TelegraphChat::all();
        foreach ($users as $user) {
            TelegramStart::dispatch($user->id);
        }
    }
    public function render()
    {
        return view('livewire.reset-telegram');
    }
}
