<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\User\ForUpdateRequest;
use Auth;

class UserController extends Controller
{
    public function show()
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->get();
        return UserResource::collection($user);
    }

    public function update(ForUpdateRequest $request)
    {
        $id = Auth::user()->id;
        User::where('id', $id)->first()->update($request->only('email', 'name', 'password'));
 
        $response = [
            'success' => true,
            'message' => 'Данные обновлены',
        ];
        
        return response()->json($response);
    }

    public function editPhoto(ForUpdateRequest $request)
    {
        $id = Auth::user()->id;
        $user = User::where('id', $id)->get();
        $data = $request->all();
        
        $user->media()->delete($id);

        if ($user->hasMedia('images')) 
        {
            $user->updateMedia($data, 'images');
        } else {
            $user->addMediaFromRequest('image')
                 ->toMediaCollection('images');
        }

        $user->update($data);

        $response = [
            'success' => true,
            'message' => 'Фото профиля успешно обновлено',
        ];
    
        return response()->json($response);
    }   

    public function delete()
    { 
        $id = Auth::user()->id;
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
