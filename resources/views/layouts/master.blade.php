<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'QuickTask Application')</title>
    @vite(['resources/css/app.css', 'resources/sass/custom.scss', 'resources/js/app.js', 'resources/js/custom.js'])
</head>
<body class="bg-gray-100 font-sans text-gray-900 antialiased">
    <!-- Header / Navigation Bar -->
    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center shadow-sm">
        <div class="flex items-center space-x-6">
            <a href="/" class="text-xl font-bold text-indigo-600 flex items-center gap-2">
                <i class="fa-solid fa-list-check"></i> QuickTask
            </a>
            <a href="{{ route('users.index') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">
                <i class="fa-solid fa-users me-1"></i> Users Management
            </a>
            <a href="{{ route('tasks.index') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600">
                <i class="fa-solid fa-tasks me-1"></i> Tasks Management
            </a>
        </div>
        <div class="flex items-center space-x-3 text-sm">
            <span class="text-gray-500">{{ __('messages.language') }}:</span>
            <a href="{{ route('lang.switch', 'en') }}" class="px-2 py-1 text-xs rounded font-medium {{ app()->getLocale() == 'en' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">🇬🇧 EN</a>
            <a href="{{ route('lang.switch', 'vi') }}" class="px-2 py-1 text-xs rounded font-medium {{ app()->getLocale() == 'vi' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">🇻🇳 VI</a>
        </div>
    </nav>

    <!-- Main Content Yield Section -->
    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-4 text-center text-xs text-gray-500 mt-12">
        <p>&copy; {{ date('Y') }} QuickTask Laravel App. All rights reserved.</p>
    </footer>

    @stack('scripts')
</body>
</html>
