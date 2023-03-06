<?php

use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchasesController;
use App\Http\Controllers\PostGuzzleController;
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


Route::get('posts',[PostGuzzleController::class,'index']);
Route::get('posts/store', [PostGuzzleController::class, 'store' ]);
Route::get('/success',  [StripeController::class, 'paymentSuccess']);
Route::get('/order/success',  [StripeController::class, 'orderPaymentSuccess']);
Route::get('digital/success', [StripeController::class, 'DigitalPaymentSuccess']);

 
Route::get('/{any}', [App\Http\Controllers\SpaController::class, 'index'])->where('any', '.*');
Route::get('/', function () {
    return view('welcome');
});
