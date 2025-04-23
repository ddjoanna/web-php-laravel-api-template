<?php

namespace App\UseCases\UserLogout;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'token' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'token.required' => trans('validation.required', ['attribute' => 'Token']),
            'token.string' => trans('validation.string', ['attribute' => 'Token']),
        ];
    }

    protected function prepareForValidation()
    {
        $token = $this->user()->currentAccessToken()->token ?? null;
        $this->merge(['token' => $token]);
    }
}
