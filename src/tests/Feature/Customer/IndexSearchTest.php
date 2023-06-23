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
        $this->name_kana = $customers->random()->name_kana;
        $this->gender = $customers->random()->gender;
        $this->phone = $customers->random()->phone;
        $this->postal_code = $customers->random()->postal_code;
        $this->pref = $customers->random()->pref;
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

    /**
     * ふりがなで検索できること。
     *
     * @return void
     */
    public function test_searchByNameKana()
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?search_value[name_kana]=' . $this->name_kana);

        $response->assertStatus(200)
            ->assertJsonPath('data.0.name_kana', $this->name_kana);
    }

    /**
     * 性別で検索できること。
     *
     * @return void
     */
    public function test_searchByGender()
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?search_value[gender]=' . $this->gender);

        $response->assertStatus(200)
            ->assertJsonPath('data.0.gender', $this->gender);
    }

    /**
     * 電話番号で検索できること。
     *
     * @return void
     */
    public function test_searchByPhone()
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?search_value[phone]=' . $this->phone);

        $response->assertStatus(200)
            ->assertJsonPath('data.0.phone', $this->phone);
    }

    /**
     * 郵便番号で検索できること。
     *
     * @return void
     */
    public function test_searchByPostalCode()
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?search_value[postal_code]=' . $this->postal_code);

        $response->assertStatus(200)
            ->assertJsonPath('data.0.postal_code', $this->postal_code);
    }

    /**
     * 都道府県で検索できること。
     *
     * @return void
     */
    public function test_searchByPref()
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?search_value[pref]=' . $this->pref);

        $response->assertStatus(200)
            ->assertJsonPath('data.0.pref', $this->pref);
    }
}
