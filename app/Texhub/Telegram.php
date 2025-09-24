<?php

namespace App\Texhub;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use DefStudio\Telegraph\Telegraph;
use Illuminate\Support\Stringable;
use Illuminate\Notifications\Action;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Enums\ChatActions;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Models\TelegraphChat;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use DefStudio\Telegraph\Facades\Telegraph as FacadesTelegraph;

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
                    ReplyButton::make('🚚 Дархости доставка'),
                ])
                ->row([
                    ReplyButton::make('📍 Сурогаи склади Душанбе'),
                    ReplyButton::make('👤 Тамос бо оператор'),
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
                    ReplyButton::make('🚚 Заказать доставку'),
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
    public function handleChatMessage(Stringable $text): void
    {
        $chat_id = $this->chat->chat_id;
        $customer = User::where('chat_id', $chat_id)->first();
        if ($text == '❌ Закрыт чат' || $text == '❌ Пушидани чат') {
            $customer->step = null;
            $customer->save();
            $chat_sec = Chat::where('chat_id', $customer->id)->first();
            if ($chat_sec) {
                $chat_sec->status = 'closed';
                $chat_sec->save();
            }

            if ($this->chat->lang == 'ru') {
                $this->ru_keys();
            } else {
                $this->tj_keys();
            }
            return;
        }

        if ($customer && $customer->step == 'delivery_phone') {
            // Изменено на поиск Chat по chat_id
            $delivery = new OrderDelivery();
            $delivery->code = $customer->code;
            $delivery->phone = str($text);
            $delivery->address = 'null';
            $delivery->save();
            $customer->step = 'delivery_address';
            $customer->save();
            $this->chat->message('Сурогаи худро дохил кунед (ба тарзи фахмо бо ориентир)')->send();
            return;
        }
        if ($customer && $customer->step == 'delivery_address') {
            // Изменено на поиск Chat по chat_id
            $delivery = OrderDelivery::where('code', $customer->code)->orderBy('created_at', 'desc')->first();
            $delivery->address = str($text);
            $delivery->save();
            $customer->step = null;
            $customer->save();
            $this->chat->message("Дархости шумо тахти раками # " . $delivery->id . " кабул шуд! Занги курерро интизор шавед борхоятонро бурда мерасонанд!")->send();
            return;
        }
        if ($customer && $customer->step == 'chat') {
            // Изменено на поиск Chat по chat_id
            $chat = Chat::where('chat_id', $customer->id)->first();
            if ($chat) {
                Message::create([
                    'chat_id' => $chat->id,
                    'user_id' => $chat->id,
                    'message' => $text,
                    'status' => 'pending',
                ]);
            }
            return;
        }
        if ($text == '📍 Сурогаи склади Душанбе' || $text == '📍 Адрес склада Душанбе') {
            $this->chat->deleteMessage($this->messageId)->send();
            $this->chat->location(38.56834699185991, 68.73575168818122)->send();
            $this->chat->message("ш. Душанбе, Колсовой Каленин")->send();
            return;
        }
        if ($text == '👤 Тамос бо мушовир' || $text == '👤 Связаться с оператором') {
            $this->chat->deleteMessage($this->messageId)->send();
            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/call_ru.jpg'))->message("<b>Режим работы</b> с Душанбе по воскресенье с <b>08:00 до 18:00</b>.\n\nВ рабочие часы свяжитесь с нами — мы обязательно ответим на ваши вопросы!\n\nСвяжитесь с нами через один из мессенджеров ниже или подключитесь к консультанту прямо в боте! ⤵️")
                    ->keyboard(
                        Keyboard::make()
                            ->row([
                                Button::make('Telegram')->url('https://t.me/+992945100200'),
                                Button::make('WeChat')->url('https://u.wechat.com/kHHFGH2D-GqDbFIcWiuEPX4'),
                            ])
                            ->row([
                                Button::make('Телеграм канал')->url('https://t.me/TJ0007_CARGO'),
                            ])
                            ->row([
                                Button::make('Тамос бо мушовир')->action('open_chat'),
                            ])
                    )->send();
            } else {
                $this->chat->photo(public_path('assets/call_tj.jpg'))->message("<b>Реҷаи корӣ</b> аз Душанбе то Якшанбе соатҳои <b>08:00 то 18:00</b>.\n\nДар вақти корӣ бо мо тамос гиред ҳатман ба саволҳоятон ҷавоб медиҳем!\n\nБо мо тарики яке аз паёмрасонҳои зер тамос гиред, ё дар худи бот бо мушовир пайваст шавед! ⤵️")
                    ->keyboard(
                        Keyboard::make()
                            ->row([
                                Button::make('Telegram')->url('https://t.me/+992945100200'),
                                Button::make('WeChat')->url('https://u.wechat.com/kHHFGH2D-GqDbFIcWiuEPX4'),
                            ])
                            ->row([
                                Button::make('Телеграм канал')->url('https://t.me/TJ0007_CARGO'),
                            ])
                            ->row([
                                Button::make('Тамос бо мушовир')->action('open_chat'),
                            ])
                    )->send();
            }

            return;
        }
        if ($text == '💲 Нархнома' || $text == '💲 Прайс лист') {
            $this->chat->deleteMessage($this->messageId)->send();
            $price_kg = Setting::where('name', 'price_kg')->first();
            $price_cube = Setting::where('name', 'price_cube')->first();
            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/prise_list_ru.jpg'))->message("💡 Цена за 1 килограмм груза: $price_kg->value \n📦 Цена за 1 кубический метр груза: $price_cube->value")->send();
            } else {
                $this->chat->photo(public_path('assets/prise_list_tj.jpg'))->message("💡 Нархнома барои як килограм: $price_kg->value \n📦 Нархнома барои як метри куби: $price_cube->value")->send();
            }
            return;
        }
        if ($text == '❌ Молҳои манъшуда' || $text == '❌ Запрещенные товары') {
            $this->chat->deleteMessage($this->messageId)->send();
            $dangers = Setting::where('name', 'danger_products')->first();
            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/danger_ru.jpg'))->message($dangers->value)->send();
            } else {
                $this->chat->photo(public_path('assets/danger_tj.jpg'))->message($dangers->value)->send();
            }
            return;
        }
        if ($text == '🔢 Тафтиши трек-код' || $text == '🔢 Проверить трек-код') {
            $this->chat->deleteMessage($this->messageId)->send();
            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/track_ru.jpg'))->message("Отправьте трек-код вашего груза для проверки!")
                    ->replyKeyboard(ReplyKeyboard::make()
                        ->row([
                            ReplyButton::make('🔄 Основной меню'),
                        ])
                        ->resize())->send();
            } else {
                $this->chat->photo(public_path('assets/track_tj.jpg'))->message("📦🔍 Трек-коди бори худро барои тафтиш равон кунед!")
                    ->replyKeyboard(ReplyKeyboard::make()
                        ->row([
                            ReplyButton::make('🔄 Менюи асосӣ'),
                        ])
                        ->resize())->send();
            }
            return;
        }
        if ($text == '🔄 Менюи асосӣ' || $text == '🔄 Основной меню') {
            $this->chat->deleteMessage($this->messageId)->send();
            if ($this->chat->lang == 'ru') {
                $this->ru_keys();
            } else {
                $this->tj_keys();
            }
            return;
        }
        if ($text == '✅ Сурогаи склади Иву' || $text == '✅ Адрес склада Иву') {
            $this->chat->deleteMessage($this->messageId)->send();
            $location = Setting::where('name', 'address_ivu')->first();
            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/ivuloc_ru.jpg'))->message("$location->value")->send();
            } else {
                $this->chat->photo(public_path('assets/ivuloc_tj.jpg'))->message("$location->value")->send();
            }
            return;
        }
        if ($this->message->contact()) {
            $this->chat->deleteMessage($this->messageId)->send();
            $user = Customer::where('phone', str($this->message->contact()->phoneNumber()))->first();
            if ($user) {
                $usercode = $user->code;
                if ($this->chat->lang == 'ru') {
                    $this->chat->message("Вы уже подписались! Ваш специальный код <b>$usercode</b>!")->send();
                } else {
                    $this->chat->message("Шумо обуна шудагӣ ҳастед! Коди махсуси шумо <b>$usercode</b>!")->send();
                }
            } else {
                $lastCustomer = Customer::orderBy('id', 'desc')->first();

                if ($lastCustomer) {
                    // Увеличиваем код последнего клиента на 1 и форматируем его до 4 знаков
                    $newCode = str_pad($lastCustomer->code + 1, 4, '0', STR_PAD_LEFT);
                } else {
                    // Если клиентов нет, начинаем с 0001
                    $newCode = '0001';
                }

                Customer::create([
                    'name' => str($this->message->from()->firstName()),
                    'phone' => str($this->message->contact()->phoneNumber()),
                    'code' => $newCode,
                    'chat_id' => str($this->message->from()->id()), // chat_id для идентификации пользователя
                ]);
                if ($this->chat->lang == 'tj') {
                    $this->chat->message("✅ Шумо бо муввафақият бо рақамҳои <b>" . $this->message->contact()->phoneNumber() . "</b> обуна шудед! Коди махсуси шумо <b>($newCode)</b>! Барои маълумоти пурра гирифтан оиди тарзи пур кардани сурога тугмачаи <b>✅ Тарзи пур кардани суроға пахш кунед!</b>")->send();
                }
                if ($this->chat->lang == 'ru') {
                    $this->chat->message("Вы успешно подписались с номером <b>" . $this->message->contact()->phoneNumber() . "</b> Ваш специальный код <b>($newCode)</b>. Нажимайте на кнопку <b>✅ Как заполнить поля адреса</b> и получите подробную информацию о как заполнит адреса!")->send();
                }
            }
            return;
        }
        if ($this->message->video()) {
            $this->chat->message($this->message->video()->id())->send();
            return;
        }
        if ($text == 'admin shuhrat') {
            $this->chat->deleteMessage($this->messageId)->send();
            $this->chat->message(('Добро пожаловать в панел управление!'))
                ->keyboard(Keyboard::make()->buttons([
                    Button::make('Открыт панель управлению')->webApp('https://toocars.tj/'),
                ]))->send();
            return;
        }
        $this->chat->deleteMessage($this->messageId)->send();
        $trackcode = Trackcode::where('trackcode', str($text))->first();
        if ($trackcode) {
            if ($trackcode->china && $trackcode->dushanbe && $trackcode->customer) {
                if ($this->chat->lang == 'ru') {
                    $this->chat->photo(public_path('assets/close_ru.jpg'))->message("1️⃣Ваш груз с трек-кодом <b>($trackcode->trackcode)</b> был принят на нашем складе в Иву на дату $trackcode->china!\n2️⃣На дату $trackcode->dushanbe он прибыл в Душанбе!\n3️⃣На дату $trackcode->customer вы приняли груз!")->send();
                } else {
                    $this->chat->photo(public_path('assets/close_tj.jpg'))->message("1️⃣Бори шумо бо трек-коди <b>($trackcode->trackcode)</b> санаи $trackcode->china дар склади мо дар Иву кабул шудаги аст!\n2️⃣3️Санаи $trackcode->dushanbe ба Душанбе омада расид! \n3️⃣Санаи $trackcode->customer шумо онро кабул кардаги хастед!")->send();
                }
            } elseif ($trackcode->china && $trackcode->dushanbe) {
                if ($this->chat->lang == 'ru') {
                    $this->chat->photo(public_path('assets/dushan_ru.jpg'))->message("1️⃣Ваш груз с трек-кодом <b>($trackcode->trackcode)</b> был принят на нашем складе в Иву на дату $trackcode->china!\n2️⃣На дату $trackcode->dushanbe он прибыл в Душанбе!")->send();
                } else {
                    $this->chat->photo(public_path('assets/dushan_tj.jpg'))->message("1️⃣Бори шумо бо трек-коди <b>($trackcode->trackcode)</b> санаи $trackcode->china дар склади мо дар Иву кабул шудаги аст!\n2️⃣Санаи $trackcode->dushanbe ба Душанбе омада расид!")->send();
                }
            } elseif ($trackcode->china) {
                if ($this->chat->lang == 'ru') {
                    $this->chat->photo(public_path('assets/ivu_ru.jpg'))->message("✅Ваш груз с трек-кодом <b>($trackcode->trackcode)</b> был принят на нашем складе в Иву на дату $trackcode->china!")->send();
                } else {
                    $this->chat->photo(public_path('assets/ivu_tj.jpg'))->message("✅Бори шумо бо трек-коди <b>($trackcode->trackcode)</b> санаи $trackcode->china дар склади мо дар Иву кабул шудаги аст!")->send();
                }
            }
            $trackcode->customer_id = $this->message->from()->id();
            $trackcode->save();
        } else {
            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/info_tj.jpg'))->message("❌Информация по трек-коду <b>($text)</b> не найдена! 😞\nВозможно, груз ещё не поступил на наш склад в городе Иву.\nДля получения информации свяжитесь с консультантом! 📞")->send();
            } else {
                $this->chat->photo(public_path('assets/info_ru.jpg'))->message("❌Маълумот дар бораи трек-код <b>($text)</b> ёфт нашуд! 😞\nМумкин аст, ки бор ба склади мо дар шахри Иву дастрас нашудааст.\nБарои гирифтани маълумот бо мушовир тамос гиред! 📞")->send();
            }
        }
        return;
    }
}
