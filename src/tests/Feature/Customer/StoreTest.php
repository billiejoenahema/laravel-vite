<?php

declare(strict_types=1);

namespace Tests\Feature\Customer;

use App\Enums\Gender;
use App\Enums\Prefecture;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreTest extends TestCase
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
        $this->data = [
            'name' => 'test_name',
            'name_kana' => 'test_name_kana',
            'phone' => '0312345678',
            'gender' => Gender::MALE,
            'birth_date' => '2000-01-01',
            'postal_code' => '1000001',
            'pref' => Prefecture::TOKYO,
            'city' => '千代田区',
            'street' => '1-1-1',
            'note' => 'test_note',
        ];
    }

    /**
     * 一般ユーザーが顧客を登録できること。
     */
    public function test_general_user_can_store_customer(): void
    {
        $response = $this->actingAs($this->generalUser)->postJson('/api/customers', $this->data);

        $response->assertCreated();
        $this->assertDatabaseCount('customers', 1);
    }

    /**
     * 管理者ユーザーが顧客を登録できること。
     */
    public function test_admin_user_can_store_customer(): void
    {
        $response = $this->actingAs($this->adminUser)->postJson('/api/customers', $this->data);

        $response->assertCreated();
        $this->assertDatabaseCount('customers', 1);
    }
}
