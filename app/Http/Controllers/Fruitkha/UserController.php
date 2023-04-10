<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Repository\AuthRepository;
use App\Http\Controllers\Controller;
use App\Http\Respone\UserRespone;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    use UserRespone;

    protected $userRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->userRepository = $authRepository;
    }

    function tableView()
    {
        $users = $this->userRepository->getAllOfUser();
        return view("users", compact("users"));
    }


    function updateUser(Request $request)
    {
        $result = $this->userRepository->update($request->id, ["status" => $request->status]);
        $messageSuccess = "Update user success!";
        $messageFail = "Update user fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
    }

    function listUsersAdmin()
    {
        $users = $this->userRepository->getAllOfUser(true)->get();
        $users = $users->map(function ($user) {
            return (object)["id" => $user->id,
                "name" => $user->name,
                "username" => $user->username,
                "email" => $user->email,
                "address" => $user->address,
                "phone" => $user->phone,
                "status" => $user->status,
                "created_at" => $user->created_at,
                "updated_at" => $user->updated_at,
                "roles" => $user->roles->pluck("id")->toArray(),];
        });
        return view("admin.table.users", compact("users"));
    }

    function editViewUser(Request $request)
    {
        $user = $this->userRepository->getUserById($request->id)->with(["orders"])->first();
        return view("admin.form.user", compact("user"));
    }

    function editViewUserPost(Request $request)
    {
        $result = $this->userRepository->update($request->id, ["status" => $request->status]);
        $messageSuccess = "Update user success!";
        $messageFail = "Update user fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
    }

    function updateRoleUser(Request $request){
        $result = $this->userRepository->updateRoleUser([
            "user_id"=>$request->id,
            "role_id"=>$request->role_id,
        ]);
        $messageSuccess = "Update user success!";
        $messageFail = "Update user fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
    }

}