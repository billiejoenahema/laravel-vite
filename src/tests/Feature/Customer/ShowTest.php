<?php

declare(strict_types=1);

namespace Tests\Feature\Customer;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTest extends TestCase
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
        $this->customer = Customer::factory()->create();
    }

    /**
     * 一般ユーザーが指定顧客情報を取得できること。
     */
    public function test_general_user_get_customer_detail(): void
    {
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers/' . $this->customer->id);

        $response
            ->assertOK()
            ->assertJsonFragment([
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'phone' => $this->customer->phone,
                'gender' => $this->customer->gender,
                'birth_date' => $this->customer->birth_date,
                'postal_code' => $this->customer->postal_code,
                'pref' => $this->customer->pref,
                'city' => $this->customer->city,
                'street' => $this->customer->street,
                'avatar' => $this->customer->avatar,
            ]);
    }

    /**
     * 管理ユーザーが指定顧客情報を取得できること。
     */
    public function test_admin_user_can_customer_detail(): void
    {
        $response = $this->actingAs($this->adminUser)->getJson('/api/customers/' . $this->customer->id);

        $response
            ->assertOK()
            ->assertJsonFragment([
                'id' => $this->customer->id,
                'name' => $this->customer->name,
                'phone' => $this->customer->phone,
                'gender' => $this->customer->gender,
                'birth_date' => $this->customer->birth_date,
                'postal_code' => $this->customer->postal_code,
                'pref' => $this->customer->pref,
                'city' => $this->customer->city,
                'street' => $this->customer->street,
                'avatar' => $this->customer->avatar,
            ]);
    }
}
