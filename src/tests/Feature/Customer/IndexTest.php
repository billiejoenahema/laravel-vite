<?php

namespace Tests\Feature\Customer;

use App\Models\Customer;
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
    public function setUp(): void
    {
        parent::setUp();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $generalUser */
        $this->generalUser = User::factory()->create(['role' => User::ROLE_GENERAL]);

        /** @var \Illuminate\Contracts\Auth\Authenticatable $adminUser */
        $this->adminUser = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->customers = Customer::factory()->count(10)->create();
    }

    /**
     * 一般ユーザーが顧客一覧を取得できること。
     *
     * @return void
     */
    public function test_general_user_get_customers(): void
    {
        // 実行
        $response = $this->actingAs($this->generalUser)->get('/api/customers');
        $response
            ->assertOk()
            ->assertJsonCount(10, 'data');
    }

    /**
     * 管理ユーザーが顧客一覧を取得できること。
     *
     * @return void
     */
    public function test_admin_user_get_customers(): void
    {
        // 実行
        $response = $this->actingAs($this->adminUser)->get('/api/customers');
        $response
            ->assertOk()
            ->assertJsonCount(10, 'data');
    }
}
