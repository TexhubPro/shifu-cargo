<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo/favicon_color.svg') }}">
    <link rel="stylesheet" href="{{ asset('obfuscated.min.css') }}">
    <title>{{ $title ?? 'Page Title' }}</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    @yield('styles')
</head>

<body class="min-h-full bg-neutral-100 text-neutral-900 antialiased">

    {{ $slot }}
    @livewire('components.alert')

</body>

</html>
