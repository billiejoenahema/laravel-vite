<?php

declare(strict_types=1);

namespace Tests\Feature\Customer;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class RestoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * テスト前の共通処理
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->generalUser = User::factory()->create();
        $this->adminUser = User::factory()->createAdminUser();
        $this->customer = Customer::factory()->create(['avatar' => 'test.png']);
        $this->customer->delete();
    }

    /**
     * 一般ユーザーが削除された顧客を復元できないこと。
     */
    public function test_general_user_cannot_restore_customer(): void
    {
        $response = $this->actingAs($this->generalUser)->patchJson('/api/customers/' . $this->customer->id . '/restore');

        $response->assertForbidden();
    }

    /**
     * 管理者ユーザーが削除された顧客を復元できること。
     */
    public function test_admin_user_can_restore_customer(): void
    {
        $response = $this->actingAs($this->adminUser)->patchJson('/api/customers/' . $this->customer->id . '/restore');

        $response->assertOk();
    }
}
