<?php

namespace App\Http\Controllers\API\Manager;

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

    public function show($id)
    {
        return response(OrderResource::make(Order::find($id)));
    }

    public function update(ForUpdateRequest $request, $id)
    {
        $order = Order::find($id);
        $order->update($request->validated());
    
        return response(OrderResource::make($order));
    }
}
