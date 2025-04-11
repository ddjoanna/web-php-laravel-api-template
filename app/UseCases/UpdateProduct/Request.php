<?php

namespace App\UseCases\UpdateProduct;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:products,id',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => trans('validation.required', ['attribute' => '產品 ID']),
            'id.integer' => trans('validation.integer', ['attribute' => '產品 ID']),
            'id.exists' => trans('validation.exists', ['attribute' => '產品 ID']),
            'name.required' => trans('validation.required', ['attribute' => '名稱']),
            'description.required' => trans('validation.required', ['attribute' => '描述']),
            'price.required' => trans('validation.required', ['attribute' => '價格']),
            'price.numeric' => trans('validation.numeric', ['attribute' => '價格']),
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('product')]);
    }
}
