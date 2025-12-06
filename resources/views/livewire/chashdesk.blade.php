<div id="cashdesk-root" class="bg-white p-2 space-y-2">
    <div class="bg-gradient-to-r from-lime-500 via-emerald-500 to-teal-500 rounded-2xl p-3 shadow-lg">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-white/80 text-sm uppercase tracking-wider">Панель быстрых действий</p>
                <p class="text-white text-xl font-semibold">Рабочие инструменты кассы</p>
            </div>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 w-full lg:w-auto">
                <flux:modal.trigger name="add-expences">
                    <flux:button id="btn-add-expense" aria-keyshortcuts="Control+Shift+E" color="white" variant="ghost"
                        class="h-16 rounded-xl bg-white/15 border border-white/30 shadow-md hover:bg-white/25 transition-all">
                        <div class="flex items-center gap-3 text-left">
                            <span
                                class="bg-white/25 rounded-2xl w-11 h-11 flex items-center justify-center text-white text-2xl">+</span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-semibold text-white">Добавить расходы</span>
                                <span class="text-xs text-white/70">Ctrl + Shift + E</span>
                            </div>
                        </div>
                    </flux:button>
                </flux:modal.trigger>
                <flux:modal.trigger name="select-queue">
                    <flux:button id="btn-open-queue" aria-keyshortcuts="Control+Shift+Q" color="white" variant="ghost"
                        class="h-16 rounded-xl bg-white/15 border border-white/30 shadow-md hover:bg-white/25 transition-all">
                        <div class="flex items-center gap-3 text-left">
                            <span
                                class="bg-white/25 rounded-2xl w-11 h-11 flex items-center justify-center text-white text-xl">Q</span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-semibold text-white">Выбрать из очереди</span>
                                <span class="text-xs text-white/70">Ctrl + Shift + Q</span>
                            </div>
                        </div>
                    </flux:button>
                </flux:modal.trigger>
                <flux:modal.trigger name="currency-info">
                    <flux:button id="btn-currency-modal" aria-keyshortcuts="Control+Shift+C" color="white"
                        variant="ghost"
                        class="h-16 rounded-xl bg-white/15 border border-white/30 shadow-md hover:bg-white/25 transition-all">
                        <div class="flex items-center gap-3 text-left">
                            <span
                                class="bg-white/25 rounded-2xl w-11 h-11 flex items-center justify-center text-white text-xl">$</span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-semibold text-white">Курс валюты</span>
                                <span class="text-xs text-white/70">Ctrl + Shift + C</span>
                            </div>
                        </div>
                    </flux:button>
                </flux:modal.trigger>
                <flux:modal.trigger name="cashdesk-reports">
                    <flux:button id="btn-reports-modal" aria-keyshortcuts="Control+Shift+R" color="white"
                        variant="ghost"
                        class="h-16 rounded-xl bg-white/15 border border-white/30 shadow-md hover:bg-white/25 transition-all">
                        <div class="flex items-center gap-3 text-left">
                            <span
                                class="bg-white/25 rounded-2xl w-11 h-11 flex items-center justify-center text-white text-xl">R</span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-semibold text-white">Отчёты кассы</span>
                                <span class="text-xs text-white/70">Ctrl + Shift + R</span>
                            </div>
                        </div>
                    </flux:button>
                </flux:modal.trigger>
            </div>
        </div>
    </div>
    <div class="bg-neutral-200 rounded-2xl p-2 space-y-2">
        <div
            class="bg-white border border-neutral-300 rounded-xl p-2 shadow flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <p class="text-sm uppercase text-emerald-600 tracking-wide">Рабочая панель кассира</p>
                <flux:text class="text-sm font-semibold text-neutral-900" variant="strong">
                    Заполните форму ниже, чтобы оформить заявку.
                </flux:text>
            </div>
            <div class="flex flex-wrap gap-2 text-[11px]">
                <span class="bg-emerald-100 text-emerald-800 rounded-full px-3 py-1 font-medium shadow-sm">Ctrl + Enter
                    — оформить</span>
                <span class="bg-emerald-100 text-emerald-800 rounded-full px-3 py-1 font-medium shadow-sm">Ctrl + Shift
                    + H — удержать</span>
                <span class="bg-emerald-100 text-emerald-800 rounded-full px-3 py-1 font-medium shadow-sm">Ctrl + Shift
                    + T — сканер</span>
                <span class="bg-emerald-100 text-emerald-800 rounded-full px-3 py-1 font-medium shadow-sm">Ctrl + Shift
                    + Q — очередь</span>
                <span class="bg-emerald-100 text-emerald-800 rounded-full px-3 py-1 font-medium shadow-sm">Ctrl + Shift
                    + E — расходы</span>
            </div>
        </div>
        <div class="grid grid-cols-3 gap-4">
            <div class="space-y-2">
                <div class="bg-white border border-lime-200 rounded-xl p-2 space-y-2 shadow-sm">
                    <div class="flex items-center justify-between">
                        <flux:heading size="xs">Удержанные заказы</flux:heading>
                        <flux:badge color="lime" size="sm">{{ $heldOrders->count() }}</flux:badge>
                    </div>
                    <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                        @forelse ($heldOrders as $held)
                            <div class="border border-neutral-200 rounded-xl px-3 py-2 flex items-center justify-between text-xs"
                                wire:key="held-{{ $held->id }}">
                                <div class="space-y-1">
                                    <p class="font-semibold text-neutral-800">{{ $held->client ?? 'Без клиента' }}</p>
                                    <p class="text-neutral-500">
                                        {{ number_format($held->total_final, 2, '.', ' ') }} c ·
                                        {{ optional($held->created_at)->format('H:i') ?? '' }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-1">
                                    <flux:button size="xs" wire:click="loadHeldOrder({{ $held->id }})">
                                        ✓
                                    </flux:button>
                                    <flux:button size="xs" variant="danger"
                                        wire:click="deleteHeldOrder({{ $held->id }})" wire:confirm>
                                        ×
                                    </flux:button>
                                </div>
                            </div>
                        @empty
                            <flux:text variant="subtle" class="text-xs text-center block">Удержанных заказов нет.
                            </flux:text>
                        @endforelse
                    </div>
                </div>
                <div class="bg-white border border-neutral-200 rounded-xl shadow-md p-2 space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase text-neutral-500 tracking-wide">Трекинг панель</p>
                            <p class="text-md font-semibold text-neutral-800">Добавление трек-кодов</p>
                        </div>
                        <flux:badge color="blue">{{ count($tracks) }}</flux:badge>
                    </div>
                    <form wire:submit="addTrack">
                        <flux:input id="track-input" icon="qr-code" label="Сканируйте (Ctrl+Shift+T)"
                            wire:model="newTrack" placeholder="Трек-код или штрих код груза" />
                    </form>
                    <div
                        class="h-80 rounded-lg bg-neutral-50 border border-dashed border-neutral-300 overflow-y-auto p-2 space-y-2">
                        @if ($tracks)
                            @foreach ($tracks as $index => $track)
                                <div
                                    class="bg-white rounded-xl px-3 py-2 shadow flex justify-between items-center text-sm">
                                    <span class="font-semibold text-neutral-800">{{ $track }}</span>
                                    <button type="button" wire:click="removeTrack({{ $index }})"
                                        class="text-red-500 hover:text-red-600 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M18 6l-12 12" />
                                            <path d="M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-neutral-500 text-sm py-8">Трек-коды ещё не добавлены.</div>
                        @endif
                    </div>
                </div>
            </div>
            <form wire:submit="order_place" class="col-span-2" x-data @keydown.enter="$event.preventDefault()">
                <div class="bg-white border border-neutral-200 rounded-xl shadow-md p-2 space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm uppercase text-neutral-500 tracking-wide">Оформление заказа</p>
                            <p class="text-xl font-semibold text-neutral-900">Информация о клиенте и грузе</p>
                        </div>
                        <flux:badge color="neutral">Live</flux:badge>
                    </div>
                    <div class="space-y-3">
                        <flux:autocomplete id="client-input" wire:model.live="client" label="Клиент (Ctrl+Shift+K)"
                            placeholder="Выберите клиента" required>
                            @foreach ($users as $user)
                                <flux:autocomplete.item>{{ $user->phone }}</flux:autocomplete.item>
                            @endforeach
                        </flux:autocomplete>
                        @if ($showDeliveryDetails)
                            <div
                                class="grid gap-3 grid-cols-1 md:grid-cols-3 border border-neutral-200 rounded-xl p-2 bg-neutral-50">
                                <flux:input label="Номер заявки" placeholder="Введите номер заявки"
                                    wire:model.live="order_no" />
                                <flux:select wire:model="deliver_boy" label="Доставщик"
                                    placeholder="Выберите доставщика">
                                    @foreach ($delivers as $deliver)
                                        <flux:select.option>{{ $deliver->name }}</flux:select.option>
                                    @endforeach
                                </flux:select>
                                <flux:input label="Цена доставки (сомони)" placeholder="Введите стоимость доставки"
                                    wire:model.live="delivery_price" type="number" min="0" />
                            </div>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Вес груза -->
                        <flux:input label="Вес груза (кг)" placeholder="Введите общий вес груза"
                            wire:model.live="weight" required />

                        <!-- Объём груза -->
                        <flux:input label="Объём груза (м³)" placeholder="Введите примерный объём"
                            wire:model.live="volume" />
                    </div>

                    <!-- Скидка -->


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Тип оплаты -->
                        <flux:select wire:model.live="payment_type" placeholder="Выберите тип оплаты"
                            label="Тип оплаты" required>
                            <flux:select.option>Алиф Моби</flux:select.option>
                            <flux:select.option>Душанбе Сити</flux:select.option>
                            <flux:select.option>Наличными</flux:select.option>
                        </flux:select>



                        <!-- Итоговая сумма -->
                        <flux:input label="Итоговая сумма (сомони)" placeholder="Введите общую сумму"
                            wire:model.live="total_amount" type="number" min="0" required />
                    </div>
                    <div class="space-y-2">
                        <flux:label>Скидка</flux:label>
                        <div class="flex flex-col md:flex-row gap-3">
                            <flux:input placeholder="10" wire:model.live="discount" type="number" min="0" />
                            <flux:select wire:model="industry" wire:model.live="discountt"
                                placeholder="Choose discount type">
                                <flux:select.option>Фиксированная</flux:select.option>
                                <flux:select.option>Процентная</flux:select.option>
                            </flux:select>
                        </div>
                    </div>
                    <div
                        class="bg-gradient-to-r from-neutral-50 to-white rounded-xl p-2 grid grid-cols-2 md:grid-cols-4 gap-2 text-sm shadow-inner border border-neutral-100">
                        <div class="rounded-lg bg-white p-2 border border-neutral-100">
                            <p class="text-neutral-500 text-xs uppercase tracking-wide">Подытог</p>
                            <p class="font-semibold text-lg text-neutral-900">{{ $this->total_amount }}c</p>
                        </div>
                        <div class="rounded-lg bg-white p-2 border border-neutral-100">
                            <p class="text-neutral-500 text-xs uppercase tracking-wide">Доставка</p>
                            <p class="font-semibold text-lg text-neutral-900">{{ $delivery_price }}c</p>
                        </div>
                        <div class="rounded-lg bg-white p-2 border border-neutral-100">
                            <p class="text-neutral-500 text-xs uppercase tracking-wide">Скидка</p>
                            <p class="font-semibold text-lg text-rose-600">{{ $this->discount_total }}c</p>
                        </div>
                        <div class="rounded-lg bg-white p-2 border border-neutral-100">
                            <p class="text-neutral-500 text-xs uppercase tracking-wide">Итог</p>
                            <p class="font-semibold text-lg text-emerald-600">{{ $total_final }}c</p>
                        </div>
                    </div>
                    <!-- Кнопка -->
                    <div class="flex gap-3 flex-wrap">
                        <flux:button type="button" wire:click="toggleDeliveryDetails"
                            color="{{ $showDeliveryDetails ? 'red' : 'blue' }}">
                            {{ $showDeliveryDetails ? 'Скрыть доставку' : 'Оформить доставку' }}
                        </flux:button>
                        <flux:button id="btn-hold-order" type="button" class="w-full md:w-1/3"
                            wire:click="holdCurrentOrder" aria-keyshortcuts="Control+Shift+H">
                            Удержать заказ · Ctrl+Shift+H
                        </flux:button>
                        <flux:button id="btn-submit-order" type="submit" variant="primary" color="lime"
                            class="flex-1" aria-keyshortcuts="Control+Enter">
                            Оформить заявку · Ctrl+Enter
                        </flux:button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <flux:modal name="add-expences" class="w-full max-w-lg">
        <form wire:submit="addExpense" class="space-y-4">
            <div class="bg-gradient-to-r from-lime-500 to-emerald-500 rounded-xl p-2 text-white shadow-md">
                <flux:heading size="lg" class="text-white">Добавить расходы</flux:heading>
                <flux:text class="mt-1 text-white/80 text-sm">
                    Укажите сумму и описание, чтобы зафиксировать расход в отчётах.
                </flux:text>
            </div>
            <div class="space-y-3">
                <flux:input type="number" min="0" step="0.01" label="Сумма расхода (сомони)"
                    placeholder="Например, 250" required wire:model="amount" />
                <flux:textarea label="Описание" placeholder="Что было оплачено?" wire:model="description" />
            </div>
            <div class="bg-neutral-100 rounded-xl p-2 text-xs text-neutral-600 flex items-center gap-2">
                <span class="bg-white rounded-lg px-2 py-1 font-semibold text-lime-600">Совет</span>
                <span>Чёткие описания помогают быстрее собирать отчёты по расходам.</span>
            </div>
            <div class="space-y-2">
                <flux:label>Сегодняшние расходы</flux:label>
                <div class="max-h-56 overflow-y-auto space-y-2 pr-1">
                    @forelse ($this->todayExpenses as $expense)
                        <div
                            class="bg-neutral-100 border border-neutral-200 rounded-xl p-3 flex justify-between items-start text-sm">
                            <div>
                                <p class="font-semibold text-lg text-emerald-700">
                                    {{ number_format($expense->total ?? ($expense->amount ?? 0), 2, '.', ' ') }} c</p>
                                <p class="text-neutral-600">{{ $expense->content ?? 'Без описания' }}</p>
                            </div>
                            <span
                                class="text-xs text-neutral-500">{{ optional($expense->created_at)->format('H:i') }}</span>
                        </div>
                    @empty
                        <div
                            class="bg-white border border-dashed border-neutral-300 rounded-xl p-3 text-xs text-neutral-500 text-center">
                            Сегодня расходов ещё не фиксировали.
                        </div>
                    @endforelse
                </div>
            </div>
            <flux:button type="submit" variant="primary" color="lime"
                class="w-full h-12 text-base font-semibold">
                Сохранить расход
            </flux:button>
        </form>
    </flux:modal>
    <flux:modal name="select-queue" class="w-full max-w-xl">
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div>
                    <flux:heading size="lg">Выберите клиента из очереди</flux:heading>
                    <flux:text class="mt-1">После выбора телефон подтянется автоматически.</flux:text>
                </div>
                <flux:badge color="lime" size="lg">{{ $queues->count() }}</flux:badge>
            </div>
            <div class="space-y-3 max-h-96 overflow-y-auto pr-1" wire:poll.15s="refreshQueues">
                @forelse ($queues as $item)
                    <div
                        class="bg-white border border-neutral-200 rounded-xl p-3 flex items-center justify-between shadow-sm">
                        <div>
                            <p class="font-semibold text-sm">№{{ $item->no }} · {{ $item->user->name }}</p>
                            <p class="text-xs text-neutral-500">
                                Пол: {{ $item->sex == 'm' ? 'Мужчина' : 'Женщина' }}
                            </p>
                        </div>
                        <flux:button variant="danger" size="sm"
                            wire:click="select_queues({{ $item->id }})">
                            Выбрать
                        </flux:button>
                    </div>
                @empty
                    <div class="bg-neutral-100 rounded-xl p-4 text-center text-sm text-neutral-500">
                        В очереди пока никого нет.
                    </div>
                @endforelse
            </div>
        </div>
    </flux:modal>
    <flux:modal name="currency-info" class="w-full max-w-4xl">
        <form wire:submit.prevent="saveCurrencySettings" class="space-y-4">
            <div>
                <flux:heading size="lg">Курс и тарифы</flux:heading>
                <flux:text class="mt-1">Обновите курс доллара (Ctrl+Shift+S). Тарифы приводятся справочно.
                </flux:text>
            </div>
            <div class="bg-neutral-100 rounded-xl p-3">
                <flux:label>1 USD</flux:label>
                <p class="text-2xl font-semibold">{{ $this->currencyInfo['course_dollar'] }} c</p>
                <flux:text variant="subtle" class="text-xs">
                    Обновлено {{ optional($this->currencyInfo['updated_at'])->diffForHumans() ?? '—' }}
                </flux:text>
            </div>
            <flux:input type="number" step="0.01" label="Новый курс доллара"
                wire:model.defer="currencyForm.course_dollar" required />
            <div class="grid grid-cols-5 gap-2">
                <div class="bg-white rounded-xl p-3 border border-neutral-200">
                    <flux:label>Куб</flux:label>
                    <p class="text-lg font-semibold">{{ $this->currencyInfo['cube_price'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-3 border border-neutral-200">
                    <flux:label>Кг &lt; 10</flux:label>
                    <p class="text-lg font-semibold">{{ $this->currencyInfo['kg_price'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-3 border border-neutral-200">
                    <flux:label>Кг &lt; 20</flux:label>
                    <p class="text-lg font-semibold">{{ $this->currencyInfo['kg_price_10'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-3 border border-neutral-200">
                    <flux:label>Кг &lt; 30</flux:label>
                    <p class="text-lg font-semibold">{{ $this->currencyInfo['kg_price_20'] }}</p>
                </div>
                <div class="bg-white rounded-xl p-3 border border-neutral-200">
                    <flux:label>Кг 30+</flux:label>
                    <p class="text-lg font-semibold">{{ $this->currencyInfo['kg_price_30'] }}</p>
                </div>
            </div>
            <flux:button id="btn-save-currency" type="submit" variant="primary" class="w-full"
                aria-keyshortcuts="Control+Shift+S">
                Сохранить · Ctrl+Shift+S
            </flux:button>
        </form>
    </flux:modal>
    <flux:modal name="cashdesk-reports" class="w-full max-w-6xl">
        <div class="space-y-4">
            <div class="flex items-start justify-between gap-3">
                <div>
                    <flux:heading size="lg">Быстрые отчеты</flux:heading>
                    <flux:text class="mt-1">Заказы и статистика за {{ now()->format('d.m.Y') }}.</flux:text>
                </div>
                <flux:button wire:click="downloadTodayReport" variant="primary">
                    Скачать отчёт за сегодня
                </flux:button>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="bg-white border border-neutral-200 rounded-xl p-3">
                    <flux:label>Заказы сегодня</flux:label>
                    <p class="text-2xl font-semibold">{{ $this->reportStats['orders_today'] }}</p>
                </div>
                <div class="bg-white border border-neutral-200 rounded-xl p-3">
                    <flux:label>Выручка</flux:label>
                    <p class="text-2xl font-semibold">
                        {{ number_format($this->reportStats['revenue_today'], 2, '.', ' ') }} c
                    </p>
                </div>
                <div class="bg-white border border-neutral-200 rounded-xl p-3">
                    <flux:label>Очередь</flux:label>
                    <p class="text-2xl font-semibold">{{ $this->reportStats['queues_waiting'] }}</p>
                </div>
                <div class="bg-white border border-neutral-200 rounded-xl p-3">
                    <flux:label>Удержанные</flux:label>
                    <p class="text-2xl font-semibold">{{ $this->reportStats['held_orders'] }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                <div class="bg-white border border-neutral-200 rounded-xl p-3">
                    <flux:label>Всего заказов</flux:label>
                    <p class="text-2xl font-semibold">{{ $this->todayOrdersSummary['count'] }}</p>
                </div>
                <div class="bg-white border border-neutral-200 rounded-xl p-3">
                    <flux:label>Вес суммарно</flux:label>
                    <p class="text-2xl font-semibold">
                        {{ number_format($this->todayOrdersSummary['weight'], 2, '.', ' ') }} кг</p>
                </div>
                <div class="bg-white border border-neutral-200 rounded-xl p-3">
                    <flux:label>Объём суммарно</flux:label>
                    <p class="text-2xl font-semibold">
                        {{ number_format($this->todayOrdersSummary['cube'], 2, '.', ' ') }} м³</p>
                </div>
                <div class="bg-white border border-neutral-200 rounded-xl p-3">
                    <flux:label>Скидки суммарно</flux:label>
                    <p class="text-2xl font-semibold">
                        {{ number_format($this->todayOrdersSummary['discount'], 2, '.', ' ') }} c</p>
                </div>
                <div class="bg-white border border-neutral-200 rounded-xl p-3">
                    <flux:label>Доставка суммарно</flux:label>
                    <p class="text-2xl font-semibold">
                        {{ number_format($this->todayOrdersSummary['delivery'], 2, '.', ' ') }} c</p>
                </div>
                <div class="bg-white border border-neutral-200 rounded-xl p-3">
                    <flux:label>Подытог суммарно</flux:label>
                    <p class="text-2xl font-semibold">
                        {{ number_format($this->todayOrdersSummary['subtotal'], 2, '.', ' ') }} c</p>
                </div>
                <div class="bg-white border border-neutral-200 rounded-xl p-3">
                    <flux:label>Итог суммарно</flux:label>
                    <p class="text-2xl font-semibold">
                        {{ number_format($this->todayOrdersSummary['total'], 2, '.', ' ') }} c</p>
                </div>
                <div class="bg-white border border-neutral-200 rounded-xl p-3">
                    <flux:label>Расходы сегодня</flux:label>
                    <p class="text-2xl font-semibold text-rose-600">
                        {{ number_format($this->todayExpenses->sum('total'), 2, '.', ' ') }} c
                    </p>
                </div>
            </div>
            <div class="space-y-2">
                <flux:label>Сегодняшние заказы</flux:label>
                <div class="max-h-80 overflow-y-auto space-y-3 pr-1">
                    @forelse ($this->todayOrders as $order)
                        <div class="bg-white border border-neutral-200 rounded-xl p-3 shadow-sm">
                            <div class="flex items-center justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-sm">#{{ $order->id }} ·
                                        {{ optional($order->user)->phone ?? 'Без телефона' }}</p>
                                    <p class="text-xs text-neutral-500">
                                        {{ optional($order->created_at)->format('H:i') }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if ($order->delivery_total > 0)
                                        <flux:button size="xs" color="lime" variant="outline">
                                            Оплачено
                                        </flux:button>
                                    @endif
                                    <flux:badge color="blue">{{ number_format($order->total, 2, '.', ' ') }} c
                                    </flux:badge>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-8 gap-2 text-xs mt-2">
                                <div class="bg-neutral-100 rounded-lg p-2">
                                    <p class="text-neutral-500">Клиент</p>
                                    <p class="font-semibold">{{ optional($order->user)->name ?? '—' }}</p>
                                </div>
                                <div class="bg-neutral-100 rounded-lg p-2">
                                    <p class="text-neutral-500">Телефон</p>
                                    <p class="font-semibold">{{ optional($order->user)->phone ?? '—' }}</p>
                                </div>
                                <div class="bg-neutral-100 rounded-lg p-2">
                                    <p class="text-neutral-500">Вес / Куб</p>
                                    <p class="font-semibold">{{ number_format($order->weight, 2, '.', ' ') }} кг ·
                                        {{ number_format($order->cube, 2, '.', ' ') }} м³</p>
                                </div>
                                <div class="bg-neutral-100 rounded-lg p-2">
                                    <p class="text-neutral-500">Скидка</p>
                                    <p class="font-semibold">{{ number_format($order->discount, 2, '.', ' ') }} c</p>
                                </div>
                                <div class="bg-neutral-100 rounded-lg p-2">
                                    <p class="text-neutral-500">Подытог</p>
                                    <p class="font-semibold">{{ number_format($order->subtotal, 2, '.', ' ') }} c</p>
                                </div>
                                <div class="bg-neutral-100 rounded-lg p-2">
                                    <p class="text-neutral-500">Доставка</p>
                                    <p class="font-semibold">{{ number_format($order->delivery_total, 2, '.', ' ') }}
                                        c</p>
                                </div>
                                <div class="bg-neutral-100 rounded-lg p-2">
                                    <p class="text-neutral-500">Итог</p>
                                    <p class="font-semibold">{{ number_format($order->total, 2, '.', ' ') }} c</p>
                                </div>
                                <div class="bg-neutral-100 rounded-lg p-2">
                                    <p class="text-neutral-500">Доставщик</p>
                                    <p class="font-semibold">{{ optional($order->deliver)->name ?? 'Не назначен' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border border-dashed border-neutral-300 rounded-xl p-4 text-center">
                            <p class="text-sm text-neutral-500">Сегодня ещё нет оформленных заказов.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </flux:modal>
</div>

<script src="https://cdn.jsdelivr.net/npm/mousetrap@1.6.5/mousetrap.min.js"></script>
<script>
    (function() {
        const initHotkeys = () => {
            const root = document.getElementById('cashdesk-root');
            if (!root || typeof Mousetrap === 'undefined') {
                return;
            }

            const binder = new Mousetrap(root);

            // Разрешаем обработку даже когда фокус в input/textarea внутри кассы
            binder.stopCallback = function(e, element) {
                if (!root.contains(element)) {
                    return true;
                }
                return false;
            };

            const triggerClick = (id) => {
                const el = document.getElementById(id);
                if (el) {
                    el.click();
                }
            };

            const focusInput = (id) => {
                const el = document.getElementById(id);
                if (el) {
                    el.focus();
                    if (typeof el.select === 'function') {
                        el.select();
                    }
                }
            };

            const combos = [{
                    keys: ['command+shift+e', 'ctrl+shift+e'],
                    action: () => triggerClick('btn-add-expense')
                },
                {
                    keys: ['command+shift+q', 'ctrl+shift+q'],
                    action: () => triggerClick('btn-open-queue')
                },
                {
                    keys: ['command+shift+c', 'ctrl+shift+c'],
                    action: () => triggerClick('btn-currency-modal')
                },
                {
                    keys: ['command+shift+r', 'ctrl+shift+r'],
                    action: () => triggerClick('btn-reports-modal')
                },
                {
                    keys: ['command+shift+h', 'ctrl+shift+h'],
                    action: () => triggerClick('btn-hold-order')
                },
                {
                    keys: ['command+shift+t', 'ctrl+shift+t'],
                    action: () => focusInput('track-input')
                },
                {
                    keys: ['command+shift+k', 'ctrl+shift+k'],
                    action: () => focusInput('client-input')
                },
                {
                    keys: ['command+shift+s', 'ctrl+shift+s'],
                    action: () => triggerClick('btn-save-currency')
                },
            ];

            combos.forEach(({
                keys,
                action
            }) => {
                binder.bind(keys, (event) => {
                    event.preventDefault();
                    action();
                    return false;
                });
            });

            binder.bind(['command+enter', 'ctrl+enter'], (event) => {
                event.preventDefault();
                triggerClick('btn-submit-order');
                return false;
            });
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initHotkeys);
        } else {
            initHotkeys();
        }
    })();
</script>
