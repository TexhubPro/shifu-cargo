@php
    $user = $application->user;
    $order = $application->order;
    $deliver = $order?->deliver;
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-xl">Детали заявки</flux:heading>
        <flux:text class="text-sm" variant="subtle">
            Полная информация по заявке, связанному заказу и фото-отчёту.
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
                    <span class="font-medium text-gray-900">{{ $application->phone ?? '—' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Адрес</span>
                    <span class="font-medium text-gray-900 text-right">{{ $application->address ?? '—' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Статус</span>
                    <span class="font-medium text-gray-900">{{ $application->status ?? '—' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Дата заявки</span>
                    <span class="font-medium text-gray-900">{{ $application->created_at->format('H:i | d.m.Y') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">Заказ</p>
                    <p class="text-lg font-semibold text-gray-900">
                        {{ $order ? '#' . $order->id : 'Не оформлен' }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">{{ $order->status ?? '—' }}</p>
                </div>
                <div
                    class="h-12 w-12 rounded-2xl bg-emerald-50 text-emerald-600 inline-flex items-center justify-center">
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
                    <span>Доставщик</span>
                    <span class="font-medium text-gray-900">{{ $deliver->name ?? '—' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Телефон доставщика</span>
                    <span class="font-medium text-gray-900">{{ $deliver->phone ?? '—' }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Цена доставки</span>
                    <span class="font-medium text-gray-900">
                        {{ $order ? number_format($order->delivery_total, 2, '.', ' ') : '—' }} c
                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Вес</span>
                    <span class="font-medium text-gray-900">{{ $order->weight ?? '—' }} кг</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Куб</span>
                    <span class="font-medium text-gray-900">{{ $order->cube ?? '—' }} м³</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
            <p class="text-xs text-gray-500">Итого</p>
            <p class="text-3xl font-semibold text-gray-900 mt-2">
                {{ $order ? number_format($order->total, 2, '.', ' ') : '—' }} c
            </p>
            <div class="mt-4 grid grid-cols-2 gap-3 text-sm">
                <div class="rounded-xl bg-slate-50 p-3">
                    <p class="text-xs text-gray-500">Подытог</p>
                    <p class="font-semibold text-gray-900">
                        {{ $order ? number_format($order->subtotal, 2, '.', ' ') : '—' }} c
                    </p>
                </div>
                <div class="rounded-xl bg-rose-50 p-3">
                    <p class="text-xs text-rose-600">Скидка</p>
                    <p class="font-semibold text-rose-900">
                        {{ $order ? number_format($order->discount, 2, '.', ' ') : '—' }} c
                    </p>
                </div>
                <div class="rounded-xl bg-amber-50 p-3 col-span-2">
                    <p class="text-xs text-amber-600">Доставка</p>
                    <p class="font-semibold text-amber-900">
                        {{ $order ? number_format($order->delivery_total, 2, '.', ' ') : '—' }} c
                    </p>
                </div>
                <div class="rounded-xl bg-emerald-50 p-3 col-span-2">
                    <p class="text-xs text-emerald-600">Итог с доставкой</p>
                    <p class="font-semibold text-emerald-900">
                        {{ $order ? number_format($order->total, 2, '.', ' ') : '—' }} c
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
        <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100">
            <div class="flex flex-col gap-1">
                <flux:heading>Фото-отчёт</flux:heading>
                <flux:text>Приложенный файл к заказу.</flux:text>
            </div>
            <div class="mt-4">
                @if ($order && $order->photo_report_path)
                    <a class="text-blue-600 text-sm underline"
                        href="{{ 'https://shifucargo.texhub.pro/public/storage/' . $order->photo_report_path }}"
                        target="_blank" rel="noopener">
                        Открыть фото-отчёт
                    </a>
                    <div class="mt-3">
                        <img class="w-full max-h-80 object-contain rounded-xl border border-slate-100"
                            src="{{ 'https://shifucargo.texhub.pro/public/storage/' . $order->photo_report_path }}"
                            alt="Фото-отчёт">
                    </div>
                @else
                    <div class="rounded-xl border border-dashed border-slate-200 p-6 text-sm text-gray-400">
                        Фото-отчёт пока не прикреплён.
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100">
            <div class="flex flex-col gap-1">
                <flux:heading>Трек-коды</flux:heading>
                <flux:text>Список трек-кодов, прикрепленных к заказу.</flux:text>
            </div>
            <div class="mt-4">
                @if ($trackcodes && count($trackcodes) > 0)
                    <div class="space-y-2 text-sm">
                        @foreach ($trackcodes as $track)
                            <div class="flex items-center justify-between rounded-xl border border-slate-100 px-4 py-2">
                                <span class="font-medium text-gray-900">{{ $track->code }}</span>
                                <span class="text-xs text-gray-500">{{ $track->status ?? '—' }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-xl border border-dashed border-slate-200 p-6 text-sm text-gray-400">
                        Трек-коды не найдены.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
