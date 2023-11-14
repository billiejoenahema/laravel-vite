<?php

declare(strict_types=1);

namespace Tests\Feature\Notice;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SetAllReadTest extends TestCase
{
    use RefreshDatabase;

    /**
     * テスト前の共通処理
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->generalUser = User::factory()->createGeneralUser();
        $this->adminUser = User::factory()->createAdminUser();
        $this->notice = Notice::factory(10)->create();
        $this->data = [
            'title' => 'test_title',
            'content' => 'test_content',
        ];
    }

    /**
     * 一般ユーザーがお知らせをすべて既読にできること。
     */
    public function test_general_user_can_set_all_notice_read(): void
    {
        $response = $this->actingAs($this->generalUser)->patchJson('/api/notices/set-all-read');

        $response->assertOk();
        $this->assertDatabaseCount('notice_reads', 10);
        $this->assertDatabaseHas(
            'notice_reads',
            [
                'user_id' => $this->generalUser->id,
            ]
        );
    }

    /**
     * 管理ユーザーがお知らせをすべて既読にできること。
     */
    public function test_admin_user_can_set_all_notice_read(): void
    {
        $response = $this->actingAs($this->adminUser)->patchJson('/api/notices/set-all-read');

        $response->assertOk();
        $this->assertDatabaseCount('notice_reads', 10);
        $this->assertDatabaseHas(
            'notice_reads',
            [
                'user_id' => $this->adminUser->id,
            ]
        );
    }
}
