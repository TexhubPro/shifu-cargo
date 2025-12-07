<div class="min-h-screen bg-neutral-950 text-white py-10" wire:poll.15s="refreshQueues">
    <div class="max-w-6xl mx-auto px-4 space-y-8">
        <div class="bg-white/5 border border-white/10 rounded-3xl p-6 md:p-8 shadow-[0_20px_60px_rgba(0,0,0,0.45)]">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.4em] text-white/60">Управление очередью</p>
                    <h1 class="text-3xl font-semibold mt-2">Принимайте или отменяйте клиентов мгновенно</h1>
                </div>
                <flux:button color="white" variant="outline" wire:click="refreshQueues" class="flex items-center gap-2">

                    Обновить
                </flux:button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-xs uppercase tracking-[0.35em] text-white/60">всего сегодня</p>
                    <p class="text-3xl font-semibold mt-1">
                        {{ ($waitingQueues?->count() ?? 0) + ($approvedQueues?->count() ?? 0) }}</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                    <p class="text-xs uppercase tracking-[0.35em] text-white/60">ожидают решения</p>
                    <p class="text-3xl font-semibold mt-1">{{ $waitingQueues?->count() ?? 0 }}</p>
                </div>
                <div class="rounded-2xl border border-emerald-400/40 bg-emerald-500/10 p-4">
                    <p class="text-xs uppercase tracking-[0.35em] text-white/60">подтверждены</p>
                    <p class="text-3xl font-semibold mt-1 text-emerald-300">{{ $approvedQueues?->count() ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <section class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Ожидают подтверждения</h2>
                    <span class="text-sm text-white/60">{{ $waitingQueues?->count() ?? 0 }} клиентов</span>
                </div>

                @forelse ($waitingQueues as $queue)
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-5 space-y-4"
                        wire:key="wait-{{ $queue->id }}">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm uppercase tracking-[0.35em] text-white/60">
                                    №{{ str_pad($queue->no, 4, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-2xl font-semibold">{{ $queue->user->name ?? 'Без имени' }}</p>
                                <p class="text-sm text-white/60 mt-1">{{ $queue->user->phone ?? '—' }}</p>
                            </div>
                            <div class="text-right text-sm text-white/60">
                                <p>{{ optional($queue->created_at)->format('H:i') }}</p>
                                <p>пол: {{ $queue->sex === 'z' ? 'жен' : 'муж' }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <flux:button class="flex-1" color="lime" wire:click="approve({{ $queue->id }})">
                                Принять в кассу
                            </flux:button>
                            <flux:button class="flex-1" color="rose" variant="outline"
                                wire:click="cancel({{ $queue->id }})">
                                Отменить
                            </flux:button>
                        </div>
                    </div>
                @empty
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-6 text-center text-white/60">
                        Все клиенты уже обработаны.
                    </div>
                @endforelse
            </section>

            <section class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Подтвержденные</h2>
                    <span class="text-sm text-white/60">{{ $approvedQueues?->count() ?? 0 }} клиентов</span>
                </div>

                @forelse ($approvedQueues as $queue)
                    <div class="bg-emerald-500/10 border border-emerald-400/30 rounded-3xl p-5 space-y-3"
                        wire:key="approved-{{ $queue->id }}">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm uppercase tracking-[0.35em] text-emerald-200">Навбат подтвержден</p>
                                <p class="text-2xl font-semibold">№{{ str_pad($queue->no, 4, '0', STR_PAD_LEFT) }}</p>
                                <p class="text-sm text-white/70 mt-1">{{ $queue->user->name ?? 'Без имени' }}</p>
                            </div>
                            <flux:badge color="lime" size="lg">Готов к кассе</flux:badge>
                        </div>
                        <div class="flex items-center justify-between text-sm text-white/70">
                            <span>{{ $queue->user->phone ?? '—' }}</span>
                            <span>создан: {{ optional($queue->created_at)->format('H:i') }}</span>
                        </div>
                        <flux:button color="white" variant="outline" class="w-full"
                            wire:click="complete({{ $queue->id }})">
                            Завершить и убрать с табло
                        </flux:button>
                    </div>
                @empty
                    <div class="bg-white/5 border border-white/10 rounded-3xl p-6 text-center text-white/60">
                        Пока нет подтвержденных клиентов.
                    </div>
                @endforelse
            </section>
        </div>
    </div>
</div>
