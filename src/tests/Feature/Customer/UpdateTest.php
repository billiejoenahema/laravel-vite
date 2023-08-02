<?php

namespace Tests\Feature\Customer;

use App\Enums\Gender;
use App\Enums\Prefecture;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTest extends TestCase
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
        $this->customer = Customer::factory()->create();
        $this->data = [
            'user_id' => null,
            'name' => 'test_name',
            'name_kana' => 'test_name_kana',
            'phone' => '0312345678',
            'gender' => Gender::MALE,
            'birth_date' => '2000-01-01',
            'postal_code' => '1000001',
            'pref' => Prefecture::TOKYO,
            'city' => '千代田区',
            'street' => '1-1-1',
            'avatar' => 'test_avatar.png',
            'note' => 'test_note',
        ];
    }

    /**
     * 一般ユーザーが顧客情報を更新できて、アイコン画像は更新されないこと。
     */
    public function test_updateCustomerByGeneralUser(): void
    {
        // 実行
        $response = $this->actingAs($this->user)->patchJson('/api/customers/' . $this->customer->id, $this->data);
        $response->assertOk();
        $this->assertDatabaseHas(
            'customers',
            [
                'id' => $this->customer->id,
                'user_id' => null,
                'name' => $this->data['name'],
                'name_kana' => $this->data['name_kana'],
                'phone' => $this->data['phone'],
                'gender' => $this->data['gender'],
                'birth_date' => $this->data['birth_date'],
                'postal_code' => $this->data['postal_code'],
                'pref' => $this->data['pref'],
                'city' => $this->data['city'],
                'street' => $this->data['street'],
                'avatar' => null,
                'note' => $this->data['note'],
            ]
        );
    }

    /**
     * 管理ユーザーが顧客情報を更新できて、アイコン画像は更新されないこと。
     */
    public function test_updateCustomerByAdminUser(): void
    {
        $this->user->role = User::ROLE_ADMIN;
        $this->user->save();

        // 実行
        $response = $this->actingAs($this->user)->patchJson('/api/customers/' . $this->customer->id, $this->data);
        $response->assertOk();
        $this->assertDatabaseHas(
            'customers',
            [
                'id' => $this->customer->id,
                'user_id' => null,
                'name' => $this->data['name'],
                'name_kana' => $this->data['name_kana'],
                'phone' => $this->data['phone'],
                'gender' => $this->data['gender'],
                'birth_date' => $this->data['birth_date'],
                'postal_code' => $this->data['postal_code'],
                'pref' => $this->data['pref'],
                'city' => $this->data['city'],
                'street' => $this->data['street'],
                'avatar' => null,
                'note' => $this->data['note'],
            ]
        );
    }
}
