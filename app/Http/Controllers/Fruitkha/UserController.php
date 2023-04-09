<?php

namespace App\Http\Controllers\Fruitkha;

use App\Http\Repository\AuthRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    function tableView()
    {
        $user = new AuthRepository();
        $users = $user->getAllOfUser();
        return view("users", compact("users"));
    }


    function updateUser(Request $request)
    {
        $id = $request->id;
        $users = new AuthRepository();
        $users->update($id);
        return redirect('/users');
    }

    function listUsersAdmin()
    {
        return view("admin.table.users");
    }

    function editViewUser(Request $request){
        return view("admin.form.user");
    }
}