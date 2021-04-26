<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user/orders', [UserController::class,'index']);
Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::get('/users/{user}',[UserController::class,'show']);
Route::get('/users/{user}/orders',[UserController::class,'showOrders']);
Route::get('/products',[ProductController::class,'index']);
Route::post('/product/store',[ProductController::class,'store']);
Route::get('/product/uploadfile',[ProductController::class,'uploadFile']);
Route::get('/product/{product}',[ProductController::class,'show']);
Route::post('/product/{product}/update',[ProductController::class,'update']);
Route::post('/product/{product}/quantity',[ProductController::class,'quantity']);
Route::post('/product/{product}/destroy',[ProductController::class,'destroy']);
Route::get('/orders',[OrderController::class,'index']);
Route::post('/order/makeorder',[OrderController::class,'store'])->middleware('auth:api');

Route::post('/order/{order}/delieverd',[OrderController::class,'deliverOrder']);
Route::get('/order/{order}',[OrderController::class,'show']);

