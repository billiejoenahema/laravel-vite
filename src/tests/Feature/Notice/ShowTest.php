<?php

namespace Tests\Feature\Notice;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
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
     * 一般ユーザーが指定のお知らせを取得できること。
     */
    public function test_general_user_get_notice_detail(): void
    {
        $response = $this->actingAs($this->generalUser)->getJson('/api/notices/' . $this->notice->id);

        $response
            ->assertOK()
            ->assertJsonFragment([
                'title' => $this->notice->title,
                'content' => $this->notice->content,
            ]);
    }

    /**
     * 管理ユーザーが指定のお知らせを取得できること。
     */
    public function test_admin_user_get_notice_detail(): void
    {
        $response = $this->actingAs($this->adminUser)->getJson('/api/notices/' . $this->notice->id);

        $response
            ->assertOK()
            ->assertJsonFragment([
                'title' => $this->notice->title,
                'content' => $this->notice->content,
            ]);
    }
}
