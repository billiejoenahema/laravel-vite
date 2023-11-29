<?php

declare(strict_types=1);

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
    protected function setUp(): void
    {
        parent::setUp();

        $this->generalUser = User::factory()->createGeneralUser();
        $this->adminUser = User::factory()->createAdminUser();

        $customers = Customer::factory()->count(10)->create();
        $this->name = $customers->random()->name;
        $this->name_kana = $customers->random()->name_kana;
        $this->gender = $customers->random()->gender;
        $this->phone = $customers->random()->phone;
        $this->postal_code = $customers->random()->postal_code;
        $this->pref = $customers->random()->pref;
    }

    /**
     * 顧客一覧を取得し指定したカラムで検索できていることをアサートする
     *
     * @param string $column 検索カラム
     * @param string $searchValue 検索ワード
     */
    private function searchAndAssert($column, $searchValue): void
    {
        $response = $this->actingAs($this->generalUser)->getJson("/api/customers?search_value[{$column}]={$searchValue}");

        $response->assertStatus(200)
            ->assertJsonPath("data.0.{$column}", $searchValue);
    }

    /**
     * 氏名で検索できること。
     */
    public function test_search_by_name(): void
    {
        $this->searchAndAssert('name', $this->name);
    }

    /**
     * ふりがなで検索できること。
     */
    public function test_search_by_nameKana(): void
    {
        $this->searchAndAssert('name_kana', $this->name_kana);
    }

    /**
     * 性別で検索できること。
     */
    public function test_search_by_gender(): void
    {
        $this->searchAndAssert('gender', $this->gender);
    }

    /**
     * 電話番号で検索できること。
     */
    public function test_search_by_phone(): void
    {
        $this->searchAndAssert('phone', $this->phone);
    }

    /**
     * 郵便番号で検索できること。
     */
    public function test_search_by_postalCode(): void
    {
        $this->searchAndAssert('postal_code', $this->postal_code);
    }

    /**
     * 都道府県で検索できること。
     */
    public function test_search_by_pref(): void
    {
        $this->searchAndAssert('pref', $this->pref);
    }
}
