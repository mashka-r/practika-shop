<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ForUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'price'         => 'nullable|float',
            'name'          => 'nullable',
            'code'          => 'nullable|unique:products',
            'category_id'   => 'nullable|integer|exists:categories,id',
            'count_store'   => 'nullable|integer',
        ];
    }
}
