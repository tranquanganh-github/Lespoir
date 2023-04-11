<?php

use App\Http\Controllers\Fruitkha\CategoryController;
use App\Http\Controllers\Fruitkha\CheckoutController;
use App\Http\Controllers\Fruitkha\EmailController;
use App\Http\Controllers\Fruitkha\HomeController;
use App\Http\Controllers\Fruitkha\NewController;
use App\Http\Controllers\Fruitkha\OrderController;
use App\Http\Controllers\Fruitkha\UserController;
use App\Http\Controllers\Fruitkha\ProductController;
use App\Http\Controllers\Fruitkha\ShopController;
use App\Http\Repository\AuthRepository;
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
Route::group(["prefix" => "/admin","middleware"=>["admin","auth"]], function () {
    //Dashboard
    Route::get('/dashboard', [HomeController::class, "dashBoard"])->name("admin.dashboard");

    //Email
    Route::get('/email-inobox', [EmailController::class, "inboxView"])->name("admin.email.inbox");
    Route::get('/email-read', [EmailController::class, "readView"])->name("admin.email.read");
    Route::get('/email-compose', [EmailController::class, "composeView"])->name("admin.email.compose");

    //App
    Route::get("/app-calendar", [HomeController::class, "calendarView"])->name("admin.app.calendar");

    //Table
    Route::get("/table-orders",[OrderController::class, 'listOrdersAdmin'])->name('admin.table.orders');
    Route::get("/table-users", [UserController::class, 'listUsersAdmin'])->name('admin.table.users');
    Route::get("/user/update-role", [UserController::class, 'updateRoleUser'])->name('admin.user.update.role');
    Route::get("/table-news", [NewController::class, 'listNewsAdmin'])->name('admin.table.news');
    Route::get("/form-user",[UserController::class, 'editViewUser'])->name('admin.form.user');
    Route::post("/form-user",[UserController::class, 'editViewUserPost'])->name('admin.form.user');

    //Form
    Route::get('/table-categories',[CategoryController::class, 'table'])->name("admin.table.categories");
    Route::get('/form-category', [CategoryController::class, 'formEdit'])->name('admin.table.categories.update');
    Route::post('/form-category', [CategoryController::class, 'edit'])->name('admin.table.categories.update');
    Route::get('/create-category', [CategoryController::class, 'create'])->name('admin.form.category');
    Route::post('/create-category', [CategoryController::class, 'createPost'])->name('admin.form.category');
    Route::get("/form-new", [NewController::class, 'createNewView'])->name('admin.form.new');
    Route::post("/new-update", [NewController::class, 'editNew'])->name('admin.form.new.edit');
    Route::get('/new-update', [NewController::class, 'changeStatus'])->name('admin.new.change.status');
    Route::get("/form-order",[OrderController::class, 'createOrderView'])->name('admin.form.order');
    Route::get("/order-update",[OrderController::class, 'updateOrder'])->name('admin.order.update');
    Route::post("/order-update",[OrderController::class, 'updateOrderPost'])->name('admin.order.update');
    Route::get("/order-detail",[OrderController::class, 'detailOrder'])->name('admin.order.detail');
    Route::get('/table-products',[ProductController::class, 'index'])->name('admin.table.products');
    Route::get('/table-products-update',[ProductController::class, 'edit'])->name('admin.table.products.update');
    Route::post('/table-products-update', [ProductController::class, 'updateProduct'])->name('admin.table.products.update');
    Route::get("/form-product",[ProductController::class, 'createProductView'])->name('admin.form.product');
    Route::post('/form-product', [ProductController::class, 'store'])->name('admin.table.products.create');
    Route::get('/product-update', [ProductController::class, 'changeStatus'])->name('admin.product.changestatus');
    Route::get('/user-update', [UserController::class, 'updateUser'])->name('admin.user.update');

});


Route::get('/home', [HomeController::class, 'homeViewV1'])->name('home.page1');

Route::get('/home-v2', [HomeController::class, 'homeViewV2'])->name('home.page2');

Route::get('/about-us', [HomeController::class, 'aboutUsView'])->name('about-us');

Route::get('/cart', [ShopController::class, 'cartView'])->name('cart');

Route::get('/shop', [ShopController::class, 'shopView'])->name('shop');

Route::get('/product/{id}', [ProductController::class, 'detailProduct'])->name('detail-product');

Route::get('/contact-us', [HomeController::class, 'contactView'])->name('contact');

Route::post('/add-contact',[HomeController::class, 'insertContact']);

Route::get('/news', [NewController::class, 'listNews'])->name('new');

Route::get('/news/{id}', [NewController::class, 'detailNew'])->name('detail-new');

Route::post('/add-to-cart', [ProductController::class, 'addToCart'])->name('addToCart');

Route::post('/update-cart', [ProductController::class, 'update'])->name('cart.update');

Route::post('/remove-from-cart', [ProductController::class, 'delete'])->name('cart.delete');


