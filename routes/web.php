<?php

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

Route::get('/', 'HomeController@index');

Route::get('user/login', 'LoginController@login')->name('login');
Route::post('user/login', 'LoginController@doLogin');
Route::get('user/logout', 'LoginController@logout');
Route::get('user/register', 'LoginController@register');
Route::post('user/register', 'LoginController@store');
Route::put('user/verify', 'LoginController@verifyUser');
Route::put('user/forgot', 'LoginController@sendForgotPassword');
Route::get('user/reset', 'LoginController@resetPassword');
Route::put('user/reset', 'LoginController@doReset');

Route::get('admin/products', 'ProductController@adminIndex');

Route::get('products', 'ProductController@index');
Route::get('products/detail', 'ProductController@detail');

Route::group(['prefix' => 'user'], function() {
    Route::get('carts', 'CartController@showCart');
    Route::post('carts/add', 'CartController@addCart');
    Route::put('carts/update', 'CartController@updateCart');
    Route::delete('carts/delete-item', 'CartController@deleteCartItem');

    Route::get('vouchers', 'VoucherController@index');
    Route::get('vouchers/ajax', 'VoucherController@getVoucher');
    Route::put('vouchers/mark-used', 'VoucherController@updateUsed');

});