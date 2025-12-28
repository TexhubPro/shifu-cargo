<div id="cashdesk-root" class="bg-white p-5 space-y-5 min-h-screen" data-price-kg="{{ $this->priceInfo['kg'] }}"
    data-price-kg-10="{{ $this->priceInfo['kg_10'] }}" data-price-kg-20="{{ $this->priceInfo['kg_20'] }}"
    data-price-kg-30="{{ $this->priceInfo['kg_30'] }}" data-price-cube="{{ $this->priceInfo['cube'] }}">
    <div class="bg-gradient-to-r from-lime-500 via-emerald-500 to-teal-500 rounded-2xl p-3 shadow-lg">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <p class="text-white/80 text-sm uppercase tracking-wider">Панель быстрых действий</p>
                <p class="text-white text-xl font-semibold">Рабочие инструменты</p>
            </div>
            <div class="grid grid-cols- lg:grid-cols-5 gap-3 w-full lg:w-auto max-w-6xl">


                <flux:modal.trigger name="add-expences">
                    <flux:button id="btn-add-expense" aria-keyshortcuts="Shift+Alt+E" color="white" variant="ghost"
                        class="h-16 rounded-xl bg-white/15 border border-white/30 shadow-md hover:bg-white/25 transition-all">
                        <div class="flex items-center gap-3 text-left">
                            <span
                                class="bg-white/25 rounded-2xl w-11 h-11 flex items-center justify-center text-white text-2xl">+</span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-semibold text-white">Добавить расходы</span>
                                <span class="text-xs text-white/70">Shift + Alt + E</span>
                            </div>
                        </div>
                    </flux:button>
                </flux:modal.trigger>
                <flux:modal.trigger name="select-queue">
                    <flux:button id="btn-open-queue" aria-keyshortcuts="Shift+Alt+Q" color="white" variant="ghost"
                        class="h-16 rounded-xl bg-white/15 border border-white/30 shadow-md hover:bg-white/25 transition-all">
                        <div class="flex items-center gap-3 text-left">
                            <span
                                class="bg-white/25 rounded-2xl w-11 h-11 flex items-center justify-center text-white text-xl">Q</span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-semibold text-white">Выбрать из очереди</span>
                                <span class="text-xs text-white/70">Shift + Alt + Q</span>
                            </div>
                        </div>
                    </flux:button>
                </flux:modal.trigger>
                <flux:modal.trigger name="currency-info">
                    <flux:button id="btn-currency-modal" aria-keyshortcuts="Shift+Alt+C" color="white" variant="ghost"
                        class="h-16 rounded-xl bg-white/15 border border-white/30 shadow-md hover:bg-white/25 transition-all">
                        <div class="flex items-center gap-3 text-left">
                            <span
                                class="bg-white/25 rounded-2xl w-11 h-11 flex items-center justify-center text-white text-xl">$</span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-semibold text-white">Курс валюты</span>
                                <span class="text-xs text-white/70">Shift + Alt + C</span>
                            </div>
                        </div>
                    </flux:button>
                </flux:modal.trigger>
                <flux:modal.trigger name="cashdesk-reports">
                    <flux:button id="btn-reports-modal" aria-keyshortcuts="Shift+Alt+R" color="white" variant="ghost"
                        class="h-16 rounded-xl bg-white/15 border border-white/30 shadow-md hover:bg-white/25 transition-all"
                        wire:click="goReports">
                        <div class="flex items-center gap-3 text-left">
                            <span
                                class="bg-white/25 rounded-2xl w-11 h-11 flex items-center justify-center text-white text-xl">R</span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-semibold text-white">Отчёты кассы</span>
                                <span class="text-xs text-white/70">Shift + Alt + R</span>
                            </div>
                        </div>
                    </flux:button>
                </flux:modal.trigger>
                <button type="button"
                    class="h-16 rounded-xl bg-red-500 border border-white/30 w-full shadow-md hover:bg-red-400 transition-all flex items-center gap-3 text-left px-3 text-white"
                    wire:click="logout">
                    <span
                        class="bg-white/25 rounded-2xl w-11 h-11 flex items-center justify-center text-white text-xl">⏻</span>
                    <div class="flex flex-col leading-tight">
                        <span class="font-semibold text-white">Выйти</span>
                        <span class="text-xs text-white/70">Logout</span>
                    </div>
                </button>

            </div>
        </div>
    </div>
    <div class="bg-neutral-200 rounded-2xl p-5 space-y-2">

        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white border border-lime-200 rounded-xl p-6 space-y-2 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-xl font-semibold text-neutral-900">Удержанные заказы</p>

                    <flux:badge color="lime" size="sm">{{ $heldOrders->count() }}</flux:badge>
                </div>
                <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                    @forelse ($heldOrders as $held)
                        <div class="border border-neutral-200 rounded-xl px-3 py-2 flex items-center justify-between text-xs"
                            wire:key="held-{{ $held->id }}">
                            <div class="space-y-1">
                                @php
                                    $heldUser = $held->user ?? null;
                                    $heldPhone = $heldUser?->phone ?? $held->client;
                                    $heldNamePhone = $heldUser?->name
                                        ? $heldUser->name . ' — ' . ($heldPhone ?? '')
                                        : $heldPhone ?? null;
                                @endphp
                                <p class="font-semibold text-neutral-800">
                                    {{ $heldNamePhone ?? 'Без клиента' }}
                                </p>
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
            <form wire:submit="order_place" class="col-span-2" x-data @keydown.enter="$event.preventDefault()">
                <div class="bg-white border border-neutral-200 rounded-xl shadow-md p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xl font-semibold text-neutral-900">Оформление заказа</p>
                        </div>
                        <flux:badge color="neutral">Live</flux:badge>
                    </div>
                    <div class="space-y-3">
                        <flux:autocomplete id="client-input" wire:model.defer="client" label="Клиент (Ctrl+Enter)"
                            placeholder="Выберите клиента" required>
                            @foreach ($users as $user)
                                <flux:autocomplete.item>{{ $user->phone }}</flux:autocomplete.item>
                            @endforeach
                        </flux:autocomplete>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Вес груза -->
                        <flux:input id="weight-input" label="Вес груза" placeholder="Введите общий вес груза"
                            wire:model.defer="weight" required />

                        <!-- Объём груза -->
                        <flux:input id="volume-input" label="Объём груза" placeholder="Введите примерный объём"
                            wire:model.defer="volume" />
                    </div>

                    <!-- Скидка -->


                    <div class="space-y-2">
                        <flux:label>Полученная сумма</flux:label>
                        <flux:input id="received-amount-input" placeholder="Сколько оплатил клиент"
                            wire:model.defer="received_amount" type="text" inputmode="decimal" min="0" />
                        <input id="total-amount-input" type="hidden" wire:model.defer="total_amount">
                        <input id="discount-total-input" type="hidden" wire:model.defer="discount_total">
                        <input id="total-final-input" type="hidden" wire:model.defer="total_final">
                        <p class="text-xs text-neutral-500">Недостающая сумма автоматически попадёт в скидку.</p>
                    </div>
                    <div
                        class="bg-gradient-to-r from-neutral-50 to-white rounded-xl p-2 grid grid-cols-2 md:grid-cols-3 gap-2 text-sm shadow-inner border border-neutral-100">
                        <div class="rounded-lg bg-white p-2 border border-neutral-100">
                            <p class="text-neutral-500 text-xs uppercase tracking-wide">Подытог</p>
                            <p id="total-amount-value" class="font-semibold text-lg text-neutral-900">
                                {{ $this->total_amount }}c
                            </p>
                        </div>
                        <div class="rounded-lg bg-white p-2 border border-neutral-100">
                            <p class="text-neutral-500 text-xs uppercase tracking-wide">Скидка</p>
                            <p id="discount-total-value" class="font-semibold text-lg text-rose-600">
                                {{ $this->discount_total }}c
                            </p>
                        </div>
                        <div class="rounded-lg bg-white p-2 border border-neutral-100">
                            <p class="text-neutral-500 text-xs uppercase tracking-wide">Итог</p>
                            <p id="total-final-value" class="font-semibold text-lg text-emerald-600">
                                {{ $total_final }}c
                            </p>
                        </div>
                    </div>
                    <!-- Кнопка -->
                    <div class="flex gap-3 flex-wrap">
                        <flux:button id="btn-hold-order" type="button" class="w-full md:w-1/3"
                            wire:click="holdCurrentOrder" aria-keyshortcuts="Shift+Alt+H">
                            Удержать заказ
                        </flux:button>
                        <flux:button id="btn-submit-order" type="button" variant="primary" color="lime"
                            class="flex-1" aria-keyshortcuts="Shift+Alt+Enter">
                            Оформить заявку
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
                <flux:text class="mt-1">Обновите курс доллара (Shift+Alt+U). Тарифы приводятся справочно.
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
                aria-keyshortcuts="Shift+Alt+U">
                Сохранить · Shift+Alt+U
            </flux:button>
        </form>
    </flux:modal>
    <!-- Подтверждение оформления -->
    <div id="confirm-submit-modal"
        class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-4 space-y-3 border border-neutral-200">
            <div class="flex items-start gap-3">
                <div
                    class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                    !
                </div>
                <div class="space-y-1">
                    <p class="text-lg font-semibold text-neutral-900">Подтвердить оформление?</p>
                    <p class="text-sm text-neutral-600">Нажмите «Подтвердить» для отправки заказа или «Отмена», чтобы
                        вернуться и исправить данные.</p>
                </div>
            </div>
            <div class="flex gap-2 justify-end">
                <button id="cancel-submit-btn" type="button"
                    class="px-4 py-2 rounded-lg border border-neutral-300 text-neutral-700 hover:bg-neutral-100 transition">
                    Отмена (Esc)
                </button>
                <button id="confirm-submit-btn" type="button"
                    class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 transition">
                    Подтвердить (Enter)
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/mousetrap@1.6.5/mousetrap.min.js"></script>
<script>
    (function() {
        const initHotkeys = () => {
            const root = document.getElementById('cashdesk-root');
            if (!root) {
                return;
            }

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

            window.addEventListener('focus-weight-input', () => focusInput('weight-input'));
            window.addEventListener('focus-received-amount', () => focusInput('received-amount-input'));

            const confirmModal = () => document.getElementById('confirm-submit-modal');
            const confirmSubmitBtn = () => document.getElementById('confirm-submit-btn');
            const cancelSubmitBtn = () => document.getElementById('cancel-submit-btn');
            const submitBtn = () => document.getElementById('btn-submit-order');
            const orderForm = () => document.querySelector('form[wire\\:submit=\"order_place\"]');
            const componentEl = root.closest('[wire\\:id]');
            const livewireComponent = componentEl ? Livewire.find(componentEl.getAttribute('wire:id')) : null;
            let confirmOpen = false;

            const showConfirm = () => {
                const modal = confirmModal();
                if (!modal) return;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                confirmOpen = true;
                confirmSubmitBtn()?.focus();
            };

            const hideConfirm = () => {
                const modal = confirmModal();
                if (!modal) return;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                confirmOpen = false;
                focusInput('received-amount-input');
            };

            const bindOnce = (el, event, key, handler) => {
                if (!el || el.dataset[key]) return;
                el.dataset[key] = '1';
                el.addEventListener(event, handler);
            };

            const clearCashdeskFields = () => {
                const ids = ['client-input', 'weight-input', 'volume-input', 'received-amount-input'];
                ids.forEach((id) => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.value = '';
                    }
                });
                const total = document.getElementById('total-amount-value');
                const discount = document.getElementById('discount-total-value');
                const final = document.getElementById('total-final-value');
                if (total) total.textContent = '0c';
                if (discount) discount.textContent = '0c';
                if (final) final.textContent = '0c';

                const totalInput = document.getElementById('total-amount-input');
                const discountInput = document.getElementById('discount-total-input');
                const finalInput = document.getElementById('total-final-input');
                if (totalInput) totalInput.value = '0';
                if (discountInput) discountInput.value = '0';
                if (finalInput) finalInput.value = '0';

                window.__cashdesk_received_dirty = false;
                focusInput('client-input');
            };

            const syncLivewireFields = () => {
                emitInput(document.getElementById('received-amount-input'));
                emitInput(document.getElementById('total-amount-input'));
                emitInput(document.getElementById('discount-total-input'));
                emitInput(document.getElementById('total-final-input'));
            };

            bindOnce(confirmSubmitBtn(), 'click', 'confirmSubmit', () => {
                hideConfirm();
                if (typeof window.__cashdesk_calc === 'function') {
                    window.__cashdesk_calc();
                }
                syncLivewireFields();
                window.__cashdesk_clear_pending = true;
                orderForm()?.requestSubmit();
            });

            bindOnce(cancelSubmitBtn(), 'click', 'cancelSubmit', hideConfirm);

            bindOnce(document.getElementById('weight-input'), 'keydown', 'weightEnter', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    event.stopPropagation();
                    focusInput('received-amount-input');
                }
            });

            bindOnce(document.getElementById('volume-input'), 'keydown', 'volumeEnter', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    event.stopPropagation();
                    focusInput('received-amount-input');
                }
            });

            bindOnce(document.getElementById('received-amount-input'), 'keydown', 'receivedEnter', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    event.stopPropagation();
                    showConfirm();
                }
            });
            bindOnce(document.getElementById('client-input'), 'keydown', 'clientEnter', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    event.stopPropagation();
                    focusInput('weight-input');
                }
            });

            bindOnce(submitBtn(), 'click', 'submitClick', (event) => {
                event.preventDefault();
                showConfirm();
            });

            document.addEventListener('keydown', (event) => {
                if ((event.metaKey || event.ctrlKey) && event.key === 'Enter' && !confirmOpen) {
                    event.preventDefault();
                    focusInput('client-input');
                    return;
                }
                if (!confirmOpen) {
                    return;
                }
                if (event.key === 'Escape') {
                    event.preventDefault();
                    hideConfirm();
                } else if (event.key === 'Enter') {
                    event.preventDefault();
                    confirmSubmitBtn()?.click();
                }
            });

            // После успешной отправки формы Livewire можно слушать событие
            if (window.Livewire) {
                Livewire.on('order-submitted', () => {
                    focusInput('client-input');
                });
            }

            // Переинициализация после обновлений Livewire
            if (window.Livewire && !window.__cashdesk_bindings_set) {
                window.__cashdesk_bindings_set = true;
                Livewire.hook('message.processed', () => initHotkeys());
                Livewire.hook('message.sent', () => {
                    if (window.__cashdesk_clear_pending) {
                        window.__cashdesk_clear_pending = false;
                        clearCashdeskFields();
                    }
                });
            }
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initHotkeys);
        } else {
            initHotkeys();
        }
    })();
</script>

<script>
    (function() {
        const root = document.getElementById('cashdesk-root');
        if (!root) {
            return;
        }

        const prices = {
            kg: parseFloat(root.dataset.priceKg) || 0,
            kg10: parseFloat(root.dataset.priceKg10) || 0,
            kg20: parseFloat(root.dataset.priceKg20) || 0,
            kg30: parseFloat(root.dataset.priceKg30) || 0,
            cube: parseFloat(root.dataset.priceCube) || 0,
        };

        const els = {
            weight: document.getElementById('weight-input'),
            volume: document.getElementById('volume-input'),
            received: document.getElementById('received-amount-input'),
            total: document.getElementById('total-amount-value'),
            discount: document.getElementById('discount-total-value'),
            final: document.getElementById('total-final-value'),
        };

        const parseNumber = (value) => {
            if (value === null || value === undefined || value === '') {
                return 0;
            }
            const normalized = String(value).replace(/\s+/g, '').replace(',', '.');
            const parsed = parseFloat(normalized);
            return Number.isNaN(parsed) ? 0 : parsed;
        };

        const emitInput = (el) => {
            if (!el) return;
            el.dispatchEvent(new Event('input', {
                bubbles: true
            }));
            el.dispatchEvent(new Event('change', {
                bubbles: true
            }));
        };

        const roundPrice = (value) => {
            const fraction = value - Math.floor(value);
            return fraction > 0.5 ? Math.ceil(value) : Math.floor(value);
        };

        const formatValue = (value) => `${value}c`;

        if (window.__cashdesk_received_dirty === undefined) {
            window.__cashdesk_received_dirty = false;
        }
        if (window.__cashdesk_last_auto_received === undefined) {
            window.__cashdesk_last_auto_received = '';
        }
        if (window.__cashdesk_autofill_received === undefined) {
            window.__cashdesk_autofill_received = false;
        }

        const calc = () => {
            const weight = parseNumber(els.weight?.value);
            const volume = parseNumber(els.volume?.value);

            let kgPrice = prices.kg;
            if (weight > 10 && weight <= 20) {
                kgPrice = prices.kg10 || prices.kg;
            } else if (weight > 20 && weight <= 30) {
                kgPrice = prices.kg20 || prices.kg10 || prices.kg;
            } else if (weight > 30) {
                kgPrice = prices.kg30 || prices.kg20 || prices.kg10 || prices.kg;
            }

            const kgTotal = weight * (kgPrice || 0);
            const cubeTotal = volume * (prices.cube || 0);
            const totalAmount = roundPrice(kgTotal + cubeTotal);

            const receivedEl = els.received;
            const receivedValue = receivedEl ? String(receivedEl.value ?? '') : '';
            const canAutofill = receivedEl &&
                (!window.__cashdesk_received_dirty ||
                    receivedValue === window.__cashdesk_last_auto_received);
            if (canAutofill) {
                window.__cashdesk_autofill_received = true;
                receivedEl.value = String(totalAmount);
                window.__cashdesk_last_auto_received = String(totalAmount);
            }
            const received = parseNumber(receivedEl?.value);
            let discount = Math.max(0, totalAmount - received);
            discount = Math.min(discount, totalAmount);

            const totalFinal = roundPrice(Math.max(0, totalAmount - discount));

            if (els.total) {
                els.total.textContent = formatValue(totalAmount);
            }
            if (els.discount) {
                els.discount.textContent = formatValue(discount);
            }
            if (els.final) {
                els.final.textContent = formatValue(totalFinal);
            }

            const totalInput = document.getElementById('total-amount-input');
            const discountInput = document.getElementById('discount-total-input');
            const finalInput = document.getElementById('total-final-input');
            if (totalInput) totalInput.value = totalAmount;
            if (discountInput) discountInput.value = discount;
            if (finalInput) finalInput.value = totalFinal;
        };

        const bind = (el) => {
            if (!el) return;
            el.addEventListener('input', calc);
            el.addEventListener('change', calc);
        };

        bind(els.weight);
        bind(els.volume);
        if (els.received) {
            els.received.addEventListener('input', () => {
                if (window.__cashdesk_autofill_received) {
                    window.__cashdesk_autofill_received = false;
                } else {
                    window.__cashdesk_received_dirty = true;
                }
                calc();
            });
            els.received.addEventListener('change', () => {
                if (window.__cashdesk_autofill_received) {
                    window.__cashdesk_autofill_received = false;
                } else {
                    window.__cashdesk_received_dirty = true;
                }
                calc();
            });
        }
        window.__cashdesk_calc = calc;
        calc();
    })();
</script>
