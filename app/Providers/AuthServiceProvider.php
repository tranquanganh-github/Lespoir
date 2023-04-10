<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $roles = Roles::all();
        foreach ($roles as $role) {
            Gate::define($role->name, function (User $user) use ($role) {
                $roleIds = $this->getRolesArray($user);
                if (in_array($role->id, $roleIds)&&$user->status==1){
                    return true;
                }
                return false;
            });
        }
    }
    public function getRolesArray(User $user)
    {
        $cacheKey = "role_ids_".$user->id;
        $rolesIds = Cache::get($cacheKey);
        if(!is_null($rolesIds)){
            return $rolesIds;
        }
        $user = User::where("id", "=", $user->id)->with(["roles"])->get();
        $rolesIds = $user->pluck("roles")->flatten()->pluck("id")->toArray();
        Cache::put($cacheKey, $rolesIds, 300);
        return $rolesIds;
    }
}
