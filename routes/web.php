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

Route::get('user/login', 'LoginController@login');
Route::get('user/logout', 'LoginController@logout');
Route::post('user/login', 'LoginController@doLogin');
