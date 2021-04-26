<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\CheckoutController;



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

Route::get('payment', [PayPalController::class,'handlePayment'])->name('make.payment');
Route::get('cancel', [PayPalController::class,'paymentCancel'])->name('cancel.payment');
Route::get('payment/success',[PayPalController::class,'paymentSuccess'] )->name('success.payment');
Route::post('/charge',[CheckoutController::class,'charge']);
