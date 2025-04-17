<?php

namespace App\UseCases\GetCategory;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => trans('validation.required', ['attribute' => '產品分類 ID']),
            'id.integer' => trans('validation.integer', ['attribute' => '產品分類 ID']),
            'id.exists' => trans('validation.exists', ['attribute' => '產品分類 ID']),
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('category')]);
    }
}
