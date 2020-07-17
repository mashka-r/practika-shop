<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;

class ForUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'description'   => 'min:3|max:255',
            'name'          => 'min:3|max:255',
            'code'          => 'min:3|max:255',
        ];
    }
}
