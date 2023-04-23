<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログアウトできること。
     */
    public function test_logoutSuccess(): void
    {
        $user = User::factory()->create();
        $user = $this->actingAs($user);
        $response = $user->postJson('/logout');

        $response->assertStatus(200);
        $this->assertGuest();
    }
}
