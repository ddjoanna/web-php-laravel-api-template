<?php

namespace App\UseCases\UpdateCategory;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:categories,id',
            'name' => 'required|string',
            'parent_id' => 'nullable|integer|exists:categories,id',
            'layer' => 'required|integer|min:1',
            'sort_order' => 'required|integer',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => trans('validation.required', ['attribute' => '產品分類 ID']),
            'id.integer' => trans('validation.integer', ['attribute' => '產品分類 ID']),
            'id.exists' => trans('validation.exists', ['attribute' => '產品分類 ID']),
            'name.required' => trans('validation.required', ['attribute' => '分類名稱']),
            'name.string' => trans('validation.string', ['attribute' => '分類名稱']),
            'parent_id.integer' => trans('validation.integer', ['attribute' => '上層分類 ID']),
            'parent_id.exists' => trans('validation.exists', ['attribute' => '上層分類 ID']),
            'layer.required' => trans('validation.required', ['attribute' => '層級']),
            'layer.integer' => trans('validation.integer', ['attribute' => '層級']),
            'layer.min' => trans('validation.min', ['attribute' => '層級', 'min' => 1]),
            'sort_order.required' => trans('validation.required', ['attribute' => '排序權重']),
            'sort_order.integer' => trans('validation.integer', ['attribute' => '排序權重']),
            'is_active.required' => trans('validation.required', ['attribute' => '是否啟用']),
            'is_active.boolean' => trans('validation.boolean', ['attribute' => '是否啟用']),
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('category')]);
    }
}
