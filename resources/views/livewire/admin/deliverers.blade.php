@php
    $stats = $this->stats;
    $deliverers = $this->deliverers;
    $periodLabel = $this->periodLabel;
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
    <div class="bg-white rounded-2xl p-3 shadow-sm ring-1 ring-gray-100">
        <div class="flex items-center justify-between gap-3">
            <flux:heading class="text-xl">Доставщики</flux:heading>

            <flux:modal.trigger name="deliverers-filters">
                <flux:button variant="primary" color="lime" square size="base" class="shrink-0 !text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-adjustments">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M6 3a1 1 0 0 1 .993 .883l.007 .117v3.171a3.001 3.001 0 0 1 0 5.658v7.171a1 1 0 0 1 -1.993 .117l-.007 -.117v-7.17a3.002 3.002 0 0 1 -1.995 -2.654l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-3.17a1 1 0 0 1 1 -1z" />
                        <path
                            d="M12 3a1 1 0 0 1 .993 .883l.007 .117v9.171a3.001 3.001 0 0 1 0 5.658v1.171a1 1 0 0 1 -1.993 .117l-.007 -.117v-1.17a3.002 3.002 0 0 1 -1.995 -2.654l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-9.17a1 1 0 0 1 1 -1z" />
                        <path
                            d="M18 3a1 1 0 0 1 .993 .883l.007 .117v.171a3.001 3.001 0 0 1 0 5.658v10.171a1 1 0 0 1 -1.993 .117l-.007 -.117v-10.17a3.002 3.002 0 0 1 -1.995 -2.654l-.005 -.176l.005 -.176a3.002 3.002 0 0 1 1.995 -2.654v-.17a1 1 0 0 1 1 -1z" />
                    </svg>
                </flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    <flux:modal name="deliverers-filters" flyout position="right" class="md:!min-w-[28rem]">
        <div class="space-y-5">
            <flux:heading>Фильтры доставщиков</flux:heading>

            <form class="space-y-4 grid" wire:submit.prevent="applyFilters">
                <flux:date-picker wire:model.defer="start" label="Начальная дата" />
                <flux:date-picker wire:model.defer="end" label="Конечная дата" />

                <div class="text-xs text-gray-500 bg-slate-50 px-4 py-2 rounded-xl">
                    Диапазон: {{ $periodLabel }}
                </div>

                <div class="grid grid-cols-1 gap-2 pt-2">
                    <flux:modal.close>
                        <flux:button variant="primary" color="lime" class="w-full" type="button"
                            wire:click="applyFilters">
                            Применить фильтр
                        </flux:button>
                    </flux:modal.close>
                </div>
            </form>
        </div>
    </flux:modal>


    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100 h-full">
            <div class="flex h-full flex-col">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-medium text-gray-500">Заказов в доставке</p>
                    <span
                        class="inline-flex size-8 aspect-square shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600 ring-1 ring-blue-100">
                        <flux:icon icon="clipboard-document-list" variant="mini" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-auto pt-3 text-2xl font-semibold text-gray-900">{{ $stats['count'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100 h-full">
            <div class="flex h-full flex-col">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-medium text-gray-500">Доход по доставке</p>
                    <span
                        class="inline-flex size-8 aspect-square shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100">
                        <flux:icon icon="banknotes" variant="mini" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-auto pt-3 text-2xl font-semibold text-gray-900">
                    {{ number_format($stats['sum'], 2, '.', ' ') }} c
                </p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100 h-full">
            <div class="flex h-full flex-col">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-medium text-gray-500">Средняя доставка</p>
                    <span
                        class="inline-flex size-8 aspect-square shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100">
                        <flux:icon icon="calculator" variant="mini" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-auto pt-3 text-2xl font-semibold text-gray-900">
                    {{ number_format($stats['avg'], 2, '.', ' ') }} c
                </p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-4 shadow-sm ring-1 ring-gray-100 h-full">
            <div class="flex h-full flex-col">
                <div class="flex items-start justify-between gap-3">
                    <p class="text-xs font-medium text-gray-500">Доставщиков в периоде</p>
                    <span
                        class="inline-flex size-8 aspect-square shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600 ring-1 ring-amber-100">
                        <flux:icon icon="users" variant="mini" class="h-4 w-4" />
                    </span>
                </div>
                <p class="mt-auto pt-3 text-2xl font-semibold text-gray-900">{{ count($deliverers) }}</p>
            </div>
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
                        <linearGradient id="deliveriesGradient" x1="0" y1="0" x2="0"
                            y2="1">
                            <stop offset="0%" stop-color="#f43f5e" stop-opacity="0.25" />
                            <stop offset="100%" stop-color="#f43f5e" stop-opacity="0" />
                        </linearGradient>
                    </defs>
                    <g stroke="#e5e7eb" stroke-width="1">
                        <line x1="{{ $padding }}" y1="{{ $padding }}" x2="{{ $width - $padding }}"
                            y2="{{ $padding }}" />
                        <line x1="{{ $padding }}" y1="{{ $height / 2 }}" x2="{{ $width - $padding }}"
                            y2="{{ $height / 2 }}" />
                        <line x1="{{ $padding }}" y1="{{ $height - $padding }}" x2="{{ $width - $padding }}"
                            y2="{{ $height - $padding }}" />
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
