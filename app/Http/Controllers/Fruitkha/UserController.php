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

    /**
     * cập nhật thông tin người dùng
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function updateUser(Request $request)
    {
        $result = $this->userRepository->update($request->id, $request->all());
        $messageSuccess = "Update user success!";
        $messageFail = "Update user fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
    }

    /**
     * danh sách người dùng cho admin
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
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

    /**
     * form cập nhật thông tin người dùng
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    function editViewUser(Request $request)
    {
        $user = $this->userRepository->getUserById($request->id)->with(["orders"])->first();
        return view("admin.form.user", compact("user"));
    }

    /**
     * tiến hành cập nhật trạng thái ngường dùng
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    function editViewUserPost(Request $request)
    {
        $result = $this->userRepository->update($request->id, ["status" => $request->status]);
        $messageSuccess = "Update user success!";
        $messageFail = "Update user fail!";
        return $this->responeResultWithMessage($result, $messageSuccess, $messageFail);
    }

    /**
     * cập nhật quyền cho người dùng
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
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