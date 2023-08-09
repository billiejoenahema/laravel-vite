<?php

namespace Tests\Feature\Customer;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyTest extends TestCase
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
     * 一般ユーザーが顧客を削除できないこと。
     */
    public function test_general_user_cannot_delete_customer(): void
    {
        $response = $this->actingAs($this->user)->deleteJson('/api/customers/' . $this->customer->id);
        $response->assertForbidden();
    }

    /**
     * 管理般ユーザーが顧客を削除できること。
     */
    public function test_admin_user_can_delete_customer(): void
    {
        $this->user->role = User::ROLE_ADMIN;
        $this->user->save();

        $response = $this->actingAs($this->user)->deleteJson('/api/customers/' . $this->customer->id);
        $response->assertOk();
    }
}