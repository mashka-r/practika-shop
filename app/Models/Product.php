<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 
        'category_id', 
        'code',
        'description',
        'price',
        'count_store',
        'count_res'
    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function baskets()
    {
        return $this->hasMany(Basket::class);
    }

}
