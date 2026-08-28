@extends('layouts.master')

@section('title', 'Danh sách người dùng - User Management')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex items-center justify-between bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-2">
                <i class="fa-solid fa-users text-indigo-600"></i>
                Danh sách người dùng (User Management)
            </h1>
            <p class="text-sm text-gray-500 mt-1">Quản lý tất cả người dùng trong hệ thống và danh sách công việc liên quan.</p>
        </div>
        <div>
            <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-lg transition shadow-sm">
                <i class="fa-solid fa-plus me-2"></i> Thêm người dùng mới
            </a>
        </div>
    </div>

    {{-- Flash messages (Transaction success / error) --}}
    @if(session('success'))
        <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm font-medium">
            <i class="fa-solid fa-circle-check text-green-500 text-base"></i>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm font-medium">
            <i class="fa-solid fa-circle-xmark text-red-500 text-base"></i>
            {{ session('error') }}
        </div>
    @endif

    <!-- Users Data Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Họ và tên</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Username</th>
                        <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Vai trò</th>
                        <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Hành động (CRUD)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-indigo-600">
                                <a href="{{ route('users.show', $user->id) }}" class="hover:underline flex items-center gap-2">
                                    <i class="fa-solid fa-circle-user text-gray-400"></i>
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->username ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($user->is_admin)
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700">
                                        <i class="fa-solid fa-user-shield me-1"></i> Admin
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">
                                        <i class="fa-solid fa-user me-1"></i> User
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($user->is_active)
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
                                        <i class="fa-solid fa-circle me-1 text-[8px]"></i> Active
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">
                                        <i class="fa-solid fa-circle me-1 text-[8px]"></i> Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center space-x-2">
                                    <!-- View Details & Related Tasks Button -->
                                    <a href="{{ route('users.show', $user->id) }}" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-md transition text-xs flex items-center gap-1 font-semibold" title="Xem danh sách công việc">
                                        <i class="fa-solid fa-eye"></i> Xem Tasks
                                    </a>
                                    <!-- Edit Button -->
                                    <a href="{{ route('users.edit', $user->id) }}" class="px-2.5 py-1.5 bg-amber-50 text-amber-600 hover:bg-amber-100 rounded-md transition text-xs font-semibold" title="Chỉnh sửa">
                                        <i class="fa-solid fa-pen-to-square"></i> Sửa
                                    </a>
                                    <!-- Delete Button -->
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
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
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">Chưa có dữ liệu người dùng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
