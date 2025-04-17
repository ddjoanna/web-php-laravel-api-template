<?php

namespace App\UseCases\ListProducts;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'nullable|string',
            'description' => 'nullable|string',
            'page' => 'nullable|integer|min:1',
            'page_size' => 'nullable|integer|min:1|max:100',
            'order_by' => 'nullable|string|in:id,name,description,price',
            'order_direction' => 'nullable|string|in:asc,desc',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => trans('validation.string', ['attribute' => '名稱']),
            'description.string' => trans('validation.string', ['attribute' => '描述']),
            'page.integer' => trans('validation.integer', ['attribute' => '頁碼']),
            'page.min' => trans('validation.min', ['attribute' => '頁碼', 'min' => 1]),
            'page_size.integer' => trans('validation.integer', ['attribute' => '每頁顯示數量']),
            'page_size.min' => trans('validation.min', ['attribute' => '每頁顯示數量', 'min' => 1]),
            'page_size.max' => trans('validation.max', ['attribute' => '每頁顯示數量', 'max' => 100]),
            'order_by.string' => trans('validation.string', ['attribute' => '排序欄位']),
            'order_by.in' => trans('validation.in', ['attribute' => '排序欄位', 'values' => 'id,name,description,price']),
            'order_direction.string' => trans('validation.string', ['attribute' => '排序方向']),
            'order_direction.in' => trans('validation.in', ['attribute' => '排序方向', 'values' => 'asc,desc']),
        ];
    }
}
