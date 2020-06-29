<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Role;

class ForStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $a = Role::max('id');
        $b = (Role::min('id')) + 1;

        return [
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required',
            'role_id'  => 'required|integer|between:'.$b.','.$a
        ];
    }
}
