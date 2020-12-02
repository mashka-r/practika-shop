<?php

namespace App\Http\Controllers\API\Catalog\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return response(CategoryResource::collection(Category::all()));
    }

    public function show(Category $category)
    {
        return response(CategoryResource::make($category));
    }

}
