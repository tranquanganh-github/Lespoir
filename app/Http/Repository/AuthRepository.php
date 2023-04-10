<?php

namespace App\Http\Repository;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class AuthRepository
{

    public function createUser($data, $password)
    {
        return User::create([
            "username" => $data["username"],
            "password" => $password,
            "email" => $data["email"],
            "phone" => $data["data_phone"] . $data["leyka_donor_phone"],
            "address" => $data["address"],
            "name" => $data["name"],
            "created_at" => Carbon::now()->format("d-m-Y"),
            "status" => ACTIVE,
        ]);
    }

    public function findUserByUsername($username, $count = false)
    {
        $userExist = User::where("username", "=", $username);
        return $count ? $userExist->count() : $userExist->first();
    }

    public function checkAuthenticated($credentials)
    {
        $user = $this->findUserByUsername($credentials["username"]);

        if ($user == null) {
            return false;
        }
        $password_salt = $user->salt_string . $credentials["password"];
        if (!$token = Auth::attempt([
            "username" => $credentials["username"],
            "password" => $password_salt,
        ])) {
            return false;
        }
        return $token;
    }


    public function getAllOfUser($roles = false)
    {
        $users = User::query();
        $users = $roles ? $users->with(["roles"]) : $users->all();
        return $users;
    }

    public function getUserById($id){
        return User::whereId($id);
    }

    public function update($id,$data)
    {
        $user = User::find($id)->update($data);
        return $user;
    }
    function updateRoleUser($data){
     $user =   User::whereId($data["user_id"])->with("roles")->get();
     $user_roles = $user->pluck("roles")->flatten()->pluck("id")->toArray();

     if (!in_array($data["role_id"],$user_roles)){
         return DB::table("role_user")->insert($data);
     }else{
        return DB::table("role_user")
             ->where("user_id",$data["user_id"])
             ->where("role_id",$data["role_id"])
             ->delete();
     }
    }
}
