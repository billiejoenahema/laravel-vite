<?php

namespace Tests\Feature\Customer;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexSearchTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    /**
     * テスト前の共通処理
     */
    public function setUp(): void
    {
        parent::setUp();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $this->user = User::factory()->create();

        $customers = Customer::factory()->count(10)->create();
        $this->name = $customers->random()->name;
    }

    /**
     * 氏名で検索できること。
     *
     * @return void
     */
    public function test_searchByName()
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?search_value[name]=' . $this->name);

        $response->assertStatus(200)
            ->assertJsonPath('data.0.name', $this->name);
    }
}
