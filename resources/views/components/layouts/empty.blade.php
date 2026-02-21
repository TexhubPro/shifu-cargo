<!DOCTYPE>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" html
    class="{{ Route::is('cashier') ? 'light' : 'dark' }}{{ Route::is('cashier.reports') ? 'light' : 'dark' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('obfuscated.min.css') }}">
    <title>{{ $title ?? 'Page Title' }}</title>
    @livewireStyles
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @yield('styles')
</head>

<body class="bg-neutral-950">

    {{ $slot }}
    @livewire('components.alert')
    @livewireScripts
    @fluxScripts
</body>

</html>
