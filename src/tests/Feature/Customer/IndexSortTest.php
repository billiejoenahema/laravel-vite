<?php

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
    public function setUp(): void
    {
        parent::setUp();

        /** @var \Illuminate\Contracts\Auth\Authenticatable $user */
        $this->user = User::factory()->create();

        $this->customers = Customer::factory()->count(10)->create();
    }

    /**
     * 氏名で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_name_desc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=name&is_asc=false');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortByDesc('name')->pluck('name'),
            $actual->pluck('name')
        );
    }

    /**
     * 氏名で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_name_asc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=name&is_asc=true');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortBy('name')->pluck('name'),
            $actual->pluck('name')
        );
    }

    /**
     * 年齢で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_age_desc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=age&is_asc=false');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortByDesc('age')->pluck('age'),
            $actual->pluck('age')
        );
    }

    /**
     * 年齢で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_age_asc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=age&is_asc=true');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortBy('age')->pluck('age'),
            $actual->pluck('age')
        );
    }

    /**
     * 性別で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_gender_desc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=gender&is_asc=false');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortByDesc('gender')->pluck('gender'),
            $actual->pluck('gender')
        );
    }

    /**
     * 性別で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_gender_asc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=gender&is_asc=true');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortBy('gender')->pluck('gender'),
            $actual->pluck('gender')
        );
    }

    /**
     * 電話番号で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_phone_desc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=phone&is_asc=false');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortByDesc('phone')->pluck('phone'),
            $actual->pluck('phone')
        );
    }

    /**
     * 電話番号で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_phone_asc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=phone&is_asc=true');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortBy('phone')->pluck('phone'),
            $actual->pluck('phone')
        );
    }

    /**
     * 生年月日で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_birth_date_asc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=birth_date&is_asc=false');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortByDesc('birth_date')->pluck('birth_date'),
            $actual->pluck('birth_date')
        );
    }

    /**
     * 生年月日で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_birth_date_desc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=birth_date&is_asc=true');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortBy('birth_date')->pluck('birth_date'),
            $actual->pluck('birth_date')
        );
    }

    /**
     * 都道府県で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_pref_desc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=pref&is_asc=false');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortByDesc('pref')->pluck('pref'),
            $actual->pluck('pref')
        );
    }

    /**
     * 都道府県で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_pref_asc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=pref&is_asc=true');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortBy('pref')->pluck('pref'),
            $actual->pluck('pref')
        );
    }

    /**
     * 登録日で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_created_at_desc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=created_at&is_asc=false');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortByDesc('created_at')->pluck('created_at'),
            $actual->pluck('created_at')
        );
    }

    /**
     * 登録日で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_created_at_asc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=created_at&is_asc=true');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortBy('created_at')->pluck('created_at'),
            $actual->pluck('created_at')
        );
    }

    /**
     * 更新日で顧客一覧を降順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_updated_at_desc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=updated_at&is_asc=false');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortByDesc('updated_at')->pluck('updated_at'),
            $actual->pluck('updated_at')
        );
    }

    /**
     * 更新日で顧客一覧を昇順ソートできること。
     *
     * @return void
     */
    public function test_sort_customers_by_updated_at_asc(): void
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_key=updated_at&is_asc=true');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortBy('updated_at')->pluck('updated_at'),
            $actual->pluck('updated_at')
        );
    }
}
