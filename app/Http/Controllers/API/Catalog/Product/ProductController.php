<?php

namespace App\Http\Controllers\API\Catalog\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return response(ProductResource::collection(Product::all()));
    }

    public function show(Product $product)
    {
        return response(ProductResource::make($product));
    }

}
