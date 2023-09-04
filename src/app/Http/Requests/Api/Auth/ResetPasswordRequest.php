<?php

namespace App\Http\Requests\Api\Auth;

use App\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' => ['required', 'string', 'max:255', 'email:filter,rfc,spoof'],
            'password' => ['required', new Password, 'min:8', 'max:32'],
            'token' => ['required', 'string'],
        ];
    }
}
