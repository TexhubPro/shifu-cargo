<?php

namespace App\Livewire\Admin;

use App\Models\Chat;
use App\Models\Message;
use App\Texhub\Telegram;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Chats extends Component
{
    public $chats;
    public $message;
    public $messages;
    public $active_chat = null;
    public $chat_bar = false;
    public function add_message()
    {
        Message::create([
            'chat_id' => $this->active_chat->id,
            'message' => $this->message,
            'is_admin' => true
        ]);
        $sms = new Telegram();
        $sms->sms_single($this->active_chat->user->id, $this->message);
        $this->message = null;
        $this->load_m();
    }
    public function open_chat($id)
    {
        $this->active_chat = Chat::find($id);
        $this->load_m();
    }
    public function load_m()
    {
        $this->messages = Message::where('chat_id', $this->active_chat->id)->orderBy('created_at', 'desc')->get();
    }
    public function back()
    {
        $this->active_chat = null;
    }
    public function mount()
    {
        $this->chats = Chat::orderBy('updated_at', 'desc')->get();
    }
    public function render()
    {
        return view('livewire.admin.chats');
    }
}
