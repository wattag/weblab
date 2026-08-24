<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title', config('app.name', 'WebLab'))
    </title>

    <link rel="icon" href="{{ asset('logo.ico') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
    <body class="antialiased bg-slate-950 text-slate-100 h-screen w-screen overflow-hidden flex">

    @include('partials.sidebar')

    <div class="flex-1 h-full overflow-y-auto relative">
        <main class="w-full h-full px-4 sm:px-6 lg:px-8 py-6 lg:py-10 pb-28 md:pb-10">
            @yield('content')
        </main>
    </div>

    </body>
</html>
