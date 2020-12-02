<?php

namespace App\Http\Controllers\API\Users\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Requests\Orders\ForUpdateRequest;
use App\Models\Order;
use Auth;

class OrderController extends Controller
{
    public function index()
    {
        return response(OrderResource::collection(Order::whereUser_id(Auth::id())->get()));
    }

    public function show(Order $order)
    {
        if ($order->user_id === Auth::id()) {
            return response(OrderResource::make($order));
        }
        
    }

    public function update(ForUpdateRequest $request, Order $order)
    {
        if ($order->user_id === Auth::id()) {
            $order->update($request->validated());
            
            return response(OrderResource::make($order->refresh()));
        }

    }
}
