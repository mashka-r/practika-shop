<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $fillable = [ 'status'];

    const ORDER_STATUSES = [
        'status_processing'  => '1',
        'status_transit'     => '2',
        'status_delivered'   => '3',
        'status_received'    => '4',
        'status_cancel'      => '5',
        'status_return'      => '6',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
