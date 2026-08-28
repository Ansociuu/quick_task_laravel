@extends('layouts.master')

@section('title', 'Chi tiết User & Danh sách Tasks - ' . $user->name)

@section('content')
<div class="space-y-6">
    <!-- Navigation Back Link -->
    <div>
        <a href="{{ route('users.index') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800 transition">
            <i class="fa-solid fa-arrow-left me-2"></i> Quay lại danh sách người dùng
        </a>
    </div>

    <!-- User Information Card -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl font-bold">
                <i class="fa-solid fa-user-gear"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                    {{ $user->name }}
                    @if($user->is_admin)
                        <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full bg-purple-100 text-purple-700">Admin</span>
                    @endif
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    <i class="fa-solid fa-envelope me-1"></i> {{ $user->email }} | 
                    <i class="fa-solid fa-at me-1"></i> {{ $user->username ?? 'no-username' }}
                </p>
            </div>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('users.edit', $user->id) }}" class="px-4 py-2 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-lg text-sm font-semibold transition">
                <i class="fa-solid fa-pen-to-square me-1"></i> Sửa thông tin
            </a>
            <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold transition shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> Thêm Task mới cho User
            </a>
        </div>
    </div>

    <!-- Related Tasks List Section (Model Quan Hệ) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-indigo-600"></i>
                Danh sách Tasks của {{ $user->name }} ({{ $user->tasks->count() }} công việc)
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Task ID</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Tên công việc (Task Name)</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase">Mô tả</th>
                        <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase">Trạng thái</th>
                        <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase">Tags</th>
                        <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase">Hành động Task (CRUD)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($user->tasks as $task)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $task->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                {{ $task->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                {{ $task->description ?? 'Không có mô tả' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($task->is_completed)
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        <i class="fa-solid fa-check me-1"></i> Complete
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">
                                        <i class="fa-solid fa-clock me-1"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-1">
                                    @forelse($task->tags as $tag)
                                        <span class="px-2 py-0.5 text-[10px] font-medium bg-indigo-50 text-indigo-600 rounded">
                                            #{{ $tag->name }}
                                        </span>
                                    @empty
                                        <span class="text-xs text-gray-400">-</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- View Task -->
                                    <a href="{{ route('tasks.show', $task->id) }}" class="px-2.5 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-md transition text-xs font-semibold">
                                        <i class="fa-solid fa-eye"></i> Xem
                                    </a>
                                    <!-- Edit Task -->
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="px-2.5 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-md transition text-xs font-semibold">
                                        <i class="fa-solid fa-pen-to-square"></i> Sửa
                                    </a>
                                    <!-- Delete Task -->
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn muốn xóa task này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-md transition text-xs font-semibold">
                                            <i class="fa-solid fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                User này chưa có task nào. <a href="{{ route('tasks.create') }}" class="text-indigo-600 underline font-medium">Tạo task đầu tiên</a>.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
