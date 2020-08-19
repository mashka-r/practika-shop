<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Config;
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
            'image'    => 'mimes:png,jpeg,jpg',
            'role_id'  => 'integer|between:'.min(Config::get('constants.roles')).','.max(Config::get('constants.roles')),
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'password' => (Hash::make($this->password)),
        ]);
    }
}
