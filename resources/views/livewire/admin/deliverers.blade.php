@php
    $stats = $this->stats;
    $deliverers = $this->deliverers;
    $data = $deliveryDaily;
    $width = 520;
    $height = 200;
    $padding = 18;
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

<div class="space-y-6">
    <div class="flex flex-col gap-2">
        <flux:heading class="text-xl">Доставщики</flux:heading>
        <flux:text class="text-sm" variant="subtle">
            Аналитика по доходам доставщиков и динамика доставки.
        </flux:text>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-3 items-end">
            <flux:date-picker wire:model.live="start" label="Начальная дата" />
            <flux:date-picker wire:model.live="end" label="Конечная дата" />
            <div class="lg:col-span-3 flex flex-col lg:flex-row gap-3 lg:justify-end">
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
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100">
            <p class="text-xs text-gray-500">Заказов в доставке</p>
            <p class="text-2xl font-semibold text-gray-900 mt-2">{{ $stats['count'] }}</p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100">
            <p class="text-xs text-gray-500">Доход по доставке</p>
            <p class="text-2xl font-semibold text-gray-900 mt-2">
                {{ number_format($stats['sum'], 2, '.', ' ') }} c
            </p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100">
            <p class="text-xs text-gray-500">Средняя доставка</p>
            <p class="text-2xl font-semibold text-gray-900 mt-2">
                {{ number_format($stats['avg'], 2, '.', ' ') }} c
            </p>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100">
            <p class="text-xs text-gray-500">Доставщиков в периоде</p>
            <p class="text-2xl font-semibold text-gray-900 mt-2">{{ count($deliverers) }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
        <div class="xl:col-span-2 bg-white rounded-2xl p-5 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-gray-700">Динамика по дням</p>
                    <p class="text-xs text-gray-400 mt-1">Сумма доставки</p>
                </div>
                <span class="text-xs text-rose-600 bg-rose-50 px-3 py-1 rounded-full">
                    {{ number_format(array_sum($deliveryDaily), 2, '.', ' ') }} c
                </span>
            </div>
            <div class="mt-4">
                <svg viewBox="0 0 {{ $width }} {{ $height }}" class="w-full h-48">
                    <defs>
                        <linearGradient id="deliveriesGradient" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#f43f5e" stop-opacity="0.25" />
                            <stop offset="100%" stop-color="#f43f5e" stop-opacity="0" />
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
                    @if ($area)
                        <path d="{{ $area }}" fill="url(#deliveriesGradient)" />
                    @endif
                    <polyline points="{{ $polyline }}" fill="none" stroke="#f43f5e" stroke-width="3"
                        stroke-linecap="round" stroke-linejoin="round" />
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
                    <p class="text-sm font-semibold text-gray-700">Топ доставщики</p>
                    <p class="text-xs text-gray-400 mt-1">Сумма заработка</p>
                </div>
                <span class="text-xs text-slate-500 bg-slate-50 px-3 py-1 rounded-full">за период</span>
            </div>
            <div class="mt-5 space-y-3">
                @forelse ($deliverers as $row)
                    <div class="rounded-xl border border-slate-100 p-4">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <div class="text-sm font-semibold text-gray-900">{{ $row['name'] }}</div>
                                <div class="text-xs text-gray-400">
                                    {{ $row['phone'] ?? 'Телефон не указан' }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1">
                                    Заказов: {{ $row['count'] }}
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-semibold text-rose-600">
                                    {{ number_format($row['sum'], 2, '.', ' ') }} c
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-xl border border-dashed border-slate-200 p-6 text-sm text-gray-400">
                        За выбранный период доставок нет.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl p-4 lg:p-6 shadow-sm ring-1 ring-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading>Список доставщиков</flux:heading>
                <flux:text class="text-sm">Доход по доставке за выбранный период.</flux:text>
            </div>
            <span class="text-xs text-gray-500 bg-slate-50 px-3 py-2 rounded-xl">
                Всего: {{ count($deliverers) }}
            </span>
        </div>
        <div class="mt-4 overflow-x-auto">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Доставщик</flux:table.column>
                    <flux:table.column>Телефон</flux:table.column>
                    <flux:table.column>Заказов</flux:table.column>
                    <flux:table.column>Сумма доставки</flux:table.column>
                </flux:table.columns>
                <flux:table.rows>
                    @foreach ($deliverers as $row)
                        <flux:table.row>
                            <flux:table.cell>{{ $row['name'] }}</flux:table.cell>
                            <flux:table.cell>{{ $row['phone'] ?? '—' }}</flux:table.cell>
                            <flux:table.cell>{{ $row['count'] }}</flux:table.cell>
                            <flux:table.cell>
                                {{ number_format($row['sum'], 2, '.', ' ') }} c
                            </flux:table.cell>
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </div>
    </div>
</div>
