<?php

use App\Http\Controllers\Fruitkha\CheckoutController;
use App\Http\Controllers\Fruitkha\HomeController;
use App\Http\Controllers\Fruitkha\NewController;
use App\Http\Controllers\Fruitkha\OrderController;
use App\Http\Controllers\Fruitkha\UserController;
use App\Http\Controllers\Fruitkha\ProductController;
use App\Http\Controllers\Fruitkha\ShopController;
use App\Http\Enum\Status;
use App\Models\Cloundinary;
use Illuminate\Http\Request;
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


require __DIR__ . '/auth.php';

Route::group(["middleware" => "auth"], function () {
    Route::get('/check-out', [CheckoutController::class, "checkOutView"])->name('check-out');
    Route::post('/check-out', [CheckoutController::class, "paymentOnDelivery"])->name('payment.delivery');
    Route::post('/check-paypal', [CheckoutController::class, "paymentOnPaypal"])->name('payment.paypal');
    Route::get('/paypal-success', [CheckoutController::class, "checkTransaction"])->name('payment.paypal.success');
    Route::get("/payment-message",[CheckoutController::class,"viewMessage"])->name("check-out-status");
});
Route::group(["prefix"=>"/admin"], function () {
    //Dashboard
    Route::get('/dashboard', function () {
        return view('admin.Dashborad.dashboard');
    })->name("admin.dashboard");
    //Email
    Route::get('/email-inobox', function () {
        return view('admin.email.inbox');
    })->name("admin.email.inbox");
    Route::get('/email-read', function () {
        return view('admin.email.read');
    })->name("admin.email.read");
    Route::get('/email-compose', function () {
        return view('admin.email.compose');
    })->name("admin.email.compose");
    //App
    Route::get("/app-calendar",function (){
        return view("admin.app.calendar");
    })->name("admin.app.calendar");
    //Table
    Route::get("/table-products",function (){
        return view("admin.table.products");
    })->name("admin.table.products");

    Route::get("/table-orders",function (){
        return view("admin.table.orders");
    })->name("admin.table.orders");

    Route::get("/table-users",function (){
        return view("admin.table.users");
    })->name("admin.table.users");

    Route::get("/table-news",function (){
        return view("admin.table.news");
    })->name("admin.table.news");
    //Form
    Route::get("/form-product",function (){
        return view("admin.form.product");
    })->name("admin.form.product");

    Route::get("/form-order",function (){
        return view("admin.form.order");
    })->name("admin.form.order");

    Route::get("/form-user",function (){
        return view("admin.form.user");
    })->name("admin.form.user");

    Route::get("/form-new",function (){
        return view("admin.form.new");
    })->name("admin.form.new");
});


Route::get('/home', [HomeController::class, "homeViewV1"])->name('home.page1');

Route::get('/home-v2', [HomeController::class, "homeViewV2"])->name('home.page2');

Route::get('/about-us', [HomeController::class, "aboutUsView"])->name('about-us');

Route::get('/cart', [ShopController::class, "cartView"])->name('cart');

Route::get('/shop', [ShopController::class, "shopView"])->name('shop');

Route::get('/product/{id}', [ProductController::class, "detailProduct"])->name('detail-product');

Route::get('/contact-us', [HomeController::class, "contactView"])->name('contact');

Route::post('/add-contact',[HomeController::class, "insertContact"]);

Route::get('/news', [NewController::class, "listNews"])->name('new');

Route::get('/news/{id}', [NewController::class, "detailNew"])->name('detail-new');

Route::get('/add-to-cart/{id}', [ProductController::class,"addToCart"])->name('addToCart');

Route::post('/update-cart', [ProductController::class,"update"])->name('cart.update');

Route::post('/remove-form-cart', [ProductController::class,"delete"])->name('cart.delete');

Route::get('/users', [UserController::class,"tableView"]);
Route::get('/users/{id}', [UserController::class,"updateUser"]);
//Route::post('/users/{id}', [UserController::class,"updateUser"]);



Route::post("upload-image", function (\Illuminate\Http\Request $request) {
//$colud = new Cloundinary();
//dd($colud->uploadImage());
})->name('updateload-img');