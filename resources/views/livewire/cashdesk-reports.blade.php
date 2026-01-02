<div class="p-4 space-y-4 bg-white">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm uppercase text-neutral-500 tracking-wide">Отчёты кассы</p>
            <p class="text-xl font-semibold text-neutral-900">Статистика за сегодня</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('cashier') }}"
                class="px-4 py-2 rounded-lg bg-neutral-200 hover:bg-neutral-300 text-neutral-800 font-semibold">Касса</a>
            <flux:button wire:click="downloadTodayReport" variant="primary">
                Скачать отчёт за сегодня
            </flux:button>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
        <div class="rounded-xl p-3 bg-gradient-to-r from-emerald-100 to-emerald-50 border border-emerald-200">
            <div class="flex items-center gap-2 text-emerald-700 font-semibold">
                <span>📦</span> <span>Заказы сегодня</span>
            </div>
            <p class="text-2xl font-bold text-emerald-800 mt-1">{{ $this->reportStats['orders_today'] }}</p>
        </div>
        <div class="rounded-xl p-3 bg-gradient-to-r from-amber-100 to-amber-50 border border-amber-200">
            <div class="flex items-center gap-2 text-amber-700 font-semibold">
                <span>💰</span> <span>Выручка</span>
            </div>
            <p class="text-2xl font-bold text-amber-800 mt-1">
                {{ number_format($this->reportStats['revenue_today'], 2, '.', ' ') }} c
            </p>
        </div>
        <div class="rounded-xl p-3 bg-gradient-to-r from-blue-100 to-blue-50 border border-blue-200">
            <div class="flex items-center gap-2 text-blue-700 font-semibold">
                <span>⏳</span> <span>Очередь</span>
            </div>
            <p class="text-2xl font-bold text-blue-800 mt-1">{{ $this->reportStats['queues_waiting'] }}</p>
        </div>
        <div class="rounded-xl p-3 bg-gradient-to-r from-rose-100 to-rose-50 border border-rose-200">
            <div class="flex items-center gap-2 text-rose-700 font-semibold">
                <span>🧊</span> <span>Удержанные</span>
            </div>
            <p class="text-2xl font-bold text-rose-800 mt-1">{{ $this->reportStats['held_orders'] }}</p>
        </div>
        <div class="rounded-xl p-3 bg-gradient-to-r from-orange-100 to-orange-50 border border-orange-200">
            <div class="flex items-center gap-2 text-orange-700 font-semibold">
                <span>🚚</span> <span>От доставщиков</span>
            </div>
            <p class="text-2xl font-bold text-orange-800 mt-1">
                {{ number_format($this->reportStats['deliverer_payments'], 2, '.', ' ') }} c
            </p>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="bg-white border border-lime-200 rounded-xl p-3 shadow-sm">
            <div class="flex items-center gap-2 text-lime-700 font-semibold">
                <span>📈</span><span>Всего заказов</span>
            </div>
            <p class="text-2xl font-bold">{{ $this->todayOrdersSummary['count'] }}</p>
        </div>
        <div class="bg-white border border-sky-200 rounded-xl p-3 shadow-sm">
            <div class="flex items-center gap-2 text-sky-700 font-semibold">
                <span>⚖️</span><span>Вес суммарно</span>
            </div>
            <p class="text-2xl font-bold">
                {{ number_format($this->todayOrdersSummary['weight'], 2, '.', ' ') }} кг</p>
        </div>
        <div class="bg-white border border-indigo-200 rounded-xl p-3 shadow-sm">
            <div class="flex items-center gap-2 text-indigo-700 font-semibold">
                <span>📦</span><span>Объём суммарно</span>
            </div>
            <p class="text-2xl font-bold">
                {{ number_format($this->todayOrdersSummary['cube'], 2, '.', ' ') }} м³</p>
        </div>
        <div class="bg-white border border-rose-200 rounded-xl p-3 shadow-sm">
            <div class="flex items-center gap-2 text-rose-700 font-semibold">
                <span>🏷️</span><span>Скидки суммарно</span>
            </div>
            <p class="text-2xl font-bold text-rose-600">
                {{ number_format($this->todayOrdersSummary['discount'], 2, '.', ' ') }} c</p>
        </div>
        <div class="bg-white border border-amber-200 rounded-xl p-3 shadow-sm">
            <div class="flex items-center gap-2 text-amber-700 font-semibold">
                <span>🧾</span><span>Подытог суммарно</span>
            </div>
            <p class="text-2xl font-bold">
                {{ number_format($this->todayOrdersSummary['subtotal'], 2, '.', ' ') }} c</p>
        </div>
        <div class="bg-white border border-emerald-200 rounded-xl p-3 shadow-sm">
            <div class="flex items-center gap-2 text-emerald-700 font-semibold">
                <span>✅</span><span>Итог суммарно</span>
            </div>
            <p class="text-2xl font-bold text-emerald-700">
                {{ number_format($this->todayOrdersSummary['total'], 2, '.', ' ') }} c</p>
        </div>
        <div class="bg-white border border-rose-200 rounded-xl p-3 shadow-sm">
            <div class="flex items-center gap-2 text-rose-700 font-semibold">
                <span>💸</span><span>Расходы сегодня</span>
            </div>
            <p class="text-2xl font-bold text-rose-600">
                {{ number_format($this->todayExpenses->sum('total'), 2, '.', ' ') }} c
            </p>
        </div>
    </div>

    <div class="space-y-2">
        <flux:label>Сегодняшние заказы</flux:label>
        <div class="bg-white border border-neutral-200 rounded-xl p-3 shadow-sm">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach ($this->todayOrders as $order)
                    <div class="border border-neutral-200 rounded-lg p-3 bg-neutral-50 shadow-sm space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-neutral-500">#{{ $order->id }}</span>
                            <span class="text-xs text-neutral-500">{{ optional($order->created_at)->format('H:i') }}</span>
                        </div>
                        <p class="font-semibold">{{ optional($order->user)->phone ?? 'Без телефона' }}</p>
                        <p class="text-neutral-600 text-sm">
                            ⚖️ {{ number_format($order->weight, 2, '.', ' ') }} кг ·
                            📦 {{ number_format($order->cube, 2, '.', ' ') }} м³
                        </p>
                        <p class="text-emerald-700 font-semibold text-sm">Итог: {{ number_format($order->total, 2, '.', ' ') }} c</p>
                        <p class="text-rose-600 text-sm">Скидка: {{ number_format($order->discount, 2, '.', ' ') }} c</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="space-y-2">
        <flux:label>Поступления от доставщиков</flux:label>
        <div class="bg-white border border-neutral-200 rounded-xl p-3 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @forelse ($this->todayDelivererPayments as $payment)
                    <div class="border border-neutral-200 rounded-lg p-3 bg-neutral-50 shadow-sm space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-neutral-500">#{{ $payment->id }}</span>
                            <span class="text-xs text-neutral-500">
                                {{ optional($payment->created_at)->format('H:i') }}
                            </span>
                        </div>
                        <p class="font-semibold">{{ $payment->deliverer?->name ?? '—' }}</p>
                        <p class="text-emerald-700 font-semibold text-sm">
                            Сумма: {{ number_format($payment->amount, 2, '.', ' ') }} c
                        </p>
                        @if ($payment->note)
                            <p class="text-neutral-600 text-sm">{{ $payment->note }}</p>
                        @endif
                    </div>
                @empty
                    <div
                        class="bg-white border border-dashed border-neutral-300 rounded-xl p-4 text-xs text-neutral-500 text-center">
                        Сегодня поступлений нет.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
