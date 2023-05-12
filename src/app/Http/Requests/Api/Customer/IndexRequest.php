<?php

namespace App\Http\Requests\Api\Customer;

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
     * ソート対象のカラムを返す。nullならデフォルト値の'id'を返す。
     *
     * @return string
     */
    public function getSortColumn(): string
    {
        $columns = [
            'ulid',
            'name',
            'gender',
            'phone',
            'birth_date',
            'pref',
        ];

        $key = array_search($this->sort_value, $columns);

        if (!$key) {
            return 'ulid';
        }

        return $columns[$key];
    }

    /**
     * ソートの方向を返す。
     *
     * @return string
     */
    public function getSortDirection(): string
    {
        if ($this->is_asc === 'true') {
            return 'asc';
        } else {
            return 'desc';
        }
    }
}
