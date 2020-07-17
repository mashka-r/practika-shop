<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Cart;

class BasketController extends Controller
{
    public function basket() 
    {
        if (!Session::has('cart')) {
            return view('basket');
        } 
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        return view ('basket', ['products' => $cart->items, 
                                    'totalPrice' => $cart->totalPrice]);
    }

    public function basketConfirm(Request $request) 
    {
        $cart = Session::get('cart');
        $order = Order::create();
        $products = $cart->items;

        foreach ($products as $product) {
            $order->products()->attach($product['item']);
            
            $pivotRow = $order->products()->where('product_id', $product['item']['id'])
                                          ->first()->pivot;
            $pivotRow->count = $product['qty']; 
            $pivotRow->update();

            $rowCountRes = Product::find($product['item']['id']);
            $rowCountRes->count_res = $product['qty'];
            $rowCountRes->save();
        }
        
        $success = $order->saveOrder($order->id, $request->name, $request->email);
        if ($success) {
            session()->flash('success', 'Ваш заказ принят в обработку');
            $request->session()->forget('cart');
        } else {
            session()->flash('warning', 'Что-то пошло не так');
        }

        return redirect()->route('index');
    }

    public function basketPlace() {
        $cart = Session::get('cart');
        return view ('order', ['products' => $cart->items, 
                            'totalPrice' => $cart->totalPrice]);
    }

    public function basketAdd(Request $request, $id) 
    {
        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : null;

        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);
        $request->session()->put('cart', $cart);

        return redirect()->route('basket');
    }

    public function basketRemove(Request $request, $id) 
    {

        $product = Product::find($id);
        $oldCart = Session::has('cart') ? Session::get('cart') : redirect()->route('basket');
        
        $cart = new Cart($oldCart);
        $cart->del($product, $product->id);

        $request->session()->put('cart', $cart);
        session()->flash('success', 'Товар '. $product->name.' удален.');

        return redirect()->route('basket');
    }
}
