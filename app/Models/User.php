<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use App\Models\Role;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, Notifiable, HasMediaTrait, SoftDeletes;

    protected $fillable = [
        'name', 
        'email', 
        'password',
        'image',
    ];

    protected $dates = ['deleted_at'];
    
    protected $hidden = [
        'password', 
        'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function baskets()
    {
        return $this->hasMany(Basket::class);    
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function isAdmin()
    {
        return (boolean)$this->roles->where('id', Role::ROLES['role_admin'])->count();
    }
    
    public function isManager()
    {
        return (boolean)$this->roles->where('id', Role::ROLES['role_manager'])->count();
    }
    public function isClient()
    {
        return (boolean)$this->roles->where('id', Role::ROLES['role_user'])->count();
    }
    
    public function registerMediaCollections()
    {
        $this->addMediaCollection('image')->singleFile();
    }
}
