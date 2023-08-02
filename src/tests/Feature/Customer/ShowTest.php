<?php

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
    public function setUp(): void
    {
        parent::setUp();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $this->user = User::factory()->create();
        $this->customer = Customer::factory()->create();
    }

    /**
     * 一般ユーザーが指定顧客情報を取得できること。
     */
    public function test_getCustomerDetailByGeneralUser(): void
    {
        // 実行
        $response = $this->actingAs($this->user)->getJson('/api/customers/' . $this->customer->id);
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
    public function test_getCustomerDetailByAdminUser(): void
    {
        $this->user->role = User::ROLE_ADMIN;
        $this->user->save();

        // 実行
        $response = $this->actingAs($this->user)->getJson('/api/customers/' . $this->customer->id);
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
