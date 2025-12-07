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
            'is_admin' => true,
            'status' => true
        ]);
        $sms = new Telegram();
        $sms->sms_single($this->active_chat->user->id, $this->message);
        $this->message = null;
        $this->load_m();
        $this->refreshChatsList();
    }
    public function open_chat($id)
    {
        $this->active_chat = Chat::with('user')->find($id);
        $this->markChatAsRead($id, false);
        $this->load_m();
    }

    public function markChatAsRead($chatId = null, bool $refreshList = true): void
    {
        $chatId = $chatId ?? optional($this->active_chat)->id;
        if (!$chatId) {
            return;
        }

        Message::where('chat_id', $chatId)
            ->where('status', false)
            ->update(['status' => true]);

        if ($refreshList) {
            $this->refreshChatsList();
        }
    }

    public function load_m()
    {
        if (!$this->active_chat) {
            $this->messages = collect();
            return;
        }

        $this->messages = Message::where('chat_id', $this->active_chat->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }
    public function back()
    {
        $this->active_chat = null;
    }
    public function mount()
    {
        $this->refreshChatsList();
    }
    public function render()
    {
        return view('livewire.admin.chats');
    }

    protected function refreshChatsList(): void
    {
        $this->chats = Chat::with(['user', 'latestMessage', 'unreadMessages'])
            ->withCount('unreadMessages')
            ->orderByRaw('(SELECT MAX(created_at) FROM messages WHERE messages.chat_id = chats.id) DESC')
            ->get();
    }
}
