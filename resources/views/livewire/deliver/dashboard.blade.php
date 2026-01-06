@php
    $earningsMax = max(1, (float) (collect($dailyEarnings)->max() ?? 0));
    $deliveriesMax = max(1, (int) (collect($dailyDeliveries)->max() ?? 0));
@endphp

<div class="min-h-screen bg-neutral-950 py-6 text-neutral-100">
    <div class="max-w-6xl mx-auto space-y-6 px-4">
        @include('livewire.deliver.partials.nav', [
            'page' => 'dashboard',
            'activeCount' => $activeCount,
            'archiveCount' => $archiveCount,
        ])

        <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-4 shadow-lg shadow-black/40">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-3 items-end">
                <flux:date-picker wire:model.live="start" label="С" />
                <flux:date-picker wire:model.live="end" label="По" />
                <div class="lg:col-span-2 flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <flux:button variant="primary" color="lime" wire:click="updatePeriod">
                        Применить период
                    </flux:button>
                    <div class="flex items-center gap-3 rounded-xl bg-neutral-950/50 px-4 py-2 text-sm text-neutral-400">
                        <span>Диапазон:</span>
                        <span class="font-semibold text-neutral-100">
                            {{ \Carbon\Carbon::parse($start)->format('d.m.Y') }} —
                            {{ \Carbon\Carbon::parse($end)->format('d.m.Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-4 shadow-lg shadow-black/40">
                <p class="text-xs uppercase text-neutral-500 tracking-wide">Доставлено</p>
                <p class="text-3xl font-semibold text-emerald-300 mt-2">{{ $deliveredCount }}</p>
                <p class="text-sm text-neutral-400 mt-1">За период</p>
            </div>
            <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-4 shadow-lg shadow-black/40">
                <p class="text-xs uppercase text-neutral-500 tracking-wide">Возвраты</p>
                <p class="text-3xl font-semibold text-rose-300 mt-2">{{ $returnedCount }}</p>
                <p class="text-sm text-neutral-400 mt-1">За период</p>
            </div>
            <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-4 shadow-lg shadow-black/40">
                <p class="text-xs uppercase text-neutral-500 tracking-wide">Заработано</p>
                <p class="text-3xl font-semibold text-white mt-2">
                    {{ number_format($totalEarned, 2, '.', ' ') }} c
                </p>
                <p class="text-sm text-neutral-400 mt-1">Доход по доставке</p>
            </div>
            <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-4 shadow-lg shadow-black/40">
                <p class="text-xs uppercase text-neutral-500 tracking-wide">Успех</p>
                <p class="text-3xl font-semibold text-white mt-2">{{ $successRate }}%</p>
                <p class="text-sm text-neutral-400 mt-1">Доставлено без возврата</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
            <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-5 shadow-lg shadow-black/40">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-300 font-medium">Доход по дням</p>
                        <p class="text-xs text-neutral-500">Сумма доставки</p>
                    </div>
                    <span class="text-xs text-neutral-500">
                        {{ number_format($totalEarned, 2, '.', ' ') }} c
                    </span>
                </div>
                <div class="mt-5">
                    <div class="flex items-end gap-2 h-28">
                        @foreach ($dailyEarnings as $value)
                            @php
                                $height = max(6, round(($value / $earningsMax) * 96));
                            @endphp
                            <div class="flex-1 flex flex-col items-center gap-2">
                                <div class="h-24 w-full flex items-end">
                                    <div class="w-full rounded-full bg-emerald-500/80" style="height: {{ $height }}px"></div>
                                </div>
                                <span class="text-[10px] text-neutral-500">{{ $dailyLabels[$loop->index] ?? '' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="bg-neutral-900 rounded-2xl border border-neutral-800 p-5 shadow-lg shadow-black/40">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-neutral-300 font-medium">Доставки по дням</p>
                        <p class="text-xs text-neutral-500">Количество заказов</p>
                    </div>
                    <span class="text-xs text-neutral-500">
                        Всего: {{ $deliveredCount }}
                    </span>
                </div>
                <div class="mt-5">
                    <div class="flex items-end gap-2 h-28">
                        @foreach ($dailyDeliveries as $value)
                            @php
                                $height = max(6, round(($value / $deliveriesMax) * 96));
                            @endphp
                            <div class="flex-1 flex flex-col items-center gap-2">
                                <div class="h-24 w-full flex items-end">
                                    <div class="w-full rounded-full bg-indigo-500/80" style="height: {{ $height }}px"></div>
                                </div>
                                <span class="text-[10px] text-neutral-500">{{ $dailyLabels[$loop->index] ?? '' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
