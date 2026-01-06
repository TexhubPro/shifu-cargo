@php
    $statusBadge = [
        'Доставляется' => 'bg-amber-500/10 text-amber-200 border border-amber-500/30',
        'Оплачено' => 'bg-emerald-500/10 text-emerald-200 border border-emerald-500/30',
        'Возврат' => 'bg-rose-500/10 text-rose-200 border border-rose-500/30',
    ];
@endphp

<div class="min-h-screen bg-neutral-950 py-6 text-neutral-100">
    <div class="max-w-6xl mx-auto space-y-6 px-4">
        @include('livewire.deliver.partials.nav', [
            'page' => 'archive',
            'activeCount' => $activeCount,
            'archiveCount' => $archiveCount,
        ])

        <div class="bg-neutral-900 rounded-2xl border border-neutral-800 shadow-lg shadow-black/40 overflow-hidden">
            <div class="px-4 py-4 border-b border-neutral-800">
                <p class="text-lg font-semibold text-white">Архив заказов</p>
                <p class="text-sm text-neutral-400">Доставленные и возвращенные заявки.</p>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    @forelse ($orders as $order)
                        <div class="bg-neutral-950/60 rounded-2xl border border-neutral-800 p-4 space-y-4">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-xs uppercase text-neutral-500 tracking-wide">
                                        Заказ #{{ $order->id }}
                                    </p>
                                    <p class="text-lg font-semibold text-white mt-1">
                                        {{ $order->user->name ?? '—' }}
                                    </p>
                                    <p class="text-sm text-neutral-400">
                                        {{ optional($order->application)->phone ?? '—' }}
                                    </p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full {{ $statusBadge[$order->status] ?? 'bg-neutral-800 text-neutral-300' }}">
                                    {{ $order->status }}
                                </span>
                            </div>

                            <div class="text-sm text-neutral-300">
                                <p class="line-clamp-2">{{ optional($order->application)->address ?? 'Адрес не указан' }}</p>
                                <p class="text-xs text-neutral-500 mt-1">
                                    {{ $order->created_at?->format('d.m.Y H:i') }}
                                </p>
                            </div>

                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div class="flex items-center justify-between rounded-lg bg-neutral-900/60 px-3 py-2 border border-neutral-800">
                                    <span class="text-neutral-400">Доставка</span>
                                    <span class="text-neutral-100 font-semibold">
                                        {{ number_format($order->delivery_total, 2, '.', ' ') }} c
                                    </span>
                                </div>
                                <div class="flex items-center justify-between rounded-lg bg-neutral-900/60 px-3 py-2 border border-neutral-800">
                                    <span class="text-neutral-400">Итог</span>
                                    <span class="text-neutral-100 font-semibold">
                                        {{ number_format($order->total, 2, '.', ' ') }} c
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full rounded-2xl border border-dashed border-neutral-800 p-8 text-center text-neutral-500">
                            В архиве пока нет заказов.
                        </div>
                    @endforelse
                </div>
                <div class="mt-4">
                    {{ $orders->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
