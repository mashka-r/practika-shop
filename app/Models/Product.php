<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 
        'category_id', 
        'code',
        'description',
        'price',
        'count_store',
        'count_res'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function baskets()
    {
        return $this->hasMany(Basket::class);
    }

}
