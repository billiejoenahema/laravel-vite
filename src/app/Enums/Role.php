<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: string
{
    use CodeTrait;

    case ADMIN = '01';
    case GENERAL = '02';

    public function text(): string
    {
        return match ($this) {
            self::ADMIN => '管理者',
            self::GENERAL => '一般ユーザー',
        };
    }
}
