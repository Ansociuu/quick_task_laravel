<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource (Sử dụng Eloquent ORM + Eager Loading tránh N+1 Query).
     * Áp dụng Gate 'is-super-admin' thay thế middleware CheckSuperAdmin.
     */
    public function index()
    {
        // Gate::authorize ném ra HTTP 403 nếu user không thỏa điều kiện Gate
        Gate::authorize('is-super-admin');

        // Eager loading mối quan hệ tasks và tags để giải quyết triệt để N+1 Queries
        $users = User::withoutGlobalScopes()->with('tasks.tags')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['message' => 'Show user creation form']);
    }

    /**
     * Store a newly created resource in storage (Sử dụng Eloquent ORM + Form Request).
     */
    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        return redirect()->route('users.index')->with('success', 'Tạo người dùng mới thành công!');
    }

    /**
     * Display the specified resource (Eloquent ORM Eager Loading).
     */
    public function show(User $user)
    {
        $user->load('tasks.tags');
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     * Áp dụng UserPolicy::update - chỉ chính user đó mới được sửa thông tin mình.
     */
    public function edit(User $user)
    {
        // Policy 'update': nếu $authUser->id !== $user->id thì trả về HTTP 403
        // Super Admin bypass rule này nhờ method before() trong UserPolicy
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage (Eloquent ORM + Form Request).
     * Áp dụng UserPolicy::update - chỉ chính user đó mới được cập nhật thông tin mình.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Kiểm tra Policy trước khi thực hiện update
        $this->authorize('update', $user);

        $user->update($request->validated());
        return redirect()->route('users.show', $user->id)->with('success', 'Cập nhật người dùng thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * Sử dụng DB::transaction để đảm bảo tính nguyên vẹn dữ liệu (Data Integrity):
     * - Xóa tất cả bản ghi pivot task_tag liên quan đến tasks của user.
     * - Xóa tất cả tasks của user.
     * - Xóa user.
     *
     * Nếu bất kỳ bước nào thất bại, toàn bộ thao tác sẽ được ROLLBACK,
     * đảm bảo CSDL không rơi vào trạng thái không nhất quán.
     */
    public function destroy(User $user)
    {
        try {
            DB::transaction(function () use ($user) {
                // Bước 1: Lấy ID tất cả tasks của user này
                $taskIds = $user->tasks()->pluck('id');

                // Bước 2: Xóa tất cả bản ghi trong bảng pivot task_tag liên quan
                if ($taskIds->isNotEmpty()) {
                    DB::table('task_tag')->whereIn('task_id', $taskIds)->delete();
                }

                // Bước 3: Xóa tất cả tasks của user
                $user->tasks()->delete();

                // Bước 4: Xóa user (nếu 3 bước trên đều thành công)
                $user->delete();
            });

            return redirect()->route('users.index')
                ->with('success', 'Đã xóa người dùng và toàn bộ tasks liên quan thành công!');

        } catch (\Throwable $e) {
            // Nếu có lỗi -> Transaction tự động ROLLBACK, không có gì bị xóa
            Log::error("Lỗi khi xóa user #{$user->id}: " . $e->getMessage());

            return redirect()->route('users.index')
                ->with('error', 'Có lỗi xảy ra khi xóa người dùng. Vui lòng thử lại!');
        }
    }
}
