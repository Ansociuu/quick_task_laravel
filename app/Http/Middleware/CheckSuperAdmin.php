<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra người dùng đã đăng nhập chưa và có quyền admin không
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Unauthorized access. Super Admin privileges required.');
        }

        return $next($request);
    }
}
