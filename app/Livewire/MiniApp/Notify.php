<?php

namespace App\Livewire\MiniApp;

use Livewire\Component;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class Notify extends Component
{
    public $notifications;

    public function mount()
    {
        // Получаем уведомления текущего пользователя, последние сверху
        $this->notifications = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public function render()
    {
        return view('livewire.mini-app.notify');
    }
}
