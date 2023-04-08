<?php

use App\Http\Controllers\Fruitkha\CheckoutController;
use App\Http\Controllers\Fruitkha\HomeController;
use App\Http\Controllers\Fruitkha\NewController;
use App\Http\Controllers\Fruitkha\OrderController;
use App\Http\Controllers\Fruitkha\UserController;
use App\Http\Controllers\Fruitkha\ProductController;
use App\Http\Controllers\Fruitkha\ShopController;
use App\Models\Cloundinary;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//this view is create by vue
//trinh huy
//new
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/home', [HomeController::class,"homeViewV1"])->name('home.page1');

Route::get('/home-v2', [HomeController::class,"homeViewV2"])->name('home.page2');

Route::get('/about-us', [HomeController::class,"aboutUsView"])->name('about-us');

Route::get('/cart',  [ShopController::class,"cartView"])->name('cart');

Route::get('/shop',  [ShopController::class,"shopView"])->name('shop');

Route::get('/product/{id}', [ProductController::class,"detailProduct"])->name('detail-product');

Route::get('/check-out', [CheckoutController::class,"checkOutView"])->name('check-out');

Route::get('/contact-us', [HomeController::class,"contactView"])->name('contact');

Route::get('/news', [NewController::class,"listNews"])->name('new');

Route::get('/news/{id}', [NewController::class,"detailNew"])->name('detail-new');

Route::get('/404-page', function () {
    return view('client.404page.404page');
})->name('error404');

Route::get("order/data-table",function (){
   dd( \App\Models\User::find(1)->with(["carts"])->get()->toArray());
});

Route::get('/users', [UserController::class,"tableView"]);
Route::get('/users/{id}', [UserController::class,"updateUser"]);
//Route::post('/users/{id}', [UserController::class,"updateUser"]);

Route::post("upload-image",function(\Illuminate\Http\Request $request){
//$colud = new Cloundinary();
//dd($colud->uploadImage());
})->name('updateload-img');