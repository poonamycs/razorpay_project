<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('payment', 'App\Http\Controllers\PaymentController@index');
// Route::Post('payment','App\Http\Controllers\PaymentController@store')->name('razorpay.payment.store');
Route::get('/get-form', 'App\Http\Controllers\MainController@getform');
Route::post('/login', 'App\Http\Controllers\MainController@storeform');

Route::get('/', 'App\Http\Controllers\MainController@index')->name('home');
Route::get('/success', 'App\Http\Controllers\MainController@success');
Route::post('/payment', 'App\Http\Controllers\MainController@payment');

Route::post('/pay' , 'App\Http\Controllers\MainController@pay');
Route::get('/error' , 'App\Http\Controllers\MainController@error');

Route::get('/loadmore', 'App\Http\Controllers\BlogController@index');
Route::post('/loadmore/load_data', 'App\Http\Controllers\BlogController@load_data')->name('loadmore.load_data');
