<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'status',
        'address',
        'username',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles() {
        return $this->belongsToMany('App\Models\Roles', 'role_user', 'user_id', 'role_id');
    }
    public function carts(){
        return $this->hasMany(ShoppingCart::class,"user_id","id");
    }
    public function orders(){
        return $this->hasMany(Orders::class,"user_id","id");
    }
    public function hasRole($roleName){
        $roleNames = $this->getRolesArray("name");
        return in_array($roleName,$roleNames);
    }
    public function getRolesArray($role_column)
    {
        $user = $this;
        $cacheKey = "role_".$role_column."s_".$user->id;
        $rolesIds = Cache::get($cacheKey);
//        if(!is_null($rolesIds)){
//            return $rolesIds;
//        }
        $user = User::where("id", "=", $user->id)->with(["roles"])->get();
        $rolesIds = $user->pluck("roles")->flatten()->pluck($role_column)->toArray();
        Cache::put($cacheKey, $rolesIds, 300);
        return $rolesIds;
    }
}
