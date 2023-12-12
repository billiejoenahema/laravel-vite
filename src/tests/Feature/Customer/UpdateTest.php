<?php

declare(strict_types=1);

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
    protected function setUp(): void
    {
        parent::setUp();

        $this->generalUser = User::factory()->createGeneralUser();
        $this->adminUser = User::factory()->createAdminUser();
        $this->customer = Customer::factory()->create();
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
     * 一般ユーザーが顧客情報を更新できること。
     */
    public function test_general_user_update_customer(): void
    {
        $response = $this->actingAs($this->generalUser)->patchJson('/api/customers/' . $this->customer->id, $this->data);

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
     * 管理ユーザーが顧客情報を更新できること。
     */
    public function test_update_customer(): void
    {
        $response = $this->actingAs($this->adminUser)->patchJson('/api/customers/' . $this->customer->id, $this->data);

        $response->assertOk();
        $this->assertDatabaseHas(
            'customers',
            [
                'id' => $this->customer->id,
                'user_id' => null,
                'name' => $this->data['name'],
                'phone' => $this->data['phone'],
                'gender' => $this->data['gender'],
                'postal_code' => $this->data['postal_code'],
            ]
        );
    }

    /**
     * 電話番号と郵便番号にハイフンが入っていても更新できること。
     */
    public function test_admin_user_update_customer_phone_postal_code_with_hyphen(): void
    {
        $data = [
            'id' => $this->customer->id,
            'user_id' => null,
            'name' => $this->data['name'],
            'phone' => '03-1234-5678',
            'gender' => $this->data['gender'],
            'postal_code' => '100-0001',
        ];

        // 実行
        $response = $this->actingAs($this->generalUser)->patchJson('/api/customers/' . $this->customer->id, $data);
        $response->assertOk();
        $this->assertDatabaseHas(
            'customers',
            [
                'id' => $this->customer->id,
                'user_id' => null,
                'name' => $this->data['name'],
                'phone' => str_replace('-', '', $data['phone']),
                'gender' => $this->data['gender'],
                'postal_code' => str_replace('-', '', $data['postal_code']),
            ]
        );
    }
}
