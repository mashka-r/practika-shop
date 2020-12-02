<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    const TOTAL = 0;
    const VALUE = 7;

    protected $fillable = [
        'user_id',
        'temporary_key', 
        'product_id',
        'count',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);    
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
