<?php

namespace App\Livewire\Admin;

use App\Jobs\SendBulkSms;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Smsbulk extends Component
{
    public $message;

    public function smsbulk()
    {
        if (empty($this->message)) {
            $this->dispatch('alert', 'Введите текст сообщения!');
            return;
        }

        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                SendBulkSms::dispatch($this->message, $user->id);
            }
        });
        $this->message = null;
        $this->dispatch('alert', 'Сообщения поставлены в очередь на отправку!');
    }

    public function render()
    {
        return view('livewire.admin.smsbulk');
    }
}
