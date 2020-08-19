<?php

namespace App\Http\Requests\Orders;

use Illuminate\Foundation\Http\FormRequest;
use Config;
use Auth;

class ForUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $role = Config::get('constants.roles.role_user');

        if ((boolean)(Auth::user()->roles->where('id', $role)->count())) {
            $a = Config::get('constants.status.status_return'); 
            $b = Config::get('constants.status.status_received'); 
           
        } else {
            $a = Config::get('constants.status.status_delivered'); 
            $b = Config::get('constants.status.status_processing'); 
        };

        return [
            'status'    => 'required|integer|between:'.$b.','.$a,
        ];
    }
}
