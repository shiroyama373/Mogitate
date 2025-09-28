<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'テストユーザー',
            'email' => 'test@example.com',
            'password' => Hash::make('password'), // パスワードはハッシュ化
        ]);

        // 必要であれば複数ユーザーを追加
        User::create([
            'name' => '管理者',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
        ]);
    }
}