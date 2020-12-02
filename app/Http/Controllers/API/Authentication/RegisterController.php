<?php
namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForStoreRequest;
use App\Models\User;
use App\Models\Role;
use Config;

class RegisterController extends Controller
{
    public function register(ForStoreRequest $request)
    {
        $user = User::create($request->validated());
        
        if ($request->hasFile('image')) {
            $user->addMediaFromRequest('image')->toMediaCollection('images');
        }
        
        $user->refresh();  
        $user->roles()->attach(Role::ROLES['role_user']);

        $response = [
            'success' => true,
            'message' => $user->name.', '.'регистрация прошла успешно!',
        ];
        
        return response()->json($response);
    }
}
