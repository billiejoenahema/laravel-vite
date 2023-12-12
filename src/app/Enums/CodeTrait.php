<?php

declare(strict_types=1);

namespace App\Enums;

trait CodeTrait
{
    /**
     * caseのスカラー値とcaseに対応するテキストの配列を返す。
     */
    public static function toArray(): array
    {
        return array_map(static function (self $case) {
            return [
                'id' => $case->value,
                'name' => $case->text(),
            ];
        }, self::cases());
    }

    /**
     * caseの一覧の配列を返す。
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * caseのスカラー値一覧の配列を返す。
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * スカラー値の配列からランダムに1つ値を返す。
     */
    public static function randomValue(): string|int
    {
        return self::values()[array_rand(self::values())];
    }
}
