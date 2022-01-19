<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaytmController;

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

// Route::get('/', function () {
//     return view('whatsapp')->name('paytm.main');
// });

//Paytm Payment
Route::post('paytm-payment', [App\Http\Controllers\PaytmController::class, 'paytmPayment'])->name('paytm.payment');
Route::post('paytm-callback', [App\Http\Controllers\PaytmController::class, 'paytmCallback'])->name('paytm.callback');
//Route::get('paytm-purchase', ['PaytmController@paytmPurchase'])->name('paytm.purchase');
Route::get('/paytm-purchase', [App\Http\Controllers\PaytmController::class, 'paytmPurchase'])->name('paytm.purchase');
Route::get('/', [App\Http\Controllers\PaytmController::class, 'main'])->name('paytm.main');

