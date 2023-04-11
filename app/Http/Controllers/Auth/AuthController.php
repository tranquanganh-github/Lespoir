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

    /**
     * đang ký người dùng
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {

        $data = $request->all();
//        $salt = $this->randomSalt(16);
        /*mã hóa mật khẩu*/
        $password = $this->createPasswordHas($data["password"]);
        /*tìm kiếm tài khoản đã tồn tại chưa*/
        $userExist = $this->authRepository->findUserByUsername($data["username"],true);
        if ($userExist >= 1) {
            return $this->responseExistAccount();
        }
        try {
            /*tạo người dùng*/
            $user = $this->authRepository->createUser($data, $password);
            return $this->responseCreatedUserSuccessful($user);
        } catch (\Exception $ex) {
            return $this->respomseCreatedUserFail();
        }

    }

    /**
     * đăng nhập
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        /*chỉ nhận reuqest username và password*/
        $credentials = $request->only('username', 'password');
        /*tiến hành check authentication*/
        $isAuthenticated = $this->authRepository->checkAuthenticated($credentials);

        try {
            if (is_null($isAuthenticated) || $isAuthenticated === false) {
                return $this->respomseLoginFail();
            }
        } catch (AuthenticationException $e) {
            return $this->respomseLoginFail();
        }

        return $this->respomseLoginSuccess([
            "redirect"=>route("home.page2"),
        ]);
    }

    /**
     * đăng xuất
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logOut(){
        Auth::logout();
        return redirect()->route("home.page1");
    }

    /**
     * chi tiết người dùng
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function userDetailView(){
        $user = Auth::user();
        if (is_null($user)){
            return  redirect("login");
        }
        return view();
    }

    /**
     * form đăng nhập
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function loginView()
    {
        return view("login");
    }

    /**
     * form đăng ký
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function registerView()
    {
        return view("register");
    }
}
