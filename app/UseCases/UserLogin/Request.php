<?php

namespace App\UseCases\UserLogin;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string',
            'password' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => trans('validation.required', ['attribute' => '電子郵件']),
            'password.required' => trans('validation.required', ['attribute' => '密碼']),
        ];
    }
}
