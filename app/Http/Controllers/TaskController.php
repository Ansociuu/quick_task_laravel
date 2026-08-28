<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource (Sử dụng Query Builder với Join bảng users).
     */
    public function index()
    {
        $tasks = DB::table('tasks')
            ->join('users', 'tasks.user_id', '=', 'users.id')
            ->select('tasks.*', 'users.name as user_name', 'users.email as user_email')
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json(['message' => 'Show task creation form']);
    }

    /**
     * Store a newly created resource in storage (Sử dụng Query Builder + Form Request).
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->validated();
        $tags = $data['tags'] ?? [];
        unset($data['tags']);

        $data['created_at'] = now();
        $data['updated_at'] = now();

        $taskId = DB::table('tasks')->insertGetId($data);

        // Nếu có tags truyền lên, chèn vào bảng pivot task_tag qua Query Builder
        if (! empty($tags)) {
            $pivotData = array_map(fn ($tagId) => [
                'task_id' => $taskId,
                'tag_id' => $tagId,
            ], $tags);

            DB::table('task_tag')->insert($pivotData);
        }

        $task = DB::table('tasks')->where('id', $taskId)->first();

        return response()->json(['message' => 'Tạo task mới thành công!', 'task' => $task], 201);
    }

    /**
     * Display the specified resource (Sử dụng Query Builder).
     */
    public function show(int $id)
    {
        $task = DB::table('tasks')
            ->join('users', 'tasks.user_id', '=', 'users.id')
            ->select('tasks.*', 'users.name as user_name', 'users.email as user_email')
            ->where('tasks.id', $id)
            ->first();

        if (! $task) {
            abort(404, 'Task không tồn tại');
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $task = DB::table('tasks')
            ->join('users', 'tasks.user_id', '=', 'users.id')
            ->select('tasks.*', 'users.name as user_name')
            ->where('tasks.id', $id)
            ->first();

        if (! $task) {
            abort(404, 'Task không tồn tại');
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage (Sử dụng Query Builder + Form Request).
     */
    public function update(UpdateTaskRequest $request, int $id)
    {
        $data = $request->validated();
        unset($data['tags']);
        $data['updated_at'] = now();

        DB::table('tasks')->where('id', $id)->update($data);

        return redirect()->route('tasks.show', $id)->with('success', 'Cập nhật task thành công!');
    }

    /**
     * Remove the specified resource from storage (Sử dụng Query Builder).
     */
    public function destroy(int $id)
    {
        DB::table('tasks')->where('id', $id)->delete();
        return redirect()->route('tasks.index')->with('success', 'Xóa task thành công!');
    }
}
