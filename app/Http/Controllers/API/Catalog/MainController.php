<?php

namespace App\Http\Controllers\API\Catalog;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Product;

class MainController extends Controller
{
    public function index(Product $product = null) 
    {
        if (!$product) {
            return response(ProductResource::collection(Product::all()));
        } else {
            return response(ProductResource::make($product));
        }
    }

    public function categories(Category $category = null) 
    {
        if (!$category) {
            return response(CategoryResource::collection(Category::all()));
        } else {
            return response(ProductResource::collection(Product::whereCategory_id($category->id)->get()));
        }
    }

    public function product(Category $category, Product $product) 
    {
        return response(ProductResource::make($product));
    }

}
