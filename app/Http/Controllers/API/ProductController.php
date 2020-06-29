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
        $product->update($request->all());
    
    }

    public function destroy($id)
    {
        $this->authorize('before', User::class); 

        $product = Product::find($id);
        $product->delete();
        
    }
}
