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
     * 氏名で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_name_desc(): void
    {
        $column = 'name';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 氏名で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_name_asc(): void
    {
        $column = 'name';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 年齢で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_age_desc(): void
    {
        $column = 'age';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 年齢で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_age_asc(): void
    {
        $column = 'age';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 性別で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_gender_desc(): void
    {
        $column = 'gender';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 性別で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_gender_asc(): void
    {
        $column = 'gender';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 電話番号で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_phone_desc(): void
    {
        $column = 'phone';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 電話番号で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_phone_asc(): void
    {
        $column = 'phone';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 生年月日で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_birth_date_asc(): void
    {
        $column = 'birth_date';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 生年月日で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_birth_date_desc(): void
    {
        $column = 'birth_date';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 都道府県で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_pref_desc(): void
    {
        $column = 'pref';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 都道府県で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_pref_asc(): void
    {
        $column = 'pref';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 登録日で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_created_at_desc(): void
    {
        $column = 'created_at';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 登録日で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_created_at_asc(): void
    {
        $column = 'created_at';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 更新日で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_updated_at_desc(): void
    {
        $column = 'updated_at';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }

    /**
     * 更新日で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_updated_at_asc(): void
    {
        $column = 'updated_at';
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=' . $column . '&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc($column)->pluck($column)->values()->all();
        $actual = $data->pluck($column)->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }
}
