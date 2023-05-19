<?php

namespace App\Http\Requests\Api\Customer;

use App\Enums\Gender;
use App\Enums\Prefecture;
use App\helpers\Converter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'name_kana' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date:Y-m-d',
            'phone' => 'nullable|string|max:20|regex:/^[0-9]+$/',
            'gender' => ['required', 'string', Rule::in(Gender::values())],
            'postal_code' => 'nullable|string|size:7|regex:/^[0-9]+$/',
            'pref' => ['nullable', Rule::in(Prefecture::values())],
            'city' => 'nullable|string|max:50',
            'street' => 'nullable|string|max:50',
        ];
    }

    /**
     * バリデーションエラーのカスタム属性の取得
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => '名前',
            'kana_name' => 'ふりがな',
            'birth_date' => '生年月日',
            'phone' => '電話番号',
            'gender' => '性別',
            'postal_code' => '郵便番号',
            'pref' => '都道府県',
            'city' => '市区町村',
            'street' => '番地',
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return [
            'phone.regex' => '電話番号は数字とハイフンのみで入力してください。',
            'postal_code.regex' => '郵便番号は数字のみで入力してください。',
        ];
    }

    /**
     * バリーデーションのためにデータを準備
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        // 郵便番号、電話番号のハイフンを取り除く
        $this->merge([
            'phone' => Converter::removeHyphen($this->phone),
            'postal_code' => Converter::removeHyphen($this->postal_code),
        ]);
    }
}
