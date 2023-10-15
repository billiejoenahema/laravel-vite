<?php

declare(strict_types=1);

namespace Tests\Feature\Customer;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AvatarDestroyTest extends TestCase
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
        $this->customer = Customer::factory()->create(['avatar' => 'test.png']);
    }

    /**
     * 一般ユーザーが顧客のアイコンを削除できないこと。
     */
    public function test_cannot_delete_avatar_by_general_user(): void
    {
        $response = $this->actingAs($this->generalUser)->deleteJson('/api/customers/' . $this->customer->id . '/avatar');

        $response->assertForbidden();
    }

    /**
     * 管理般ユーザーが顧客のアイコンを削除できること。
     */
    public function test_delete_avatar_by_admin_user(): void
    {
        $response = $this->actingAs($this->adminUser)->deleteJson('/api/customers/' . $this->customer->id . '/avatar');

        $response->assertOk();
    }
}
