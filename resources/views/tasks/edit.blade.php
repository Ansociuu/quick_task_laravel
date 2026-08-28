@extends('layouts.master')

@section('title', 'Sửa Task - ' . $task->name)

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Back Link -->
    <div>
        <a href="{{ route('tasks.show', $task->id) }}" class="inline-flex items-center text-sm font-medium text-cyan-600 hover:text-cyan-800 transition">
            <i class="fa-solid fa-arrow-left me-2"></i> Quay lại chi tiết Task
        </a>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                <i class="fa-solid fa-pen-to-square"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">Chỉnh sửa Task</h1>
                <p class="text-sm text-gray-500">ID: #{{ $task->id }} &mdash; Người sở hữu: <strong>{{ $task->user_name }}</strong></p>
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

        {{-- Dùng PATCH method để update --}}
        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')

            <!-- Task Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">
                    Tên công việc <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name"
                    value="{{ old('name', $task->name) }}"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition"
                    required>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">
                    Mô tả công việc
                </label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:border-transparent transition resize-none">{{ old('description', $task->description) }}</textarea>
            </div>

            <!-- is_completed -->
            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_completed" name="is_completed" value="1"
                    @checked(old('is_completed', $task->is_completed))
                    class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                <label for="is_completed" class="text-sm font-semibold text-gray-700">
                    Đánh dấu đã hoàn thành
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white text-sm font-semibold rounded-lg transition shadow-sm">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Lưu thay đổi
                </button>
                <a href="{{ route('tasks.show', $task->id) }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-lg transition">
                    Hủy
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
