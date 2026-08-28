@extends('layouts.master')

@section('title', 'Chi tiết Task - ' . $task->name)

@section('content')
<div class="space-y-6">
    <!-- Back Link -->
    <div>
        <a href="{{ route('tasks.index') }}" class="inline-flex items-center text-sm font-medium text-cyan-600 hover:text-cyan-800 transition">
            <i class="fa-solid fa-arrow-left me-2"></i> Quay lại danh sách Tasks
        </a>
    </div>

    <!-- Task Detail Card -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
        <div class="flex items-start justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-cyan-100 text-cyan-600 flex items-center justify-center text-2xl">
                    <i class="fa-solid fa-file-lines"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $task->name }}</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        <i class="fa-solid fa-circle-user me-1 text-indigo-500"></i>
                        Người sở hữu:
                        <a href="{{ route('users.show', $task->user_id) }}" class="font-medium text-indigo-600 hover:underline">
                            {{ $task->user_name }}
                        </a>
                        ({{ $task->user_email }})
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if($task->is_completed)
                    <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-green-100 text-green-700">
                        <i class="fa-solid fa-check me-1"></i> Completed
                    </span>
                @else
                    <span class="px-3 py-1.5 text-sm font-semibold rounded-full bg-amber-100 text-amber-700">
                        <i class="fa-solid fa-clock me-1"></i> Pending
                    </span>
                @endif
                <a href="{{ route('tasks.edit', $task->id) }}" class="px-4 py-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg text-sm font-semibold transition">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Sửa Task
                </a>
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xóa task này?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 rounded-lg text-sm font-semibold transition">
                        <i class="fa-solid fa-trash me-1"></i> Xóa Task
                    </button>
                </form>
            </div>
        </div>

        <!-- Description -->
        <div class="mt-6 pt-6 border-t border-gray-100">
            <h2 class="text-sm font-semibold text-gray-500 uppercase mb-2">Mô tả công việc</h2>
            <p class="text-gray-700 text-sm leading-relaxed">
                {{ $task->description ?? 'Không có mô tả cho task này.' }}
            </p>
        </div>

        <!-- Metadata -->
        <div class="mt-6 grid grid-cols-2 md:grid-cols-3 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 font-semibold uppercase">Task ID</p>
                <p class="text-lg font-bold text-gray-900 mt-1">#{{ $task->id }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 font-semibold uppercase">Ngày tạo</p>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $task->created_at }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-500 font-semibold uppercase">Cập nhật lần cuối</p>
                <p class="text-sm font-medium text-gray-900 mt-1">{{ $task->updated_at }}</p>
            </div>
        </div>
    </div>

    <!-- Query Builder Note -->
    <div class="bg-cyan-50 border border-cyan-100 rounded-xl p-4 text-sm text-cyan-700">
        <i class="fa-solid fa-circle-info me-2"></i>
        Dữ liệu Task này được lấy bằng <strong>Query Builder (DB Facade)</strong> với <code>JOIN</code> bảng <code>users</code>, thể hiện cách sử dụng <strong>Query Builder</strong> trong Laravel.
    </div>
</div>
@endsection
