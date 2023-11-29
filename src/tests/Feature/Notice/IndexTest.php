<?php

declare(strict_types=1);

namespace Tests\Feature\Notice;

use App\Models\Notice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    /**
     * テスト前の共通処理
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->generalUser = User::factory()->createGeneralUser();
        $this->adminUser = User::factory()->createAdminUser();
        $notices = Notice::factory()->count(10)->create();
        $notices[rand(0, 9)]->users()->attach($this->generalUser->id);
        $notices[0]->users()->attach($this->adminUser->id);
        $notices[rand(1, 9)]->users()->attach($this->adminUser->id);
    }

    /**
     * 一般ユーザーがお知らせ一覧を取得できること。
     */
    public function test_general_user_get_notice_index(): void
    {
        $response = $this->actingAs($this->generalUser)->get('/api/notices');

        $response
            ->assertOk()
            ->assertJsonCount(10, 'data');
    }

    /**
     * 管理ユーザーがお知らせ一覧を取得できること。
     */
    public function test_admin_user_get_notice_index(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/api/notices');

        $response
            ->assertOk()
            ->assertJsonCount(10, 'data');
    }

    /**
     * 一般ユーザーが未読のお知らせのみの一覧を取得できること。
     */
    public function test_general_user_get_unread_notice_index(): void
    {
        $response = $this->actingAs($this->generalUser)->get('/api/notices?unread_only=true');

        $response
            ->assertOk()
            ->assertJsonCount(9, 'data');
    }

    /**
     * 管理ユーザーが未読のお知らせのみの一覧を取得できること。
     */
    public function test_admin_user_get_unread_notice_index(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/api/notices?unread_only=true');

        $response
            ->assertOk()
            ->assertJsonCount(8, 'data');
    }
}
