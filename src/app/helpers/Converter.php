<?php

namespace App\helpers;

class Converter
{
    /**
     * ハイフンを取り除いて数字を半角に変換する。
     *
     * @param string|null $value
     * @return ?string
     */
    public static function removeHyphen($value): ?string
    {
        if (is_null($value)) {
            return null;
        }
        // ハイフンを取り除く
        $hyphenRemovedValue = preg_replace('/[-－ー−―‐ｰ—₋]/', '', $value);
        // 数字を半角に変換する
        $halfWidthValue = mb_convert_kana($hyphenRemovedValue, "n");

        return $halfWidthValue;
    }
}
