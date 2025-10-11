<div class="">
    <div class="mb-5">
        <flux:heading class="text-xl">Панель управления</flux:heading>
        <flux:text class="text-base" variant="subtle">Основной раздел для контроля и навигации по системе.</flux:text>
    </div>
    <div class="space-y-4">
        <!-- Card Section -->
        <div class="">
            <!-- Grid -->
            <div
                class="grid md:grid-cols-4 border border-gray-200 shadow-2xs rounded-xl overflow-hidden dark:border-neutral-800">
                <!-- Card -->
                <a class="block p-4 md:p-5 relative bg-white hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 before:absolute before:top-0 before:start-0 before:w-full before:h-px md:before:w-px md:before:h-full before:bg-gray-200 first:before:bg-transparent dark:bg-neutral-900 dark:before:bg-neutral-800 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    href="#">
                    <div class="flex md:flex flex-col lg:flex-row gap-y-3 gap-x-5">
                        <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>

                        <div class="grow">
                            <p class="text-xs uppercase font-medium text-gray-800 dark:text-neutral-200">
                                Новые клиенты на сегодня
                            </p>
                            <h3 class="mt-1 text-xl sm:text-2xl font-semibold text-blue-600 dark:text-blue-500">
                                {{ $newUsersCount }}
                            </h3>
                        </div>
                    </div>
                </a>
                <!-- End Card -->

                <!-- Card -->
                <a class="block p-4 md:p-5 relative bg-white hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 before:absolute before:top-0 before:start-0 before:w-full before:h-px md:before:w-px md:before:h-full before:bg-gray-200 first:before:bg-transparent dark:bg-neutral-900 dark:before:bg-neutral-800 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    href="#">
                    <div class="flex md:flex flex-col lg:flex-row gap-y-3 gap-x-5">
                        <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 22h14" />
                            <path d="M5 2h14" />
                            <path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22" />
                            <path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2" />
                        </svg>

                        <div class="grow">
                            <p class="text-xs uppercase font-medium text-gray-800 dark:text-neutral-200">
                                Заказы на сегодня
                            </p>
                            <h3 class="mt-1 text-xl sm:text-2xl font-semibold text-blue-600 dark:text-blue-500">
                                {{ $trackcodesCount }}
                            </h3>
                        </div>
                    </div>
                </a>
                <!-- End Card -->

                <!-- Card -->
                <a class="block p-4 md:p-5 relative bg-white hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 before:absolute before:top-0 before:start-0 before:w-full before:h-px md:before:w-px md:before:h-full before:bg-gray-200 first:before:bg-transparent dark:bg-neutral-900 dark:before:bg-neutral-800 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    href="#">
                    <div class="flex md:flex flex-col lg:flex-row gap-y-3 gap-x-5">
                        <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 11V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6" />
                            <path d="m12 12 4 10 1.7-4.3L22 16Z" />
                        </svg>

                        <div class="grow">
                            <p class="text-xs uppercase font-medium text-gray-800 dark:text-neutral-200">
                                Заработок на сегодня
                            </p>
                            <h3 class="mt-1 text-xl sm:text-2xl font-semibold text-blue-600 dark:text-blue-500">
                                {{ $ordersSum }}c
                            </h3>
                        </div>
                    </div>
                </a>
                <!-- End Card -->

                <!-- Card -->
                <a class="block p-4 md:p-5 relative bg-white hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 before:absolute before:top-0 before:start-0 before:w-full before:h-px md:before:w-px md:before:h-full before:bg-gray-200 first:before:bg-transparent dark:bg-neutral-900 dark:before:bg-neutral-800 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    href="#">
                    <div class="flex md:flex flex-col lg:flex-row gap-y-3 gap-x-5">
                        <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12s2.545-5 7-5c4.454 0 7 5 7 5s-2.546 5-7 5c-4.455 0-7-5-7-5z" />
                            <path d="M12 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                            <path d="M21 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2" />
                            <path d="M21 7V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2" />
                        </svg>

                        <div class="grow">
                            <p class="text-xs uppercase font-medium text-gray-800 dark:text-neutral-200">
                                Затраты на сегодня
                            </p>
                            <h3 class="mt-1 text-xl sm:text-2xl font-semibold text-blue-600 dark:text-blue-500">
                                {{ $expensesSum }}c
                            </h3>
                        </div>
                    </div>
                </a>
                <!-- End Card -->
            </div>
            <!-- End Grid -->
        </div>
        <!-- End Card Section -->
        <!-- Card Section -->
        <div class="">
            <!-- Grid -->
            <div
                class="grid md:grid-cols-4 border border-gray-200 shadow-2xs rounded-xl overflow-hidden dark:border-neutral-800">
                <!-- Card -->
                <a class="block p-4 md:p-5 relative bg-white hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 before:absolute before:top-0 before:start-0 before:w-full before:h-px md:before:w-px md:before:h-full before:bg-gray-200 first:before:bg-transparent dark:bg-neutral-900 dark:before:bg-neutral-800 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    href="#">
                    <div class="flex md:flex flex-col lg:flex-row gap-y-3 gap-x-5">
                        <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>

                        <div class="grow">
                            <p class="text-xs uppercase font-medium text-gray-800 dark:text-neutral-200">
                                Новые клиенты на месяц
                            </p>
                            <h3 class="mt-1 text-xl sm:text-2xl font-semibold text-blue-600 dark:text-blue-500">
                                {{ $montnewUsersCount }}
                            </h3>
                        </div>
                    </div>
                </a>
                <!-- End Card -->

                <!-- Card -->
                <a class="block p-4 md:p-5 relative bg-white hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 before:absolute before:top-0 before:start-0 before:w-full before:h-px md:before:w-px md:before:h-full before:bg-gray-200 first:before:bg-transparent dark:bg-neutral-900 dark:before:bg-neutral-800 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    href="#">
                    <div class="flex md:flex flex-col lg:flex-row gap-y-3 gap-x-5">
                        <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 22h14" />
                            <path d="M5 2h14" />
                            <path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22" />
                            <path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2" />
                        </svg>

                        <div class="grow">
                            <p class="text-xs uppercase font-medium text-gray-800 dark:text-neutral-200">
                                Заказы на месяц
                            </p>
                            <h3 class="mt-1 text-xl sm:text-2xl font-semibold text-blue-600 dark:text-blue-500">
                                {{ $monttrackcodesCount }}
                            </h3>
                        </div>
                    </div>
                </a>
                <!-- End Card -->

                <!-- Card -->
                <a class="block p-4 md:p-5 relative bg-white hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 before:absolute before:top-0 before:start-0 before:w-full before:h-px md:before:w-px md:before:h-full before:bg-gray-200 first:before:bg-transparent dark:bg-neutral-900 dark:before:bg-neutral-800 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    href="#">
                    <div class="flex md:flex flex-col lg:flex-row gap-y-3 gap-x-5">
                        <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 11V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6" />
                            <path d="m12 12 4 10 1.7-4.3L22 16Z" />
                        </svg>

                        <div class="grow">
                            <p class="text-xs uppercase font-medium text-gray-800 dark:text-neutral-200">
                                Заработок на месяц
                            </p>
                            <h3 class="mt-1 text-xl sm:text-2xl font-semibold text-blue-600 dark:text-blue-500">
                                {{ $montordersSum }}c
                            </h3>
                        </div>
                    </div>
                </a>
                <!-- End Card -->

                <!-- Card -->
                <a class="block p-4 md:p-5 relative bg-white hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 before:absolute before:top-0 before:start-0 before:w-full before:h-px md:before:w-px md:before:h-full before:bg-gray-200 first:before:bg-transparent dark:bg-neutral-900 dark:before:bg-neutral-800 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    href="#">
                    <div class="flex md:flex flex-col lg:flex-row gap-y-3 gap-x-5">
                        <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12s2.545-5 7-5c4.454 0 7 5 7 5s-2.546 5-7 5c-4.455 0-7-5-7-5z" />
                            <path d="M12 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                            <path d="M21 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2" />
                            <path d="M21 7V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2" />
                        </svg>

                        <div class="grow">
                            <p class="text-xs uppercase font-medium text-gray-800 dark:text-neutral-200">
                                Затраты на месяц
                            </p>
                            <h3 class="mt-1 text-xl sm:text-2xl font-semibold text-blue-600 dark:text-blue-500">
                                {{ $montexpensesSum }}c
                            </h3>
                        </div>
                    </div>
                </a>
                <!-- End Card -->
            </div>
            <!-- End Grid -->
        </div>
        <!-- End Card Section -->
        <!-- Card Section -->
        <div class="">
            <!-- Grid -->
            <div
                class="grid md:grid-cols-4 border border-gray-200 shadow-2xs rounded-xl overflow-hidden dark:border-neutral-800">
                <!-- Card -->
                <a class="block p-4 md:p-5 relative bg-white hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 before:absolute before:top-0 before:start-0 before:w-full before:h-px md:before:w-px md:before:h-full before:bg-gray-200 first:before:bg-transparent dark:bg-neutral-900 dark:before:bg-neutral-800 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    href="#">
                    <div class="flex md:flex flex-col lg:flex-row gap-y-3 gap-x-5">
                        <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>

                        <div class="grow">
                            <p class="text-xs uppercase font-medium text-gray-800 dark:text-neutral-200">
                                Остаток товаров на складе
                            </p>
                            <h3 class="mt-1 text-xl sm:text-2xl font-semibold text-blue-600 dark:text-blue-500">
                                {{ $ostatok->count() }}
                            </h3>
                        </div>
                    </div>
                </a>
                <!-- End Card -->

                <!-- Card -->
                <a class="block p-4 md:p-5 relative bg-white hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 before:absolute before:top-0 before:start-0 before:w-full before:h-px md:before:w-px md:before:h-full before:bg-gray-200 first:before:bg-transparent dark:bg-neutral-900 dark:before:bg-neutral-800 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    href="#">
                    <div class="flex md:flex flex-col lg:flex-row gap-y-3 gap-x-5">
                        <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 22h14" />
                            <path d="M5 2h14" />
                            <path d="M17 22v-4.172a2 2 0 0 0-.586-1.414L12 12l-4.414 4.414A2 2 0 0 0 7 17.828V22" />
                            <path d="M7 2v4.172a2 2 0 0 0 .586 1.414L12 12l4.414-4.414A2 2 0 0 0 17 6.172V2" />
                        </svg>

                        <div class="grow">
                            <p class="text-xs uppercase font-medium text-gray-800 dark:text-neutral-200">
                                Заработок из доставки
                            </p>
                            <h3 class="mt-1 text-xl sm:text-2xl font-semibold text-blue-600 dark:text-blue-500">
                                {{ $total_delivery }}c
                            </h3>
                        </div>
                    </div>
                </a>
                <!-- End Card -->

                <!-- Card -->
                <a class="block p-4 md:p-5 relative bg-white hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 before:absolute before:top-0 before:start-0 before:w-full before:h-px md:before:w-px md:before:h-full before:bg-gray-200 first:before:bg-transparent dark:bg-neutral-900 dark:before:bg-neutral-800 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    href="#">
                    <div class="flex md:flex flex-col lg:flex-row gap-y-3 gap-x-5">
                        <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 11V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h6" />
                            <path d="m12 12 4 10 1.7-4.3L22 16Z" />
                        </svg>

                        <div class="grow">
                            <p class="text-xs uppercase font-medium text-gray-800 dark:text-neutral-200">
                                Затраты склад душанбе
                            </p>
                            <h3 class="mt-1 text-xl sm:text-2xl font-semibold text-blue-600 dark:text-blue-500">
                                {{ $expences_dusanbe }}c
                            </h3>
                        </div>
                    </div>
                </a>
                <!-- End Card -->

                <!-- Card -->
                <a class="block p-4 md:p-5 relative bg-white hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 before:absolute before:top-0 before:start-0 before:w-full before:h-px md:before:w-px md:before:h-full before:bg-gray-200 first:before:bg-transparent dark:bg-neutral-900 dark:before:bg-neutral-800 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800"
                    href="#">
                    <div class="flex md:flex flex-col lg:flex-row gap-y-3 gap-x-5">
                        <svg class="shrink-0 size-5 text-gray-400 dark:text-neutral-600"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12s2.545-5 7-5c4.454 0 7 5 7 5s-2.546 5-7 5c-4.455 0-7-5-7-5z" />
                            <path d="M12 13a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                            <path d="M21 17v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2" />
                            <path d="M21 7V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2" />
                        </svg>

                        <div class="grow">
                            <p class="text-xs uppercase font-medium text-gray-800 dark:text-neutral-200">
                                Затраты склад Иву
                            </p>
                            <h3 class="mt-1 text-xl sm:text-2xl font-semibold text-blue-600 dark:text-blue-500">
                                {{ $expences_ivu }}c
                            </h3>
                        </div>
                    </div>
                </a>
                <!-- End Card -->
            </div>
            <!-- End Grid -->
        </div>
        <!-- End Card Section -->
    </div>

</div>