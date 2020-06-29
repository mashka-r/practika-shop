<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use App\Models\User;
use App\Models\Role;
use Validator;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth\register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required',
            'image'    => 'mimes:png,jpeg,jpg',
        ]);

        if ($validator->fails()) {
            return response()->json('Validation Error');
            
        } else {
            $user = User::create([
                'name'     => request('name'),
                'email'    => request('email'),
                'password' => Hash::make(request('password'))
            ]);
            
            if ($request->hasFile('image')) {
                $user->addMediaFromRequest('image')->toMediaCollection('images');
            }

            $user->roles()->attach(Role::where('name', 'Registered')->get());
            
            return redirect()->route('index');

            $response = [
                'success' => true,
                'message' => $user->name.', '.'регистрация прошла успешно!',
            ];
            
            return response()->json($response);
        
        }
    }
}
