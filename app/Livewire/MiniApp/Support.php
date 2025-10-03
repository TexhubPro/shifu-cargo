<?php

namespace App\Livewire\MiniApp;

use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Support extends Component
{
    public $chat;
    public $messages;
    public $message;
    public function add_message()
    {
        Message::create([
            'chat_id' => $this->chat->id,
            'message' => $this->message,
        ]);
        $this->reset(['message']);
        $this->load();
    }
    public function mount()
    {
        $this->load();
    }
    public function load()
    {
        $this->chat = Chat::where('user_id', Auth::id())->first();
        if ($this->chat) {
            $this->messages = Message::where('chat_id', $this->chat->id)->orderBy('created_at', 'desc')->get();
        } else {
            $chat = Chat::create([
                'user_id' => Auth::id(),
                'status' => true
            ]);
            $this->chat = $chat;
        }
    }
    public function render()
    {
        return view('livewire.mini-app.support');
    }
}
