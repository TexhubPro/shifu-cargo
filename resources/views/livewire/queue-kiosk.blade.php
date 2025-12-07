<div class="relative min-h-screen bg-neutral-950 overflow-hidden px-4 py-12 flex items-center justify-center">
    <div class="absolute inset-0 opacity-30 pointer-events-none select-none">
        <div class="absolute -top-40 -left-20 w-96 h-96 bg-emerald-500 blur-[180px] rounded-full"></div>
        <div class="absolute top-1/3 -right-40 w-[32rem] h-[32rem] bg-sky-500 blur-[220px] rounded-full"></div>
        <div class="absolute bottom-0 left-1/4 w-72 h-72 bg-emerald-700 blur-[180px] rounded-full"></div>
    </div>

    <div
        class="relative w-full max-w-4xl bg-white/5 backdrop-blur-[45px] border border-white/10 rounded-[36px] p-8 md:p-10 text-white space-y-8 shadow-[0_25px_80px_rgba(0,0,0,0.6)]">
        <div
            class="bg-gradient-to-br from-emerald-500/30 via-sky-500/30 to-transparent rounded-[30px] border border-white/10 p-5 text-center space-y-3 shadow-inner shadow-black/40">
            <p class="text-[2.2rem] uppercase tracking-[0.7em] text-white">Shifu Cargo</p>
            <h1 class="text-3xl md:text-3xl font-semibold tracking-wide">Введите номер телефона для получения очереди
            </h1>
            <p class="text-white/80 mx-auto text-base max-w-xl">
                Используйте номер, указанный при оформлении заказа. Введите ровно 9 цифр — без пробелов и дефисов.
            </p>
        </div>

        <div class="flex flex-col gap-10" x-data @queue-cleared.window="setTimeout(() => $wire.resetInput(), 5000)">

            <div class="max-w-3xl w-full mx-auto space-y-6">
                <div class="space-y-2">
                    <flux:heading size="xl" class="text-white tracking-[0.3em] uppercase text-center">Номер
                        телефона</flux:heading>
                    <p class="text-base text-white/70 text-center">Допустимы только цифры от 0 до 9.</p>
                </div>
                @php
                    $digits = $this->displayDigits;
                    $slots = 9;
                @endphp
                <div class="flex flex-wrap items-center justify-center gap-6 select-none">
                    @for ($i = 0; $i < $slots; $i++)
                        <div
                            class="w-16 h-20 rounded-3xl border border-white/25 bg-black/40 flex items-center justify-center text-4xl font-semibold tracking-widest transition
                                {{ isset($digits[$i]) ? 'text-white shadow-[0_0_20px_rgba(15,255,164,0.4)] border-emerald-400/50' : 'text-white/30' }}">
                            {{ $digits[$i] ?? '•' }}
                        </div>
                    @endfor
                </div>

                @if ($errorMessage)
                    <div
                        class="rounded-xl border border-rose-500/40 bg-rose-500/10 px-4 py-3 text-base text-rose-100 text-center">
                        {{ $errorMessage }}
                    </div>
                @endif

                @if ($statusMessage)
                    <div
                        class="rounded-xl border border-emerald-500/40 bg-emerald-500/10 px-4 py-3 text-base text-emerald-100 text-center">
                        {{ $statusMessage }}
                    </div>
                @endif

                @if ($assignedNumber)
                    <div class="text-center space-y-1">
                        <p class="text-base text-white/70">Ваш номер очереди</p>
                        <p class="text-5xl font-bold text-emerald-300 tracking-[0.3em]">{{ $assignedNumber }}</p>
                    </div>
                @endif

                @if ($awaitingConfirmation && !$showAlternateInput)
                    <div class="rounded-3xl border border-white/15 bg-black/40 p-6 space-y-4 text-center">
                        <p class="text-lg">Этот номер <span class="font-semibold">{{ $pendingPhoneDisplay }}</span>
                            сейчас с вами?</p>
                        <div class="flex flex-col md:flex-row gap-3 justify-center">
                            <flux:button color="lime" variant="primary" wire:click="confirmOriginalPhone">
                                Да, использовать этот номер
                            </flux:button>
                            <flux:button color="white" variant="outline" wire:click="startAlternatePhone">
                                Нет, отправить на другой
                            </flux:button>
                        </div>
                    </div>
                @endif

            </div>

            <div class="bg-white rounded-[28px] p-4 shadow-xl max-w-3xl w-full mx-auto">
                <div class="grid grid-cols-3 gap-4 text-black font-semibold text-2xl select-none">
                    @foreach ([1, 2, 3, 4, 5, 6, 7, 8, 9] as $number)
                        <button type="button" wire:click="appendDigit('{{ $number }}')"
                            class="h-20 rounded-3xl bg-neutral-100 hover:bg-neutral-200 transition shadow-sm">
                            {{ $number }}
                        </button>
                    @endforeach
                    <button type="button" onclick="window.location.reload()"
                        class="h-20 rounded-3xl bg-neutral-100 text-base hover:bg-neutral-200 transition shadow-sm">
                        Обновить
                    </button>
                    <button type="button" wire:click="appendDigit('0')"
                        class="h-20 rounded-3xl bg-neutral-100 hover:bg-neutral-200 transition shadow-sm">0</button>
                    <div class="grid grid-cols-2 gap-4">
                        <button type="button" wire:click="removeDigit"
                            class="h-20 rounded-3xl bg-neutral-100 text-base hover:bg-neutral-200 transition shadow-sm flex justify-center items-center">
                            <svg class="size-10" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-backspace">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M20 6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-11l-5 -5a1.5 1.5 0 0 1 0 -2l5 -5z" />
                                <path d="M12 10l4 4m0 -4l-4 4" />
                            </svg></button>
                        <button type="button" wire:click="resetInput"
                            class="h-20 rounded-3xl bg-neutral-100 text-base hover:bg-neutral-200 transition shadow-sm flex justify-center items-center">
                            <svg class="size-10" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7l16 0" />
                                <path d="M10 11l0 6" />
                                <path d="M14 11l0 6" />
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                            </svg>
                        </button>
                    </div>

                </div>

                @if ($showAlternateInput)
                    <flux:button class="w-full mt-6 h-16 text-2xl rounded-2xl" color="sky" variant="primary"
                        wire:click="confirmAlternatePhone" wire:loading.attr="disabled">
                        Отправить SMS с номером очереди
                    </flux:button>
                @else
                    <flux:button class="w-full mt-6 h-16 text-2xl rounded-2xl" color="lime" variant="primary"
                        wire:click="takeQueue" wire:loading.attr="disabled">
                        Взять очередь
                    </flux:button>
                @endif
            </div>
        </div>
    </div>
</div>
