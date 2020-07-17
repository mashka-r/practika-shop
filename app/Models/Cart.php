<?php

namespace App\Models;
use App\Models\Product;

class Cart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if ($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
            
    }

    public function add($item, $id) {
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }

        $product = Product::find($id);
        if (($product->count_store - ($product->count_res +  $storedItem['qty'])) > 0) {

            $storedItem['qty']++;
            $storedItem['price'] = $item->price * $storedItem['qty'];
            $this->items[$id] = $storedItem;
            $this->totalQty++;
            $this->totalPrice += $item->price;

            session()->flash('success', 'Добавлен товар '. $product->name);
        } else {
            session()->flash('warning', 'В данный момент товар '. $product->name.' отсутствует на складе');
        }
    }

    public function del($item, $id) {
        $storedItem = ['qty' => 0, 'price' => $item->price, 'item' => $item];
        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }

        $storedItem['qty']--;
        $storedItem['price'] = $item->price * $storedItem['qty'];
        $this->items[$id] = $storedItem;
        $this->totalQty--;
        $this->totalPrice -= $item->price;
        
        if ($storedItem['qty'] == 0) {
            unset($this->items[$id]);
        }
    }
}
