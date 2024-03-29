<?php

declare(strict_types=1);

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
    protected function setUp(): void
    {
        parent::setUp();

        $this->generalUser = User::factory()->createGeneralUser();
        $this->adminUser = User::factory()->createAdminUser();
        $this->customers = Customer::factory()->count(10)->create();
    }

    /**
     * 一般ユーザーが顧客一覧を取得できること。
     */
    public function test_general_user_get_customers(): void
    {
        $response = $this->actingAs($this->generalUser)->get('/api/customers');

        $response
            ->assertOk()
            ->assertJsonCount(10, 'data');
    }

    /**
     * 管理ユーザーが顧客一覧を取得できること。
     */
    public function test_admin_user_get_customers(): void
    {
        $response = $this->actingAs($this->adminUser)->get('/api/customers');

        $response
            ->assertOk()
            ->assertJsonCount(10, 'data');
    }
}
