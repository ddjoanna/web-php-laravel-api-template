<?php

namespace App\UseCases\CreateProduct;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => trans('validation.required', ['attribute' => '名稱']),
            'description.required' => trans('validation.required', ['attribute' => '描述']),
            'price.required' => trans('validation.required', ['attribute' => '價格']),
            'price.numeric' => trans('validation.numeric', ['attribute' => '價格']),
        ];
    }
}
