<?php

namespace App\UseCases\UserProfile;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => trans('validation.required', ['attribute' => '用戶 ID']),
            'id.integer' => trans('validation.integer', ['attribute' => '用戶 ID']),
            'id.exists' => trans('validation.exists', ['attribute' => '用戶 ID']),
        ];
    }

    protected function prepareForValidation()
    {
        $token = $this->user()->currentAccessToken()->token ?? null;
        $user_id = $this->user()->id ?? null;
        $this->merge(['id' => $user_id]);
    }
}
