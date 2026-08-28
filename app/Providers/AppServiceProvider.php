<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * Định nghĩa Gates và đăng ký Policies tại đây.
     */
    public function boot(): void
    {
        /*
        |--------------------------------------------------------------
        | GATE: is-super-admin
        |--------------------------------------------------------------
        | Gate là cách khai báo phân quyền đơn giản dựa trên một điều
        | kiện logic. Gate 'is-super-admin' kiểm tra xem người dùng
        | đang đăng nhập có quyền admin hay không.
        |
        | Cách dùng:
        |   - Trong Controller : Gate::authorize('is-super-admin')
        |   - Trong Blade      : @can('is-super-admin') ... @endcan
        |   - Kiểm tra boolean : Gate::allows('is-super-admin')
        */
        Gate::define('is-super-admin', function (User $user): bool {
            return (bool) $user->is_admin;
        });

        /*
        |--------------------------------------------------------------
        | POLICY: UserPolicy
        |--------------------------------------------------------------
        | Policy nhóm nhiều logic phân quyền liên quan đến một Model
        | cụ thể (User). Khác với Gate (định nghĩa đơn lẻ), Policy
        | giúp tổ chức phân quyền theo từng hành động (update,
        | delete...) một cách có cấu trúc hơn.
        |
        | Cách dùng:
        |   - Trong Controller : $this->authorize('update', $user)
        |   - Trong Blade      : @can('update', $user) ... @endcan
        */
        Gate::policy(User::class, UserPolicy::class);
    }
}
