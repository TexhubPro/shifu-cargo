<div class="space-y-3">
    <div>
        <img src="{{ asset('assets/welcome-1.jpg') }}" alt="" class="rounded-xl border border-neutral-700">
    </div>

    <div class="bg-neutral-800 border border-neutral-700 rounded-xl p-2">
        <div class="flex gap-4 items-center">
            @if($avatar)
            <flux:avatar size="lg" src="{{ $avatar }}" />
            @else
            <flux:avatar size="lg" name="Shifu Cargo" />
            @endif
            <div>
                <flux:heading class="text-xl/5 uppercase">{{ Auth::user()->name }}<span
                        class="text-lime-500 font-semibold ml-3">{{
                        Auth::user()->code
                        }}</span>
                </flux:heading>
                <flux:text>{{ Auth::user()->phone }}</flux:text>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-3 gap-3">
        <a href="{{ route('all-orders') }}" class="rounded-xl p-2 bg-neutral-800 border border-neutral-700 space-y-1">
            <div class="p-1.5 w-min rounded-lg bg-lime-500 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M3 9l4 -4l4 4m-4 -4v14"></path>
                    <path d="M21 15l-4 4l-4 -4m4 4v-14"></path>
                </svg>
            </div>
            <p class="text-sm/4 text-white font-semibold">Все трек-коды</p>
        </a>
        <a href="{{ route('add-order') }}" class="rounded-xl p-2 bg-neutral-800 border border-neutral-700 space-y-1">
            <div class="p-1.5 w-min rounded-lg bg-lime-500 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-circle-plus">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                    <path d="M9 12h6" />
                    <path d="M12 9v6" />
                </svg>
            </div>
            <p class="text-sm/4 text-white font-semibold">Добавить трек-код</p>
        </a>
        <a href="{{ route('check-order') }}" class="rounded-xl p-2 bg-neutral-800 border border-neutral-700 space-y-1">
            <div class="p-1.5 w-min rounded-lg bg-lime-500 text-white">
                <svg s xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-search">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" />
                    <path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" />
                    <path d="M18.5 19.5l2.5 2.5" />
                </svg>
            </div>
            <p class="text-sm/4 text-white font-semibold">Проверить трек-код</p>
        </a>
        <a href="{{ route('application') }}" class="rounded-xl p-2 bg-neutral-800 border border-neutral-700 space-y-1">
            <div class="p-1.5 w-min rounded-lg bg-lime-500 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-truck-delivery">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                    <path d="M3 9l4 0" />
                </svg>
            </div>
            <p class="text-sm/4 text-white font-semibold">Заказать доставка</p>
        </a>
        <a href="{{ route('queue') }}" class="rounded-xl p-2 bg-neutral-800 border border-neutral-700 space-y-1">
            <div class="p-1.5 w-min rounded-lg bg-lime-500 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-alarm">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                    <path d="M12 10l0 3l2 0" />
                    <path d="M7 4l-2.75 2" />
                    <path d="M17 4l2.75 2" />
                </svg>
            </div>
            <p class="text-sm/4 text-white font-semibold">Взять очередь</p>
        </a>
        <a href="{{ route('support') }}" class="rounded-xl p-2 bg-neutral-800 border border-neutral-700 space-y-1">
            <div class="p-1.5 w-min rounded-lg bg-lime-500 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-brand-wechat">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M16.5 10c3.038 0 5.5 2.015 5.5 4.5c0 1.397 -.778 2.645 -2 3.47l0 2.03l-1.964 -1.178a6.649 6.649 0 0 1 -1.536 .178c-3.038 0 -5.5 -2.015 -5.5 -4.5s2.462 -4.5 5.5 -4.5z" />
                    <path
                        d="M11.197 15.698c-.69 .196 -1.43 .302 -2.197 .302a8.008 8.008 0 0 1 -2.612 -.432l-2.388 1.432v-2.801c-1.237 -1.082 -2 -2.564 -2 -4.199c0 -3.314 3.134 -6 7 -6c3.782 0 6.863 2.57 7 5.785l0 .233" />
                    <path d="M10 8h.01" />
                    <path d="M7 8h.01" />
                    <path d="M15 14h.01" />
                    <path d="M18 14h.01" />
                </svg>
            </div>
            <p class="text-sm/4 text-white font-semibold">Связаться <br> с нами</p>
        </a>
        <a href="{{ route('calculator') }}" class="rounded-xl p-2 bg-neutral-800 border border-neutral-700 space-y-1">
            <div class="p-1.5 w-min rounded-lg bg-lime-500 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-calculator">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 3m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                    <path d="M8 7m0 1a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v1a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1z" />
                    <path d="M8 14l0 .01" />
                    <path d="M12 14l0 .01" />
                    <path d="M16 14l0 .01" />
                    <path d="M8 17l0 .01" />
                    <path d="M12 17l0 .01" />
                    <path d="M16 17l0 .01" />
                </svg>
            </div>
            <p class="text-sm/4 text-white font-semibold">Калькулятор грузов</p>
        </a>
        <a href="{{ route('faqs') }}" class="rounded-xl p-2 bg-neutral-800 border border-neutral-700 space-y-1">
            <div class="p-1.5 w-min rounded-lg bg-lime-500 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-question-mark">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M8 8a3.5 3 0 0 1 3.5 -3h1a3.5 3 0 0 1 3.5 3a3 3 0 0 1 -2 3a3 4 0 0 0 -2 4" />
                    <path d="M12 19l0 .01" />
                </svg>
            </div>
            <p class="text-sm/4 text-white font-semibold">Частые вопросы</p>
        </a>
        <a href="{{ route('settings') }}" class="rounded-xl p-2 bg-neutral-800 border border-neutral-700 space-y-1">
            <div class="p-1.5 w-min rounded-lg bg-lime-500 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                    <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                </svg>
            </div>
            <p class="text-sm/4 text-white font-semibold">Настройка <br> и профиль</p>
        </a>
    </div>


</div>