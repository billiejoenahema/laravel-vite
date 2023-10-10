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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=name&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc('name')->pluck('name')->values()->all();
        $actual = $data->pluck('name')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=name&is_asc=true');

        $response->assertStatus(200);
        $data = collect($response->json('data'));
        $expected = $data->sortBy('name')->pluck('name')->values()->all();
        $actual = $data->pluck('name')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=age&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc('age')->pluck('age')->values()->all();
        $actual = $data->pluck('age')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=age&is_asc=true');

        $response->assertStatus(200);
        $data = collect($response->json('data'));
        $expected = $data->sortBy('age')->pluck('age')->values()->all();
        $actual = $data->pluck('age')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=gender&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc('gender')->pluck('gender')->values()->all();
        $actual = $data->pluck('gender')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=gender&is_asc=true');

        $response->assertStatus(200);
        $data = collect($response->json('data'));
        $expected = $data->sortBy('gender')->pluck('gender')->values()->all();
        $actual = $data->pluck('gender')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=phone&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc('phone')->pluck('phone')->values()->all();
        $actual = $data->pluck('phone')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=phone&is_asc=true');

        $response->assertStatus(200);
        $data = collect($response->json('data'));
        $expected = $data->sortBy('phone')->pluck('phone')->values()->all();
        $actual = $data->pluck('phone')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=birth_date&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc('birth_date')->pluck('birth_date')->values()->all();
        $actual = $data->pluck('birth_date')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=birth_date&is_asc=true');

        $response->assertStatus(200);
        $data = collect($response->json('data'));
        $expected = $data->sortBy('birth_date')->pluck('birth_date')->values()->all();
        $actual = $data->pluck('birth_date')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=pref&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc('pref')->pluck('pref')->values()->all();
        $actual = $data->pluck('pref')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=pref&is_asc=true');

        $response->assertStatus(200);
        $data = collect($response->json('data'));
        $expected = $data->sortBy('pref')->pluck('pref')->values()->all();
        $actual = $data->pluck('pref')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=created_at&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc('created_at')->pluck('created_at')->values()->all();
        $actual = $data->pluck('created_at')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=created_at&is_asc=true');

        $response->assertStatus(200);
        $data = collect($response->json('data'));
        $expected = $data->sortBy('created_at')->pluck('created_at')->values()->all();
        $actual = $data->pluck('created_at')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=updated_at&is_asc=false');

        $data = collect($response->json('data'));
        $expected = $data->sortByDesc('updated_at')->pluck('updated_at')->values()->all();
        $actual = $data->pluck('updated_at')->values()->all();

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
        $response = $this->actingAs($this->generalUser)->getJson('/api/customers?sort_key=updated_at&is_asc=true');

        $response->assertStatus(200);
        $data = collect($response->json('data'));
        $expected = $data->sortBy('updated_at')->pluck('updated_at')->values()->all();
        $actual = $data->pluck('updated_at')->values()->all();

        $this->assertSame(
            $expected,
            $actual,
        );
    }
}
