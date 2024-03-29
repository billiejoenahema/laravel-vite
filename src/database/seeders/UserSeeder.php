<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 本番環境なら実行しない
        if (env('APP_ENV') === 'production') {
            return;
        }
        // テストユーザー
        User::create([
            'name' => 'test_user',
            'email' => 'test@example.com',
            'password' => Hash::make('test_user'),
            'role' => Role::GENERAL->value,
        ]);
    }
}
