<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('obfuscated.min.css') }}">
    <title>{{ $title ?? 'Панель заявщика' }}</title>
    @livewireStyles
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @yield('styles')
</head>

<body class="min-h-full bg-slate-50 text-gray-900">
    @php
        $navItems = [
            ['label' => 'Дашборд', 'route' => 'applicant.dashboard', 'active' => 'applicant.dashboard'],
            ['label' => 'Заявки', 'route' => 'applicant', 'active' => 'applicant'],
            ['label' => 'Чаты с клиентами', 'route' => 'applicant.chats', 'active' => 'applicant.chats'],
            ['label' => 'Трек-коды', 'route' => 'applicant.trackcodes', 'active' => 'applicant.trackcodes'],
            ['label' => 'Клиенты и коды', 'route' => 'applicant.customers', 'active' => 'applicant.customers'],
            ['label' => 'Склад Хитой', 'route' => 'applicant.china', 'active' => 'applicant.china'],
            ['label' => 'Склад Душанбе', 'route' => 'applicant.dushanbe', 'active' => 'applicant.dushanbe'],
            ['label' => 'СМС рассылка', 'route' => 'applicant.smsbulk', 'active' => 'applicant.smsbulk'],
        ];
    @endphp

    <div class="min-h-screen">
        <nav class="sticky top-0 z-30 border-b border-gray-200 bg-white/80 backdrop-blur">
            <div class="max-w-6xl mx-auto px-4 py-3 space-y-3">
                <div class="flex items-center justify-between gap-3 rounded-2xl bg-teal-500 px-3 py-2 shadow-sm">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('applicant') }}" class="inline-flex items-center gap-2">
                            <span
                                class="h-9 w-9 rounded-xl bg-white/20 text-white font-bold inline-flex items-center justify-center">
                                TH
                            </span>
                            <span class="text-lg font-semibold text-white">ShifuCargo</span>
                        </a>
                        <span
                            class="hidden lg:block text-xs uppercase tracking-wide text-white/80 bg-white/10 border border-white/20 px-2 py-1 rounded-full">
                            Панель заявщика
                        </span>
                    </div>
                    <a href="{{ route('logout') }}"
                        class="px-3 py-2 rounded-xl text-sm font-semibold bg-white text-teal-700 hover:bg-rose-500 hover:text-white transition">
                        Выйти
                    </a>
                </div>
                <div
                    class="flex items-center gap-2 overflow-x-auto whitespace-nowrap pb-1 -mx-4 px-4 lg:mx-0 lg:px-0 lg:overflow-visible lg:flex-wrap">
                    @foreach ($navItems as $item)
                        <a href="{{ route($item['route']) }}"
                            class="shrink-0 px-3 py-2 rounded-xl text-sm font-medium transition {{ Route::is($item['active']) ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100 border border-gray-200' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </nav>

        <main class="applicant-scope max-w-6xl mx-auto px-4 py-6">
            {{ $slot }}
            @livewire('components.alert')
        </main>
    </div>

    @livewireScripts
    @fluxScripts
</body>

</html>
