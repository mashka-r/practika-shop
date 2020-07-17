<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use  App\Http\Resources\OrderResource;
use App\Http\Requests\Orders\ForUpdateRequest;

class ManagerController extends Controller
{
    public function index()
    {
        $this->authorize('before', User::class); 
        $orders = Order::get();
        return OrderResource::collection($orders);
    }

    public function show($id)
    {
        $this->authorize('before', User::class);
        $orders = Order::where('id', $id)->get();
        return OrderResource::collection($orders);
    }

    public function update(ForUpdateRequest $request, $id)
    {
        $this->authorize('before', User::class);
        $order = Order::where('id', $id);
        $order->update($request->only('status'));
        $response = [
            'success' => true,
            'message' => 'Статус заказа обновлен',
        ];
    
        return response()->json($response);
    }
}
