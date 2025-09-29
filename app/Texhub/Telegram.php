<?php

namespace App\Texhub;

use App\Models\Application;
use App\Models\Chat;
use App\Models\User;
use App\Models\Setting;
use App\Models\Trackcode;
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
        $this->chat->photo(public_path('assets/welcome.png'))->message("Салом " . $this->message->from()->firstName() . "! \nИн телеграм боти <b>Shifu Cargo</b> мебошад! \nБарои истифода бурдан аввал забонро интихоб кунед!\n\nЭто телеграм бот <b>Shifu Cargo!</b> \nЧтобы использовать, сначала выберите язык! ⤵️")
            ->keyboard(
                Keyboard::make()
                    ->row([
                        Button::make('🇹🇯 Тоҷикӣ')->action('tj'),
                        Button::make('🇷🇺 Русский')->action('ru'),
                    ])
            )->send();
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
        $this->chat->message(("Бахши лозимаро дар менюи дар зер буда интихоб намоед! 🔽"))
            ->replyKeyboard(ReplyKeyboard::make()
                ->row([
                    ReplyButton::make('🔢 Тафтиши трек-код'),
                    ReplyButton::make('🕹 Ҳуҷраи шахсӣ'),
                ])
                ->row([
                    ReplyButton::make('➕ Обуна шудан')->requestContact(),
                    ReplyButton::make('👤 Тамос бо оператор'),
                    ReplyButton::make('💲 Нархнома'),
                ])
                ->row([
                    ReplyButton::make('🚚 Дархости доставка'),
                    ReplyButton::make('✅ Сурогаи склади Иву'),
                    ReplyButton::make('📍 Сурогаи склади Душанбе'),
                ])
                ->row([
                    ReplyButton::make('❌ Молҳои манъшуда'),
                    ReplyButton::make('🧮 Ҳисобкунак'),
                    ReplyButton::make('🎞 Дарсҳои ройгон'),
                ])
                ->resize())->send();
    }
    public function ru_keys(): void
    {
        $this->chat->message(("Выберите нужный раздел в меню ниже! 🔽"))
            ->replyKeyboard(ReplyKeyboard::make()
                ->row([
                    ReplyButton::make('🔢 Проверить трек-код'),
                    ReplyButton::make('🕹 Личный кабинет'),
                ])
                ->row([
                    ReplyButton::make('➕ Подписаться')->requestContact(),
                    ReplyButton::make('👤 Связаться с оператором'),
                    ReplyButton::make('💲 Прайс лист'),
                ])
                ->row([
                    ReplyButton::make('🚚 Заказать доставку'),
                    ReplyButton::make('✅ Адрес склада Иву'),
                    ReplyButton::make('📍 Адрес склада Душанбе'),
                ])
                ->row([
                    ReplyButton::make('❌ Запрещенные товары'),
                    ReplyButton::make('🧮 Калькулятор'),
                    ReplyButton::make('🎞 Бесплатные уроки'),
                ])
                ->resize())->send();
    }
    public function edit_profile($id): void
    {
        $user = User::find($id);
        $user->step = 'name';
        $user->save();
        if ($this->chat->lang == 'ru') {
            $this->chat->message("✍️ Напишите своё имя, например: <b>Абдулло</b>")->send();
        } else {
            $this->chat->message("✍️ Номи худро нависед, масалан: <b>Абдулло</b>")->send();
        }
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
        $this->chat->deleteMessage($this->messageId)->send();

        $user = User::where('chat_id', $this->message->from()->id())->first();
        if ($text == '➕ Обуна шудан' || $text == '➕ Подписаться') {
            if (!$user) {
                $user = new User();
                $user->chat_id = $this->message->from()->id();
                $user->step = 'name';
                $user->save();
                if ($this->chat->lang == 'ru') {
                    $this->chat->message("✍️ Напишите своё имя, например: <b>Абдулло</b>")->send();
                } else {
                    $this->chat->message("✍️ Номи худро нависед, масалан: <b>Абдулло</b>")->send();
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
                $this->chat->message("🤖 Для использования нашего бота сначала пройдите регистрацию. После этого вам будут доступны все функции. ✅")->send();
            } else {
                $this->chat->message("🤖 Барои истифодаи боти мо аввал сабти ном шавед. Пас аз ин ҳамаи функсияҳои дастрасро истифода бурда метавонед. ✅")->send();
            }

            return;
        }
        if ($user) {
            if ($user->step == 'name') {
                $code = User::orderBy('code', 'desc')->first();

                $user->name = $text;
                $user->code = str_pad($code ? $code->code + 1 : 1, 4, '0', STR_PAD_LEFT);
                $user->step = "phone";
                $user->save();

                if ($this->chat->lang == 'ru') {
                    $this->chat->message("✍️ Напишите свой номер телефона, например: <b>005335051</b>")->send();
                } else {
                    $this->chat->message("✍️ Рақами телефони худро нависед, масалан: <b>005335051</b>")->send();
                }
                return;
            }
            if ($user->step == 'phone') {
                $user->phone = $text;
                $user->step = "sex";
                $user->save();
                if ($this->chat->lang == 'ru') {
                    $this->chat->message("✍️ Укажите свой пол, например: <b>Мужской</b> или <b>Женский</b>")
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
                } else {
                    $this->chat->message("✍️ Ҷинси худро нишон диҳед, масалан: <b>Мард</b> ё <b>Зан</b>")
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
                return;
            }
            if ($user->step == 'apl_phone') {
                $application = Application::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
                $application->phone = $text;
                $application->save();
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
                $application = Application::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
                $application->address = $text;
                $application->save();
                $user->step = null;
                $user->save();
                if ($this->chat->lang == 'ru') {
                    $this->chat->message("✅ Ваш заказ получен! Мы проверим, и если он уже есть на нашем складе в Душанбе, мы обязательно доставим его вам. 📦")->send();
                } else {
                    $this->chat->message("✅ Фармоиши шумо қабул шуд! Мо месанҷем ва агар он дар анбори мо дар шаҳри Душанбе бошад, ҳатман онро ба шумо мерасонем. 📦")->send();
                }
                return;
            }
        }
        if ($text == '🚚 Дархости доставка' || $text == '🚚 Заказать доставку') {
            $application = new Application();
            $application->user_id = $user->id;
            $application->save();
            $user->step = "apl_phone";
            $user->save();
            if ($this->chat->lang == 'ru') {
                $this->chat->message("✍️ Напишите свой номер телефона, например: <b>005335051</b>")->send();
            } else {
                $this->chat->message("✍️ Рақами телефони худро нависед, масалан: <b>005335051</b>")->send();
            }
            return;
        }



        if ($text == '📍 Сурогаи склади Душанбе' || $text == '📍 Адрес склада Душанбе') {
            // $this->chat->location(38.56834699185991, 68.73575168818122)->send();
            $dushanbe = Setting::where('name', 'address_dushanbe')->first();
            $this->chat->message("$dushanbe->content")->send();
            return;
        }
        if ($text == '👤 Тамос бо оператор' || $text == '👤 Связаться с оператором') {
            if ($this->chat->lang == 'ru') {
                $this->chat->message("<b>Режим работы</b> с Душанбе по воскресенье с <b>08:00 до 18:00</b>.\n\nВ рабочие часы свяжитесь с нами — мы обязательно ответим на ваши вопросы!\n\nСвяжитесь с нами через один из мессенджеров ниже или подключитесь к консультанту прямо в боте! ⤵️")
                    ->keyboard(
                        Keyboard::make()
                            ->row([
                                Button::make('Telegram')->url('https://t.me/+992005335051'),
                            ])
                            ->row([
                                Button::make('Телеграм канал')->url('https://t.me/cargoshifu'),
                            ])
                            ->row([
                                Button::make('Тамос бо мушовир')->action('open_chat'),
                            ])
                    )->send();
            } else {
                $this->chat->message("<b>Реҷаи корӣ</b> аз Душанбе то Якшанбе соатҳои <b>08:00 то 18:00</b>.\n\nДар вақти корӣ бо мо тамос гиред ҳатман ба саволҳоятон ҷавоб медиҳем!\n\nБо мо тарики яке аз паёмрасонҳои зер тамос гиред, ё дар худи бот бо мушовир пайваст шавед! ⤵️")
                    ->keyboard(
                        Keyboard::make()
                            ->row([
                                Button::make('Telegram')->url('https://t.me/+992005335051'),
                            ])
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
            if ($this->chat->lang == 'ru') {
                $this->chat->message("💲 Цена за 1 килограмм груза: $price_kg->content \n📦 Цена за 1 кубический метр груза: $price_cube->content")->send();
            } else {
                $this->chat->message("💲 Нархнома барои як килограм: $price_kg->content \n📦 Нархнома барои як метри куби: $price_cube->content")->send();
            }
            return;
        }
        if ($text == '❌ Молҳои манъшуда' || $text == '❌ Запрещенные товары') {
            $dangers = Setting::where('name', 'danger_products')->first();
            if ($this->chat->lang == 'ru') {
                $this->chat->message($dangers->content)->send();
            } else {
                $this->chat->message($dangers->content)->send();
            }
            return;
        }
        if ($text == '🔢 Тафтиши трек-код' || $text == '🔢 Проверить трек-код') {
            $this->chat->deleteMessage($this->messageId)->send();
            if ($this->chat->lang == 'ru') {
                $this->chat->message("Отправьте трек-код вашего груза для проверки!")
                    ->replyKeyboard(ReplyKeyboard::make()
                        ->row([
                            ReplyButton::make('🔄 Основной меню'),
                        ])
                        ->resize())->send();
            } else {
                $this->chat->message("📦🔍 Трек-коди бори худро барои тафтиш равон кунед!")
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
        if ($text == '✅ Сурогаи склади Иву' || $text == '✅ Адрес склада Иву') {
            $location = Setting::where('name', 'address_ivu')->first();
            if (!$user) {
                if ($this->chat->lang == 'ru') {
                    $this->chat->message("📦 Чтобы получить адрес нашего склада в городе Иву, сначала нажмите кнопку «➕ Подписаться» в меню ниже ⬇️, а затем повторите действие. ✅")->send();
                } else {
                    $this->chat->message("📦 Барои гирифтани суроғаи анбори мо дар шаҳри Иву, аввал тугмаи «➕ Обуна шудан»-ро дар менюи поён ⬇️ пахш кунед, баъд ин амалро такрор намоед. ✅")->send();
                }
                return;
            }
            $locations = "$location->content $user->code $user->sex $user->name $user->phone";

            if ($this->chat->lang == 'ru') {
                $this->chat->message($locations)
                    ->keyboard(function (Keyboard $keyboard) use ($locations) {
                        return $keyboard
                            ->button('📋 Скопировать адрес')->copyText($locations);
                    })->send();
            } else {
                $this->chat->message($locations)
                    ->keyboard(function (Keyboard $keyboard) use ($locations) {
                        return $keyboard
                            ->button('📋 Нусха бардоштани суроға')->copyText($locations);
                    })->send();
            }


            return;
        }
        if ($this->message->contact()) {
            $user = User::where('phone', str($this->message->contact()->phoneNumber()))->first();
            if ($user) {
                $usercode = $user->code;
                if ($this->chat->lang == 'ru') {
                    $this->chat->message("Вы уже подписались! Ваш специальный код <b>$usercode</b>!")->send();
                } else {
                    $this->chat->message("Шумо обуна шудагӣ ҳастед! Коди махсуси шумо <b>$usercode</b>!")->send();
                }
            } else {
                $lastCustomer = User::orderBy('id', 'desc')->first();

                if ($lastCustomer) {
                    // Увеличиваем код последнего клиента на 1 и форматируем его до 4 знаков
                    $newCode = str_pad($lastCustomer->code + 1, 4, '0', STR_PAD_LEFT);
                } else {
                    // Если клиентов нет, начинаем с 0001
                    $newCode = '0001';
                }

                User::create([
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
        if ($text == 'supershifu') {
            $this->chat->message(('Добро пожаловать в панел управление!'))
                ->keyboard(Keyboard::make()->buttons([
                    Button::make('Открыт панель управлению')->webApp('https://sifucargo.texhub.pro.tj/'),
                ]))->send();
            return;
        }
        $trackcode = Trackcode::where('trackcode', str($text))->first();
        if ($trackcode) {
            if ($trackcode->china && $trackcode->dushanbe && $trackcode->customer) {
                if ($this->chat->lang == 'ru') {
                    $this->chat->message("1️⃣Ваш груз с трек-кодом <b>($trackcode->trackcode)</b> был принят на нашем складе в Иву на дату $trackcode->china!\n2️⃣На дату $trackcode->dushanbe он прибыл в Душанбе!\n3️⃣На дату $trackcode->customer вы приняли груз!")->send();
                } else {
                    $this->chat->message("1️⃣Бори шумо бо трек-коди <b>($trackcode->trackcode)</b> санаи $trackcode->china дар склади мо дар Иву кабул шудаги аст!\n2️⃣3️Санаи $trackcode->dushanbe ба Душанбе омада расид! \n3️⃣Санаи $trackcode->customer шумо онро кабул кардаги хастед!")->send();
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
                $this->chat->message("❌Информация по трек-коду <b>($text)</b> не найдена! 😞\nВозможно, груз ещё не поступил на наш склад в городе Иву.\nДля получения информации свяжитесь с консультантом! 📞")->send();
            } else {
                $this->chat->message("❌Маълумот дар бораи трек-код <b>($text)</b> ёфт нашуд! 😞\nМумкин аст, ки бор ба склади мо дар шахри Иву дастрас нашудааст.\nБарои гирифтани маълумот бо мушовир тамос гиред! 📞")->send();
            }
        }
        return;
    }
}
