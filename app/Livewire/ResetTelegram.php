<?php

namespace App\Livewire;

use Livewire\Component;
use App\Jobs\SendBulkSms;
use DefStudio\Telegraph\Models\TelegraphChat;

class ResetTelegram extends Component
{
    public function refresh()
    {
        $users = TelegraphChat::all();
        foreach ($users as $user) {
            SendBulkSms::dispatch($user->id);
        }
    }
    public function render()
    {
        return view('livewire.reset-telegram');
    }
}
