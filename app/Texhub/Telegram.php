<?php

namespace App\Texhub;

use App\Http\Controllers\SmsController;
use App\Models\Chat;
use App\Models\User;
use App\Models\Order;
use App\Models\Message;
use App\Models\Setting;
use App\Models\Trackcode;
use App\Models\Application;
use App\Models\Notification;
use Illuminate\Http\Request;
use DefStudio\Telegraph\Telegraph;
use Illuminate\Support\Stringable;
use Illuminate\Support\Str;
use Illuminate\Notifications\Action;
use Illuminate\Support\Facades\Storage;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Enums\ChatActions;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Keyboard\ReplyButton;
use DefStudio\Telegraph\Models\TelegraphChat;
use DefStudio\Telegraph\Keyboard\ReplyKeyboard;
use DefStudio\Telegraph\Facades\Telegraph as FacadesTelegraph;

class Telegram extends \DefStudio\Telegraph\Handlers\WebhookHandler
{
    public function refresh($user_id)
    {
        $chat = TelegraphChat::find($user_id);
        if ($chat->lang == 'ru') {
            $chat->message(("Выберите нужный раздел в меню ниже! 🔽"))
                ->replyKeyboard(ReplyKeyboard::make()
                    ->row([
                        ReplyButton::make('🔢 Проверить трек-код'),
                        ReplyButton::make('🕹 Личный кабинет')->webApp("https://shifucargo.texhub.pro/profile/$chat->chat_id"),
                    ])
                    ->row([
                        ReplyButton::make('➕ Подписаться'),
                        ReplyButton::make('👤 Связаться с оператором'),
                        ReplyButton::make('💲 Прайс лист'),
                    ])
                    ->row([
                        ReplyButton::make('🚚 Заказать доставку'),
                        ReplyButton::make('✅ Склад в Китай'),
                        ReplyButton::make('📍 Адрес склада Душанбе'),
                    ])
                    ->row([
                        ReplyButton::make('❌ Запрещенные товары'),
                        ReplyButton::make('🧮 Калькулятор')->webApp("https://shifucargo.texhub.pro/calculator"),
                        ReplyButton::make('🎞 Бесплатные уроки'),
                    ])
                    ->resize())->send();
        } else {
            $chat->message(("Бахши лозимаро дар менюи дар зер буда интихоб намоед! 🔽"))
                ->replyKeyboard(ReplyKeyboard::make()
                    ->row([
                        ReplyButton::make('🔢 Тафтиши трек-код'),
                        ReplyButton::make('🕹 Ҳуҷраи шахсӣ')->webApp("https://shifucargo.texhub.pro/profile/$chat->chat_id"),
                    ])
                    ->row([
                        ReplyButton::make('➕ Обуна шудан'),
                        ReplyButton::make('👤 Тамос бо оператор'),
                        ReplyButton::make('💲 Нархнома'),
                    ])
                    ->row([
                        ReplyButton::make('🚚 Дархости доставка'),
                        ReplyButton::make('✅ Склад дар Хитой'),
                        ReplyButton::make('📍 Сурогаи склади Душанбе'),
                    ])
                    ->row([
                        ReplyButton::make('❌ Молҳои манъшуда'),
                        ReplyButton::make('🧮 Ҳисобкунак')->webApp("https://shifucargo.texhub.pro/calculator"),
                        ReplyButton::make('🎞 Дарсҳои ройгон'),
                    ])
                    ->resize())->send();
        }
    }
    public function ai(): void
    {
        $chat_id = $this->chat->chat_id;
        $chat = User::where('chat_id', $chat_id)->first();
        $chat->step = 'ai';
        $chat->save();
        if ($this->chat->lang == 'ru') {
            $this->chat->message("Привет! 👋 Я ассистент компании Shifu Cargo. Чем могу помочь?")
                ->replyKeyboard(ReplyKeyboard::make()
                    ->row([
                        ReplyButton::make('❌ Закрыт чат'),
                    ])
                    ->resize())->send();
        } else {
            $this->chat->message("Салом! 👋 Ман мушовири ширкати Shifu Cargo ҳастам. Чӣ кӯмак карда метавонам?")
                ->replyKeyboard(ReplyKeyboard::make()
                    ->row([
                        ReplyButton::make('❌ Пушидани чат'),
                    ])
                    ->resize())->send();
        }
    }
    public function code(): void
    {
        $this->chat->message($this->message->from()->id())->send();
    }
    public function sms_bulk(): void
    {
        // $chats = TelegraphChat::all();
        // foreach ($chats as $chat) {
        //     if ($chat->lang == 'ru') {
        //         $chat->photo(public_path('assets/ivu_ru.png'))->message("Выберите, в каком складе в Душанбе хотите получить свои товары:")
        //             ->keyboard(Keyboard::make()->buttons([
        //                 Button::make('Водонасос (Гулдаст)')
        //                     ->action('selec_warehouse')
        //                     ->param('wh', 'vadanasos')
        //                     ->param('chat_id', (string) $chat->chat_id),

        //                 Button::make('Мост 46мкр (Саховат)')
        //                     ->action('selec_warehouse')
        //                     ->param('wh', '46mkr')
        //                     ->param('chat_id', (string) $chat->chat_id),
        //             ]))
        //             ->send();
        //     } else {
        //         $chat->photo(public_path('assets/ivu_ru.png'))->message("Интихоб кунед, ки дар кадом анбори Душанбе мехоҳед молатонро гиред:")
        //             ->keyboard(Keyboard::make()->buttons([
        //                 Button::make('Водонасос (Гулдаст)')
        //                     ->action('selec_warehouse')
        //                     ->param('wh', 'vadanasos')
        //                     ->param('chat_id', (string) $chat->chat_id),

        //                 Button::make('Мост 46мкр (Саховат)')
        //                     ->action('selec_warehouse')
        //                     ->param('wh', '46mkr')
        //                     ->param('chat_id', (string) $chat->chat_id),
        //             ]))
        //             ->send();
        //     }
        // }
        $chat = TelegraphChat::find(3);
        if ($chat->lang == 'ru') {
            $chat->photo(public_path('assets/ivu_ru.png'))->message("Выберите, в каком складе в Душанбе хотите получить свои товары:")
                ->keyboard(Keyboard::make()->buttons([
                    Button::make('Водонасос (Гулдаст)')
                        ->action('selec_warehouse')
                        ->param('wh', 'vadanasos')
                        ->param('chat_id', (string) $chat->chat_id),

                    Button::make('Мост 46мкр (Саховат)')
                        ->action('selec_warehouse')
                        ->param('wh', '46mkr')
                        ->param('chat_id', (string) $chat->chat_id),
                ]))
                ->send();
        } else {
            $chat->photo(public_path('assets/ivu_ru.png'))->message("Интихоб кунед, ки дар кадом анбори Душанбе мехоҳед молатонро гиред:")
                ->keyboard(Keyboard::make()->buttons([
                    Button::make('Водонасос (Гулдаст)')
                        ->action('selec_warehouse')
                        ->param('wh', 'vadanasos')
                        ->param('chat_id', (string) $chat->chat_id),

                    Button::make('Мост 46мкр (Саховат)')
                        ->action('selec_warehouse')
                        ->param('wh', '46mkr')
                        ->param('chat_id', (string) $chat->chat_id),
                ]))
                ->send();
        }
    }
    public function start(): void
    {
        $this->chat->photo(public_path('assets/welcome.png'))->message("Салом " . $this->message->from()->firstName() . "! \nИн телеграм боти <b>Shifu Cargo</b> мебошад! \nБарои истифода бурдан аввал забонро интихоб кунед!\n\nЭто телеграм бот <b>Shifu Cargo!</b> \nЧтобы использовать, сначала выберите язык! ⤵️")
            ->keyboard(
                Keyboard::make()
                    ->row([
                        Button::make('🇹🇯 Тоҷикӣ')->action('tj'),
                        Button::make('🇷🇺 Русский')->action('ru'),
                    ])
            )->send();
        $user = User::where('chat_id', $this->message->from()->id())->first();
        $user->step = null;
        $user->save();
    }
    public function tj(): void
    {
        $lang = $this->chat;
        $lang->lang = 'tj';
        $lang->save();
        $this->chat->deleteMessage($this->messageId)->send();
        $this->chat->photo(public_path('assets/tj.png'))->message(("Забони <b>🇹🇯 Тоҷикӣ</b> интихоб карда шуд!\n\nБарои бо воситаи каргои мо бор дархост кардан аввал тугмачаи <b>➕ Обуна шудан</b>-ро пахш намоед. Ба шумо коди махсус равон карда мешавад, ки шумо бо воситаи он аз маркетплейсҳои Хитойи бор дархост карда метавонед <b>(Обуна шудан ҳатмӣ аст!)</b>"))
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
        $this->chat->photo(public_path('assets/ru.png'))->message(("<b>🇷🇺 Русский</b> язык выбран! \n\nЧтобы заказать товары из Китая через наше карго, сначала нажмите на кнопку <b>➕ Подписаться</b>. Мы отправим вам специальный код, который в дальнейшем используете для заказа товаров с маркетплейсов Китая <b>(Подписаться обязательно!)</b>."))
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
        $chat_id = $this->chat->chat_id;

        $this->chat->message(("Бахши лозимаро дар менюи дар зер буда интихоб намоед! 🔽"))
            ->replyKeyboard(ReplyKeyboard::make()
                ->row([
                    ReplyButton::make('🔢 Тафтиши трек-код'),
                    ReplyButton::make('🕹 Ҳуҷраи шахсӣ')->webApp("https://shifucargo.texhub.pro/profile/$chat_id"),
                ])
                ->row([
                    ReplyButton::make('➕ Обуна шудан'),
                    ReplyButton::make('👤 Тамос бо оператор'),
                    ReplyButton::make('💲 Нархнома'),
                ])
                ->row([
                    ReplyButton::make('🚚 Дархости доставка'),
                    ReplyButton::make('✅ Склад в Китай'),
                    ReplyButton::make('📍 Сурогаи склади Душанбе'),
                ])
                ->row([
                    ReplyButton::make('❌ Молҳои манъшуда'),
                    ReplyButton::make('🧮 Ҳисобкунак')->webApp("https://shifucargo.texhub.pro/calculator"),
                    ReplyButton::make('🎞 Дарсҳои ройгон'),
                ])
                ->resize())->send();
    }
    public function ru_keys(): void
    {
        $chat_id = $this->chat->chat_id;


        $this->chat->message(("Выберите нужный раздел в меню ниже! 🔽"))
            ->replyKeyboard(ReplyKeyboard::make()
                ->row([
                    ReplyButton::make('🔢 Проверить трек-код'),
                    ReplyButton::make('🕹 Личный кабинет')->webApp("https://shifucargo.texhub.pro/profile/$chat_id"),
                ])
                ->row([
                    ReplyButton::make('➕ Подписаться'),
                    ReplyButton::make('👤 Связаться с оператором'),
                    ReplyButton::make('💲 Прайс лист'),
                ])
                ->row([
                    ReplyButton::make('🚚 Заказать доставку'),
                    ReplyButton::make('✅ Склад дар Хитой'),
                    ReplyButton::make('📍 Адрес склада Душанбе'),
                ])
                ->row([
                    ReplyButton::make('❌ Запрещенные товары'),
                    ReplyButton::make('🧮 Калькулятор')->webApp("https://shifucargo.texhub.pro/calculator"),
                    ReplyButton::make('🎞 Бесплатные уроки'),
                ])
                ->resize())->send();
    }
    public function edit_profile($id): void
    {
        $user = User::find($id);
        $user->step = 'phone';
        $user->sub_step = null;
        $user->save();
        if ($this->chat->lang == 'ru') {
            $this->chat->message("📞 Напишите свой номер телефона, например: <b>931234567</b>")->send();
        } else {
            $this->chat->message("📞 Рақами телефони худро нависед, масалан: <b>931234567</b>")->send();
        }
    }
    public function open_chat(): void
    {
        $this->chat->deleteMessage($this->messageId)->send();
        if ($this->chat->lang == 'ru') {
            $this->chat->message("⚠️ В данный момент чат внутри Telegram‑бота отключен по техническим причинам. Пожалуйста, обращайтесь к нам в Instagram Direct.")->send();
        } else {
            $this->chat->message("⚠️ Айни ҳол чат дар дохили боти Telegram бо сабабҳои техникӣ ғайрифаъол аст. Лутфан ба мо дар Instagram Direct муроҷиат кунед.")->send();
        }
        return;

        // $chat_id = $this->chat->chat_id;
        // $chat = User::where('chat_id', $chat_id)->first();
        // if (!$chat) {
        //     if ($this->chat->lang == 'ru') {
        //         $this->chat->message("🔹 Чтобы связаться с консультантом, сначала нажмите кнопку <b>➕ Подписаться</b> и 📩 оформите подписку! ✅")->send();
        //     } else {
        //         $this->chat->message("🔹 Барои пайваст шудан бо мушовир, аввал тугмаи <b>➕ Обуна шудан</b>-ро пахш карда 📩 обуна шавед! ✅")->send();
        //     }
        //     return;
        // }


        // $chat_open = Chat::where('user_id', $chat->id)->first();
        // if (!$chat_open) {
        //     Chat::create([
        //         'user_id' => $chat->id,
        //         'status' => true,
        //     ]);
        // } else {
        //     $chat_open->status = true;
        //     $chat_open->save();
        // }
        // if ($this->chat->lang == 'ru') {
        //     $this->chat->message("🔹 Привет! ✍️ Опишите свою проблему в одном сообщении и 📩 отправьте. 🔄 Консультант обязательно вам ответит! ✅")->replyKeyboard(ReplyKeyboard::make()
        //         ->row([
        //             ReplyButton::make('❌ Закрыт чат'),
        //         ])
        //         ->resize())->send();
        // } else {
        //     $this->chat->message("🔹 Салом! ✍️ Мушкилии худро дар як матн навишта 📩 равон кунед. 🔄 Мушовир ҳатман ба шумо ҷавоб мегардонад! ✅")->replyKeyboard(ReplyKeyboard::make()

        //         ->row([
        //             ReplyButton::make('❌ Пушидани чат'),
        //         ])
        //         ->resize())->send();
        // }
        // $chat->step = 'chat';
        // $chat->save();
    }
    public function sex_radio($id, $sex): void
    {
        $this->chat->deleteMessage($this->messageId)->send();

        $user = User::find($id);
        $user->sex = $sex;
        $user->step = null;
        $user->save();

        if ($this->chat->lang == 'ru') {
            $this->chat->message("✅ Вы успешно зарегистрированы! Теперь можете заказывать из Китая. Для получения адреса нашего склада в городе Иву нажмите на кнопку в меню ниже: «Адрес склада Иву» ⬇️")->send();
        } else {
            $this->chat->message("✅ Шумо бо муваффақият сабти ном шудед! Ҳоло метавонед аз Чин фармоиш диҳед. Барои гирифтани суроғаи анбори мо дар шаҳри Иву тугмаи «Суроғаи анбори Иву»-ро дар менюи поён пахш кунед ⬇️")->send();
        }
        return;
    }
    public function handleChatMessage(Stringable $text): void
    {
        if ($text == $this->message->video()) {
            $this->chat->message($this->message->video()->id())->send();
        }

        $user = User::where('chat_id', $this->message->from()->id())->first();

        if ($text == '❌ Закрыт чат' || $text == '❌ Пушидани чат' || $text == "❌ Не хочу оставлять заявку" || $text == "❌ Намехоҳам дархост гузорам") {
            $user->step = null;
            $user->save();
            $chat_sec = Chat::where('user_id', $user->id)->first();
            if ($chat_sec) {
                $chat_sec->status = false;
                $chat_sec->save();
            }

            if ($this->chat->lang == 'ru') {
                $this->ru_keys();
            } else {
                $this->tj_keys();
            }
            return;
        }
        if ($text == '➕ Обуна шудан' || $text == '➕ Подписаться') {
            if (!$user) {
                $user = new User();
                $user->chat_id = $this->message->from()->id();
                $user->step = 'phone';
                $user->sub_step = null;
                $user->save();
                if ($this->chat->lang == 'ru') {
                    $this->chat->message("📞 Напишите свой номер телефона, например: <b>931234567</b>")->send();
                } else {
                    $this->chat->message("📞 Рақами телефони худро нависед, масалан: <b>931234567</b>")->send();
                }
            } elseif (!$user->phone || !$user->name || !$user->sex) {
                $user->step = 'phone';
                $user->sub_step = null;
                $user->save();

                if ($this->chat->lang == 'ru') {
                    $this->chat->message("📞 Продолжим регистрацию. Напишите свой номер телефона, например: <b>931234567</b>")->send();
                } else {
                    $this->chat->message("📞 Сабти номро идома медиҳем. Рақами телефони худро нависед, масалан: <b>931234567</b>")->send();
                }
            } else {
                if ($this->chat->lang == 'ru') {
                    $this->chat->message("👤 Имя: " . ($user->name ?? '—') . "\n📞 Номер телефона: " . ($user->phone ?? '—'))->send();
                    $this->chat->message("✅ Вы уже подписаны. Если хотите изменить информацию, нажмите на кнопку «Изменить» ниже ⬇️")
                        ->keyboard(
                            Keyboard::make()
                                ->row([
                                    Button::make('Изменить')->action('edit_profile')->param('id', $user->id),
                                ])
                        )->send();
                } else {
                    $this->chat->message("👤 Ном: " . ($user->name ?? '—') . "\n📞 Рақами телефон: " . ($user->phone ?? '—'))->send();
                    $this->chat->message("✅ Шумо аллакай обуна шудаед. Барои тағйир додани маълумот, тугмаи «Тағйир додан»-ро дар поён пахш кунед ⬇️")
                        ->keyboard(
                            Keyboard::make()
                                ->row([
                                    Button::make('Тағйир додан')->action('edit_profile')->param('id', $user->id),
                                ])
                        )->send();
                }
            }

            return;
        }
        if (!$user) {
            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/subscribe_ru.png'))->message("🤖 Для использования нашего бота сначала пройдите регистрацию. После этого вам будут доступны все функции. ✅")->send();
            } else {
                $this->chat->photo(public_path('assets/subscribe_tj.png'))->message("🤖 Барои истифодаи боти мо аввал сабти ном шавед. Пас аз ин ҳамаи функсияҳои дастрасро истифода бурда метавонед. ✅")->send();
            }

            return;
        }
        if ($user) {
            if ($user->step) {
                if (
                    // 🇹🇯 Таджикские кнопки
                    $text == "🔢 Тафтиши трек-код" ||
                    $text == "🕹 Ҳуҷраи шахсӣ" ||
                    $text == "➕ Обуна шудан" ||
                    $text == "👤 Тамос бо оператор" ||
                    $text == "💲 Нархнома" ||
                    $text == "🚚 Дархости доставка" ||
                    $text == "✅ Склад в Китай" ||
                    $text == "📍 Сурогаи склади Душанбе" ||
                    $text == "❌ Молҳои манъшуда" ||
                    $text == "🧮 Ҳисобкунак" ||
                    $text == "🎞 Дарсҳои ройгон" ||

                    // 🇷🇺 Русские кнопки
                    $text == "🔢 Проверить трек-код" ||
                    $text == "🕹 Личный кабинет" ||
                    $text == "➕ Подписаться" ||
                    $text == "👤 Связаться с оператором" ||
                    $text == "💲 Прайс лист" ||
                    $text == "🚚 Заказать доставку" ||
                    $text == "✅ Склад дар Хитой" ||
                    $text == "📍 Адрес склада Душанбе" ||
                    $text == "❌ Запрещенные товары" ||
                    $text == "🧮 Калькулятор" ||
                    $text == "🎞 Бесплатные уроки"
                ) {
                    if ($this->chat->lang == 'ru') {
                        $this->chat->message("⚠️ Введите правильные данные!")->send();
                    } else {
                        $this->chat->message("⚠️ Маълумоти дуруст ворид кунед!")->send();
                    }
                    return;
                }
            }

            if ($user->step == 'chat') {
                $chatik = Chat::where('user_id', $user->id)->first();
                Message::create([
                    'chat_id' => $chatik->id,
                    'message' => $text,
                ]);
                return;
            }
            if ($user->step == 'ai') {
                $chatik = Chat::where('user_id', $user->id)->first();
                if (!$chatik) {
                    $chatik = Chat::create([
                        'user_id' => $user->id,
                        'status' => true,
                    ]);
                } else {
                    $chatik->status = true;
                    $chatik->save();
                }
                $assistant = new Assistant();
                if (!$chatik->thread) {
                    $thread_id = $assistant->createThread();
                    $chatik->thread = $thread_id;
                    $chatik->save();
                }
                $add_sms = $assistant->addMessage($chatik->thread, $text);
                $runId = $assistant->runAssistant($chatik->thread, "asst_9O6POmPVglMEQnvNARYriTuu");
                $status = $assistant->getRunStatus($chatik->thread, $runId);

                while ($status['status'] !== 'completed') {
                    sleep(3);
                    $status = $assistant->getRunStatus($chatik->thread, $runId);
                }

                $ai_response = $assistant->getLastMessage($chatik->thread);
                Message::create([
                    'chat_id' => $chatik->id,
                    'message' => $text,
                    'is_admin' => false,
                ]);
                Message::create([
                    'chat_id' => $chatik->id,
                    'message' => $ai_response,
                    'is_admin' => true,
                ]);
                $this->chat->message(str($ai_response))->send();
                return;
            }
            if ($user->step == 'name') {
                $code = User::orderBy('code', 'desc')->first();

                $user->name = $text;
                if (!$user->code) {
                    $user->code = str_pad($code ? $code->code + 1 : 1, 4, '0', STR_PAD_LEFT);
                }
                $user->step = "sex";
                $user->save();

                $this->sendSexSelectionKeyboard($user);
                return;
            }
            if ($user->step == 'phone') {
                $phone = $this->normalizePhoneInput((string) $text);
                if (!$this->isValidPhone($phone)) {
                    if ($this->chat->lang == 'ru') {
                        $this->chat->message("❗️ Пожалуйста, отправьте корректный номер телефона. Допустимы только цифры и, при необходимости, знак «+» (пример: +992900000000).")->send();
                    } else {
                        $this->chat->message("❗️ Лутфан рақами дурусти телефонро фиристед. Танҳо рақамҳо ва аломати «+» иҷозат дода мешавад (мисол: +992900000000).")->send();
                    }
                    return;
                }

                $verificationCode = (string) random_int(100000, 999999);
                $smsMessage = $this->chat->lang == 'ru'
                    ? "Код подтверждения Shifu Cargo: $verificationCode. Код действует 5 минут."
                    : "Рамзи тасдиқи Shifu Cargo: $verificationCode. Рамз 5 дақиқа фаъол аст.";

                $smsController = new SmsController();
                $smsResult = $smsController->sendSms($phone, $smsMessage);

                if (!Str::startsWith((string) $smsResult, 'SMS успешно отправлено')) {
                    if ($this->chat->lang == 'ru') {
                        $this->chat->message("⚠️ Не удалось отправить SMS-код подтверждения. Попробуйте еще раз через минуту.")->send();
                    } else {
                        $this->chat->message("⚠️ Фиристодани рамзи тасдиқ тавассути SMS муваффақ нашуд. Лутфан пас аз як дақиқа дубора кӯшиш кунед.")->send();
                    }
                    return;
                }

                $user->step = "phone_verify";
                $user->sub_step = json_encode([
                    'phone' => $phone,
                    'code' => $verificationCode,
                    'expires_at' => now()->addMinutes(5)->timestamp,
                ], JSON_UNESCAPED_UNICODE);
                $user->save();

                if ($this->chat->lang == 'ru') {
                    $this->chat->message("📩 Мы отправили SMS-код на номер <b>$phone</b>. Введите 6-значный код подтверждения.\n\nЕсли код не пришел, отправьте: <b>🔁 Отправить код повторно</b>")->send();
                } else {
                    $this->chat->message("📩 Мо рамзи SMS-ро ба рақами <b>$phone</b> фиристодем. Рамзи 6-рақамаро ворид кунед.\n\nАгар рамз нарасид, ин матнро фиристед: <b>🔁 Рамзро дубора фиристед</b>")->send();
                }
                return;
            }
            if ($user->step == 'phone_verify') {
                $verification = $this->getPhoneVerificationData($user);
                if (!$verification) {
                    $user->step = "phone";
                    $user->sub_step = null;
                    $user->save();
                    if ($this->chat->lang == 'ru') {
                        $this->chat->message("⚠️ Сессия подтверждения завершилась. Напишите номер телефона еще раз.")->send();
                    } else {
                        $this->chat->message("⚠️ Сессияи тасдиқ ба анҷом расид. Лутфан рақами телефонро боз нависед.")->send();
                    }
                    return;
                }

                if ($text == '🔁 Отправить код повторно' || $text == '🔁 Рамзро дубора фиристед') {
                    $verificationCode = (string) random_int(100000, 999999);
                    $smsMessage = $this->chat->lang == 'ru'
                        ? "Код подтверждения Shifu Cargo: $verificationCode. Код действует 5 минут."
                        : "Рамзи тасдиқи Shifu Cargo: $verificationCode. Рамз 5 дақиқа фаъол аст.";

                    $smsController = new SmsController();
                    $smsResult = $smsController->sendSms((string) $verification['phone'], $smsMessage);

                    if (!Str::startsWith((string) $smsResult, 'SMS успешно отправлено')) {
                        if ($this->chat->lang == 'ru') {
                            $this->chat->message("⚠️ Не удалось отправить SMS-код повторно. Попробуйте еще раз через минуту.")->send();
                        } else {
                            $this->chat->message("⚠️ Рамз дубора фиристода нашуд. Лутфан пас аз як дақиқа кӯшиши дигар кунед.")->send();
                        }
                        return;
                    }

                    $user->sub_step = json_encode([
                        'phone' => $verification['phone'],
                        'code' => $verificationCode,
                        'expires_at' => now()->addMinutes(5)->timestamp,
                    ], JSON_UNESCAPED_UNICODE);
                    $user->save();

                    if ($this->chat->lang == 'ru') {
                        $this->chat->message("📩 Новый SMS-код отправлен. Введите 6-значный код подтверждения.")->send();
                    } else {
                        $this->chat->message("📩 Рамзи нави SMS фиристода шуд. Рамзи 6-рақамаро ворид кунед.")->send();
                    }
                    return;
                }

                $enteredCode = preg_replace('/\D/', '', (string) $text);
                if (strlen($enteredCode) !== 6) {
                    if ($this->chat->lang == 'ru') {
                        $this->chat->message("❗️ Введите 6-значный код подтверждения из SMS.")->send();
                    } else {
                        $this->chat->message("❗️ Рамзи 6-рақамаи тасдиқро аз SMS ворид кунед.")->send();
                    }
                    return;
                }

                if ((int) now()->timestamp > (int) $verification['expires_at']) {
                    $user->step = "phone";
                    $user->sub_step = null;
                    $user->save();

                    if ($this->chat->lang == 'ru') {
                        $this->chat->message("⌛️ Срок действия кода истек. Напишите номер телефона еще раз, и мы отправим новый код.")->send();
                    } else {
                        $this->chat->message("⌛️ Муҳлати рамз ба охир расид. Рақами телефонро боз нависед, мо рамзи нав мефиристем.")->send();
                    }
                    return;
                }

                if (!hash_equals((string) $verification['code'], $enteredCode)) {
                    if ($this->chat->lang == 'ru') {
                        $this->chat->message("❌ Неверный код подтверждения. Попробуйте снова или отправьте: <b>🔁 Отправить код повторно</b>")->send();
                    } else {
                        $this->chat->message("❌ Рамзи тасдиқ нодуруст аст. Дубора кӯшиш кунед ё ин матнро фиристед: <b>🔁 Рамзро дубора фиристед</b>")->send();
                    }
                    return;
                }

                $user->phone = (string) $verification['phone'];
                $user->step = "name";
                $user->sub_step = null;
                $user->save();
                if ($this->chat->lang == 'ru') {
                    $this->chat->message("👤 Напишите своё имя с английскими буквами, например: <b>Abdullo</b>")->send();
                } else {
                    $this->chat->message("👤 Номи худро бо харфхои англиси нависед, масалан: <b>Abdullo</b>")->send();
                }
                return;
            }
            if ($user->step == 'apl_phone') {
                $phone = trim($text);
                if (!preg_match('/^\+?[0-9]{7,15}$/', $phone)) {
                    if ($this->chat->lang == 'ru') {
                        $this->chat->message("❗️ Пожалуйста, отправьте корректный номер телефона. Допустимы только цифры и, при необходимости, знак «+» (пример: +992900000000).")->send();
                    } else {
                        $this->chat->message("❗️ Лутфан рақами дурусти телефонро фиристед. Танҳо рақамҳо ва аломати «+» иҷозат дода мешавад (мисол: +992900000000).")->send();
                    }
                    return;
                }
                $application = Application::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
                if ($application) {
                    $application->phone = $phone;
                    $application->save();
                }
                $user->step = "apl_address";
                $user->save();
                if ($this->chat->lang == 'ru') {
                    $this->chat->message("📍 Отправьте свой адрес как можно подробнее, с указанием ориентиров (улица, дом, район, рядом с чем находится). Это поможет нам доставить заказ быстрее ✅")->send();
                } else {
                    $this->chat->message("📍 Суроғаи худро бо нишон додани тамоми ҷузъиёт ва нишонаҳои атроф (кӯча, хона, маҳалла, дар назди чӣ ҷойгир аст) фиристед. Ин ба мо кӯмак мекунад, ки фармоиши шуморо зудтар расонем ✅")->send();
                }
                return;
            }
            if ($user->step == 'apl_address') {
                $address = trim($text);
                if (mb_strlen($address) < 8) {
                    if ($this->chat->lang == 'ru') {
                        $this->chat->message("❗️ Уточните адрес — минимум 8 символов с указанием улицы, дома и ориентира.")->send();
                    } else {
                        $this->chat->message("❗️ Суроға бояд ақаллан аз 8 аломат иборат бошад ва кӯча, хона ва нишонаҳоро дар бар гирад.")->send();
                    }
                    return;
                }
                $application = Application::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
                if ($application) {
                    $application->address = $address;
                    $application->save();
                }
                $user->step = null;
                $user->save();
                if ($this->chat->lang == 'ru') {
                    $this->chat->message("✅ Ваш заказ получен! Мы проверим, и если он уже есть на нашем складе в Душанбе, мы обязательно доставим его вам. 📦")->send();
                    $this->ru_keys();

                } else {
                    $this->chat->message("✅ Фармоиши шумо қабул шуд! Мо месанҷем ва агар он дар анбори мо дар шаҳри Душанбе бошад, ҳатман онро ба шумо мерасонем. 📦")->send();
                    $this->tj_keys();

                }
                return;
            }
        }
        $this->chat->deleteMessage($this->messageId)->send();

        if ($text == '🚚 Дархости доставка' || $text == '🚚 Заказать доставку') {

            // if ($this->chat->lang == 'ru') {
            //     $this->chat->message("⚠️  Сейчас заказ доставки временно недоступен. В ближайшее время сервис снова заработает, мы обязательно сообщим об этом.")->send();
            // } else {
            //     $this->chat->message("⚠️ Айни ҳол фармоиши расонидан муваққатан дастрас нест. Дар ояндаи наздик хизматрасонӣ дубора фаъол мешавад, мо ҳатман хабар медиҳем.")->send();
            // }
            // return;
            $application = new Application();
            $application->user_id = $user->id;
            $application->save();
            $user->step = "apl_phone";
            $user->save();
            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/delivery_ru.png'))->message("✍️ Напишите свой номер телефона, например: <b>931234567</b>")->replyKeyboard(ReplyKeyboard::make()
                    ->row([
                        ReplyButton::make('❌ Не хочу оставлять заявку'),
                    ])
                    ->resize())->send();
                ;
            } else {
                $this->chat->photo(public_path('assets/delivery_tj.png'))->message("✍️ Рақами телефони худро нависед, масалан: <b>931234567</b>")->replyKeyboard(ReplyKeyboard::make()
                    ->row([
                        ReplyButton::make('❌ Намехоҳам дархост гузорам'),
                    ])
                    ->resize())->send();
            }
            return;
        }
        if ($text == '📍 Сурогаи склади Душанбе' || $text == '📍 Адрес склада Душанбе') {
            $dushanbe = Setting::where('name', 'address_dushanbe')->first();

            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/dushanbe_ru.png'))
                    ->message("Выберите склад в Душанбе:\n\n$dushanbe->content")
                    ->keyboard(Keyboard::make()->buttons([
                        Button::make('Водонасос (Гулдаст)')
                            ->action('selec_wareh')
                            ->param('wh', 'vadanasos'),

                        Button::make('Мост 46мкр (Саховат)')
                            ->action('selec_wareh')
                            ->param('wh', '46mkr'),
                    ]))
                    ->send();
            } else {
                $this->chat->photo(public_path('assets/dushanbe_tj.png'))
                    ->message("Анбори Душанбе-ро интихоб кунед:\n\n$dushanbe->content")
                    ->keyboard(Keyboard::make()->buttons([
                        Button::make('Водонасос (Гулдаст)')
                            ->action('selec_wareh')
                            ->param('wh', 'vadanasos'),

                        Button::make('Пули 46мкр (Саховат)')
                            ->action('selec_wareh')
                            ->param('wh', '46mkr'),
                    ]))
                    ->send();
            }

            return;
        }
        if ($text == '👤 Тамос бо оператор' || $text == '👤 Связаться с оператором') {
            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/chat_ru.png'))->message("<b>Режим работы</b> с Душанбе по воскресенье с <b>08:00 до 18:00</b>.\n\nВ рабочие часы свяжитесь с нами — мы обязательно ответим на ваши вопросы!\n\nСвяжитесь с нами через один из мессенджеров ниже или подключитесь к консультанту прямо в боте! ⤵️")
                    ->keyboard(
                        Keyboard::make()
                            ->row([
                                Button::make('Телеграм канал')->url('https://t.me/cargoshifu'),
                            ])
                            ->row([
                                Button::make('Тамос бо мушовир')->action('open_chat'),
                            ])
                    )->send();
            } else {
                $this->chat->photo(public_path('assets/chat_tj.png'))->message("<b>Реҷаи корӣ</b> аз Душанбе то Якшанбе соатҳои <b>08:00 то 18:00</b>.\n\nДар вақти корӣ бо мо тамос гиред ҳатман ба саволҳоятон ҷавоб медиҳем!\n\nБо мо тарики яке аз паёмрасонҳои зер тамос гиред, ё дар худи бот бо мушовир пайваст шавед! ⤵️")
                    ->keyboard(
                        Keyboard::make()

                            ->row([
                                Button::make('Телеграм канал')->url('https://t.me/cargoshifu'),
                            ])
                            ->row([
                                Button::make('Тамос бо мушовир')->action('open_chat'),
                            ])
                    )->send();
            }

            return;
        }
        if ($text == '💲 Нархнома' || $text == '💲 Прайс лист') {
            $price_kg = Setting::where('name', 'kg_price')->first();
            $price_cube = Setting::where('name', 'cube_price')->first();
            $kg_price_20 = Setting::where('name', 'kg_price_20')->first();
            $kg_price_30 = Setting::where('name', 'kg_price_30')->first();
            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/price_ru.png'))->message("📋 <b>Прайс-лист (с 23.03.2025)</b>\n🚚 Иву ➜ Душанбе\n\n⏱ <b>Срок доставки:</b> 14–20 дней\n\n💲 <b>Цена за 1 килограмм груза:</b>\n• от 1 кг до 20 кг — $price_kg->content\n• от 20 кг до 30 кг — $kg_price_20->content\n• свыше 30 кг — $kg_price_30->content\n\n📦 <b>Цена за 1 кубический метр груза:</b> $price_cube->content\n\n📌 Цены действуют для грузов, прибывших на склад в один день и соответствующих указанному весу.\n📞 При заказе от 200 кг и выше — заранее свяжитесь с администрацией.")
                    ->send();
            } else {
                $this->chat->photo(public_path('assets/price_tj.png'))->message("📋 <b>Нархнома (аз 23.03.2025)</b>\n🚚 Иву ➜ Душанбе\n\n⏱ <b>Мӯҳлати расонидан:</b> 14–20 рӯз\n\n💲 <b>Нарх барои як килограмм бор:</b>\n• аз 1 кг то 20 кг — $price_kg->content\n• аз 20 кг то 30 кг — $kg_price_20->content\n• зиёда аз 30 кг — $kg_price_30->content\n\n📦 <b>Нарх барои як метри мукааб бор:</b> $price_cube->content\n\n📌 Нарҳҳо барои борҳое амал мекунанд, ки дар як рӯз ба анбор оварда шудаанд ва ба вазни зикршуда мувофиқат мекунанд.\n📞 Ҳангоми фармоиши аз 200 кг боло — пешакӣ бо маъмурият тамос гиред.")
                    ->send();
            }

            return;
        }
        if ($text == '❌ Молҳои манъшуда' || $text == '❌ Запрещенные товары') {
            $dangers = Setting::where('name', 'danger_products')->first();
            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/danger_ru.png'))->message($dangers->content)->send();
            } else {
                $this->chat->photo(public_path('assets/danger_tj.png'))->message($dangers->content)->send();
            }
            return;
        }
        if ($text == '🔢 Тафтиши трек-код' || $text == '🔢 Проверить трек-код') {
            $this->chat->deleteMessage($this->messageId)->send();
            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/track_code_ru.png'))->message("Отправьте трек-код вашего груза для проверки!")
                    ->replyKeyboard(ReplyKeyboard::make()
                        ->row([
                            ReplyButton::make('🔄 Основной меню'),
                        ])
                        ->resize())->send();
            } else {
                $this->chat->photo(public_path('assets/track_code_tj.png'))->message("📦🔍 Трек-коди бори худро барои тафтиш равон кунед!")
                    ->replyKeyboard(ReplyKeyboard::make()
                        ->row([
                            ReplyButton::make('🔄 Менюи асосӣ'),
                        ])
                        ->resize())->send();
            }
            return;
        }
        if ($text == '🔄 Менюи асосӣ' || $text == '🔄 Основной меню') {
            if ($this->chat->lang == 'ru') {
                $this->ru_keys();
            } else {
                $this->tj_keys();
            }
            return;
        }
        if ($text == '✅ Склад дар Хитой' || $text == '✅ Склад в Китай') {
            $location = Setting::where('name', 'address_ivu')->first();
            if (!$user) {
                if ($this->chat->lang == 'ru') {
                    $this->chat->message("📦 Чтобы получить адрес нашего склада в городе Иву, сначала нажмите кнопку «➕ Подписаться» в меню ниже ⬇️, а затем повторите действие. ✅")->send();
                } else {
                    $this->chat->message("📦 Барои гирифтани суроғаи анбори мо дар шаҳри Иву, аввал тугмаи «➕ Обуна шудан»-ро дар менюи поён ⬇️ пахш кунед, баъд ин амалро такрор намоед. ✅")->send();
                }
                return;
            }
            $locations_vadanasos = "联系人：Shifu-$user->code\n联系电话：15057921193\n收货地址：浙江省金华市义乌市第二毛纺厂内\n义乌市城北路J128号一楼2单元shifu仓库-$user->code-$user->name-$user->phone";
            $locations_46mkr = "联系人：Shifu1-$user->code\n联系电话：15057921193\n收货地址：浙江省金华市义乌市第二毛纺厂内\n义乌市城北路J128号一楼5单元shifu1仓库-$user->code-$user->name-$user->phone";

            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/ivu_ru.png'))->message("Выберите, в каком складе в Душанбе хотите получить свои товары:")
                    ->keyboard(Keyboard::make()->buttons([
                        Button::make('Водонасос (Гулдаст)')
                            ->action('selec_warehouse')
                            ->param('wh', 'vadanasos')
                            ->param('chat_id', (string) $this->chat->chat_id),

                        Button::make('Мост 46мкр (Саховат)')
                            ->action('selec_warehouse')
                            ->param('wh', '46mkr')
                            ->param('chat_id', (string) $this->chat->chat_id),
                    ]))
                    ->send();
            } else {
                $this->chat->photo(public_path('assets/ivu_ru.png'))->message("Интихоб кунед, ки дар кадом анбори Душанбе мехоҳед молатонро гиред:")
                    ->keyboard(Keyboard::make()->buttons([
                        Button::make('Водонасос (Гулдаст)')
                            ->action('selec_warehouse')
                            ->param('wh', 'vadanasos')
                            ->param('chat_id', (string) $this->chat->chat_id),

                        Button::make('Мост 46мкр (Саховат)')
                            ->action('selec_warehouse')
                            ->param('wh', '46mkr')
                            ->param('chat_id', (string) $this->chat->chat_id),
                    ]))
                    ->send();
            }
            // if ($this->chat->lang == 'ru') {
            //     $this->chat->photo(public_path('assets/ivu_ru.png'))->message($locations)
            //         ->keyboard(function (Keyboard $keyboard) use ($locations) {
            //             return $keyboard
            //                 ->button('📋 Скопировать адрес')->copyText($locations);
            //         })->send();
            // } else {
            //     $this->chat->photo(public_path('assets/ivu_tj.png'))->message($locations)
            //         ->keyboard(function (Keyboard $keyboard) use ($locations) {
            //             return $keyboard
            //                 ->button('📋 Нусха бардоштани суроға')->copyText($locations);
            //         })->send();
            // }


            return;
        }
        if ($text == 'supershifu') {
            $this->chat->message(('Добро пожаловать в панел управление!'))
                ->keyboard(Keyboard::make()->buttons([
                    Button::make('Открыт панель управлению')->webApp('https://sifucargo.texhub.pro/admin/dashboard'),
                ]))->send();
            return;
        }
        $trackcode = Trackcode::where('code', str($text))->first();
        if ($trackcode) {
            if ($trackcode->china && $trackcode->dushanbe && $trackcode->customer) {
                if ($this->chat->lang == 'ru') {
                    $this->chat->photo(public_path('assets/done_ru.png'))->message("1️⃣Ваш груз с трек-кодом <b>($trackcode->code)</b> был принят на нашем складе в Иву на дату $trackcode->china!\n2️⃣На дату $trackcode->dushanbe он прибыл в Душанбе!\n3️⃣На дату $trackcode->customer вы приняли груз!")->send();
                } else {
                    $this->chat->photo(public_path('assets/done_tj.png'))->message("1️⃣Бори шумо бо трек-коди <b>($trackcode->code)</b> санаи $trackcode->china дар склади мо дар Иву кабул шудаги аст!\n2️⃣3️Санаи $trackcode->dushanbe ба Душанбе омада расид! \n3️⃣Санаи $trackcode->customer шумо онро кабул кардаги хастед!")->send();
                }
            } elseif ($trackcode->china && $trackcode->dushanbe) {
                if ($this->chat->lang == 'ru') {
                    $this->chat->photo(public_path('assets/dushanbe_done_ru.png'))->message("1️⃣Ваш груз с трек-кодом <b>($trackcode->code)</b> был принят на нашем складе в Иву на дату $trackcode->china!\n2️⃣На дату $trackcode->dushanbe он прибыл в Душанбе!")->send();
                } else {
                    $this->chat->photo(public_path('assets/dushanbe_done_tj.png'))->message("1️⃣Бори шумо бо трек-коди <b>($trackcode->code)</b> санаи $trackcode->china дар склади мо дар Иву кабул шудаги аст!\n2️⃣Санаи $trackcode->dushanbe ба Душанбе омада расид!")->send();
                }
            } elseif ($trackcode->china) {
                if ($this->chat->lang == 'ru') {
                    $this->chat->photo(public_path('assets/ivu_done_ru.png'))->message("✅Ваш груз с трек-кодом <b>($trackcode->code)</b> был принят на нашем складе в Иву на дату $trackcode->china!")->send();
                } else {
                    $this->chat->photo(public_path('assets/ivu_done_tj.png'))->message("✅Бори шумо бо трек-коди <b>($trackcode->code)</b> санаи $trackcode->china дар склади мо дар Иву кабул шудаги аст!")->send();
                }
            } else {
                if ($this->chat->lang == 'ru') {
                    $this->chat->photo(public_path('assets/ru_list.jpg'))->message(
                        "⏳ Ваш груз с трек-кодом <b>($trackcode->code)</b> находится в листе ожидания. Если статус изменится, мы сообщим вам!"
                    )->send();
                } else {
                    $this->chat->photo(public_path('assets/tj_list.jpg'))->message(
                        "⏳ Бори шумо бо трек-коди <b>($trackcode->code)</b> дар рӯйхати интизорӣ қарор дорад. Агар ҳолат тағйир ёбад, мо ба шумо хабар медиҳем!"
                    )->send();
                }
            }
            $trackcode->user_id = $user->id;
            $trackcode->save();
        } else {
            if ($this->chat->lang == 'ru') {
                $this->chat
                    ->photo(public_path('assets/track-empty_ru.png'))
                    ->message("❌Информация по трек-коду <b>($text)</b> не найдена! 😞\nВозможно, груз ещё не поступил на наш склад в городе Иву.\nДля получения информации свяжитесь с консультантом! 📞")
                    ->send();
            } else {
                $this->chat
                    ->photo(public_path('assets/track-empty_tj.png'))
                    ->message("❌Маълумот дар бораи трек-код <b>($text)</b> ёфт нашуд! 😞\nМумкин аст, ки бор ба склади мо дар шахри Иву дастрас нашудааст.\nБарои гирифтани маълумот бо мушовир тамос гиред! 📞")
                    ->send();
            }
        }
        return;
    }
    private function normalizePhoneInput(string $rawPhone): string
    {
        $phone = trim($rawPhone);
        $phone = str_replace([' ', '-', '(', ')'], '', $phone);

        if (Str::startsWith($phone, '00')) {
            $phone = '+' . substr($phone, 2);
        }

        return $phone;
    }
    private function isValidPhone(string $phone): bool
    {
        return (bool) preg_match('/^\+?[0-9]{7,15}$/', $phone);
    }
    private function getPhoneVerificationData(User $user): ?array
    {
        $payload = json_decode((string) $user->sub_step, true);
        if (!is_array($payload)) {
            return null;
        }
        if (empty($payload['phone']) || empty($payload['code']) || empty($payload['expires_at'])) {
            return null;
        }

        return $payload;
    }
    private function sendSexSelectionKeyboard(User $user): void
    {
        if ($this->chat->lang == 'ru') {
            $this->chat->message("☑️ Укажите свой пол, например: <b>Мужской</b> или <b>Женский</b>")
                ->keyboard(
                    Keyboard::make()
                        ->row([
                            Button::make('Мужской')
                                ->action('sex_radio')
                                ->param('id', $user->id)
                                ->param('sex', 'm'),

                            Button::make('Женский')
                                ->action('sex_radio')
                                ->param('id', $user->id)
                                ->param('sex', 'z'),
                        ])
                )->send();
            return;
        }

        $this->chat->message("☑️ Ҷинси худро нишон диҳед, масалан: <b>Мард</b> ё <b>Зан</b>")
            ->keyboard(
                Keyboard::make()
                    ->row([
                        Button::make('Мард')
                            ->action('sex_radio')
                            ->param('id', $user->id)
                            ->param('sex', 'm'),

                        Button::make('Зан')
                            ->action('sex_radio')
                            ->param('id', $user->id)
                            ->param('sex', 'z'),
                    ])
            )->send();
    }
    public function selec_wareh($wh)
    {
        $this->chat->deleteMessage($this->messageId)->send();

        if ($wh == "vadanasos") {
            $this->chat->location(38.617451, 68.780144)->send();
            $dushanbe = Setting::where('name', 'address_dushanbe')->first();
            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/dushanbe_ru.png'))
                    ->message("$dushanbe->content")->send();
            } else {
                $this->chat->photo(public_path('assets/dushanbe_tj.png'))
                    ->message("$dushanbe->content")->send();
            }
        }
        if ($wh == "46mkr") {
            // $this->chat->location(38.56834699185991, 68.73575168818122)->send();
            $dushanbe = Setting::where('name', 'address_dushanbe')->first();
            if ($this->chat->lang == 'ru') {
                $this->chat->video(public_path('46.mp4'))
                    ->message("Мост 46мкр (Саховат)")->send();
            } else {
                $this->chat->video(public_path('46.mp4'))
                    ->message("Мост 46мкр (Саховат)")->send();
            }
        }
        return;

    }

    public function selec_warehouse($wh, $chat_id)
    {
        $this->chat->deleteMessage($this->messageId)->send();

        $user = User::where('chat_id', $chat_id)->first();

        $locations_vadanasos = "联系人：SF$user->code\n联系电话：15057921193\n收货地址：浙江省金华市义乌市第二毛纺厂内\n义乌市城北路J128号一楼2单元shifu仓库-SF$user->code-$user->name-$user->phone";
        $locations_46mkr = "联系人：SF$user->code\n联系电话：15057921193\n收货地址：浙江省金华市义乌市第二毛纺厂内\n义乌市城北路J128号一楼5单元shifu1仓库-SF$user->code-$user->name-$user->phone";

        if ($wh == "vadanasos") {

            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/ivu_ru.png'))->message($locations_vadanasos)
                    ->keyboard(function (Keyboard $keyboard) use ($locations_vadanasos) {
                        return $keyboard
                            ->button('📋 Скопировать адрес')->copyText($locations_vadanasos);
                    })->send();
            } else {
                $this->chat->photo(public_path('assets/ivu_tj.png'))->message($locations_vadanasos)
                    ->keyboard(function (Keyboard $keyboard) use ($locations_vadanasos) {
                        return $keyboard
                            ->button('📋 Нусха бардоштани суроға')->copyText($locations_vadanasos);
                    })->send();
            }
        }
        if ($wh == "46mkr") {

            if ($this->chat->lang == 'ru') {
                $this->chat->photo(public_path('assets/ivu_ru.png'))->message($locations_46mkr)
                    ->keyboard(function (Keyboard $keyboard) use ($locations_46mkr) {
                        return $keyboard
                            ->button('📋 Скопировать адрес')->copyText($locations_46mkr);
                    })->send();
            } else {
                $this->chat->photo(public_path('assets/ivu_tj.png'))->message($locations_46mkr)
                    ->keyboard(function (Keyboard $keyboard) use ($locations_46mkr) {
                        return $keyboard
                            ->button('📋 Нусха бардоштани суроға')->copyText($locations_46mkr);
                    })->send();
            }
        }
        return;
    }
    public function sms_send_dushanbe($user_id, $trackcode)
    {
        $user = User::find($user_id);
        $chat = TelegraphChat::where('chat_id', $user->chat_id)->first();
        if ($chat->lang == 'ru') {
            $chat->photo(public_path('assets/dushanbe_done_ru.png'))->message("1️⃣Ваш груз с трек-кодом ($trackcode->code) был принят на нашем складе в Иву на дату $trackcode->china!\n2️⃣На дату $trackcode->dushanbe он прибыл в Душанбе!")->send();
        } else {
            $chat->photo(public_path('assets/dushanbe_done_tj.png'))->message("1️⃣Бори шумо бо трек-коди ($trackcode->code) санаи $trackcode->china дар склади мо дар Иву кабул шудаги аст!\n2️⃣Санаи $trackcode->dushanbe ба Душанбе омада расид!")->send();
        }
        Notification::create([
            'user_id' => $user_id,
            'content' => "✅Ваш груз с трек-кодом ($trackcode->code) был принят на нашем складе в Душанбе!"
        ]);
    }
    public function sms_send_ivu($user_id, $trackcode)
    {
        $user = User::find($user_id);
        $chat = TelegraphChat::where('chat_id', $user->chat_id)->first();
        if ($chat->lang == 'ru') {
            $chat->photo(public_path('assets/ivu_done_ru.png'))->message("✅Ваш груз с трек-кодом <b>($trackcode->code)</b> был принят на нашем складе в Иву на дату $trackcode->china!")->send();
        } else {
            $chat->photo(public_path('assets/ivu_done_tj.png'))->message("✅Бори шумо бо трек-коди <b>($trackcode->code)</b> санаи $trackcode->china дар склади мо дар Иву кабул шудаги аст!")->send();
        }
        Notification::create([
            'user_id' => $user_id,
            'content' => "✅Ваш груз с трек-кодом ($trackcode->code) был принят на нашем складе в Иву на дату $trackcode->china!"
        ]);
    }
    public function sms_bulk($user_id, $message)
    {
        $user = User::find($user_id);
        if ($user->chat_id) {
            $chat = TelegraphChat::where('chat_id', $user->chat_id)->first();
            $chat->message($message)->send();
            Notification::create([
                'user_id' => $user_id,
                'content' => "$message"
            ]);
        }
    }
    public function sms_single($user_id, $message)
    {
        $user = User::find($user_id);
        if ($user->chat_id) {
            $chat = TelegraphChat::where('chat_id', $user->chat_id)->first();
            $chat->message($message)->send();
            Notification::create([
                'user_id' => $user_id,
                'content' => "$message"
            ]);
        }
    }
    public function sms_order($user_id, $order_id, $file = null)
    {
        $user = User::find($user_id);
        $order = Order::find($order_id);
        if ($user->chat_id) {
            $chat = TelegraphChat::where('chat_id', $user->chat_id)->first();
            if ($order->photo_report_path) {
                $chat->document("https://shifucargo.texhub.pro/public/storage/" . $order->photo_report_path)->send();
            }
            if ($chat->lang == 'ru') {
                $chat->message("📦 Добрый день, уважаемый клиент!\n\n🚚 Вы успешно оформили доставку.\n⚖️ Вес: $order->weight кг\n📏 Объём: $order->cube м³\n💰 Подытог: $order->subtotal с\n💵 Скидка: $order->discount с\n🚛 Доставка: $order->delivery_total с\n✅ Итог: $order->total с\n\nСпасибо, что вы с нами! 💚")->send();
            } else {
                $chat->message("📦 Салом, муштарии муҳтарам!\n\n🚚 Шумо бо муваффақият фармоиши худро қабул/дархост намудед.\n⚖️ Вазн: $order->weight кг\n📏 Ҳаҷм: $order->cube м³\n💰 Ҷамъбаст: $order->subtotal с\n💵 Тахфиф: $order->discount с\n🚛 Нархи бурда расонӣ: $order->delivery_total с\n✅ Ҳамагӣ: $order->total с\n\nТашаккур, ки бо мо ҳастед! 💚")->send();
            }
        }
    }
    public function sms_deliver_boy($user_id, $order_id, $application_id = null)
    {
        $user = User::find($user_id);
        $order = Order::find($order_id);
        $apl = Application::find($application_id);
        if ($user->chat_id) {
            $chat = TelegraphChat::where('chat_id', $user->chat_id)->first();
            $chat->message("📦 *Заказ №$apl->id*\n\n📞 Телефон: $apl->phone\n🏠 Адрес: $apl->address\n\n⚖️ Вес: $order->weight кг\n📏 Объём: $order->cube м³\n💰 Подытог: $order->subtotal с\n💵 Скидка: $order->discount с\n🚚 Доставка: $order->delivery_total с\n✅ *Итого: $order->total с*")
                ->keyboard(
                    Keyboard::make()
                        ->row([
                            Button::make('🔁 Возврат')->action('order_del_status')->param('order_id', $order_id)->param('apl_id', $application_id)->param('status', 'returned'),
                            Button::make('📦 Доставлено')->action('order_del_status')->param('order_id', $order_id)->param('apl_id', $application_id)->param('status', 'delivered'),
                        ])
                )->send();
        }
    }
    public function order_del_status($order_id, $apl_id, $status): void
    {
        $order = Order::find($order_id);
        $apl = Application::find($apl_id);
        if ($status == 'delivered') {
            $order->status = 'Оплачено';
            $order->save();
            $apl->status = 'Доставлено';
            $apl->save();
            $this->chat->message("📦 Заказ №$apl->id доставлено!")->send();
        }
        if ($status == 'returned') {
            $order->status = 'Возврат';
            $order->save();
            $apl->status = 'Отменено';
            $apl->save();
            $this->chat->message("🔁 Заказ №$apl->id возвращено!")->send();
        }
        $this->chat->deleteMessage($this->messageId)->send();
    }

}
