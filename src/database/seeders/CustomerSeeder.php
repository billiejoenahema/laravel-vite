<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 本番環境なら実行しない
        if (env('APP_ENV') === 'production') {
            return;
        }

        Customer::factory(100)->create();
    }
}
