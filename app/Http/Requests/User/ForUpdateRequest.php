<?php

namespace App\Http\Requests\User;

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
            'email'    => 'email',
            'image'    => 'mimes:png,jpeg,jpg',
        ];
    }
}
