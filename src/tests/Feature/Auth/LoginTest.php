<?php

declare(strict_types=1);

namespace Tests\Feature\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

final class LoginTest extends TestCase
{
    use RefreshDatabase;

    private $data;

    /**
     * テスト前の共通処理
     */
    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed --class=UserSeeder');

        $this->correctData = [
            'email' => 'test@example.com',
            'password' => 'test_user',
        ];

        $this->wrongEmailData = [
            'email' => 'wrong_email@example.com',
            'password' => 'test_user',
        ];
        $this->wrongPasswordData = [
            'email' => 'test@example.com',
            'password' => 'wrong_password',
        ];

        $this->url = env('HOME_URL') . '/sanctum/csrf-cookie';
    }

    /**
     * 正しいメールアドレスとパスワードでゲストログインできること。
     *
     * @return void
     */
    public function test_loginSuccess()
    {
        $this->getJson($this->url);
        $this->postJson('/login', $this->correctData)->assertOk();
    }

    /**
     * メールアドレスが誤っているとログインできないこと。
     *
     * @return void
     */
    public function test_wrongEmailLoginFailure()
    {
        $this->getJson($this->url);
        $this->postJson('/login', $this->wrongEmailData)->assertUnauthorized();
    }

    /**
     * パスワードが誤っているとログインできないこと。
     *
     * @return void
     */
    public function test_wrongPasswordLoginFailure()
    {
        $this->getJson($this->url);
        $this->postJson('/login', $this->wrongPasswordData)->assertUnauthorized();
    }
}
