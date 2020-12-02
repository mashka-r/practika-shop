<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;

class ForUpdateRequest extends FormRequest
{
    public function rules()
    {

        return [
            'description'   => 'nullable|min:3|max:255',
            'name'          => 'nullable|min:3|max:255',
            'code'          => 'nullable|min:3|max:255',
        ];
    }
}
