<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <!-- Language Switcher -->
            <div class="mt-4 flex items-center space-x-3 text-sm font-medium">
                <span class="text-gray-500">{{ __('messages.language') }}:</span>
                <a href="{{ route('lang.switch', 'en') }}" class="px-3 py-1 rounded-md transition-colors {{ app()->getLocale() == 'en' ? 'bg-indigo-600 text-white font-semibold shadow-sm' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">🇬🇧 {{ __('messages.english') }}</a>
                <a href="{{ route('lang.switch', 'vi') }}" class="px-3 py-1 rounded-md transition-colors {{ app()->getLocale() == 'vi' ? 'bg-indigo-600 text-white font-semibold shadow-sm' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">🇻🇳 {{ __('messages.vietnamese') }}</a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
