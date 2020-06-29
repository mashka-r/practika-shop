<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Route;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        $route = Route::currentRouteName();
        
        if ((stripos($route, 'users')) === false) {
            return $user->isManager();

        } else {
            return $user->isAdmin();
        }
    }
    
}
