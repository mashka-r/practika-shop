<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('count')->withTimestamps();
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status');
    }

    public function getFullPrice()
    {
        $sum = 0;
        foreach ($this->products as $product) {
            $sum += $product->getPriceForCount();
           
        }
        return $sum;
    }

    public function saveOrder($name, $email) 
    {
        if ($this->status == 0) {
            $this->name = $name;
            $this->email = $email;
            $this->status = 1;
            $this->save(); 
            session()->forget('orderId');

            return true;

        } else {
            return false;
        }
        
    }
    
}
