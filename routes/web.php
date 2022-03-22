<?php

use App\Http\Controllers\StripeController;
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

Route::get('/success',  [StripeController::class, 'paymentSuccess']);
Route::get('/order/success',  [StripeController::class, 'orderPaymentSuccess']);


Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'welcome'])->where('any', '.*');
Route::get('/', function () {
    return view('welcome');
});
