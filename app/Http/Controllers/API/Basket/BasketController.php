<?php

namespace App\Http\Controllers\API\Basket;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Basket;
use  App\Http\Resources\BasketResource;
use App\Http\Controllers\Controller;
use Auth;

class BasketController extends Controller
{
     public function basketCheck(Request $request) 
    {
        $value = 4;
        $temporary_key = $request->cookie('temporary_key') ? $request->cookie('temporary_key') 
                                    : setcookie('temporary_key', $value, time()+3600);
        
        $basket = Basket::whereTemporary_key($temporary_key)->get();
        $total = 0;

        foreach ($basket as $item) {
            $total += $item->count * $item->product->price;
        }
        return response()->json(['товары' => BasketResource::collection($basket), 
                                    'стоимость корзины (руб.)' => $total]);
    }

    public function basketAdd(Request $request, Product $product) 
    {
        $value = 4;
        $temporary_key = $request->cookie('temporary_key') ? $request->cookie('temporary_key') 
                                    : setcookie('temporary_key', $value, time()+3600);
                                    
        if ($product->count_store - $product->count_res > 0) {
            $basket = Basket::firstOrCreate(['temporary_key' => $temporary_key, 
                                                'user_id'    => Auth::id(),
                                                'product_id' => $product->id]);

            $basket->increment('count');
        } else {
            return 'Товар отсутствует на складе';
        }
    }

    public function basketRemove(Request $request, Product $product) 
    {
        $value = 4;
        $temporary_key = $request->cookie('temporary_key') ? $request->cookie('temporary_key') 
                            : setcookie('temporary_key', $value, time()+3600);

        $basket = Basket::firstOrCreate(['temporary_key' => $temporary_key, 
                                            'user_id'    => Auth::id(),
                                            'product_id' => $product->id]);
                                            
        if ($basket->count > 1) {
            $basket->decrement('count');

        }  else {
            $basket->delete();

        }

    }

    public function basketConfirm(Request $request)  {
        $value = 4;
        $temporary_key = $request->cookie('temporary_key') ? $request->cookie('temporary_key') 
                    : setcookie('temporary_key', $value, time()+3600);

        $products = Basket::whereTemporary_key($temporary_key)->get();
       
        if (!count($products)) {
            return 'Ваша корзина пуста';
            
        } else {
            $order = Order::create(['user_id' => Auth::id()]);
        
            foreach ($products as $product) {
                $order->products()->attach($product->product_id);
                $pivotRow = $order->products()
                                ->where('product_id',$product->product_id)
                                ->first()->pivot;
                                    
                $pivotRow->count = $product->count; 
                $pivotRow->update();

                $rowCountRes = Product::find($product->product_id);
                $rowCountRes->count_res += $product->count;
                $rowCountRes->save();
            }

            $success = $order->saveOrder($order->id, $request->name, $request->email);
            if ($success) {
                Basket::whereTemporary_key($temporary_key)->delete();
           }
        }
    }
}
