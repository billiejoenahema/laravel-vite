<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Customer([
            'name' => $row['氏名'],
            'name_kana' => $row['ふりがな'],
            'phone' => $row['電話番号'],
            'gender' => $row['性別'],
            'birth_date' => $row['生年月日'],
            'postal_code' => $row['郵便番号'],
            'pref' => $row['都道府県'],
            'city' => $row['市区町村'],
            'street' => $row['番地'],
            'note' => $row['備考'],
        ]);
    }
}
