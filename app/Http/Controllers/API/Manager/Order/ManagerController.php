<?php

namespace App\Http\Controllers\API\Manager\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Http\Requests\Orders\ForUpdateRequest;

class ManagerController extends Controller
{
    public function index()
    {
        return response(OrderResource::collection(Order::all()));
    }

    public function show(Order $order)
    {
        return response(OrderResource::make(($order)));
    }

    public function update(ForUpdateRequest $request, Order $order)
    {
        $order->update($request->validated());
        return response(OrderResource::make($order->refresh()));
    }
}
