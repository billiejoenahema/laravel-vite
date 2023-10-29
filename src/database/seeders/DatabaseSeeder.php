<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 開発環境でのみシーダを実行する
        if (env('APP_ENV') === 'local') {
            $this->call([
                UserSeeder::class,
                CustomerSeeder::class,
                NoticeSeeder::class,
            ]);
        }
    }
}
