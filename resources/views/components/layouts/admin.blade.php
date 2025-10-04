<!DOCTYPE>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" html class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('obfuscated.min.css') }}">
    <title>{{ $title ?? 'Page Title' }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-neutral-100">
    <!-- Navigation Toggle -->
    {{-- <div class="lg:hidden py-16 text-center">
        <button type="button"
            class="py-2 px-3 inline-flex justify-center items-center gap-x-2 text-start bg-gray-800 border border-gray-800 text-white text-sm font-medium rounded-lg shadow-2xs align-middle hover:bg-gray-950 focus:outline-hidden focus:bg-gray-900 dark:bg-white dark:text-neutral-800 dark:hover:bg-neutral-200 dark:focus:bg-neutral-200"
            aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-sidebar-empty-content"
            aria-label="Toggle navigation" data-hs-overlay="#hs-sidebar-empty-content">
            Open
        </button>
    </div> --}}
    <div>
        <div class="lg:pl-64">
            <div class="w-full bg-neutral-950 p-3 flex justify-between lg:justify-end items-center sticky top-0">
                <flux:button size="sm" class="lg:hidden" icon="bars-3" aria-haspopup="dialog" aria-expanded="false"
                    aria-controls="hs-sidebar-empty-content" aria-label="Toggle navigation"
                    data-hs-overlay="#hs-sidebar-empty-content" />
                <img src="{{ asset('logo/white_logo.svg') }}" class="h-8 lg:hidden" alt="">
                @livewire('components.avatar')
            </div>
            <div class="p-3 space-y-3">
                {{ $slot }}
                @livewire('components.alert')
            </div>
        </div>
    </div>
    <!-- End Navigation Toggle -->

    <!-- Sidebar -->
    <div id="hs-sidebar-empty-content" class="hs-overlay [--auto-close:lg] lg:block lg:translate-x-0 lg:end-auto lg:bottom-0 w-64
hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform h-full hidden fixed top-0 start-0 bottom-0 z-60
bg-lime-500 border-e border-gray-200 dark:bg-lime-500 dark:border-neutral-700" role="dialog" tabindex="-1"
        aria-label="Sidebar">
        <div class="relative flex flex-col h-full max-h-full ">
            <!-- Header -->
            <header class=" p-4 flex justify-between items-center gap-x-2">

                <img src="{{ asset('logo/white_logo.svg') }}" class="h-15 bg-lime-950 px-3 pt-3 pb-1.5 rounded-xl"
                    alt="">
                <div class="lg:hidden -me-2">
                    <!-- Close Button -->
                    <button type="button"
                        class="flex justify-center items-center gap-x-3 size-6 bg-white border border-gray-200 text-sm text-gray-600 hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:hover:text-neutral-200 dark:focus:text-neutral-200"
                        data-hs-overlay="#hs-sidebar-empty-content">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                        <span class="sr-only">Close</span>
                    </button>
                    <!-- End Close Button -->
                </div>
            </header>
            <!-- End Header -->

            <!-- Body -->
            <nav
                class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
                <main class="">
                    <div class="hs-accordion-group pb-0 px-2  w-full flex flex-col flex-wrap"
                        data-hs-accordion-always-open>
                        <a class=" flex items-center gap-x-3.5 font-semibold py-2 px-2.5  text-base text-white rounded-lg hover:bg-lime-600 focus:outline-hidden focus:bg-lime-700  dark:hover:bg-lime-600 dark:focus:bg-lime-700 dark:text-white"
                            href="{{ route('admin.dashboard') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-dashboard">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M13.45 11.55l2.05 -2.05" />
                                <path d="M6.4 20a9 9 0 1 1 11.2 0z" />
                            </svg>
                            Панель управления
                        </a>
                        <a class=" flex items-center gap-x-3.5 font-semibold py-2 px-2.5  text-base text-white rounded-lg hover:bg-lime-600 focus:outline-hidden focus:bg-lime-700  dark:hover:bg-lime-600 dark:focus:bg-lime-700 dark:text-white"
                            href="{{ route('admin.china') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-packages">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                                <path d="M2 13.5v5.5l5 3" />
                                <path d="M7 16.545l5 -3.03" />
                                <path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                                <path d="M12 19l5 3" />
                                <path d="M17 16.5l5 -3" />
                                <path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5" />
                                <path d="M7 5.03v5.455" />
                                <path d="M12 8l5 -3" />
                            </svg>
                            Склад Хитой
                        </a>
                        <a class=" flex items-center gap-x-3.5 font-semibold py-2 px-2.5  text-base text-white rounded-lg hover:bg-lime-600 focus:outline-hidden focus:bg-lime-700  dark:hover:bg-lime-600 dark:focus:bg-lime-700 dark:text-white"
                            href="{{ route('admin.dushanbe') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-package">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                                <path d="M12 12l8 -4.5" />
                                <path d="M12 12l0 9" />
                                <path d="M12 12l-8 -4.5" />
                                <path d="M16 5.25l-8 4.5" />
                            </svg>
                            Склад Душанбе
                        </a>
                        <a class=" flex items-center gap-x-3.5 font-semibold py-2 px-2.5  text-base text-white rounded-lg hover:bg-lime-600 focus:outline-hidden focus:bg-lime-700  dark:hover:bg-lime-600 dark:focus:bg-lime-700 dark:text-white"
                            href="{{ route('admin.trackcodes') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-scan">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7v-1a2 2 0 0 1 2 -2h2" />
                                <path d="M4 17v1a2 2 0 0 0 2 2h2" />
                                <path d="M16 4h2a2 2 0 0 1 2 2v1" />
                                <path d="M16 20h2a2 2 0 0 0 2 -2v-1" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Трек-коды
                        </a>
                        <a class=" flex items-center gap-x-3.5 font-semibold py-2 px-2.5  text-base text-white rounded-lg hover:bg-lime-600 focus:outline-hidden focus:bg-lime-700  dark:hover:bg-lime-600 dark:focus:bg-lime-700 dark:text-white"
                            href="{{ route('admin.customers') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                            </svg>
                            Клиенты и коды
                        </a>
                        <a class=" flex items-center gap-x-3.5 font-semibold py-2 px-2.5  text-base text-white rounded-lg hover:bg-lime-600 focus:outline-hidden focus:bg-lime-700  dark:hover:bg-lime-600 dark:focus:bg-lime-700 dark:text-white"
                            href="{{ route('admin.applications') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-truck-delivery">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                <path d="M5 17h-2v-4m-1 -8h11v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" />
                                <path d="M3 9l4 0" />
                            </svg>
                            Заявки на доставку
                        </a>
                        <a class=" flex items-center gap-x-3.5 font-semibold py-2 px-2.5  text-base text-white rounded-lg hover:bg-lime-600 focus:outline-hidden focus:bg-lime-700  dark:hover:bg-lime-600 dark:focus:bg-lime-700 dark:text-white"
                            href="{{ route('admin.smsbulk') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-message-share">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8 9h8" />
                                <path d="M8 13h6" />
                                <path d="M13 18l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v6" />
                                <path d="M16 22l5 -5" />
                                <path d="M21 21.5v-4.5h-4.5" />
                            </svg>
                            СМС рассылка
                        </a>
                        <a class=" flex items-center gap-x-3.5 font-semibold py-2 px-2.5  text-base text-white rounded-lg hover:bg-lime-600 focus:outline-hidden focus:bg-lime-700  dark:hover:bg-lime-600 dark:focus:bg-lime-700 dark:text-white"
                            href="{{ route('admin.chats') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-messages">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10" />
                                <path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2" />
                            </svg>
                            Чат склиентами
                        </a>
                        <a class=" flex items-center gap-x-3.5 font-semibold py-2 px-2.5  text-base text-white rounded-lg hover:bg-lime-600 focus:outline-hidden focus:bg-lime-700  dark:hover:bg-lime-600 dark:focus:bg-lime-700 dark:text-white"
                            href="{{ route('admin.packages') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-stack-push">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M6 10l-2 1l8 4l8 -4l-2 -1" />
                                <path d="M4 15l8 4l8 -4" />
                                <path d="M12 4v7" />
                                <path d="M15 8l-3 3l-3 -3" />
                            </svg>
                            Регистрация грузы
                        </a>
                        <a class=" flex items-center gap-x-3.5 font-semibold py-2 px-2.5  text-base text-white rounded-lg hover:bg-lime-600 focus:outline-hidden focus:bg-lime-700  dark:hover:bg-lime-600 dark:focus:bg-lime-700 dark:text-white"
                            href="{{ route('admin.emplyones') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-hexagon">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 13a3 3 0 1 0 0 -6a3 3 0 0 0 0 6z" />
                                <path d="M6.201 18.744a4 4 0 0 1 3.799 -2.744h4a4 4 0 0 1 3.798 2.741" />
                                <path
                                    d="M19.875 6.27c.7 .398 1.13 1.143 1.125 1.948v7.284c0 .809 -.443 1.555 -1.158 1.948l-6.75 4.27a2.269 2.269 0 0 1 -2.184 0l-6.75 -4.27a2.225 2.225 0 0 1 -1.158 -1.948v-7.285c0 -.809 .443 -1.554 1.158 -1.947l6.75 -3.98a2.33 2.33 0 0 1 2.25 0l6.75 3.98h-.033z" />
                            </svg>
                            Сотрудники
                        </a>
                        <a class=" flex items-center gap-x-3.5 font-semibold py-2 px-2.5  text-base text-white rounded-lg hover:bg-lime-600 focus:outline-hidden focus:bg-lime-700  dark:hover:bg-lime-600 dark:focus:bg-lime-700 dark:text-white"
                            href="{{ route('admin.settings') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path
                                    d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                            </svg>
                            Настройки Т-БОТ
                        </a>

                    </div>
                </main>
            </nav>
            <!-- End Body -->
        </div>
    </div>
    <!-- End Sidebar -->
    @fluxScripts
</body>

</html>