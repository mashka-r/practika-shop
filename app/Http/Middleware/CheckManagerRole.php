<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Auth;

class CheckManagerRole
{
    public function handle($request, Closure $next)
    {   
        if (Auth::user()->isManager()) {
            return $next($request);

        } else {
            $response = [
                'message' => 'Unauthorized',
            ];

            return response()->json($response, 403);
        }
    }
}
