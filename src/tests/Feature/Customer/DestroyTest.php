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
     * 一般ユーザーがアイコンを削除できること。
     */
    public function test_generalUserCanDeleteAvatar(): void
    {
        $response = $this->actingAs($this->user)->deleteJson('/api/customers/avatar/' . $this->customer->id);
        $response->assertOk();
    }

    /**
     * 管理般ユーザーが顧客を削除できること。
     */
    public function test_adminUserCanDeleteCustomer(): void
    {
        $this->user->role = User::ROLE_ADMIN;
        $this->user->save();

        $response = $this->actingAs($this->user)->deleteJson('/api/customers/' . $this->customer->id);
        $response->assertOk();
    }
}
