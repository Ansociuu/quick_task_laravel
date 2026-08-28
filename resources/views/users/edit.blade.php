@extends('layouts.master')

@section('title', 'Sửa User - ' . $user->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Back Link -->
    <div>
        <a href="{{ route('users.show', $user->id) }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 transition">
            <i class="fa-solid fa-arrow-left me-2"></i> Quay lại chi tiết User
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Chỉnh sửa thông tin User</h1>
                <p class="text-sm text-gray-500">ID: #{{ $user->id }}</p>
            </div>
        </div>

        {{-- Hiển thị lỗi validation --}}
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <ul class="text-sm text-red-700 space-y-1 list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Dùng PUT method để update --}}
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                    Họ và tên <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name"
                    value="{{ old('name', $user->name) }}"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                    required>
            </div>

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-semibold text-gray-700 mb-1">
                    Username
                </label>
                <input type="text" id="username" name="username"
                    value="{{ old('username', $user->username) }}"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" id="email" name="email"
                    value="{{ old('email', $user->email) }}"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                    required>
            </div>

            <!-- Password (optional on edit) -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                    Mật khẩu mới <span class="text-gray-400 font-normal">(để trống nếu không đổi)</span>
                </label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
            </div>

            <!-- is_admin -->
            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_admin" name="is_admin" value="1"
                    @checked(old('is_admin', $user->is_admin))
                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                <label for="is_admin" class="text-sm font-semibold text-gray-700">Quyền Admin</label>
            </div>

            <!-- is_active -->
            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_active" name="is_active" value="1"
                    @checked(old('is_active', $user->is_active))
                    class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                <label for="is_active" class="text-sm font-semibold text-gray-700">Tài khoản đang hoạt động</label>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition shadow-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Lưu thay đổi
                </button>
                <a href="{{ route('users.show', $user->id) }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
