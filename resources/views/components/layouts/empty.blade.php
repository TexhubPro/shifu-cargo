<!DOCTYPE>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" html class="{{ Route::is('cashier') ? 'light' : 'dark' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('obfuscated.min.css') }}">
    <title>{{ $title ?? 'Page Title' }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @yield('styles')
</head>

<body class="bg-neutral-950">

    {{ $slot }}
    @livewire('components.alert')
    @fluxScripts
</body>

</html>