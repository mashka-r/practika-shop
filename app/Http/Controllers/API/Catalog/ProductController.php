<?php

namespace App\Http\Controllers\API\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Http\Requests\Products\ForUpdateRequest;
use App\Http\Requests\Products\ForStoreRequest;

class ProductController extends Controller
{
    public function index()
    {
        return response(ProductResource::collection(Product::all()));
    }

    public function store(ForStoreRequest $request)
    {
        $product = Product::create($request->validated());

        return response(ProductResource::make($product));
    }

    public function show($id)
    {
        return response(ProductResource::make(Product::find($id)));
    }

    public function update(ForUpdateRequest $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->validated());
        
        return response(ProductResource::make($product));
    }

    public function destroy($id)
    {
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

        return response($response);
    }
}
