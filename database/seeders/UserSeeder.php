<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tạo 1 Super Admin ban đầu
        User::updateOrCreate(
            ['email' => 'admin@quicktask.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => 'admin123456',
                'is_admin' => true,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 2. Tạo dữ liệu mẫu cho 10 người dùng thông thường bằng Factory & Faker
        User::factory()->count(10)->create();
    }
}
