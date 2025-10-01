<div class="space-y-4">
    <div class="bg-neutral-800 border border-neutral-700 rounded-xl p-2">
        <div class="flex gap-4 items-center">
            @if($avatar)
            <flux:avatar size="lg" src="{{ $avatar }}" />
            @else
            <flux:avatar size="lg" name="Shifu Cargo" />
            @endif
            <div>
                <flux:heading class="text-xl/5">{{ Auth::user()->name }}</flux:heading>
                <flux:text>{{ Auth::user()->phone }}</flux:text>
            </div>
        </div>
    </div>
    <div class="bg-neutral-800 border border-neutral-700 rounded-xl py-2">
        <div class="grid grid-cols-4 w-full gap-2">
            <a href="{{ route('all-orders') }}"
                class="w-full grid justify-center gap-1 group cursor-pointer text-sm text-center">
                <svg class="size-12 p-2 bg-neutral-700 group-hover:bg-lime-500 rounded-full text-white mx-auto duration-200"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M3 9l4 -4l4 4m-4 -4v14"></path>
                    <path d="M21 15l-4 4l-4 -4m4 4v-14"></path>
                </svg>
                <span class="text-white text-sm/4">Все трек-коды</span>
            </a>
            <a href="{{ route('add-order') }}"
                class="w-full grid justify-center gap-1 group cursor-pointer text-sm text-center">

                <svg class="size-12 p-2 bg-neutral-700 group-hover:bg-lime-500 rounded-full text-white mx-auto duration-200"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-circle-plus">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                    <path d="M9 12h6" />
                    <path d="M12 9v6" />
                </svg>
                <span class="text-white text-sm/4">Добавить трек-код</span>
            </a>
            <a href="{{ route('check-order') }}"
                class="w-full grid justify-center gap-1 group cursor-pointer text-sm text-center">
                <svg class="size-12 p-2 bg-neutral-700 group-hover:bg-lime-500 rounded-full text-white mx-auto duration-200"
                    s xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-search">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M12 21h-5a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v4.5" />
                    <path d="M16.5 17.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" />
                    <path d="M18.5 19.5l2.5 2.5" />
                </svg>
                <span class="text-white text-sm/4">Проверить трек-код</span>
            </a>
            <a href="{{ route('application') }}"
                class="w-full grid justify-center gap-1 group cursor-pointer text-sm text-center">
                <svg class="size-12 p-2 bg-neutral-700 group-hover:bg-lime-500 rounded-full text-white mx-auto duration-200"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-truck-delivery">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                    <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                    <path d="M3 9l4 0" />
                </svg>
                <span class="text-white text-sm/4">Заказать доставка</span>
            </a>
            <a href="{{ route('queue') }}"
                class="w-full grid justify-center gap-1 group cursor-pointer text-sm text-center">
                <svg class="size-12 p-2 bg-neutral-700 group-hover:bg-lime-500 rounded-full text-white mx-auto duration-200"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-alarm">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 13m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                    <path d="M12 10l0 3l2 0" />
                    <path d="M7 4l-2.75 2" />
                    <path d="M17 4l2.75 2" />
                </svg>
                <span class="text-white text-sm/4">Взять очередь</span>
            </a>
            <a href="{{ route('support') }}"
                class="w-full grid justify-center gap-1 group cursor-pointer text-sm text-center">
                <svg class="size-12 p-2 bg-neutral-700 group-hover:bg-lime-500 rounded-full text-white mx-auto duration-200"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
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
                <span class="text-white text-sm/4">Связаться с нами</span>
            </a>
            <a href="{{ route('calculator') }}"
                class="w-full grid justify-center gap-1 group cursor-pointer text-sm text-center">
                <svg class="size-12 p-2 bg-neutral-700 group-hover:bg-lime-500 rounded-full text-white mx-auto duration-200"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
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
                <span class="text-white text-sm/4">Калькулятор грузов</span>
            </a>
            <a href="{{ route('faqs') }}"
                class="w-full grid justify-center gap-1 group cursor-pointer text-sm text-center">
                <svg class="size-12 p-2 bg-neutral-700 group-hover:bg-lime-500 rounded-full text-white mx-auto duration-200"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-question-mark">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M8 8a3.5 3 0 0 1 3.5 -3h1a3.5 3 0 0 1 3.5 3a3 3 0 0 1 -2 3a3 4 0 0 0 -2 4" />
                    <path d="M12 19l0 .01" />
                </svg>
                <span class="text-white text-sm/4">Частые вопросы</span>
            </a>


        </div>
    </div>
    <div class="grid grid-cols-2 gap-4">

        <!-- Заказы за месяц -->
        <div class="tbd2k i1iav aqyoh rsdjd kvbsq er6t7 hj07t dark:bg-neutral-800 dark:border-neutral-700">
            <div class="sm:flex o1uif">
                <svg class="text-neutral-400 mb-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-sort-ascending-shapes">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 15l3 3l3 -3" />
                    <path d="M7 6v12" />
                    <path d="M14 5a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1v-4z" />
                    <path d="M17 14l-3.5 6h7z" />
                </svg>
                <div class="xafg0 hlt95 space-y-1">
                    <h2 class="as39u w4xo0 ah4ps dark:text-neutral-400">Все заказы</h2>
                    <p class="tbkeq ba4pq cnneu jf8im dark:text-neutral-200">22</p>
                </div>
            </div>
        </div>

        <!-- Новые клиенты -->
        <div class="tbd2k i1iav aqyoh rsdjd kvbsq er6t7 hj07t dark:bg-neutral-800 dark:border-neutral-700">
            <div class="sm:flex o1uif">
                <svg class="text-neutral-400 mb-2" s xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-building-skyscraper">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 21l18 0" />
                    <path d="M5 21v-14l8 -4v18" />
                    <path d="M19 21v-10l-6 -4" />
                    <path d="M9 9l0 .01" />
                    <path d="M9 12l0 .01" />
                    <path d="M9 15l0 .01" />
                    <path d="M9 18l0 .01" />
                </svg>
                <div class="xafg0 hlt95 space-y-1">
                    <h2 class="as39u w4xo0 ah4ps dark:text-neutral-400">Заказы в Иву</h2>
                    <p class="tbkeq ba4pq cnneu jf8im dark:text-neutral-200">19</p>
                </div>
            </div>
        </div>

        <!-- В ожидании -->
        <div class="tbd2k i1iav aqyoh rsdjd kvbsq er6t7 hj07t dark:bg-neutral-800 dark:border-neutral-700">
            <div class="sm:flex o1uif">
                <svg class="text-neutral-400 mb-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-unity">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 3l6 4v7" />
                    <path d="M18 17l-6 4l-6 -4" />
                    <path d="M4 14v-7l6 -4" />
                    <path d="M4 7l8 5v9" />
                    <path d="M20 7l-8 5" />
                </svg>
                <div class="xafg0 hlt95 space-y-1">
                    <h2 class="as39u w4xo0 ah4ps dark:text-neutral-400">Заказы в Душанбе</h2>
                    <p class="tbkeq ba4pq cnneu jf8im dark:text-neutral-200">2</p>
                </div>
            </div>
        </div>

        <!-- Доставлено -->
        <div class="tbd2k i1iav aqyoh rsdjd kvbsq er6t7 hj07t dark:bg-neutral-800 dark:border-neutral-700">
            <div class="sm:flex o1uif">
                <svg class="text-neutral-400 mb-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-rosette-discount-check">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M5 7.2a2.2 2.2 0 0 1 2.2 -2.2h1a2.2 2.2 0 0 0 1.55 -.64l.7 -.7a2.2 2.2 0 0 1 3.12 0l.7 .7c.412 .41 .97 .64 1.55 .64h1a2.2 2.2 0 0 1 2.2 2.2v1c0 .58 .23 1.138 .64 1.55l.7 .7a2.2 2.2 0 0 1 0 3.12l-.7 .7a2.2 2.2 0 0 0 -.64 1.55v1a2.2 2.2 0 0 1 -2.2 2.2h-1a2.2 2.2 0 0 0 -1.55 .64l-.7 .7a2.2 2.2 0 0 1 -3.12 0l-.7 -.7a2.2 2.2 0 0 0 -1.55 -.64h-1a2.2 2.2 0 0 1 -2.2 -2.2v-1a2.2 2.2 0 0 0 -.64 -1.55l-.7 -.7a2.2 2.2 0 0 1 0 -3.12l.7 -.7a2.2 2.2 0 0 0 .64 -1.55v-1" />
                    <path d="M9 12l2 2l4 -4" />
                </svg>
                <div class="xafg0 hlt95 space-y-1">
                    <h2 class="as39u w4xo0 ah4ps dark:text-neutral-400">Полученные заказы</h2>
                    <p class="tbkeq ba4pq cnneu jf8im dark:text-neutral-200">1</p>
                </div>
            </div>
        </div>

    </div>
</div>