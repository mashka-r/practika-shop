<?php

namespace App\Http\Requests\Orders;

use App\Models\Status;
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
        $a = Status::max('id');
        $b = (Status::min('id'));

        return [
            'status'      => 'required|integer|between:'.$b.','.$a,
        ];
    }
}
