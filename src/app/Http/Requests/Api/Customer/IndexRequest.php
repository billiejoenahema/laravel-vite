<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Customer;

use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }

    /**
     * ソート対象のカラムを返す(nullならデフォルト値を返す)
     */
    public function getSortColumn(): string
    {
        $key = array_search($this->sort_key, Customer::SORTABLE_COLUMNS, true);

        if ($key === false) {
            return Customer::DEFAULT_SORT_COLUMN;
        }

        return Customer::SORTABLE_COLUMNS[$key];
    }

    /**
     * ソートの方向を返す。
     */
    public function getSortDirection(): string
    {
        if ($this->is_asc === 'true') {
            return 'asc';
        } else {
            return 'desc';
        }
    }

    /**
     * 入力値（年齢）から生年月日を絞り込むfromの値を返す。
     */
    public function getBirthDateValueByAgeFrom(): string
    {
        return now()->subYears($this->search_value['age_from'])->format('Y-m-d');
    }

    /**
     * 入力値（年齢）から生年月日を絞り込むtoの値を返す。
     */
    public function getBirthDateValueByAgeTo(): string
    {
        return now()->subYears($this->search_value['age_to'])->format('Y-m-d');
    }
}
