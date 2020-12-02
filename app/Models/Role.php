<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ROLES = [
        'role_admin'   => '1',
        'role_manager' => '2',
        'role_user'    => '3',
    ];
    
    protected $fillable = ['id','name'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
