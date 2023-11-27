<?php

declare(strict_types=1);

namespace Tests\Feature\Customer;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexSortTest extends TestCase
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
        $this->customers = Customer::factory()->count(10)->create();
    }

    /**
     * 顧客一覧を取得し想定どおりにソートできていることをアサートする
     *
     * @param string $column ソートキー
     * @param bool $order ソート順
     */
    private function sortAndAssert($column, $order): void
    {
        $response = $this->actingAs($this->generalUser)->getJson("/api/customers?sort_key={$column}&is_asc={$order}");

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame($expected, $actual);
    }

    /**
     * 顧客一覧を氏名で降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_name_desc(): void
    {
        $this->sortAndAssert('name', false);
    }

    /**
     * 顧客一覧を氏名で昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_name_asc(): void
    {
        $this->sortAndAssert('name', true);
    }

    /**
     * 顧客一覧を年齢で降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_age_desc(): void
    {
        $this->sortAndAssert('age', false);
    }

    /**
     * 顧客一覧を年齢で昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_age_asc(): void
    {
        $this->sortAndAssert('age', true);
    }

    /**
     * 顧客一覧を性別で降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_gender_desc(): void
    {;
        $this->sortAndAssert('gender', false);
    }

    /**
     * 顧客一覧を性別で昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_gender_asc(): void
    {;
        $this->sortAndAssert('gender', true);
    }

    /**
     * 顧客一覧を電話番号で降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_phone_desc(): void
    {
        $this->sortAndAssert('phone', false);
    }

    /**
     * 顧客一覧を電話番号で昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_phone_asc(): void
    {
        $this->sortAndAssert('phone', true);
    }

    /**
     * 顧客一覧を生年月日で降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_birth_date_asc(): void
    {
        $this->sortAndAssert('birth_date', false);
    }

    /**
     * 顧客一覧を生年月日で昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_birth_date_desc(): void
    {
        $this->sortAndAssert('birth_date', true);
    }

    /**
     * 顧客一覧を都道府県で降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_pref_desc(): void
    {
        $this->sortAndAssert('pref', false);
    }

    /**
     * 顧客一覧を都道府県で昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_pref_asc(): void
    {
        $this->sortAndAssert('pref', true);
    }

    /**
     * 顧客一覧を登録日で降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_created_at_desc(): void
    {
        $this->sortAndAssert('created_at', false);
    }

    /**
     * 顧客一覧を登録日で昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_created_at_asc(): void
    {
        $this->sortAndAssert('created_at', true);
    }

    /**
     * 顧客一覧を更新日で降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_updated_at_desc(): void
    {
        $this->sortAndAssert('updated_at', false);
    }

    /**
     * 顧客一覧を更新日で昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_updated_at_asc(): void
    {
        $this->sortAndAssert('updated_at', true);
    }
}
