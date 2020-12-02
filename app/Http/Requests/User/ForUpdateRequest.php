<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Hash;

class ForUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'     => 'nullable|max:255',
            'email'    => 'nullable|email|unique:users',
            'password' => 'nullable|min:8|max:255',
            'image'    => 'mimes:png,jpeg,jpg',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'password' => (Hash::make($this->password)),
        ]);
    }
}
