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
        $this->userRepository =  $authRepository;
    }

    function tableView(){
        $users = $this->userRepository->getAllOfUser();
        return view("users",compact("users"));
     }


    function updateUser(Request $request)
    {
        $result = $this->userRepository->update($request->id,["status"=>$request->status]);
        $messageSuccess = "Update user success!";
        $messageFail = "Update user fail!";
        return $this->responeResultWithMessage($result,$messageSuccess,$messageFail);
    }

    function listUsersAdmin()
    {
        return view("admin.table.users");
    }

    function editViewUser(Request $request){
        $user = $this->userRepository->getUserById($request->id)->with(["orders"])->first();
        return view("admin.form.user", compact("user"));
    }
    function editViewUserPost(Request $request){
        $result = $this->userRepository->update($request->id,["status"=>$request->status]);
        $messageSuccess = "Update user success!";
        $messageFail = "Update user fail!";
        return $this->responeResultWithMessage($result,$messageSuccess,$messageFail);
    }
}