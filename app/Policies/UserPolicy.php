<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Phân quyền "trước" (before hook).
     *
     * Super Admin (is_admin = 1) được phép thực hiện MỌI hành động
     * trên bất kỳ User nào, bất kể các method bên dưới trả về gì.
     * Trả về null để cho các method còn lại tiếp tục kiểm tra.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->is_admin) {
            return true; // Super Admin bypass tất cả policy checks
        }

        return null; // Tiếp tục kiểm tra các method bên dưới
    }

    /**
     * Determine whether the user can view any models.
     * Chỉ admin mới có thể xem danh sách toàn bộ users.
     */
    public function viewAny(User $user): bool
    {
        return (bool) $user->is_admin;
    }

    /**
     * Determine whether the user can view the model.
     * User chỉ được xem trang profile của chính mình, admin xem tất cả.
     */
    public function view(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return (bool) $user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     *
     * RULE: Chỉ chính user đó mới có quyền update thông tin của mình.
     * (Super Admin bypass rule này nhờ method before() ở trên)
     */
    public function update(User $user, User $model): bool
    {
        // Chỉ cho phép nếu user đang đăng nhập CHÍNH LÀ user cần update
        return $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     * Chỉ admin mới có quyền xóa user.
     */
    public function delete(User $user, User $model): bool
    {
        // Không cho phép admin xóa chính mình
        return $user->is_admin && $user->id !== $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return (bool) $user->is_admin;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return (bool) $user->is_admin;
    }
}
