<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource (Sử dụng Eloquent ORM + Eager Loading tránh N+1 Query).
     */
    public function index()
    {
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
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage (Eloquent ORM + Form Request).
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated());
        return redirect()->route('users.show', $user->id)->with('success', 'Cập nhật người dùng thành công!');
    }

    /**
     * Remove the specified resource from storage (Eloquent ORM).
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Xóa người dùng thành công!');
    }
}
