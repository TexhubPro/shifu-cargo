<?php

namespace App\Texhub;

use DefStudio\Telegraph\Enums\ChatActions;
use DefStudio\Telegraph\Facades\Telegraph as FacadesTelegraph;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use Illuminate\Support\Stringable;
use Illuminate\Notifications\Action;
use DefStudio\Telegraph\Models\TelegraphChat;
use DefStudio\Telegraph\Telegraph;
use Illuminate\Http\Request;

class Telegram extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    public function start(): void
    {
        $this->chat->photo(public_path('assets/welcome.jpg'))->message("Салом " . $this->message->from()->firstName() . "! \nИн телеграм боти <b>Shifu Cargo</b> мебошад! \nБарои истифода бурдан аввал забонро интихоб кунед!\n\nЭто телеграм бот <b>Shifu Cargo!</b> \nЧтобы использовать, сначала выберите язык! ⤵️")
            ->keyboard(
                Keyboard::make()
                    ->row([
                        Button::make('🇹🇯 Тоҷикӣ')->action('tj'),
                        Button::make('🇷🇺 Русский')->action('ru'),
                    ])
            )->send();
        // $this->chat->message('hello')->send();
    }
}
