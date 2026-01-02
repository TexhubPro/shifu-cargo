@php
    $earningsTotal = $earnings->sum('total');
    $expensesTotal = $expenses->sum('total');
    $deliveryTotal = $delivery->sum('delivery_total');
    $profitTotal = $netProfit;
    $maxKpi = max(1, $earningsTotal, $expensesTotal, $deliveryTotal, $profitTotal, $applicationsTotal, $cashdeskTotal);
@endphp

<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-xl">Панель управления</flux:heading>
        <flux:text class="text-sm" variant="subtle">Контроль ключевых метрик, статусов и расходов.</flux:text>
    </div>

    @if (Auth::user()->role == 'admin')
        <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-3 items-end">
                <flux:date-picker wire:model.live="start" label="Начальная дата" />
                <flux:date-picker wire:model.live="end" label="Конечная дата" />
                <div class="lg:col-span-3 flex flex-col lg:flex-row gap-3 lg:justify-end">
                    <flux:button variant="primary" color="lime" wire:click="update">
                        Применить фильтр
                    </flux:button>
                    <div class="flex items-center gap-3 rounded-xl bg-slate-50 px-4 py-2 text-sm text-slate-600">
                        <span>Диапазон:</span>
                        <span class="font-semibold text-slate-900">
                            {{ \Carbon\Carbon::parse($start)->format('d.m.Y') }} —
                            {{ \Carbon\Carbon::parse($end)->format('d.m.Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
            <flux:modal.trigger name="newclients">
                <div
                    class="group bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Новые клиенты</p>
                            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $newClients->count() }}</p>
                            <p class="text-xs text-gray-400 mt-1">За выбранный период</p>
                        </div>
                        <div
                            class="h-12 w-12 rounded-2xl bg-blue-50 text-blue-600 inline-flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1" />
                                <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M17 10h2a2 2 0 0 1 2 2v1" />
                                <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M3 13v-1a2 2 0 0 1 2 -2h2" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-blue-100 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500" style="width: {{ min(100, $newClients->count() * 4) }}%"></div>
                    </div>
                </div>
            </flux:modal.trigger>

            <a href="{{ route('admin.trackcodes') }}"
                class="group bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Трек-коды Иву</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $trackcodes }}</p>
                        <p class="text-xs text-gray-400 mt-1">Склад Иву</p>
                    </div>
                    <div
                        class="h-12 w-12 rounded-2xl bg-emerald-50 text-emerald-600 inline-flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                            <path d="M8 13h1v3h-1z" />
                            <path d="M12 13v3" />
                            <path d="M15 13h1v3h-1z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 h-1.5 w-full bg-emerald-100 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500" style="width: {{ min(100, $trackcodes * 4) }}%"></div>
                </div>
            </a>

            <a href="{{ route('admin.orders') }}"
                class="group bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Выручка</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $earningsTotal }} с</p>
                        <p class="text-xs text-gray-400 mt-1">За период</p>
                    </div>
                    <div
                        class="h-12 w-12 rounded-2xl bg-indigo-50 text-indigo-600 inline-flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2" />
                            <path d="M14.8 8a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1" />
                            <path d="M12 6v10" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 h-1.5 w-full bg-indigo-100 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-500"
                        style="width: {{ max(8, round(($earningsTotal / $maxKpi) * 100)) }}%"></div>
                </div>
            </a>

            <flux:modal.trigger name="allexpanses">
                <div
                    class="group bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100 hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Все затраты</p>
                            <p class="text-3xl font-semibold text-gray-900 mt-2">{{ $expensesTotal }} с</p>
                            <p class="text-xs text-gray-400 mt-1">За период</p>
                        </div>
                        <div
                            class="h-12 w-12 rounded-2xl bg-amber-50 text-amber-600 inline-flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M13 21h-7a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h12.5" />
                                <path d="M21 15h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                                <path d="M19 21v1m0 -8v1" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 h-1.5 w-full bg-amber-100 rounded-full overflow-hidden">
                        <div class="h-full bg-amber-500"
                            style="width: {{ max(8, round(($expensesTotal / $maxKpi) * 100)) }}%"></div>
                    </div>
                </div>
            </flux:modal.trigger>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            <a href="{{ route('admin.applications') }}"
                class="group bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Сумма по заявкам</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            {{ number_format($applicationsTotal, 2, '.', ' ') }} c
                        </p>
                        <p class="text-xs text-gray-400 mt-1">За период</p>
                    </div>
                    <div
                        class="h-12 w-12 rounded-2xl bg-emerald-50 text-emerald-600 inline-flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 7h10" />
                            <path d="M7 12h10" />
                            <path d="M7 17h10" />
                            <path d="M5 5m0 2a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 h-1.5 w-full bg-emerald-100 rounded-full overflow-hidden">
                    <div class="h-full bg-emerald-500"
                        style="width: {{ max(8, round(($applicationsTotal / $maxKpi) * 100)) }}%"></div>
                </div>
            </a>

            <a href="{{ route('admin.orders') }}"
                class="group bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Сумма кассы</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            {{ number_format($cashdeskTotal, 2, '.', ' ') }} c
                        </p>
                        <p class="text-xs text-gray-400 mt-1">За период</p>
                    </div>
                    <div
                        class="h-12 w-12 rounded-2xl bg-indigo-50 text-indigo-600 inline-flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 21v-16a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v16l-3 -2l-2 2l-2 -2l-2 2l-2 -2l-3 2" />
                            <path d="M14.8 8a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1" />
                            <path d="M12 6v10" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 h-1.5 w-full bg-indigo-100 rounded-full overflow-hidden">
                    <div class="h-full bg-indigo-500"
                        style="width: {{ max(8, round(($cashdeskTotal / $maxKpi) * 100)) }}%"></div>
                </div>
            </a>

            <div class="group bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Сумма доставки</p>
                        <p class="text-3xl font-semibold text-gray-900 mt-2">
                            {{ number_format($deliveryOnlyTotal, 2, '.', ' ') }} c
                        </p>
                        <p class="text-xs text-gray-400 mt-1">За период</p>
                    </div>
                    <div
                        class="h-12 w-12 rounded-2xl bg-rose-50 text-rose-600 inline-flex items-center justify-center">
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
                <div class="mt-4 h-1.5 w-full bg-rose-100 rounded-full overflow-hidden">
                    <div class="h-full bg-rose-500"
                        style="width: {{ max(8, round(($deliveryOnlyTotal / $maxKpi) * 100)) }}%"></div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <div class="xl:col-span-2 bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Финансовая динамика</p>
                        <p class="text-xs text-gray-400 mt-1">Сравнение выручки, доставки, расходов и прибыли</p>
                    </div>
                    <span class="text-xs text-gray-500 bg-slate-50 px-3 py-1 rounded-full">за период</span>
                </div>
                <div class="mt-6 space-y-4">
                    <div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Выручка</span>
                            <span class="font-semibold text-gray-900">{{ $earningsTotal }} c</span>
                        </div>
                        <div class="mt-2 h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500"
                                style="width: {{ max(8, round(($earningsTotal / $maxKpi) * 100)) }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Доставка</span>
                            <span class="font-semibold text-gray-900">{{ $deliveryTotal }} c</span>
                        </div>
                        <div class="mt-2 h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-rose-500"
                                style="width: {{ max(8, round(($deliveryTotal / $maxKpi) * 100)) }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Расходы</span>
                            <span class="font-semibold text-gray-900">{{ $expensesTotal }} c</span>
                        </div>
                        <div class="mt-2 h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500"
                                style="width: {{ max(8, round(($expensesTotal / $maxKpi) * 100)) }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Чистая прибыль</span>
                            <span class="font-semibold text-gray-900">{{ $profitTotal }} c</span>
                        </div>
                        <div class="mt-2 h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500"
                                style="width: {{ max(8, round(($profitTotal / $maxKpi) * 100)) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Грузопотоки</p>
                        <p class="text-xs text-gray-400 mt-1">Вес и кубатура</p>
                    </div>
                    <span class="text-xs text-gray-500 bg-slate-50 px-3 py-1 rounded-full">за период</span>
                </div>
                <div class="mt-6 space-y-5">
                    <div class="rounded-xl border border-slate-100 p-4">
                        <div class="text-xs text-gray-500">Отправлено из Китая</div>
                        <div class="mt-2 text-lg font-semibold text-gray-900">
                            {{ $shipped->sum('weight') }} кг · {{ $shipped->sum('cube') }} м3
                        </div>
                    </div>
                    <div class="rounded-xl border border-slate-100 p-4">
                        <div class="text-xs text-gray-500">Получено в Таджикистане</div>
                        <div class="mt-2 text-lg font-semibold text-gray-900">
                            {{ $received->sum('weight') }} кг · {{ $received->sum('cube') }} м3
                        </div>
                    </div>
                    <div class="rounded-xl border border-slate-100 p-4">
                        <div class="text-xs text-gray-500">Кубатура (Китай / Таджикистан)</div>
                        <div class="mt-2 text-lg font-semibold text-gray-900">
                            {{ $cubChina->sum('total') }} c · {{ $cubTj->sum('total') }} c
                        </div>
                        <div class="mt-3 h-2 bg-slate-100 rounded-full overflow-hidden">
                            @php
                                $cubeMax = max(1, $cubChina->sum('total'), $cubTj->sum('total'));
                                $chinaWidth = max(8, round(($cubChina->sum('total') / $cubeMax) * 100));
                                $tjWidth = max(8, round(($cubTj->sum('total') / $cubeMax) * 100));
                            @endphp
                            <div class="h-full bg-blue-500" style="width: {{ $chinaWidth }}%"></div>
                            <div class="h-full bg-emerald-500" style="width: {{ $tjWidth }}%"></div>
                        </div>
                        <div class="mt-2 text-xs text-gray-400 flex justify-between">
                            <span>Китай</span>
                            <span>Таджикистан</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <div class="xl:col-span-2 bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Деньги по дням</p>
                        <p class="text-xs text-gray-400">Выручка и расходы за период</p>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-gray-500">
                        <div class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-indigo-500"></span>
                            Выручка
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                            Расходы
                        </div>
                    </div>
                </div>
                <div class="mt-5">
                    @php
                        $seriesA = $ordersDaily;
                        $seriesB = $expensesDaily;
                        $width = 640;
                        $height = 220;
                        $padding = 18;
                        $count = max(count($seriesA), count($seriesB));
                        $maxA = $seriesA ? max($seriesA) : 0;
                        $maxB = $seriesB ? max($seriesB) : 0;
                        $max = max(1, $maxA, $maxB);
                        $step = $count > 1 ? ($width - 2 * $padding) / ($count - 1) : 0;
                        $pointsA = [];
                        $pointsB = [];
                        for ($i = 0; $i < $count; $i++) {
                            $x = $padding + $step * $i;
                            $valA = (float) ($seriesA[$i] ?? 0);
                            $valB = (float) ($seriesB[$i] ?? 0);
                            $pointsA[] = $x . ',' . ($height - $padding - ($valA / $max) * ($height - 2 * $padding));
                            $pointsB[] = $x . ',' . ($height - $padding - ($valB / $max) * ($height - 2 * $padding));
                        }
                        $polylineA = implode(' ', $pointsA);
                        $polylineB = implode(' ', $pointsB);
                        $baseline = $height - $padding;
                        $xStart = $count ? $padding : 0;
                        $xEnd = $count ? $padding + $step * ($count - 1) : 0;
                        $areaA = $count
                            ? 'M ' .
                                $pointsA[0] .
                                ' L ' .
                                implode(' L ', $pointsA) .
                                ' L ' .
                                $xEnd .
                                ' ' .
                                $baseline .
                                ' L ' .
                                $xStart .
                                ' ' .
                                $baseline .
                                ' Z'
                            : '';
                    @endphp
                    <svg viewBox="0 0 {{ $width }} {{ $height }}" class="w-full h-56">
                        <defs>
                            <linearGradient id="moneyGradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#6366f1" stop-opacity="0.22" />
                                <stop offset="100%" stop-color="#6366f1" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                        <g stroke="#e5e7eb" stroke-width="1">
                            <line x1="{{ $padding }}" y1="{{ $padding }}" x2="{{ $width - $padding }}"
                                y2="{{ $padding }}" />
                            <line x1="{{ $padding }}" y1="{{ $height / 2 }}" x2="{{ $width - $padding }}"
                                y2="{{ $height / 2 }}" />
                            <line x1="{{ $padding }}" y1="{{ $height - $padding }}"
                                x2="{{ $width - $padding }}" y2="{{ $height - $padding }}" />
                        </g>
                        @if ($areaA)
                            <path d="{{ $areaA }}" fill="url(#moneyGradient)" />
                        @endif
                        <polyline points="{{ $polylineA }}" fill="none" stroke="#6366f1" stroke-width="3"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <polyline points="{{ $polylineB }}" fill="none" stroke="#f59e0b" stroke-width="3"
                            stroke-dasharray="6 6" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="mt-3 text-xs text-gray-400 flex justify-between">
                    <span>{{ $chartLabels[0] ?? '' }}</span>
                    <span>{{ \Illuminate\Support\Arr::last($chartLabels) ?? '' }}</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Ключевые показатели</p>
                        <p class="text-xs text-gray-400">Быстрый обзор</p>
                    </div>
                    <span class="text-xs text-slate-500 bg-slate-50 px-3 py-1 rounded-full">за период</span>
                </div>
                <div class="mt-5 space-y-3">
                    <div class="rounded-xl border border-slate-100 p-4">
                        <div class="text-xs text-gray-500">Доставка</div>
                        <div class="mt-2 text-lg font-semibold text-gray-900">{{ $deliveryTotal }} с</div>
                        <div class="mt-3 h-1.5 w-full bg-rose-100 rounded-full overflow-hidden">
                            <div class="h-full bg-rose-500"
                                style="width: {{ max(8, round(($deliveryTotal / $maxKpi) * 100)) }}%"></div>
                        </div>
                    </div>
                    <div class="rounded-xl border border-slate-100 p-4">
                        <div class="text-xs text-gray-500">Чистая прибыль</div>
                        <div class="mt-2 text-lg font-semibold text-gray-900">{{ $profitTotal }} с</div>
                        <div class="mt-3 h-1.5 w-full bg-emerald-100 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-500"
                                style="width: {{ max(8, round(($profitTotal / $maxKpi) * 100)) }}%"></div>
                        </div>
                    </div>
                    <flux:modal.trigger name="dushanbe">
                        <div class="rounded-xl border border-slate-100 p-4">
                            <div class="text-xs text-gray-500">Затраты Душанбе</div>
                            <div class="mt-2 text-lg font-semibold text-gray-900">
                                {{ $expensesDushanbe->sum('total') }} с
                            </div>
                        </div>
                    </flux:modal.trigger>
                    <flux:modal.trigger name="ivu">
                        <div class="rounded-xl border border-slate-100 p-4">
                            <div class="text-xs text-gray-500">Затраты Иву</div>
                            <div class="mt-2 text-lg font-semibold text-gray-900">
                                {{ $expensesIvu->sum('total') }} с
                            </div>
                        </div>
                    </flux:modal.trigger>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Трек-коды по дням</p>
                        <p class="text-xs text-gray-400">Получено в Иву</p>
                    </div>
                    <span class="text-xs text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                        {{ array_sum($trackcodesDaily) }} шт
                    </span>
                </div>
                <div class="mt-4">
                    @php
                        $data = $trackcodesDaily;
                        $width = 480;
                        $height = 180;
                        $padding = 16;
                        $count = count($data);
                        $max = $data ? max($data) : 0;
                        $max = max(1, $max);
                        $step = $count > 1 ? ($width - 2 * $padding) / ($count - 1) : 0;
                        $points = [];
                        foreach ($data as $i => $value) {
                            $x = $padding + $step * $i;
                            $y = $height - $padding - ($value / $max) * ($height - 2 * $padding);
                            $points[] = $x . ',' . $y;
                        }
                        $polyline = implode(' ', $points);
                        $baseline = $height - $padding;
                        $xStart = $count ? $padding : 0;
                        $xEnd = $count ? $padding + $step * ($count - 1) : 0;
                        $area = $count
                            ? 'M ' .
                                $points[0] .
                                ' L ' .
                                implode(' L ', $points) .
                                ' L ' .
                                $xEnd .
                                ' ' .
                                $baseline .
                                ' L ' .
                                $xStart .
                                ' ' .
                                $baseline .
                                ' Z'
                            : '';
                    @endphp
                    <svg viewBox="0 0 {{ $width }} {{ $height }}" class="w-full h-44">
                        <defs>
                            <linearGradient id="trackcodesGradient" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#10b981" stop-opacity="0.25" />
                                <stop offset="100%" stop-color="#10b981" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                        @if ($area)
                            <path d="{{ $area }}" fill="url(#trackcodesGradient)" />
                        @endif
                        <polyline points="{{ $polyline }}" fill="none" stroke="#10b981" stroke-width="3"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="mt-2 text-xs text-gray-400 flex justify-between">
                    <span>{{ $chartLabels[0] ?? '' }}</span>
                    <span>{{ \Illuminate\Support\Arr::last($chartLabels) ?? '' }}</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-gray-700">Новые клиенты по дням</p>
                        <p class="text-xs text-gray-400">Динамика регистраций</p>
                    </div>
                    <span class="text-xs text-sky-600 bg-sky-50 px-3 py-1 rounded-full">
                        {{ array_sum($clientsDaily) }} шт
                    </span>
                </div>
                <div class="mt-4">
                    @php
                        $data = $clientsDaily;
                        $width = 480;
                        $height = 180;
                        $padding = 14;
                        $count = count($data);
                        $max = $data ? max($data) : 0;
                        $max = max(1, $max);
                        $gap = 6;
                        $barWidth = $count > 0
                            ? max(2, ($width - 2 * $padding - ($count - 1) * $gap) / $count)
                            : 0;
                    @endphp
                    <svg viewBox="0 0 {{ $width }} {{ $height }}" class="w-full h-44">
                        <g>
                            @for ($i = 0; $i < $count; $i++)
                                @php
                                    $value = (float) ($data[$i] ?? 0);
                                    $barHeight = ($value / $max) * ($height - 2 * $padding);
                                    $x = $padding + $i * ($barWidth + $gap);
                                    $y = $height - $padding - $barHeight;
                                @endphp
                                <rect x="{{ $x }}" y="{{ $y }}" width="{{ $barWidth }}"
                                    height="{{ $barHeight }}" rx="6" fill="#0ea5e9" opacity="0.8" />
                            @endfor
                        </g>
                    </svg>
                </div>
                <div class="mt-2 text-xs text-gray-400 flex justify-between">
                    <span>{{ $chartLabels[0] ?? '' }}</span>
                    <span>{{ \Illuminate\Support\Arr::last($chartLabels) ?? '' }}</span>
                </div>
            </div>
        </div>
    @endif

    <flux:modal name="newclients" class="md:w-full w-fit overflow-x-scroll">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Спец код</flux:table.column>
                <flux:table.column>Имя</flux:table.column>
                <flux:table.column>Телефон</flux:table.column>
                <flux:table.column>Поль</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($newClients as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->code ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $item->name ?? '-' }}</flux:table.cell>
                        <flux:table.cell>
                            {{ $item->phone ?? '-' }}
                        </flux:table.cell>
                        <flux:table.cell variant="strong">{{ $item->sex == 'm' ? 'Муж' : 'Жен' }}</flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:modal>
    <flux:modal name="allexpanses" class="md:w-full w-fit overflow-x-scroll">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Сумма</flux:table.column>
                <flux:table.column>Склад \ Кубатура</flux:table.column>
                <flux:table.column>Описание</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($expenses as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->total ?? '-' }}с</flux:table.cell>
                        <flux:table.cell>{{ $item->sklad ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $item->content ?? '-' }}</flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:modal>
    <flux:modal name="dushanbe" class="md:w-full w-fit overflow-x-scroll">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Сумма</flux:table.column>
                <flux:table.column>Склад \ Кубатура</flux:table.column>
                <flux:table.column>Описание</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($expensesDushanbe as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->total ?? '-' }}с</flux:table.cell>
                        <flux:table.cell>{{ $item->sklad ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $item->content ?? '-' }}</flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:modal>
    <flux:modal name="ivu" class="md:w-full w-fit overflow-x-scroll">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Сумма</flux:table.column>
                <flux:table.column>Склад \ Кубатура</flux:table.column>
                <flux:table.column>Описание</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($expensesIvu as $item)
                    <flux:table.row>
                        <flux:table.cell>{{ $item->total ?? '-' }}с</flux:table.cell>
                        <flux:table.cell>{{ $item->sklad ?? '-' }}</flux:table.cell>
                        <flux:table.cell>{{ $item->content ?? '-' }}</flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:modal>
</div>
