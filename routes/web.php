<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BmiRecordController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DeliveriesController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\ForumpostsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SupplementController;
use App\Models\Orders;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login')->middleware(['guest:customers','guest:web','guest:couriers','guest:consultants']);
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware(['guest:customers','guest:web','guest:couriers','guest:consultants']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/customers/{id}/edit', [AuthController::class, 'editcustomer'])->name('customers.edit');
Route::post('/customers/{id}', [AuthController::class, 'updatecustomer'])->name('customers.update');

Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register')->middleware(['guest:customers','guest:web','guest:couriers','guest:consultants']);
Route::post('/register', [AuthController::class, 'register'])->name('register')->middleware(['guest:customers','guest:web','guest:couriers','guest:consultants']);

// Article
Route::get('/articles', [ArticleController::class, 'search'])->name('articles');
Route::get('/articles/{id}', [ArticleController::class, 'index_article'])->name('index-article');
Route::get('/createarticle',function(){
    return view('article.newarticle');
})->name('create_articles')->middleware(['auth:consultants']);
// Route::post('/createarticles', [ArticleController::class, 'input_handler'])->middleware(['auth:customers']);
Route::post('/createarticles', [ArticleController::class, 'input_handler'])->middleware('auth');


// BMI
Route::get('/bmirecord',function(){
    return view('customer.bmi');
})->name('bmirecord')->middleware(['auth:customers']);
Route::post('/bmi', [BmiRecordController::class, 'store'])->name('bmi.store')->middleware(['auth:customers']);

Route::post('/recommend-foods', [BmiRecordController::class, 'recommendFoods'])->name('recommend.foods')->middleware(['auth:customers']);

// Rute untuk menambahkan item ke keranjang

Route::get('/supplements', [SupplementController::class, 'index'])->name('supplements.index');
Route::post('/cart/add', [CartsController::class, 'add'])->name('cart.add');
Route::get('/orders', [OrdersController::class, 'summaryorders'])->name('orders.index');
Route::get('/orders/{order}', [OrdersController::class, 'summaryordersdetail'])->name('orders.detail');
// Route::put('/cart/update-quantity', [CartsController::class, 'updateQuantity'])->name('cart.updateQuantity');
// Route::delete('/cart/remove', [CartsController::class, 'remove'])->name('cart.remove');


// Route::get('/cart', [OrdersController::class, 'showorders'])->name('orders');
Route::get('/cart', [CartsController::class, 'index'])->name('cart.index');
// Route::get('/cart', [OrdersController::class, 'showorders'])->name('orders');
Route::post('/cart/update-quantity', [CartsController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::post('/cart/remove', [CartsController::class, 'remove'])->name('cart.remove');
Route::post('/orders/store', [OrdersController::class, 'store'])->name('orders.store');
// Route::get('/payment/orders', [OrdersController::class, 'index'])->name('payment.midtrans');
Route::get('/payment/confirm/{order}', [OrdersController::class, 'showconfirmPayment'])->name('payment.confirm');

// forums
Route::get('/forums', [ForumController::class,'generalforumview'])->name('forum')->middleware(['auth:customers']);
Route::post('/forumpost/{i}',[ForumpostsController::class,'InputHandler'])->middleware(['auth:customers']);
Route::post('/createforum',[ForumController::class,'input_handler'])->middleware(['auth:customers']);
Route::get('/createforum',function(){
    return view('forum.newforum');
})->name('newforum')->middleware(['auth:customers']);
Route::get('/forumpost/{i}',[ForumpostsController::class,'ReturnView'])->middleware(['auth:customers']);
Route::post('/forums',[ForumController::class,'search'])->middleware(['auth:customers']);
Route::get('/deleteforum/{i}',[ForumController::class,'DeleteForum'])->middleware(['auth:customers']);


// Route::get('/dashboard/test', [AuthController::class, 'dashboardCourier']);

Route::post('/payment/notification', [OrdersController::class, 'processPaymentAndNotification'])->name('transactions.notification');


// delivery
Route::get('/deliveries', [DeliveriesController::class, 'index'])->name('courier.deliveries.index');
Route::get('/deliveries/{id}', [DeliveriesController::class, 'show'])->name('courier.deliveries.show');
Route::put('/deliveries/{id}', [DeliveriesController::class, 'update'])->name('courier.deliveries.update');