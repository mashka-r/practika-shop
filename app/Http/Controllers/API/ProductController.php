<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use  App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use App\Http\Requests\Products\ForUpdateRequest;
use App\Http\Requests\Products\ForStoreRequest;

class ProductController extends Controller
{
    public function index()
    {
        $this->authorize('before', User::class); 
        $products = Product::get();
        return ProductResource::collection($products);
    }

    public function store(ForStoreRequest $request)
    {
        $this->authorize('before', User::class); 

        $product = Product::create([
            'name'           => request('name'),
            'category_id'    => request('category_id'),
            'code'           => request('code'),
            'description'    => request('description'),
            'price'          => request('price'),
            'count_store'    => request('count_store'),
        ]);


        $response = [
            'success' => true,
            'message' => 'Товар успешно добавлен',
        ];
        
        return response()->json($response);
    }

    public function show($id)
    {
        $this->authorize('before', User::class);
        $products = Product::where('id', $id)->get();
        return ProductResource::collection($products);
    }

    public function update(ForUpdateRequest $request, $id)
    {
        $this->authorize('before', User::class);
        $product = Product::where('id', $id);
        $product->update($request->only(
            'name', 'code', 'category_id','description','price', 'count_store'));
    
    }

    public function destroy($id)
    {
        $this->authorize('before', User::class); 

        $product = Product::find($id);
        
        if ($product->count_store == 0 && $product->count_res == 0) {
            $product->delete();
            $response = [
                'success' => true,
                'message' => 'Товар удален.',
            ];

        } else {
            $response = [
                'success' => false,
                'message' => 'Данный товар остался на складе иди участвует в активном заказе.',
            ];
        }

        return response()->json($response);
    }
}
