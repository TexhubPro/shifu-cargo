<!DOCTYPE>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" html class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('obfuscated.min.css') }}">
    <title>{{ $title ?? 'Page Title' }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

</head>

<body class="bg-neutral-950">
    <div class="max-w-sm mx-auto p-4 space-y-4">
        <div class="bg-neutral-800 rounded-xl border-neutral-700 border flex justify-between items-center p-1">
            <flux:avatar name="Shifu Cargo" color="lime" />
            <div class="text-center">
                <flux:heading class="uppercase">Shifu Cargo</flux:heading>
                <flux:text class="">Добро пожаловать</flux:text>
            </div>

            <a href="#" class="bg-yellow-500 rounded-lg p-2 text-yellow-800 relative">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="icon icon-tabler icons-tabler-outline icon-tabler-bell-ringing">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                    <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                    <path d="M21 6.727a11.05 11.05 0 0 0 -2.794 -3.727" />
                    <path d="M3 6.727a11.05 11.05 0 0 1 2.792 -3.727" />
                </svg>
                <span
                    class="absolute -top-1 -right-1 bg-red-500 w-4 h-4 rounded-full text-white text-xs flex justify-center items-center">0</span>
            </a>

        </div>

        {{ $slot }}
    </div>
    @include('partials.navigation')
</body>

</html>