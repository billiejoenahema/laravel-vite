<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Requests\Customer;

use App\Enums\Gender;
use App\Enums\Prefecture;
use App\Http\Requests\Api\Customer\SaveRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Request;

final class SaveRequestTest extends RequestTestCase
{
    /**
     * @dataProvider provideValidationSuccessfulCases
     */
    public function testValidationSuccessful(array $data): void
    {
        $validator = $this->validate($data);

        if ($validator->fails()) {
            dump($validator->errors());
        }

        $this->assertTrue($validator->passes());
    }

    public static function provideValidationSuccessfulCases(): iterable
    {
        return [
            '最小のテスト' => [
                'data' => [
                    'name' => 'あ',
                    'name_kana' => 'あ',
                    'phone' => str_repeat('0', 10),
                    'gender' => Gender::NOT_KNOWN->value,
                    'postal_code' => str_repeat('0', 7),
                    'pref' => Prefecture::HOKKAIDO->value,
                    'city' => 'あ',
                    'street' => 'あ',
                    'note' => 'あ',
                ],
            ],
            '最大のテスト' => [
                'data' => [
                    'name' => str_repeat('あ', 50),
                    'name_kana' => str_repeat('あ', 50),
                    'phone' => str_repeat('0', 14),
                    'gender' => Gender::NOT_APPLICABLE->value,
                    'postal_code' => str_repeat('0', 7),
                    'pref' => Prefecture::OKINAWA->value,
                    'city' => str_repeat('あ', 50),
                    'street' => str_repeat('あ', 50),
                    'note' => str_repeat('あ', 500),
                ],
            ],
        ];
    }

    /**
     * @dataProvider provideValidationFailureCases
     */
    public function testValidationFailure(array $data, array $messages): void
    {
        $validator = $this->validate($data);

        $this->assertTrue($validator->fails());
        $this->assertSame($messages, $validator->errors()->toArray());
    }

    public static function provideValidationFailureCases(): iterable
    {
        return [
            '必須項目テスト' => [
                'data' => [],
                'messages' => [
                    'name' => ['名前は必ず指定してください。'],
                    'gender' => ['性別は必ず指定してください。'],
                ],
            ],
            '超過のテスト' => [
                'data' => [
                    'name' => str_repeat('あ', 51),
                    'name_kana' => str_repeat('あ', 51),
                    'phone' => str_repeat('0', 16),
                    'gender' => Gender::MALE->value,
                    'postal_code' => str_repeat('0', 8),
                    'city' => str_repeat('0', 51),
                    'street' => str_repeat('0', 51),
                    'note' => str_repeat('0', 501),
                ],
                'messages' => [
                    'name' => ['名前は、50文字以下で指定してください。'],
                    'name_kana' => ['ふりがなは、50文字以下で指定してください。'],
                    'phone' => ['電話番号は0から始まる10～14桁の半角数字で入力してください。'],
                    'postal_code' => ['郵便番号は7文字で指定してください。'],
                    'city' => ['市区町村は、50文字以下で指定してください。'],
                    'street' => ['番地は、50文字以下で指定してください。'],
                    'note' => ['備考は、500文字以下で指定してください。'],
                ],
            ],
            '電話番号と郵便番号の桁不足のテスト' => [
                'data' => [
                    'name' => str_repeat('あ', 50),
                    'phone' => str_repeat('0', 9),
                    'gender' => Gender::MALE->value,
                    'postal_code' => str_repeat('0', 6),
                ],
                'messages' => [
                    'phone' => ['電話番号は0から始まる10～14桁の半角数字で入力してください。'],
                    'postal_code' => ['郵便番号は7文字で指定してください。'],
                ],
            ],
            '電話番号と郵便番号が全角数字のテスト' => [
                'data' => [
                    'name' => str_repeat('あ', 50),
                    'phone' => str_repeat('０', 10),
                    'gender' => Gender::MALE->value,
                    'postal_code' => str_repeat('０', 7),
                ],
                'messages' => [
                    'phone' => ['電話番号は0から始まる10～14桁の半角数字で入力してください。'],
                    'postal_code' => ['郵便番号は半角数字のみで入力してください。'],
                ],
            ],
        ];
    }

    private function validate(array $data): Validator
    {
        $request = SaveRequest::create(
            '/api/customers/1',
            Request::METHOD_PATCH,
            $data
        );

        return validator($data, $request->rules(), $request->messages(), $request->attributes());
    }
}
