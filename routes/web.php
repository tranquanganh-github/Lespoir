<?php

use App\Http\Controllers\Fruitkha\CheckoutController;
use App\Http\Controllers\Fruitkha\HomeController;
use App\Http\Controllers\Fruitkha\NewController;
use App\Http\Controllers\Fruitkha\ProductController;
use App\Http\Controllers\Fruitkha\ShopController;
use Illuminate\Support\Facades\Mail;
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
require __DIR__ . '/auth.php';
require __DIR__ . '/admin.php';

Route::get('/', function () {

    return view('welcome');
});

Route::group(["middleware" => "auth"], function () {
    Route::get('/check-out', [CheckoutController::class, "checkOutView"])->name('check-out');
    Route::post('/check-out', [CheckoutController::class, "paymentOnDelivery"])->name('payment.delivery');
    Route::post('/check-paypal', [CheckoutController::class, "paymentOnPaypal"])->name('payment.paypal');
    Route::get('/paypal-success', [CheckoutController::class, "checkTransaction"])->name('payment.paypal.success');
    Route::get("/payment-message", [CheckoutController::class, "viewMessage"])->name("check-out-status");
});
Route::get('/home', [HomeController::class, "homeViewV1"])->name('home.page1');
Route::get('/home-v2', [HomeController::class, "homeViewV2"])->name('home.page2');
Route::get('/about-us', [HomeController::class, "aboutUsView"])->name('about-us');
Route::get('/contact-us', [HomeController::class, "contactView"])->name('contact');
Route::post('/add-contact', [HomeController::class, "insertContact"]);
Route::get('/cart', [ShopController::class, "cartView"])->name('cart');
Route::get('/shop', [ShopController::class, "shopView"])->name('shop');
Route::get('/news', [NewController::class, "listNews"])->name('new');
Route::get('/news/{id}', [NewController::class, "detailNew"])->name('detail-new');
Route::get('/product/{id}', [ProductController::class, "detailProduct"])->name('detail-product');
Route::get('/add-to-cart/{id}', [ProductController::class, "addToCart"])->name('addToCart');
Route::post('/update-cart', [ProductController::class, "update"])->name('cart.update');
Route::get('/add-to-cart/{id}', [ProductController::class, "addToCart"])->name('addToCart');
Route::post('/update-cart', [ProductController::class, "update"])->name('cart.update');
Route::post('/remove-from-cart', [ProductController::class, "delete"])->name('cart.delete');