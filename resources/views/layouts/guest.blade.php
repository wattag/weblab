<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', config('app.name', 'WebLab'))
    </title>

    <link rel="icon" href="{{ asset('logo.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50 dark:bg-gray-900 dark:text-white flex flex-col min-h-screen">

<div class="absolute top-0 left-0 p-6">
    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        На главную
    </a>
</div>

<div class="flex-grow flex flex-col items-center justify-center p-6">

    <a href="{{ url('/') }}" class="flex flex-col items-center gap-3 mb-8 hover:opacity-80 transition">
        <img class="w-16 h-16" src="{{ asset('logo.ico') }}" alt="Логотип">
        <span class="text-2xl font-bold tracking-tight">{{ config('app.name', 'WebLab') }}</span>
    </a>

    <div class="w-full sm:max-w-md px-8 py-8 bg-white dark:bg-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 sm:rounded-2xl">
        {{ $slot }}
    </div>

</div>

</body>
</html>
