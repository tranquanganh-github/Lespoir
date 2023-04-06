<?php

namespace App\Http\Repository;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Auth;



class AuthRepository
{
    protected $hash;


    public function __construct(HasherContract $hasher)
    {
        $this->hasher = $hasher;

    }

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
}
