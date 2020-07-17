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

        public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function saveOrder($id, $name, $email) 
    {
        $order = Order::find($id);
        if ($order->status == 0) {
            $order->name = $name;
            $order->email = $email;
            $order->status = 1;
            $order->save(); 
            return true;

        } else {
            $order->delete();
            return false;
        }
    }
}
