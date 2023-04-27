<?php

declare(strict_types=1);

namespace App\Enums;

enum Gender: string
{
    use CodeTrait;

    case NOT_KNOWN = '00';
    case MALE = '01';
    case FEMALE = '02';
    case NOT_APPLICABLE = '09';

    /**
     * @return string
     */
    public function text(): string
    {
        return match ($this) {
            self::NOT_KNOWN => '不明',
            self::MALE => '男性',
            self::FEMALE => '女性',
            self::NOT_APPLICABLE => '適用不能',
        };
    }
}
