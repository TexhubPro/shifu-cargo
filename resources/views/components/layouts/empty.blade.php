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
        {{ $slot }}
    </div>
    @fluxScripts
</body>

</html>