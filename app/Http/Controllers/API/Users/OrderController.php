<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Requests\Orders\ForUpdateRequest;
use App\Models\Order;
use Config;
use Auth;

class OrderController extends Controller
{
    public function show(Order $order = null)
    {
        if (!$order) {
            return response(OrderResource::collection(Order::where('user_id', Auth::id())->get()));
        } else {
            return response(OrderResource::make($order));
        }
        

        return response(OrderResource::collection($orders));
    }

    public function update(ForUpdateRequest $request, Order $order)
    {
        if ($order->user_id == Auth::id()) {

            $order->update($request->validated());
            return response(OrderResource::make($order));
        }

    }

    public function delete(Order $order)
    { 
        if (($order->user_id == Auth::id()) && 
                ($order->status > (Config::get('constants.status.status_delivered')))) {

            $order->delete();

            $response = [
                'message' => 'Заказ удален.',
            ];

        } else {
            $response = [
                'message' => 'Заказ удалить нельзя!.',
            ];
        }

        return response($response);
    }
}
