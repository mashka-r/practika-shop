<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ForStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'           => 'required',
            'category_id'    => 'required|integer|exists:categories,id',
            'code'           => 'required|unique:products',
            'price'          => 'required',
            'count_store'    => 'required|integer',
        ];
    }
}
