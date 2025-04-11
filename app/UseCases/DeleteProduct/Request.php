<?php

namespace App\UseCases\DeleteProduct;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:products,id',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => trans('validation.required', ['attribute' => '產品 ID']),
            'id.integer' => trans('validation.integer', ['attribute' => '產品 ID']),
            'id.exists' => trans('validation.exists', ['attribute' => '產品 ID']),
        ];
    }


    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('product')]);
    }
}
