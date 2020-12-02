<?php

namespace App\Http\Controllers\API\Basket;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Basket;
use  App\Http\Resources\BasketResource;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class BasketController extends Controller
{
     public function basketCheck(Request $request) 
    {
        $total = Basket::TOTAL;
        $temporary_key = $request->cookie('temporary_key') 
                                    ? $request->cookie('temporary_key') 
                                    : setcookie('temporary_key', Basket::VALUE, time()+3600);
        
        $basket = Basket::whereTemporary_key($temporary_key)->get();

        foreach ($basket as $item) {
            $total += $item->count * $item->product->price;
        }
        return response()->json(['товары' => BasketResource::collection($basket), 
                                    'стоимость корзины (руб.)' => $total]);
    }

    public function basketAdd(Request $request, Product $product) 
    {
        $temporary_key = $request->cookie('temporary_key') ? $request->cookie('temporary_key') 
                                    : setcookie('temporary_key', Basket::VALUE, time()+3600);
                                    
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
        $temporary_key = $request->cookie('temporary_key') ? $request->cookie('temporary_key') 
                            : setcookie('temporary_key', Basket::VALUE, time()+3600);

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

        $temporary_key = $request->cookie('temporary_key') ? $request->cookie('temporary_key') 
                    : setcookie('temporary_key', Basket::VALUE, time()+3600);

        $products = Basket::whereTemporary_key($temporary_key)->get();
    
        DB::beginTransaction();
        try {
            if ($products->isEmpty()) {
                throw new CreateOrderException('Ваша корзина пуста');
            
            }
            $order = Order::create(['user_id' => Auth::id()]);

            $order->name = $request->name;
            $order->email = $request->email;
            $order->status = 1;
            $order->save(); 

            $products->each(function (Basket $product) use ($order) {
                $order->products()->attach($product->product_id);
                DB::table('order_product')->where('order_id', $order->id)
                                        ->where('product_id',$product->product_id)
                                        ->update(['count' => $product->count]);
                        
                Product::find($product->product_id)->increment('count_res', $product->count);
            });
            Basket::whereTemporary_key($temporary_key)->delete();
        
            DB::commit();

        } catch (CreateOrderException $e) {
                DB::rollBack();
                return response()->json(['message' => $e->getMessage()], 403);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Что-то пошло не так'], 500);
        }

        return response()->json(['message' => 'Заказ принят в обработку']);
        
    }
}
