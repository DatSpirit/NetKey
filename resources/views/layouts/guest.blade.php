<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NetKey') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <!-- Styles -->
    @if (app()->environment('local'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ secure_asset('build/assets/app-CfAMAoGE.css') }}">
        <script src="{{ secure_asset('build/assets/app-ByAQDGt7.js') }}" defer></script>
    @endif


</head>

<body class="font-sans text-gray-900 antialiased">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-white via-blue-200 to-white overflow-hidden relative">

        {{-- Animated Background Elements --}}
        <div
            class="absolute top-0 left-0 -ml-20 -mt-20 w-96 h-96 rounded-full bg-white opacity-20 blur-3xl animate-pulse">
        </div>
        <div class="absolute bottom-0 right-0 -mr-20 -mb-20 w-96 h-96 rounded-full bg-white opacity-20 blur-3xl animate-pulse"
            style="animation-delay: 2s;"></div>

        <div class="relative z-10 w-full sm:max-w-md flex flex-col items-center">
            <a href="/" class="mb-8 transform hover:scale-105 transition-transform duration-300">
                <div class="flex items-center gap-3">
                    <x-application-logo class="w-16 h-16" />
                    <span class="text-3xl font-extrabold text-white tracking-tight">NetKey</span>
                </div>
            </a>

            <div
                class="w-full px-8 py-8 bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl rounded-2xl sm:rounded-3xl relative text-gray-900">
                {{-- Shine Effect --}}
                <div
                    class="absolute inset-0 rounded-3xl pointer-events-none bg-gradient-to-br from-white/5 to-transparent">
                </div>

                {{ $slot }}
            </div>

            <p class="mt-6 text-sm text-gray-600">
                © {{ date('Y') }} {{ config('app.name', 'NetKey') }}. Secure Access.
            </p>
        </div>
    </div>
</body>

</html>