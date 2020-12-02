<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Hash;

class ForUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'     => 'nullable|max:255',
            'email'    => 'nullable|email|unique:users',
            'image'    => 'mimes:png,jpeg,jpg',
            'role_id'  => 'integer|exists:roles,id',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'password' => (Hash::make($this->password)),
        ]);
    }
}
