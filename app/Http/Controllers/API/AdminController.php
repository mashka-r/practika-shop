<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use  App\Http\Resources\UserResource;
use App\Http\Requests\Admin\ForUpdateRequest;
use App\Http\Requests\Admin\ForStoreRequest;
use Hash;

class AdminController extends Controller
{
    public function index()
    {
        $this->authorize('before', User::class); 
        $users = User::get();
        return UserResource::collection($users);
    }

    public function store(ForStoreRequest $request)
    {
        $this->authorize('before', User::class); 

        $user = User::create([
            'name'     => request('name'),
            'email'    => request('email'),
            'password' => Hash::make(request('password')),
            'role_id'  => request('role_id'),
        ]);

        $user->roles()->attach(request('role_id'));

        $response = [
            'success' => true,
            'message' => 'Регистрация пользователя '.$user->name.' прошла успешно!',
        ];
        
        return response()->json($response);
    }

    public function show($id)
    {
        $this->authorize('before', User::class);
        $users = User::where('id', $id)->get();
        return UserResource::collection($users);
    }

    public function update(ForUpdateRequest $request, $id)
    {
        $this->authorize('before', User::class);
        $user = User::where('id', $id);
        $user->update($request->only('email', 'name', 'password'));
 
        $response = [
            'success' => true,
            'message' => 'Данные обновлены',
        ];
        
        return response()->json($response);
    }

    public function destroy($id)
    {
        $this->authorize('before', User::class); 

        $user = User::find($id);
        $user->roles()->detach();
        $user->delete();

        $response = [
            'success' => true,
            'message' => 'Пользователь удален',
        ];
        
        return response()->json($response);
    }
}
