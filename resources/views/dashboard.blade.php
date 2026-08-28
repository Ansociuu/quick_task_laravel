<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Dashboard Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1: Users Management -->
                <div class="custom-dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Users</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">11 Users</p>
                        </div>
                        <div class="p-3 bg-indigo-50 rounded-full text-indigo-600">
                            <i class="fa-solid fa-users text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="badge-custom badge-custom-admin">
                            <i class="fa-solid fa-user-shield me-1"></i> Admin System
                        </span>
                        <a href="{{ route('users.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                            Quản lý Users <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Card 2: Tasks Management -->
                <div class="custom-dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Active Tasks</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">45 Tasks</p>
                        </div>
                        <div class="p-3 bg-cyan-50 rounded-full text-cyan-600">
                            <i class="fa-solid fa-list-check text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="badge-custom badge-custom-active">
                            <i class="fa-solid fa-circle-check me-1"></i> 32 Completed
                        </span>
                        <a href="{{ route('tasks.index') }}" class="text-xs font-semibold text-cyan-600 hover:text-cyan-800 flex items-center gap-1">
                            Quản lý Tasks <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="custom-dashboard-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Vite & SCSS Status</p>
                            <p class="text-2xl font-bold text-emerald-600 mt-1">Compiled</p>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-full text-emerald-600">
                            <i class="fa-solid fa-bolt text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs">
                        <span class="badge-custom badge-custom-pending">
                            <i class="fa-solid fa-code me-1"></i> Vite 7 Build OK
                        </span>
                    </div>
                </div>
            </div>

            <!-- Welcome Banner -->
            <div class="custom-dashboard-card flex items-center justify-between">
                <div>
                    <h3 class="card-header-title flex items-center gap-2">
                        <i class="fa-solid fa-rocket text-indigo-600"></i>
                        {{ __('messages.welcome') }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Package Manager (NPM) and Asset Compiler (Vite + SASS) are successfully configured!
                    </p>
                </div>
                <button class="toggle-sidebar px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                    <i class="fa-solid fa-sliders me-1"></i> Toggle Assets Action
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
