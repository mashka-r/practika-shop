<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Hash;

class ForStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    { 
        return [
            'name'     => 'required|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8|max:255',
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
