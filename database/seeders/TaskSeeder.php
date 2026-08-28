<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Tag;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tạo 5 Tag ngẫu nhiên
        $tags = Tag::factory()->count(5)->create();

        // 2. Lấy tất cả user hiện có
        $users = User::all();

        if ($users->isNotEmpty()) {
            // 3. Với mỗi user, tạo 3-5 tasks
            foreach ($users as $user) {
                $tasks = Task::factory()->count(rand(3, 5))->create([
                    'user_id' => $user->id,
                ]);

                // Gán ngẫu nhiên 1-2 tags cho mỗi task
                foreach ($tasks as $task) {
                    $task->tags()->attach(
                        $tags->random(rand(1, 2))->pluck('id')->toArray()
                    );
                }
            }
        }
    }
}
