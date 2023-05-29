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
     * A basic feature test example.
     */
    public function test_getCustomerDetail(): void
    {
        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $user = User::factory()->create();
        $customer = Customer::factory()->create();

        // 実行
        $response = $this->actingAs($user)->getJson('/api/customers/' . $customer->id);
        $response
            ->assertOK()
            ->assertJsonFragment([
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'gender' => $customer->gender,
                'birth_date' => $customer->birth_date,
                'postal_code' => $customer->postal_code,
                'pref' => $customer->pref,
                'city' => $customer->city,
                'street' => $customer->street,
                'avatar' => $customer->avatar,
            ]);
    }
}
