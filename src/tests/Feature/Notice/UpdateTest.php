<?php

declare(strict_types=1);

namespace Tests\Feature\Notice;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
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
        $this->notice = Notice::factory()->create();
        $this->data = [
            'title' => 'test_title',
            'content' => 'test_content',
        ];
    }

    /**
     * 一般ユーザーがお知らせを更新できないこと。
     */
    public function test_general_user_update_notice(): void
    {
        $response = $this->actingAs($this->generalUser)->patchJson('/api/notices/' . $this->notice->id, $this->data);

        $response->assertForbidden();
    }

    /**
     * 管理ユーザーがお知らせを更新できること。
     */
    public function test_update_notice(): void
    {
        $response = $this->actingAs($this->adminUser)->patchJson('/api/notices/' . $this->notice->id, $this->data);

        $response->assertOk();
        $this->assertDatabaseHas(
            'notices',
            [
                'title' => $this->data['title'],
                'content' => $this->data['content'],
            ]
        );
    }
}
