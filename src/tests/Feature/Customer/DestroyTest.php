<?php

declare(strict_types=1);

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
    protected function setUp(): void
    {
        parent::setUp();

        $this->generalUser = User::factory()->createGeneralUser();
        $this->adminUser = User::factory()->createAdminUser();
        $this->customer = Customer::factory()->create(['avatar' => 'test.png']);
    }

    /**
     * 一般ユーザーが顧客を削除できないこと。
     */
    public function test_general_user_cannot_delete_customer(): void
    {
        $response = $this->actingAs($this->generalUser)->deleteJson('/api/customers/' . $this->customer->id);

        $response->assertForbidden();
    }

    /**
     * 管理者ユーザーが顧客を削除できること。
     */
    public function test_admin_user_can_delete_customer(): void
    {
        $response = $this->actingAs($this->adminUser)->deleteJson('/api/customers/' . $this->customer->id);

        $response->assertOk();
    }
}
