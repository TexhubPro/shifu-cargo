<!DOCTYPE>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" html class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo/favicon_color.svg') }}">
    <link rel="stylesheet" href="{{ asset('obfuscated.min.css') }}">
    <title>{{ $title ?? 'Page Title' }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

</head>

<body class="bg-neutral-950">
    <div class="max-w-sm mx-auto p-4 space-y-4 mb-40">
        <div class="bg-neutral-800 rounded-xl border-neutral-700 border flex justify-between items-center p-1">
            <flux:avatar src="{{ asset('assets/photo_2025-09-25_23-47-38.jpg') }}" />
            <div class="text-center">
                <flux:heading class="uppercase text-xl/5">Shifu Cargo</flux:heading>
                <flux:text class="text-sm/4">transport company</flux:text>
            </div>

            @livewire('components.notify')

        </div>

        {{ $slot }}
        @livewire('components.alert')
    </div>
    @include('partials.navigation')
    @fluxScripts
</body>

</html>
