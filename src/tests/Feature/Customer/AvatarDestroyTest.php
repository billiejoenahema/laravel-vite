<?php

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
    public function setUp(): void
    {
        parent::setUp();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $this->user = User::factory()->create();
        $this->customer = Customer::factory()->create(['avatar' => 'test.png']);
    }

    /**
     * 一般ユーザーが顧客のアイコンを削除できないこと。
     */
    public function test_cannot_delete_avatar_by_general_user(): void
    {
        $response = $this->actingAs($this->user)->deleteJson('/api/customers/' . $this->customer->id . '/avatar');
        $response->assertForbidden();
    }

    /**
     * 管理般ユーザーが顧客のアイコンを削除できること。
     */
    public function test_delete_avatar_by_admin_user(): void
    {
        $this->user->role = User::ROLE_ADMIN;
        $this->user->save();

        $response = $this->actingAs($this->user)->deleteJson('/api/customers/' . $this->customer->id . '/avatar');
        $response->assertOk();
    }
}
