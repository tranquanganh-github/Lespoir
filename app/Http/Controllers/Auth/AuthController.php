<?php

namespace App\Http\Controllers\Auth;


use App\Http\Repository\AuthRepository;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Auth;

use function redirect;
use function route;
use function view;

class AuthController extends BaseAuthenController
{

    protected $authRepository;

    public function __construct( AuthRepository $authRepository,HasherContract $hasher)
    {
        parent::__construct($hasher);

        $this->authRepository = $authRepository;

    }

    public function register(RegisterRequest $request)
    {

        $data = $request->all();
//        $salt = $this->randomSalt(16);
        $password = $this->createPasswordHas($data["password"]);
        $userExist = $this->authRepository->findUserByUsername($data["username"],true);
        if ($userExist >= 1) {
            return $this->responseExistAccount();
        }
        try {
            $user = $this->authRepository->createUser($data, $password);
            return $this->responseCreatedUserSuccessful($user);
        } catch (\Exception $ex) {
            return $this->respomseCreatedUserFail();
        }

    }

    public function login(LoginRequest $request)
    {

        $credentials = $request->only('username', 'password');
        $isAuthenticated = $this->authRepository->checkAuthenticated($credentials);

        try {
            if (is_null($isAuthenticated)) {
                return $this->respomseLoginFail();
            }
        } catch (AuthenticationException $e) {
            return $this->respomseLoginFail();
        }

        return $this->respomseLoginSuccess([
            "redirect"=>route("home.page2"),
        ]);
    }

    public function logOut(){
        Auth::logout();
        return redirect()->route("home.page1");
    }
    public function userDetailView(){
        $user = Auth::user();
        if (is_null($user)){
            return  redirect("login");
        }
        return view();
    }
    public function loginView()
    {
        return view("login");
    }

    public function registerView()
    {
        return view("register");
    }
}
