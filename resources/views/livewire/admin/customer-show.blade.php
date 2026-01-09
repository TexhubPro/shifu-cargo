<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <flux:heading class="text-xl">Детали клиента</flux:heading>
                <flux:text class="text-sm" variant="subtle">
                    Полная информация по заказам и активности клиента.
                </flux:text>
            </div>
            <a href="{{ route('admin.customers') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-3 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100">
                Назад к списку
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm space-y-2">
            <p class="text-xs uppercase text-gray-500 tracking-wide">Клиент</p>
            <div class="space-y-1">
                <p class="text-lg font-semibold text-gray-900">{{ $user->name }}</p>
                <p class="text-sm text-gray-600">Код: {{ $user->code }}</p>
                <p class="text-sm text-gray-600">Телефон: {{ $user->phone ?? '—' }}</p>
                <p class="text-sm text-gray-600">Пол: {{ $user->sex == 'z' ? 'Женский' : 'Мужской' }}</p>
                <p class="text-sm text-gray-600">Регистрация: {{ $user->created_at->format('d.m.Y') }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm space-y-2">
            <p class="text-xs uppercase text-gray-500 tracking-wide">Заказы</p>
            <div class="grid grid-cols-2 gap-3 text-sm">
                <div class="rounded-xl border border-gray-200 p-3">
                    <p class="text-gray-500">Всего</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $ordersTotal }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 p-3">
                    <p class="text-gray-500">Сумма</p>
                    <p class="text-lg font-semibold text-emerald-600">
                        {{ number_format($ordersSum, 2, '.', ' ') }} c
                    </p>
                </div>
                <div class="rounded-xl border border-gray-200 p-3">
                    <p class="text-gray-500">Средний чек</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ number_format($avgOrder, 2, '.', ' ') }} c
                    </p>
                </div>
                <div class="rounded-xl border border-gray-200 p-3">
                    <p class="text-gray-500">Последний заказ</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $lastOrderAt ? \Carbon\Carbon::parse($lastOrderAt)->format('d.m.Y') : '—' }}
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-200 p-4 shadow-sm space-y-2">
            <p class="text-xs uppercase text-gray-500 tracking-wide">Трек-коды</p>
            <div class="rounded-xl border border-gray-200 p-4">
                <p class="text-gray-500 text-sm">Всего зарегистрировано</p>
                <p class="text-3xl font-semibold text-blue-600">{{ $trackcodesCount }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="lg">Заказы за 7 дней</flux:heading>
                <span class="text-xs text-gray-500">Всего: {{ $ordersByDay->sum('value') }}</span>
            </div>
            <div class="flex items-end gap-2 h-44">
                @foreach ($ordersByDay as $item)
                    @php
                        $height = (int) round(($item['value'] / $maxOrders) * 100);
                    @endphp
                    <div class="flex-1 flex flex-col items-center gap-2">
                        <div class="w-full bg-blue-100 rounded-xl overflow-hidden">
                            <div class="bg-blue-600 rounded-xl transition-all"
                                style="height: {{ max(8, $height) }}px"></div>
                        </div>
                        <span class="text-xs text-gray-500">{{ $item['label'] }}</span>
                        <span class="text-xs font-semibold text-gray-700">{{ $item['value'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="lg">Статусы заказов</flux:heading>
                <span class="text-xs text-gray-500">Категории</span>
            </div>
            @php
                $maxStatus = max(1, (int) $ordersByStatus->max('total'));
            @endphp
            <div class="space-y-3">
                @forelse ($ordersByStatus as $status)
                    @php
                        $width = (int) round(($status->total / $maxStatus) * 100);
                    @endphp
                    <div class="space-y-1">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-700">{{ $status->status }}</span>
                            <span class="text-gray-500">{{ $status->total }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-gray-100 overflow-hidden">
                            <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $width }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-gray-200 p-4 text-sm text-gray-500">
                        Нет данных по заказам.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="lg">Последние заказы</flux:heading>
                <span class="text-xs text-gray-500">Показано 5</span>
            </div>
            <div class="space-y-3">
                @forelse ($recentOrders as $order)
                    <div class="flex items-center justify-between gap-3 rounded-xl border border-gray-200 p-3">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Заказ #{{ $order->id }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $order->created_at->format('H:i | d.m.Y') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">{{ $order->status }}</p>
                            <p class="text-sm font-semibold text-gray-900">
                                {{ number_format($order->total, 2, '.', ' ') }} c
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-gray-200 p-4 text-sm text-gray-500">
                        Нет заказов.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="lg">Последние трек-коды</flux:heading>
                <span class="text-xs text-gray-500">Показано 5</span>
            </div>
            <div class="space-y-3">
                @forelse ($recentTrackcodes as $track)
                    <div class="flex items-center justify-between gap-3 rounded-xl border border-gray-200 p-3">
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $track->code }}</p>
                            <p class="text-xs text-gray-500">Статус: {{ $track->status ?? '—' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-gray-500">
                                {{ $track->created_at?->format('H:i | d.m.Y') ?? '—' }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-gray-200 p-4 text-sm text-gray-500">
                        Нет трек-кодов.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
