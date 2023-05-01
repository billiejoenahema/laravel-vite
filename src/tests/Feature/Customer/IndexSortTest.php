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
    public function test_sortIndexByNameDesc()
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_value=name&is_asc=false');

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
    public function test_sortIndexByNameAsc()
    {
        $response = $this->actingAs($this->user)->getJson('/api/customers?sort_value=name&is_asc=true');

        $response->assertStatus(200);
        $actual = collect($response->json('data'));
        $this->assertEquals(
            $actual->sortBy('name')->pluck('name'),
            $actual->pluck('name')
        );
    }
}
