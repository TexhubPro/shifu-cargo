<x-layouts.empty>
    <div id="cashdesk-control-root" class="bg-white p-5 space-y-5 min-h-screen">
        <div class="bg-gradient-to-r from-lime-500 via-emerald-500 to-teal-500 rounded-2xl p-3 shadow-lg">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-white/80 text-sm uppercase tracking-wider">Панель действий</p>
                    <p class="text-white text-xl font-semibold">Shifu Cargo</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-6 gap-3 w-full lg:w-auto max-w-4xl">
                    <button id="btn-add-expense" aria-keyshortcuts="Shift+Alt+E" type="button"
                        class="rounded-xl bg-white/15 border border-white/30 shadow-md hover:bg-white/25 transition-all flex items-center gap-3 text-left p-2 text-white">
                        <div class="flex items-center gap-3 text-left">
                            <span class=" text-white p-2 bg-white/20 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-cash-register">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M21 15h-2.5c-.398 0 -.779 .158 -1.061 .439c-.281 .281 -.439 .663 -.439 1.061c0 .398 .158 .779 .439 1.061c.281 .281 .663 .439 1.061 .439h1c.398 0 .779 .158 1.061 .439c.281 .281 .439 .663 .439 1.061c0 .398 -.158 .779 -.439 1.061c-.281 .281 -.663 .439 -1.061 .439h-2.5" />
                                    <path d="M19 21v1m0 -8v1" />
                                    <path
                                        d="M13 21h-7c-.53 0 -1.039 -.211 -1.414 -.586c-.375 -.375 -.586 -.884 -.586 -1.414v-10c0 -.53 .211 -1.039 .586 -1.414c.375 -.375 .884 -.586 1.414 -.586h2m12 3.12v-1.12c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586h-2" />
                                    <path
                                        d="M16 10v-6c0 -.53 -.211 -1.039 -.586 -1.414c-.375 -.375 -.884 -.586 -1.414 -.586h-4c-.53 0 -1.039 .211 -1.414 .586c-.375 .375 -.586 .884 -.586 1.414v6m8 0h-8m8 0h1m-9 0h-1" />
                                    <path d="M8 14v.01" />
                                    <path d="M8 17v.01" />
                                    <path d="M12 13.99v.01" />
                                    <path d="M12 17v.01" />
                                </svg></span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-semibold text-white whitespace-break-spaces">Добавить расходы</span>
                            </div>
                        </div>
                    </button>
                    <button id="btn-deliverer-payment" aria-keyshortcuts="Shift+Alt+D" type="button"
                        class="rounded-xl bg-white/15 border border-white/30 shadow-md hover:bg-white/25 transition-all flex items-center gap-3 text-left p-2 text-white">
                        <div class="flex items-center gap-3 text-left">
                            <span class=" text-white p-2 bg-white/20 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-truck-delivery">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                    <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                                    <path d="M3 9l4 0" />
                                </svg></span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-semibold text-white whitespace-break-spaces">Поступление доставщика</span>
                            </div>
                        </div>
                    </button>
                    <button id="btn-open-queue" aria-keyshortcuts="Shift+Alt+Q" type="button"
                        class="rounded-xl bg-white/15 border border-white/30 shadow-md hover:bg-white/25 transition-all flex items-center gap-3 text-left p-2 text-white">
                        <div class="flex items-center gap-3 text-left">
                            <span class=" text-white p-2 bg-white/20 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-users-group">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                                    <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                                    <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                    <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                                </svg></span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-semibold text-white whitespace-break-spaces">Выбрать из очереди</span>
                            </div>
                        </div>
                    </button>
                    <button id="btn-currency-modal" aria-keyshortcuts="Shift+Alt+C" type="button"
                        class="rounded-xl bg-white/15 border border-white/30 shadow-md hover:bg-white/25 transition-all flex items-center gap-3 text-left p-2 text-white">
                        <div class="flex items-center gap-3 text-left">
                            <span class=" text-white p-2 bg-white/20 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-dollar">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                    <path d="M14 11h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                                    <path d="M12 17v1m0 -8v1" />
                                </svg></span>
                            <div class="flex flex-col leading-tight">
                                <span class="font-semibold text-white whitespace-break-spaces">Курс валюты</span>
                            </div>
                        </div>
                    </button>
                    <a id="btn-reports-modal" aria-keyshortcuts="Shift+Alt+R" href="{{ route('cashier.reports') }}"
                        class="rounded-xl bg-white/15 border border-white/30 shadow-md hover:bg-white/25 transition-all flex items-center gap-3 text-left p-2 text-white">
                        <span class=" text-white p-2 bg-white/20 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-device-analytics">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M3 4m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z" />
                                <path d="M7 20l10 0" />
                                <path d="M9 16l0 4" />
                                <path d="M15 16l0 4" />
                                <path d="M8 12l3 -3l2 2l3 -3" />
                            </svg></span>
                        <div class="flex flex-col leading-tight">
                            <span class="font-semibold text-white whitespace-break-spaces">Отчёты кассы</span>
                        </div>
                    </a>
                    <a href="{{ route('logout') }}"
                        class="rounded-xl bg-red-500 border border-white/30 w-full shadow-md hover:bg-red-400 transition-all flex items-center gap-3 text-left p-2 text-white">
                        <span class=" text-white p-2 bg-white/20 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-power">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 6a7.75 7.75 0 1 0 10 0" />
                                <path d="M12 4l0 8" />
                            </svg></span>
                        <div class="flex flex-col leading-tight">
                            <span class="font-semibold text-white">Выйти</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="bg-neutral-200 rounded-2xl p-5 space-y-2">
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white border border-lime-200 rounded-xl p-6 space-y-2 shadow-sm">
                    <div class="flex items-center justify-between">
                        <p class="text-xl font-semibold text-neutral-900">Удержанные заказы</p>
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-lime-100 text-lime-700">
                            {{ $heldOrders->count() }}
                        </span>
                    </div>
                    <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                        @forelse ($heldOrders as $held)
                            <div
                                class="border border-neutral-200 rounded-xl px-3 py-2 flex items-center justify-between text-xs">
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
                                    <form method="GET" action="{{ route('cashier.held.load', $held) }}">
                                        <button type="submit"
                                            class="px-2 py-1 rounded-md bg-emerald-600 text-white hover:bg-emerald-700 transition">
                                            ✓
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('cashier.held.delete', $held) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-2 py-1 rounded-md bg-rose-500 text-white hover:bg-rose-600 transition">
                                            ×
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-neutral-500 text-center">Удержанных заказов нет.</p>
                        @endforelse
                    </div>
                </div>
                <form method="POST" action="{{ route('cashier.order') }}" class="col-span-2"
                    id="cashdesk-order-form">
                    @csrf
                    <input type="hidden" name="order_no" value="{{ $form['order_no'] }}">
                    <input type="hidden" name="selected_queue" value="{{ $form['selected_queue'] }}">
                    <input type="hidden" name="active_held_order_id" value="{{ $form['active_held_order_id'] }}">
                    <div class="bg-white border border-neutral-200 rounded-xl shadow-md p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xl font-semibold text-neutral-900">Оформление заказа</p>
                            </div>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-neutral-100 text-neutral-700">
                                Live
                            </span>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-neutral-700" for="client-input">
                                Клиент (Ctrl+Enter)
                            </label>
                            <div class="space-y-3">
                                <flux:autocomplete id="client-input" name="client" list="client-list"
                                    placeholder="Выберите клиента" required value="{{ $form['client'] }}">
                                    @foreach ($users as $user)
                                        <flux:autocomplete.item>{{ $user->phone }}</flux:autocomplete.item>
                                    @endforeach
                                </flux:autocomplete>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-neutral-700" for="weight-input">Вес
                                    груза</label>
                                <input id="weight-input" name="weight" type="text" inputmode="decimal"
                                    value="{{ $form['weight'] }}" placeholder="Введите общий вес груза" required
                                    class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-400/60">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-neutral-700" for="volume-input">Объём
                                    груза</label>
                                <input id="volume-input" name="volume" type="text" inputmode="decimal"
                                    value="{{ $form['volume'] }}" placeholder="Введите примерный объём"
                                    class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-400/60">
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-neutral-700" for="received-amount-input">
                                Полученная сумма
                            </label>
                            <input id="received-amount-input" name="received_amount" type="text"
                                inputmode="decimal" value="{{ $form['received_amount'] }}"
                                placeholder="Сколько оплатил клиент"
                                class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-400/60">
                            <p class="text-xs text-neutral-500">Недостающая сумма автоматически попадёт в скидку.</p>
                        </div>
                        <div
                            class="bg-gradient-to-r from-neutral-50 to-white rounded-xl p-2 grid grid-cols-2 md:grid-cols-3 gap-2 text-sm shadow-inner border border-neutral-100">
                            <div class="rounded-lg bg-white p-2 border border-neutral-100">
                                <p class="text-neutral-500 text-xs uppercase tracking-wide">Подытог</p>
                                <p class="font-semibold text-lg text-neutral-900">
                                    <span id="total-amount-value">{{ $totals['total_amount'] }}</span>c
                                </p>
                            </div>
                            <div class="rounded-lg bg-white p-2 border border-neutral-100">
                                <p class="text-neutral-500 text-xs uppercase tracking-wide">Скидка</p>
                                <p class="font-semibold text-lg text-rose-600">
                                    <span id="discount-total-value">{{ $totals['discount_total'] }}</span>c
                                </p>
                            </div>
                            <div class="rounded-lg bg-white p-2 border border-neutral-100">
                                <p class="text-neutral-500 text-xs uppercase tracking-wide">Итог</p>
                                <p class="font-semibold text-lg text-emerald-600">
                                    <span id="total-final-value">{{ $totals['total_final'] }}</span>c
                                </p>
                            </div>
                        </div>
                        <div class="flex gap-3 flex-wrap">
                            <button id="btn-hold-order" type="submit" formaction="{{ route('cashier.hold') }}"
                                class="w-full md:w-1/3 rounded-xl border border-neutral-200 bg-white px-4 py-2 text-sm font-semibold shadow-sm hover:bg-neutral-50 transition"
                                aria-keyshortcuts="Shift+Alt+H">
                                Удержать заказ
                            </button>
                            <button id="btn-submit-order" type="button"
                                class="flex-1 rounded-xl bg-lime-600 text-white px-4 py-2 text-sm font-semibold shadow-sm hover:bg-lime-700 transition"
                                aria-keyshortcuts="Shift+Alt+Enter">
                                Оформить заявку
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div id="modal-add-expense"
            class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center p-4 backdrop-blur-sm">
            <div class="bg-white rounded-xl shadow-xl max-w-lg w-full p-4 space-y-4 border border-neutral-200">
                <form method="POST" action="{{ route('cashier.expense') }}" class="space-y-4">
                    @csrf
                    <div class="bg-gradient-to-r from-lime-500 to-emerald-500 rounded-xl p-2 text-white shadow-md">
                        <p class="text-lg font-semibold">Добавить расходы</p>
                        <p class="mt-1 text-white/80 text-sm">
                            Укажите сумму и описание, чтобы зафиксировать расход в отчётах.
                        </p>
                    </div>
                    <div class="space-y-3">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-neutral-700" for="expense-amount-input">
                                Сумма расхода (сомони)
                            </label>
                            <input id="expense-amount-input" name="amount" type="number" min="0"
                                step="0.01" placeholder="Например, 250" required
                                class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-400/60">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-neutral-700" for="expense-description-input">
                                Описание
                            </label>
                            <textarea id="expense-description-input" name="description" rows="3" placeholder="Что было оплачено?"
                                class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-400/60"></textarea>
                        </div>
                    </div>
                    <div class="bg-neutral-100 rounded-xl p-2 text-xs text-neutral-600 flex items-center gap-2">
                        <span class="bg-white rounded-lg px-2 py-1 font-semibold text-lime-600">Совет</span>
                        <span>Чёткие описания помогают быстрее собирать отчёты по расходам.</span>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-neutral-700">Сегодняшние расходы</label>
                        <div class="max-h-56 overflow-y-auto space-y-2 pr-1">
                            @forelse ($todayExpenses as $expense)
                                <div
                                    class="bg-neutral-100 border border-neutral-200 rounded-xl p-3 flex justify-between items-start text-sm">
                                    <div>
                                        <p class="font-semibold text-lg text-emerald-700">
                                            {{ number_format($expense->total ?? ($expense->amount ?? 0), 2, '.', ' ') }}
                                            c
                                        </p>
                                        <p class="text-neutral-600">{{ $expense->content ?? 'Без описания' }}</p>
                                    </div>
                                    <span class="text-xs text-neutral-500">
                                        {{ optional($expense->created_at)->format('H:i') }}
                                    </span>
                                </div>
                            @empty
                                <div
                                    class="bg-white border border-dashed border-neutral-300 rounded-xl p-3 text-xs text-neutral-500 text-center">
                                    Сегодня расходов ещё не фиксировали.
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" data-modal-close="modal-add-expense"
                            class="flex-1 rounded-xl border border-neutral-200 bg-white px-4 py-2 text-sm font-semibold shadow-sm hover:bg-neutral-50 transition">
                            Отмена
                        </button>
                        <button type="submit"
                            class="flex-1 rounded-xl bg-lime-600 text-white px-4 py-2 text-sm font-semibold shadow-sm hover:bg-lime-700 transition">
                            Сохранить расход
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div id="modal-deliverer-payment"
            class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center p-4 backdrop-blur-sm">
            <div class="bg-white rounded-xl shadow-xl max-w-lg w-full p-4 space-y-4 border border-neutral-200">
                <form method="POST" action="{{ route('cashier.deliverer-payment') }}" class="space-y-4">
                    @csrf
                    <div class="bg-gradient-to-r from-rose-500 to-orange-500 rounded-xl p-2 text-white shadow-md">
                        <p class="text-lg font-semibold">Поступление от доставщика</p>
                        <p class="mt-1 text-white/80 text-sm">
                            Отметьте сумму, полученную от доставщика.
                        </p>
                    </div>
                    <div class="space-y-3">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-neutral-700" for="deliverer-id-input">
                                Доставщик
                            </label>
                            <select id="deliverer-id-input" name="deliverer_id" required
                                class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-rose-400/60">
                                <option value="">Выберите доставщика</option>
                                @foreach ($deliverers as $deliverer)
                                    <option value="{{ $deliverer->id }}">{{ $deliverer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-neutral-700" for="deliverer-amount-input">
                                Сумма (сомони)
                            </label>
                            <input id="deliverer-amount-input" name="amount" type="number" min="0.01"
                                step="0.01" placeholder="Например, 120" required
                                class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-rose-400/60">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-neutral-700" for="deliverer-note-input">
                                Примечание
                            </label>
                            <textarea id="deliverer-note-input" name="note" rows="2" placeholder="Комментарий"
                                class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-rose-400/60"></textarea>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-neutral-700">Сегодняшние поступления</label>
                        <div class="max-h-56 overflow-y-auto space-y-2 pr-1">
                            @forelse ($todayDelivererPayments as $payment)
                                <div
                                    class="bg-neutral-100 border border-neutral-200 rounded-xl p-3 flex justify-between items-start text-sm">
                                    <div>
                                        <p class="font-semibold text-lg text-rose-700">
                                            {{ number_format($payment->amount, 2, '.', ' ') }} c
                                        </p>
                                        <p class="text-neutral-600">{{ $payment->deliverer?->name ?? '—' }}</p>
                                        @if ($payment->note)
                                            <p class="text-neutral-500 text-xs">{{ $payment->note }}</p>
                                        @endif
                                    </div>
                                    <span class="text-xs text-neutral-500">
                                        {{ optional($payment->created_at)->format('H:i') }}
                                    </span>
                                </div>
                            @empty
                                <div
                                    class="bg-white border border-dashed border-neutral-300 rounded-xl p-3 text-xs text-neutral-500 text-center">
                                    Сегодня поступлений ещё нет.
                                </div>
                            @endforelse
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" data-modal-close="modal-deliverer-payment"
                            class="flex-1 rounded-xl border border-neutral-200 bg-white px-4 py-2 text-sm font-semibold shadow-sm hover:bg-neutral-50 transition">
                            Отмена
                        </button>
                        <button type="submit"
                            class="flex-1 rounded-xl bg-rose-600 text-white px-4 py-2 text-sm font-semibold shadow-sm hover:bg-rose-700 transition">
                            Сохранить
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div id="modal-select-queue"
            class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center p-4 backdrop-blur-sm">
            <div class="bg-white rounded-xl shadow-xl max-w-xl w-full p-4 space-y-4 border border-neutral-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-lg font-semibold">Выберите клиента из очереди</p>
                        <p class="text-sm text-neutral-600">После выбора телефон подтянется автоматически.</p>
                    </div>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-lime-100 text-lime-700">
                        {{ $queues->count() }}
                    </span>
                </div>
                <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
                    @forelse ($queues as $item)
                        <div
                            class="bg-white border border-neutral-200 rounded-xl p-3 flex items-center justify-between shadow-sm">
                            <div>
                                <p class="font-semibold text-sm">№{{ $item->no }} · {{ $item->user->name }}</p>
                                <p class="text-xs text-neutral-500">
                                    Пол: {{ $item->sex == 'm' ? 'Мужчина' : 'Женщина' }}
                                </p>
                            </div>
                            <form method="POST" action="{{ route('cashier.queue.select', $item) }}">
                                @csrf
                                <button type="submit"
                                    class="rounded-lg bg-rose-500 text-white px-3 py-1 text-sm font-semibold hover:bg-rose-600 transition">
                                    Выбрать
                                </button>
                            </form>
                        </div>
                    @empty
                        <div class="bg-neutral-100 rounded-xl p-4 text-center text-sm text-neutral-500">
                            В очереди пока никого нет.
                        </div>
                    @endforelse
                </div>
                <button type="button" data-modal-close="modal-select-queue"
                    class="w-full rounded-xl border border-neutral-200 bg-white px-4 py-2 text-sm font-semibold shadow-sm hover:bg-neutral-50 transition">
                    Закрыть
                </button>
            </div>
        </div>
        <div id="modal-currency-info"
            class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center p-4 backdrop-blur-sm">
            <div class="bg-white rounded-xl shadow-xl max-w-4xl w-full p-4 space-y-4 border border-neutral-200">
                <form method="POST" action="{{ route('cashier.currency') }}" class="space-y-4">
                    @csrf
                    <div>
                        <p class="text-lg font-semibold">Курс и тарифы</p>
                        <p class="text-sm text-neutral-600">
                            Обновите курс доллара (Shift+Alt+U). Тарифы приводятся справочно.
                        </p>
                    </div>
                    <div class="bg-neutral-100 rounded-xl p-3">
                        <p class="text-sm font-medium text-neutral-700">1 USD</p>
                        <p class="text-2xl font-semibold">{{ $currencyInfo['course_dollar'] }} c</p>
                        <p class="text-xs text-neutral-500">
                            Обновлено {{ optional($currencyInfo['updated_at'])->diffForHumans() ?? '—' }}
                        </p>
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-neutral-700" for="course-dollar-input">
                            Новый курс доллара
                        </label>
                        <input id="course-dollar-input" name="course_dollar" type="number" step="0.01" required
                            class="w-full rounded-xl border border-neutral-200 bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 focus:ring-lime-400/60">
                    </div>
                    <div class="grid grid-cols-5 gap-2">
                        <div class="bg-white rounded-xl p-3 border border-neutral-200">
                            <p class="text-sm font-medium text-neutral-700">Куб</p>
                            <p class="text-lg font-semibold">{{ $currencyInfo['cube_price'] }}</p>
                        </div>
                        <div class="bg-white rounded-xl p-3 border border-neutral-200">
                            <p class="text-sm font-medium text-neutral-700">Кг &lt; 10</p>
                            <p class="text-lg font-semibold">{{ $currencyInfo['kg_price'] }}</p>
                        </div>
                        <div class="bg-white rounded-xl p-3 border border-neutral-200">
                            <p class="text-sm font-medium text-neutral-700">Кг &lt; 20</p>
                            <p class="text-lg font-semibold">{{ $currencyInfo['kg_price_10'] }}</p>
                        </div>
                        <div class="bg-white rounded-xl p-3 border border-neutral-200">
                            <p class="text-sm font-medium text-neutral-700">Кг &lt; 30</p>
                            <p class="text-lg font-semibold">{{ $currencyInfo['kg_price_20'] }}</p>
                        </div>
                        <div class="bg-white rounded-xl p-3 border border-neutral-200">
                            <p class="text-sm font-medium text-neutral-700">Кг 30+</p>
                            <p class="text-lg font-semibold">{{ $currencyInfo['kg_price_30'] }}</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button type="button" data-modal-close="modal-currency-info"
                            class="flex-1 rounded-xl border border-neutral-200 bg-white px-4 py-2 text-sm font-semibold shadow-sm hover:bg-neutral-50 transition">
                            Отмена
                        </button>
                        <button id="btn-save-currency" type="submit"
                            class="flex-1 rounded-xl bg-lime-600 text-white px-4 py-2 text-sm font-semibold shadow-sm hover:bg-lime-700 transition"
                            aria-keyshortcuts="Shift+Alt+U">
                            Сохранить · Shift+Alt+U
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
                        <p class="text-sm text-neutral-600">Нажмите «Подтвердить» для отправки заказа или «Отмена»,
                            чтобы
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
        <div id="order-loading"
            class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center p-4 backdrop-blur-sm">
            <div
                class="bg-white rounded-2xl shadow-xl max-w-sm w-full p-6 border border-neutral-200 text-center space-y-3">
                <div
                    class="mx-auto w-12 h-12 rounded-full border-4 border-neutral-200 border-t-emerald-600 animate-spin">
                </div>
                <p class="text-lg font-semibold text-neutral-900">Оформляем заказ…</p>
                <p class="text-sm text-neutral-500">Пожалуйста, подождите.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/mousetrap@1.6.5/mousetrap.min.js"></script>
    <script>
        (function() {
            const root = document.getElementById('cashdesk-control-root');
            if (!root) {
                return;
            }

            const dataNumber = (value) => {
                const parsed = typeof value === 'string' ? parseFloat(value) : Number(value);
                return Number.isFinite(parsed) ? parsed : 0;
            };

            const rawPrices = {!! json_encode([
                'course' => $priceSettings['course'] ?? 0,
                'kg' => $priceSettings['kg'] ?? 0,
                'kg10' => $priceSettings['kg_10'] ?? 0,
                'kg20' => $priceSettings['kg_20'] ?? 0,
                'kg30' => $priceSettings['kg_30'] ?? 0,
                'cube' => $priceSettings['cube'] ?? 0,
            ]) !!};

            const priceData = {
                course: dataNumber(rawPrices.course),
                kg: dataNumber(rawPrices.kg),
                kg10: dataNumber(rawPrices.kg10),
                kg20: dataNumber(rawPrices.kg20),
                kg30: dataNumber(rawPrices.kg30),
                cube: dataNumber(rawPrices.cube),
            };

            const weightInput = document.getElementById('weight-input');
            const volumeInput = document.getElementById('volume-input');
            const receivedInput = document.getElementById('received-amount-input');
            const clientInput = document.getElementById('client-input');
            const totalAmountEl = document.getElementById('total-amount-value');
            const discountEl = document.getElementById('discount-total-value');
            const totalFinalEl = document.getElementById('total-final-value');

            const parseNumber = (value) => {
                if (value === null || value === undefined || value === '') {
                    return 0;
                }
                const normalized = String(value).replace(/[^0-9.,-]/g, '').replace(/,/g, '.');
                const num = parseFloat(normalized);
                return isNaN(num) ? 0 : num;
            };

            const roundPrice = (value) => {
                const fraction = value - Math.floor(value);
                return fraction > 0.5 ? Math.ceil(value) : Math.floor(value);
            };

            const calculateTotals = (weight, volume, received) => {
                const weightValue = parseNumber(weight);
                const volumeValue = parseNumber(volume);
                const course = priceData.course || 0;
                const cubePrice = (priceData.cube || 0) * course;

                let kgPrice = priceData.kg || 0;
                if (weightValue > 10 && weightValue <= 20) {
                    kgPrice = priceData.kg10 || 0;
                } else if (weightValue > 20 && weightValue <= 30) {
                    kgPrice = priceData.kg20 || 0;
                } else if (weightValue > 30) {
                    kgPrice = priceData.kg30 || 0;
                }

                let kgTotal = weightValue * (kgPrice * course);
                if (weightValue > 0 && kgTotal < 10) {
                    kgTotal = 10;
                }
                const cubeTotal = volumeValue * cubePrice;
                const totalAmount = roundPrice(kgTotal + cubeTotal);
                const receivedValue = parseNumber(received);
                const discountTotal = Math.min(Math.max(0, totalAmount - receivedValue), totalAmount);
                const totalFinal = roundPrice(Math.max(0, totalAmount - discountTotal));

                return {
                    totalAmount,
                    discountTotal,
                    totalFinal
                };
            };

            const updateTotals = (syncReceived) => {
                const totals = calculateTotals(weightInput?.value, volumeInput?.value, receivedInput?.value);
                if (syncReceived && receivedInput) {
                    receivedInput.value = totals.totalAmount || 0;
                }
                if (totalAmountEl) {
                    totalAmountEl.textContent = totals.totalAmount;
                }
                if (discountEl) {
                    discountEl.textContent = totals.discountTotal;
                }
                if (totalFinalEl) {
                    totalFinalEl.textContent = totals.totalFinal;
                }
            };

            weightInput?.addEventListener('input', () => updateTotals(true));
            volumeInput?.addEventListener('input', () => updateTotals(true));
            receivedInput?.addEventListener('input', () => updateTotals(false));

            updateTotals(false);

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

            const confirmModal = () => document.getElementById('confirm-submit-modal');
            const confirmSubmitBtn = () => document.getElementById('confirm-submit-btn');
            const cancelSubmitBtn = () => document.getElementById('cancel-submit-btn');
            const submitBtn = () => document.getElementById('btn-submit-order');
            const orderForm = () => document.getElementById('cashdesk-order-form');
            const loadingModal = () => document.getElementById('order-loading');
            let confirmOpen = false;
            let submitting = false;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

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

            const showLoading = () => {
                const modal = loadingModal();
                if (!modal) return;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            const lockSubmit = () => {
                if (submitting) return false;
                submitting = true;
                submitBtn()?.setAttribute('disabled', 'disabled');
                confirmSubmitBtn()?.setAttribute('disabled', 'disabled');
                cancelSubmitBtn()?.setAttribute('disabled', 'disabled');
                document.getElementById('btn-hold-order')?.setAttribute('disabled', 'disabled');
                showLoading();
                return true;
            };

            const unlockSubmit = () => {
                submitting = false;
                submitBtn()?.removeAttribute('disabled');
                confirmSubmitBtn()?.removeAttribute('disabled');
                cancelSubmitBtn()?.removeAttribute('disabled');
                document.getElementById('btn-hold-order')?.removeAttribute('disabled');
                const modal = loadingModal();
                if (modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            };

            const resetOrderForm = () => {
                if (clientInput) clientInput.value = '';
                if (weightInput) weightInput.value = '';
                if (volumeInput) volumeInput.value = '';
                if (receivedInput) receivedInput.value = '';
                updateTotals(false);
                focusInput('client-input');
            };

            const submitOrderAjax = async () => {
                if (!lockSubmit()) {
                    return;
                }
                hideConfirm();

                try {
                    const formEl = orderForm();
                    if (!formEl) {
                        unlockSubmit();
                        return;
                    }

                    const formData = new FormData(formEl);
                    if (csrfToken) {
                        formData.set('_token', csrfToken);
                    }

                    const response = await fetch(formEl.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    let responseData = null;
                    const contentType = response.headers.get('content-type') || '';
                    if (contentType.includes('application/json')) {
                        try {
                            responseData = await response.json();
                        } catch (error) {
                            responseData = null;
                        }
                    }

                    if (!response.ok || (responseData && responseData.ok === false)) {
                        const message = responseData?.message ||
                            (responseData?.errors ? Object.values(responseData.errors)[0]?.[0] : null) ||
                            'Ошибка оформления заказа.';
                        alert(message);
                        unlockSubmit();
                        return;
                    }

                    resetOrderForm();
                    unlockSubmit();
                } catch (error) {
                    unlockSubmit();
                }
            };

            const bindOnce = (el, event, key, handler) => {
                if (!el || el.dataset[key]) return;
                el.dataset[key] = '1';
                el.addEventListener(event, handler);
            };

            bindOnce(confirmSubmitBtn(), 'click', 'confirmSubmit', () => {
                submitOrderAjax();
            });

            bindOnce(cancelSubmitBtn(), 'click', 'cancelSubmit', hideConfirm);

            bindOnce(weightInput, 'keydown', 'weightEnter', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    event.stopPropagation();
                    focusInput('received-amount-input');
                }
            });

            bindOnce(volumeInput, 'keydown', 'volumeEnter', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    event.stopPropagation();
                    focusInput('received-amount-input');
                }
            });

            bindOnce(receivedInput, 'keydown', 'receivedEnter', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    event.stopPropagation();
                    showConfirm();
                }
            });

            bindOnce(clientInput, 'keydown', 'clientEnter', (event) => {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    event.stopPropagation();
                    focusInput('weight-input');
                }
            });

            bindOnce(submitBtn(), 'click', 'submitClick', (event) => {
                event.preventDefault();
                if (submitting) {
                    return;
                }
                showConfirm();
            });

            orderForm()?.addEventListener('submit', (event) => {
                const submitter = event.submitter;
                if (submitter && submitter.id === 'btn-hold-order') {
                    return;
                }
                event.preventDefault();
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

            const modalMap = {
                'btn-add-expense': 'modal-add-expense',
                'btn-deliverer-payment': 'modal-deliverer-payment',
                'btn-open-queue': 'modal-select-queue',
                'btn-currency-modal': 'modal-currency-info',
            };

            const showModal = (id) => {
                const modal = document.getElementById(id);
                if (!modal) return;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            const hideModal = (id) => {
                const modal = document.getElementById(id);
                if (!modal) return;
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            };

            Object.entries(modalMap).forEach(([triggerId, modalId]) => {
                const trigger = document.getElementById(triggerId);
                if (!trigger) return;
                trigger.addEventListener('click', () => showModal(modalId));
            });

            document.querySelectorAll('[data-modal-close]').forEach((button) => {
                button.addEventListener('click', () => hideModal(button.dataset.modalClose));
            });

            document.querySelectorAll(
                '#modal-add-expense, #modal-deliverer-payment, #modal-select-queue, #modal-currency-info'
            ).forEach((modal) => {
                modal.addEventListener('click', (event) => {
                    if (event.target === modal) {
                        hideModal(modal.id);
                    }
                });
            });

            document.addEventListener('keydown', (event) => {
                if (event.shiftKey && event.altKey && event.key.toLowerCase() === 'e') {
                    event.preventDefault();
                    showModal('modal-add-expense');
                }
                if (event.shiftKey && event.altKey && event.key.toLowerCase() === 'd') {
                    event.preventDefault();
                    showModal('modal-deliverer-payment');
                }
                if (event.shiftKey && event.altKey && event.key.toLowerCase() === 'q') {
                    event.preventDefault();
                    showModal('modal-select-queue');
                }
                if (event.shiftKey && event.altKey && event.key.toLowerCase() === 'c') {
                    event.preventDefault();
                    showModal('modal-currency-info');
                }
                if (event.shiftKey && event.altKey && event.key.toLowerCase() === 'h') {
                    event.preventDefault();
                    triggerClick('btn-hold-order');
                }
            });
        })();
    </script>
</x-layouts.empty>
