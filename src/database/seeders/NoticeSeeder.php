<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Notice;
use App\Models\NoticeRead;
use App\Models\User;
use Illuminate\Database\Seeder;

class NoticeSeeder extends Seeder
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
        $userIds = User::pluck('id');
        $notice = Notice::factory()->create();

        foreach($userIds as $userId) {
            NoticeRead::create([
                'user_id' => $userId,
                'notice_id' => $notice->id,
            ]);
        }
    }

}
