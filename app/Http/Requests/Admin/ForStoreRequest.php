<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Hash;

class ForStoreRequest extends FormRequest
{
    public function rules()
    {

        return [
            'name'     => 'required|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|max:255',
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
