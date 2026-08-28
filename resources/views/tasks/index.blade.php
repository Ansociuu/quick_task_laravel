@extends('layouts.master')

@section('title', 'Danh sách Tasks - Task Management')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-list-check text-cyan-600"></i>
                Quản lý công việc (Tasks Management - Query Builder)
            </h1>
            <p class="text-sm text-gray-500 mt-1">Danh sách tất cả các công việc được truy vấn bằng Query Builder (DB Facade).</p>
        </div>
        <div>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2.5 bg-cyan-600 hover:bg-cyan-700 text-white font-medium text-sm rounded-lg transition shadow-sm">
                <i class="fa-solid fa-plus me-2"></i> Tạo Task mới
            </a>
        </div>
    </div>

    <!-- Tasks Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tên công việc (Task)</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Người sở hữu (User)</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mô tả</th>
                        <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Hành động (CRUD)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $task->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600">
                                <a href="{{ route('tasks.show', $task->id) }}" class="hover:underline flex items-center gap-2">
                                    <i class="fa-solid fa-file-lines text-gray-400"></i>
                                    {{ $task->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <a href="{{ route('users.show', $task->user_id) }}" class="hover:underline flex items-center gap-1.5 font-medium text-gray-800">
                                    <i class="fa-solid fa-circle-user text-indigo-500"></i>
                                    {{ $task->user_name ?? 'N/A' }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate">
                                {{ $task->description ?? 'Không có mô tả' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($task->is_completed)
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        <i class="fa-solid fa-check me-1"></i> Completed
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-700">
                                        <i class="fa-solid fa-clock me-1"></i> Pending
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- View Task Button -->
                                    <a href="{{ route('tasks.show', $task->id) }}" class="px-2.5 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-md transition text-xs font-semibold" title="Xem chi tiết">
                                        <i class="fa-solid fa-eye"></i> Xem
                                    </a>
                                    <!-- Edit Task Button -->
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="px-2.5 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-md transition text-xs font-semibold" title="Chỉnh sửa">
                                        <i class="fa-solid fa-pen-to-square"></i> Sửa
                                    </a>
                                    <!-- Delete Task Button -->
                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn chắc chắn muốn xóa task này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1.5 bg-red-50 text-red-600 hover:bg-red-100 rounded-md transition text-xs font-semibold" title="Xóa">
                                            <i class="fa-solid fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Chưa có task nào trong hệ thống.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
