<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use  App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;
use App\Http\Requests\Categories\ForUpdateRequest;
use App\Http\Requests\Categories\ForStoreRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorize('before', User::class); 
        $categories = Category::get();
        return CategoryResource::collection($categories);
    }

    public function store(ForStoreRequest $request)
    {
        $this->authorize('before', User::class); 

        $category = Category::create([
            'name'           => request('name'),
            'code'           => request('code'),
            'description'    => request('description'),
        ]);


        $response = [
            'success' => true,
            'message' => 'Категория успешно добавлена',
        ];
        
        return response()->json($response);
    }

    public function show($id)
    {
        $this->authorize('before', User::class);
        $category = Category::where('id', $id)->get();
        return CategoryResource::collection($category);
    }

    public function update(ForUpdateRequest $request, $id)
    {
        $this->authorize('before', User::class);
        $category = Category::where('id', $id);
        $category->update($request->all());
    
    }

    public function destroy($id)
    {
        $this->authorize('before', User::class); 
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
