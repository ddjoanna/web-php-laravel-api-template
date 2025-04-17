<?php

namespace App\UseCases\ListCategories;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|string',
            'layer' => 'nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => trans('validation.string', ['attribute' => '分類名稱']),
            'layer.integer' => trans('validation.integer', ['attribute' => '層級']),
            'layer.min' => trans('validation.min', ['attribute' => '層級', 'min' => 1]),
        ];
    }
}
