<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Route;
use Config;
use Closure;
use Auth;

class CheckRole
{
    public function handle($request, Closure $next)
    {   
        $manager = (boolean)(Auth::user()->roles
                                         ->where('id', Config::get('constants.roles.role_manager'))
                                         ->count());

        $admin = (boolean)(Auth::user()->roles
                                       ->where('id', Config::get('constants.roles.role_admin'))
                                       ->count());
        
        if ($admin || $manager) {
            return $next($request);

        } else {
            
            if (($request->isMethod('get')) && (stripos($request->path(), 'orders') === false)) {
                return $next($request);
            } else {
                $response = [
                    'message' => 'Unauthorized',
                ];
                return response()->json($response, 403);
            }
        }      
    }
}
