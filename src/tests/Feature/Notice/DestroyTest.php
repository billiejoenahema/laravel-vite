<?php

declare(strict_types=1);

namespace Tests\Feature\Notice;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyTest extends TestCase
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
    }

    /**
     * 一般ユーザーがおしらせを削除できないこと。
     */
    public function test_general_user_cannot_delete_notice(): void
    {
        $response = $this->actingAs($this->generalUser)->deleteJson('/api/notices/' . $this->notice->id);

        $response->assertForbidden();
    }

    /**
     * 管理者ユーザーがおしらせを削除できること。
     */
    public function test_admin_user_can_delete_notice(): void
    {
        $response = $this->actingAs($this->adminUser)->deleteJson('/api/notices/' . $this->notice->id);

        $response->assertOk();
    }
}
