<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;

class ForStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'  => 'required|min:3|max:255',
            'code'  => 'required|unique:categories|min:3|max:255',
        ];
    }
}
