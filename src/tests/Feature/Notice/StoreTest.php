<?php

declare(strict_types=1);

namespace Tests\Feature\Notice;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
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
        $this->data = [
            'title' => 'test_title',
            'content' => 'test_content',
        ];
    }

    /**
     * 一般ユーザーがお知らせを登録できないこと。
     */
    public function test_general_user_can_not_store_notice(): void
    {
        $response = $this->actingAs($this->generalUser)->postJson('/api/notices', $this->data);

        $response->assertForbidden();
    }

    /**
     * 管理者ユーザーがお知らせを登録できること。
     */
    public function test_admin_user_can_store_notice(): void
    {
        $response = $this->actingAs($this->adminUser)->postJson('/api/notices', $this->data);

        $response->assertCreated();
        $this->assertDatabaseCount('notices', 1);
    }
}
