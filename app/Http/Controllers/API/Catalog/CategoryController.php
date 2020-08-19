<?php

namespace App\Http\Controllers\API\Catalog;

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

    public function show($id)
    {
        return response(CategoryResource::make(Category::get($id)));
    }

    public function update(ForUpdateRequest $request, $id)
    {
        $category = Category::find($id);
        $category->update($request->validated());
    
        return response(CategoryResource::make($category));
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if  (Product::where('category_id', $id)->count()) {
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
