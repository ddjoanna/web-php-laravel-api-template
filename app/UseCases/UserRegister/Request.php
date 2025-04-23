<?php

namespace App\UseCases\UserRegister;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => trans('validation.required', ['attribute' => '名稱']),
            'email.required' => trans('validation.required', ['attribute' => '電子郵件']),
            'email.unique' => trans('validation.unique', ['attribute' => '電子郵件']),
            'password.required' => trans('validation.required', ['attribute' => '密碼']),
            'password.confirmed' => trans('validation.confirmed', ['attribute' => '密碼']),
        ];
    }
}
