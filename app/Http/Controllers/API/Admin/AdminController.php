<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\Admin\ForUpdateRequest;
use App\Http\Requests\Admin\ForStoreRequest;

class AdminController extends Controller
{
    public function index()
    {
        $this->authorize('before', User::class); 
        return response(UserResource::collection(User::all()));
    }

    public function store(ForStoreRequest $request)
    {
        $this->authorize('before', User::class); 
        $user = User::create($request->validated());
        
        if ($request->hasFile('image')) {
            $user->addMedia($request->files()->get('image'))
                ->toMediaCollection('images');
        }

        $user->refresh();   
        $user->roles()->attach(request('role_id'));
        
        return response(UserResource::make($user));
    }

    public function show($id)
    {
        $this->authorize('before', User::class);
        return response(UserResource::make(User::find($id)));
    }

    public function update(ForUpdateRequest $request, $id)
    {
        $this->authorize('before', User::class);

        $user = User::find($id);
        $user->update($request->validated());

        if ($request->hasFile('image')) {
            $user->addMedia($request->files()->get('image'))
                ->toMediaCollection('images');
        }

        $user->refresh();
        
        return response(UserResource::make($user));
    }

    public function destroy($id)
    {
        $this->authorize('before', User::class); 

        $user = User::find($id);
        $user->delete();

        $response = [
            'success' => true,
            'message' => 'Пользователь удален',
        ];
        
        return response()->json($response);
    }
}
