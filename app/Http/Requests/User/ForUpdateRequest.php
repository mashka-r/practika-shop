<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Hash;

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
            'name'     => 'max:255',
            'email'    => 'email|unique:users',
            'password' => 'min:8|max:255',
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
