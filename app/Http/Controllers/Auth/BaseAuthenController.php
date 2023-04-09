<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Routing\Controller;

define("ACTIVE",1);
define("STATUS_MISS_DATA",300);
define("STATUS_SUCCESS",200);
define("STATUS_FAIL",400);
class BaseAuthenController extends Controller
{
    protected $hash ;
     function __construct(HasherContract $hasher)
    {
        $this->hasher = $hasher;
    }
    function randomSalt($len = 8)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789`~!@#$%^&*()-=_+';
        $l = strlen($chars) - 1;
        $str = '';
        for ($i = 0; $i < $len; ++$i) {
            $str .= $chars[rand(0, $l)];
        }
        return $str;
    }



    function createPasswordHas($password)
    {
        return $this->hasher->make($password);
    }
    function responseExistAccount(){
      return  response()->json([
            'status'=> STATUS_MISS_DATA,
            'message'=> 'Account already exists!',
            'data'=>[],
        ]);
    }
    function responseCreatedUserSuccessful($data = []){
      return  response()->json([
            'status'=> STATUS_SUCCESS,
            'message'=> 'Successful user creation',
            'data'=>$data
        ]);
    }
    function respomseCreatedUserFail($data = []){
        return  response()->json([
            'status'=> STATUS_FAIL,
            'message'=> 'User creation failed',
            'data'=>$data
        ]);
    }
    function respomseLoginSuccess($data = []){
        return  response()->json([
            'status'=> STATUS_SUCCESS,
            'message'=> 'Logged in successfully',
            'data'=>$data
        ]);
    }
    function respomseLoginFail($data = []){
        return  response()->json([
            'status'=> STATUS_FAIL,
            'message'=> 'Wrong name or wrong account',
            'data'=>$data
        ]);
    }
}
