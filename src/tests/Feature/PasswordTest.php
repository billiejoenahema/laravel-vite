<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_hashCheck(): void
    {
        // 10文字のランダムな文字列を生成
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $plainText = mb_substr(str_shuffle(str_repeat($str, 10)), 0, 8);
        $hashedPassword = Hash::make($plainText);

        $this->assertTrue(Hash::check($plainText, $hashedPassword));
    }
}
