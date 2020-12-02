<?php

namespace App\Http\Requests\Orders;

use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Auth;

class ForUpdateRequest extends FormRequest
{
    public function rules()
    {
        if (Auth::user()->isClient()) {
            $a = Status::ORDER_STATUSES['status_return']; 
            $b = Status::ORDER_STATUSES['status_received'];
           
        } else {
           
            $a = Status::ORDER_STATUSES['status_delivered'];
            $b = Status::ORDER_STATUSES['status_processing'];
        };
        
        return [
            'status'    => 'required|integer|in:{$b},{$a}',
        ];
    }
}
