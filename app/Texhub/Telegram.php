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
    public function tj(): void
    {
        $lang = $this->chat;
        $lang->lang = 'tj';
        $lang->save();
        $this->chat->deleteMessage($this->messageId)->send();
        $this->chat->photo(public_path('assets/tj.jpg'))->message(("Забони <b>🇹🇯 Тоҷикӣ</b> интихоб карда шуд!\n\nБарои бо воситаи каргои мо бор дархост кардан аввал тугмачаи <b>➕ Обуна шудан</b>-ро пахш намоед. Ба шумо коди махсус равон карда мешавад, ки шумо бо воситаи он аз маркетплейсҳои Хитойи бор дархост карда метавонед <b>(Обуна шудан ҳатмӣ аст!)</b>"))
            ->send();
        sleep(2);
        $this->chat->message("📢 Барои огоҳӣ аз хабарҳои нав ба канали Telegram-и мо обуна шавед!\n\n🚀 Ҳамаи навгониҳо ва маълумот дар бораи рейсҳо маҳз дар ҳамин канал нашр мешаванд!")
            ->keyboard(Keyboard::make()->buttons([
                Button::make('Cargo SHIFU')->url('https://t.me/cargoshifu'),
            ]))->send();
        sleep(2);
        $this->tj_keys();
    }
    public function ru(): void
    {
        $lang = $this->chat;
        $lang->lang = 'ru';
        $lang->save();
        $this->chat->deleteMessage($this->messageId)->send();
        $this->chat->photo(public_path('assets/ru.jpg'))->message(("<b>🇷🇺 Русский</b> язык выбран! \n\nЧтобы заказать товары из Китая через наше карго, сначала нажмите на кнопку <b>➕ Подписаться</b>. Мы отправим вам специальный код, который в дальнейшем используете для заказа товаров с маркетплейсов Китая <b>(Подписаться обязательно!)</b>."))
            ->send();
        sleep(2);
        $this->chat->message("📢 Чтобы быть в курсе новостей, подпишитесь на наш Telegram-канал!\n\n🚀 Все обновления и информация о рейсах публикуются только в этом канале! ")
            ->keyboard(Keyboard::make()->buttons([
                Button::make('Cargo SHIFU')->url('https://t.me/cargoshifu'),
            ]))->send();
        sleep(2);
        $this->ru_keys();
    }
    public function tj_keys(): void
    {
        $this->chat->message(("Бахши лозимаро дар менюи дар зер буда интихоб намоед! 🔽"))
            ->replyKeyboard(ReplyKeyboard::make()
                ->row([
                    ReplyButton::make('🔢 Тафтиши трек-код'),
                    ReplyButton::make('➕ Обуна шудан')->requestContact(),
                ])
                ->row([
                    ReplyButton::make('✅ Сурогаи склади Иву'),
                    ReplyButton::make('🎞 Дарсхои ройгон'),
                ])
                ->row([
                    ReplyButton::make('📍 Сурогаи склади Душанбе'),
                    ReplyButton::make('👤 Тамос бо мушовир'),
                ])
                ->row([
                    ReplyButton::make('💲 Нархнома'),
                    ReplyButton::make('❌ Молҳои манъшуда'),
                ])
                ->resize())->send();
    }
    public function ru_keys(): void
    {
        $this->chat->message(("Выберите нужный раздел в меню ниже! 🔽"))
            ->replyKeyboard(ReplyKeyboard::make()
                ->row([
                    ReplyButton::make('🔢 Проверить трек-код'),
                    ReplyButton::make('➕ Подписаться')->requestContact(),
                ])
                ->row([
                    ReplyButton::make('✅ Адрес склада Иву'),
                    ReplyButton::make('🎞 Бесплатные уроки'),
                ])
                ->row([
                    ReplyButton::make('📍 Адрес склада Душанбе'),
                    ReplyButton::make('👤 Связаться с оператором'),
                ])
                ->row([
                    ReplyButton::make('💲 Прайс лист'),
                    ReplyButton::make('❌ Запрещенные товары'),
                ])
                ->resize())->send();
    }
}
