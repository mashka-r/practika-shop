<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\ForUpdateRequest;
use Auth;

class UserController extends Controller
{
    public function show()
    {
        return response(UserResource::make(Auth::user()));
    }

    public function update(ForUpdateRequest $request)
    {
        Auth::user()->update($request->validated());

        if ($request->hasFile('image')) {
            Auth::user()->addMedia($request->files()->get('image'))
                ->toMediaCollection('images');
        }

        Auth::user()->refresh();

        if ($request->has('password')) {
            Auth::user()->token()->revoke();
        } else {
            return response(UserResource::make(Auth::user()));
        }
    }

    public function delete()
    { 
        Auth::user()->delete();
        
        $response = [
            'success' => true,
            'message' => 'Пользователь удален',
        ];
        
        return response()->json($response);
    }
}
