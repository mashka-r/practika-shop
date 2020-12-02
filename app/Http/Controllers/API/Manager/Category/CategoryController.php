<?php

namespace App\Http\Controllers\API\Manager\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\Categories\ForUpdateRequest;
use App\Http\Requests\Categories\ForStoreRequest;

class CategoryController extends Controller
{
    public function index()
    {
        return response(CategoryResource::collection(Category::all()));
    }

    public function store(ForStoreRequest $request)
    {
        $category = Category::create($request->validated());

        return response(CategoryResource::make($category));
    }

    public function show(Category $category)
    {
        return response(CategoryResource::make($category));
    }

    public function update(ForUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        return response(CategoryResource::make($category->refresh()));
    }

    public function destroy(Category $category)
    {
        if  (Product::where('category_id', $category->id)->count()) {
            $response = [
                'success' => false,
                'message' => 'Категорию удалить нельзя!',
            ];

        } else {
            $response = [
                'success' => true,
                'message' => 'Категория удалена!',
            ];

            $category->delete();
        }

        return response()->json($response);
    }
}
