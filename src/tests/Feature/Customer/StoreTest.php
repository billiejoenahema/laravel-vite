<?php

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
    public function setUp(): void
    {
        parent::setUp();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $general_user */
        $this->user = User::factory()->create();
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
        $response = $this->actingAs($this->user)->postJson('/api/customers', $this->data);

        $response->assertCreated();
        $this->assertDatabaseCount('customers', 1);
    }

    /**
     * 管理者ユーザーが顧客を登録できること。
     */
    public function test_admin_user_can_store_customer(): void
    {
        $this->user->role = User::ROLE_ADMIN;
        $this->user->save();

        $response = $this->actingAs($this->user)->postJson('/api/customers', $this->data);

        $response->assertCreated();
        $this->assertDatabaseCount('customers', 1);
    }
}
