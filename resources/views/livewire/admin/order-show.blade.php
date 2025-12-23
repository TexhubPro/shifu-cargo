@php
    $user = $order->user;
    $deliver = $order->deliver;
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-xl">Детали заказа</flux:heading>
        <flux:text class="text-sm" variant="subtle">
            Полная информация по заказу и клиенту.
        </flux:text>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Клиент</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $user->name ?? '—' }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $user->code ?? '—' }}</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-blue-50 text-blue-600 inline-flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                    </svg>
                </div>
            </div>
            <div class="mt-5 space-y-3 text-sm text-gray-600">
                <div class="flex items-center justify-between">
                    <span>Телефон</span>
                    <span class="font-medium text-gray-900">{{ $user->phone ?? '—' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Пол</span>
                    <span class="font-medium text-gray-900">
                        {{ $user && $user->sex ? ($user->sex == 'm' ? 'Мужской' : 'Женский') : '—' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Доставка</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $deliver->name ?? 'Не назначен' }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $deliver->phone ?? '—' }}</p>
                </div>
                <div class="h-12 w-12 rounded-2xl bg-emerald-50 text-emerald-600 inline-flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                        <path d="M3 9l4 0" />
                    </svg>
                </div>
            </div>
            <div class="mt-5 space-y-3 text-sm text-gray-600">
                <div class="flex items-center justify-between">
                    <span>Дата заказа</span>
                    <span class="font-medium text-gray-900">{{ $order->created_at->format('H:i | d.m.Y') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>ID заказа</span>
                    <span class="font-medium text-gray-900">#{{ $order->id }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
            <p class="text-xs text-gray-500">Итого</p>
            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ number_format($order->total, 2, '.', ' ') }} c</p>
            <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                <div class="rounded-xl bg-slate-50 p-3">
                    <p class="text-xs text-gray-500">Вес</p>
                    <p class="font-semibold text-gray-900">{{ $order->weight }} кг</p>
                </div>
                <div class="rounded-xl bg-slate-50 p-3">
                    <p class="text-xs text-gray-500">Куб</p>
                    <p class="font-semibold text-gray-900">{{ $order->cube }} м3</p>
                </div>
                <div class="rounded-xl bg-indigo-50 p-3">
                    <p class="text-xs text-indigo-600">Подытог</p>
                    <p class="font-semibold text-indigo-900">{{ number_format($order->subtotal, 2, '.', ' ') }} c</p>
                </div>
                <div class="rounded-xl bg-rose-50 p-3">
                    <p class="text-xs text-rose-600">Скидка</p>
                    <p class="font-semibold text-rose-900">{{ number_format($order->discount, 2, '.', ' ') }} c</p>
                </div>
                <div class="rounded-xl bg-amber-50 p-3 col-span-2">
                    <p class="text-xs text-amber-600">Доставка</p>
                    <p class="font-semibold text-amber-900">{{ number_format($order->delivery_total, 2, '.', ' ') }} c</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100">
        <div class="flex flex-col gap-1">
            <flux:heading>Финансовая сводка</flux:heading>
            <flux:text>Детали оплаты и расчетов по заказу.</flux:text>
        </div>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div class="rounded-xl border border-slate-100 p-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Подытог</span>
                    <span class="font-semibold text-gray-900">{{ number_format($order->subtotal, 2, '.', ' ') }} c</span>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-gray-500">Скидка</span>
                    <span class="font-semibold text-rose-600">-{{ number_format($order->discount, 2, '.', ' ') }} c</span>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-gray-500">Доставка</span>
                    <span class="font-semibold text-amber-600">{{ number_format($order->delivery_total, 2, '.', ' ') }} c</span>
                </div>
            </div>
            <div class="rounded-xl border border-slate-100 p-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-500">Итого</span>
                    <span class="font-semibold text-emerald-600">{{ number_format($order->total, 2, '.', ' ') }} c</span>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-gray-500">Клиент</span>
                    <span class="font-semibold text-gray-900">{{ $user->code ?? '—' }}</span>
                </div>
                <div class="flex items-center justify-between mt-2">
                    <span class="text-gray-500">Телефон</span>
                    <span class="font-semibold text-gray-900">{{ $user->phone ?? '—' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
