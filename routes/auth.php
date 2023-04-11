<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'guest'],function (){
    Route::get('login',  [AuthController::class, 'loginView'])->name("login.get");
    Route::get('register',  [AuthController::class, 'registerView'])->name("register.get");
    Route::post('login',  [AuthController::class, 'login'])->name("login.post");
    Route::post('register',  [AuthController::class, 'register'])->name("register.post");
});
Route::group(["middleware"=> 'auth'],function(){
    Route::get("account/log-out",[AuthController::class,"logOut"])->name("sign.out");
    Route::get("account/detail",[AuthController::class,"detailAccount"])->name("account.detail");
});