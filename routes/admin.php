<?php

use App\Http\Controllers\Fruitkha\CategoryController;
use App\Http\Controllers\Fruitkha\EmailController;
use App\Http\Controllers\Fruitkha\HomeController;
use App\Http\Controllers\Fruitkha\NewController;
use App\Http\Controllers\Fruitkha\OrderController;
use App\Http\Controllers\Fruitkha\UserController;
use App\Http\Controllers\Fruitkha\ProductController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(["prefix" => "/admin", "middleware" => ["admin", "auth"]], function () {
    //Dashboard
    Route::get('/dashboard', [HomeController::class, "dashBoard"])->name("admin.dashboard");
    //Email
    Route::get('/email-inobox', [EmailController::class, "inboxView"])->name("admin.email.inbox");
    Route::get('/email-read', [EmailController::class, "readView"])->name("admin.email.read");
    Route::get('/email-compose', [EmailController::class, "composeView"])->name("admin.email.compose");
    //App
    Route::get("/app-calendar", [HomeController::class, "calendarView"])->name("admin.app.calendar");
    //for new controller
    Route::get("/table-news", [NewController::class, "listNewsAdmin"])->name("admin.table.news");
    Route::get("/form-new-create", [NewController::class, "createNewView"])->name("admin.form.new");
    Route::post("/form-new-create", [NewController::class, "createnewPost"])->name("admin.form.new");
    Route::get("/form-new-edit", [NewController::class, "editNewView"])->name("admin.form.new.edit");
    Route::post("/form-new-edit", [NewController::class, 'editNew'])->name('admin.form.new.edit');
    Route::get('/new-update', [NewController::class, 'changeStatus'])->name('admin.new.change.status');
    //for new controller
    Route::get("/table-news", [NewController::class, "listNewsAdmin"])->name("admin.table.news");
    //for order controller
    Route::get("/table-orders", [OrderController::class, "listOrdersAdmin"])->name("admin.table.orders");
    Route::get("/order-update", [OrderController::class, "updateOrder"])->name("admin.order.update");
    Route::post("/order-update", [OrderController::class, "updateOrderPost"])->name("admin.order.update");
    Route::get("/order-detail", [OrderController::class, "detailOrder"])->name("admin.order.detail");
    Route::get("/form-order", [OrderController::class, "createOrderView"])->name("admin.form.order");
    //for user controller
    Route::get("/table-users", [UserController::class, "listUsersAdmin"])->name("admin.table.users");
    Route::get("/user/update-role", [UserController::class, "updateRoleUser"])->name("admin.user.update.role");
    Route::get('/user-update-status', [UserController::class, "editViewUserPost"])->name('admin.form.user.status');
    Route::get("/form-user", [UserController::class, "editViewUser"])->name('admin.form.user');
    Route::post("/form-user", [UserController::class, "updateUser"])->name("admin.user.update");
    //for product controller
    Route::get('/table-products', [ProductController::class, 'index'])->name("admin.table.products");
    Route::get('/table-products-update', [ProductController::class, 'edit'])->name('admin.table.products.update');
    Route::post('/table-products-update', [ProductController::class, 'updateProduct'])->name('admin.table.products.update');
    Route::get("/form-product", [ProductController::class, "createProductView"])->name("admin.form.product");
    Route::post('/form-product', [ProductController::class, 'store'])->name('admin.table.products.create');
    Route::get('/product-update', [ProductController::class, 'changeStatus'])->name('admin.product.changestatus');
    //for category controller
    Route::get('/table-categories', [CategoryController::class, 'table'])->name("admin.table.categories");
    Route::get('/form-category', [CategoryController::class, 'formEdit'])->name('admin.table.categories.update');
    Route::post('/form-category', [CategoryController::class, 'edit'])->name('admin.table.categories.update');
    Route::get('/create-category', [CategoryController::class, 'create'])->name('admin.form.category');
    Route::post('/create-category', [CategoryController::class, 'createPost'])->name('admin.form.category');
});
