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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware'=>['auth']],function(){
Route::get('/customer', 'CustomerController@index')->name('customer.index');
Route::post('/customer', 'CustomerController@index')->name('customer.search');
Route::get('/customer/create', 'CustomerController@create')->name('customer.create');
Route::post('/customer/store', 'CustomerController@store')->name('customer.store');
Route::get('/customer/{id}', 'CustomerController@show')->name('customer.show');
Route::get('/customer/{id}/edit', 'CustomerController@edit')->name('customer.edit');
Route::put('/customer/{id}/update', 'CustomerController@update')->name('customer.update');
Route::delete('/customer/{id}/destroy', 'CustomerController@destroy')->name('customer.destroy');

Route::get('/product', 'ProductController@index')->name('product.index');
Route::post('/product', 'ProductController@index')->name('product.search');
Route::get('/product/create', 'ProductController@create')->name('product.create');
Route::post('/product/store', 'ProductController@store')->name('product.store');
Route::get('/product/{id}', 'ProductController@show')->name('product.show');
Route::get('/product/{id}/edit', 'ProductController@edit')->name('product.edit');
Route::put('/product/{id}/update', 'ProductController@update')->name('product.update');
Route::delete('/product/{id}/destroy', 'ProductController@destroy')->name('product.destroy');

Route::get('/order', 'OrdersController@index')->name('order.index');
Route::post('/order', 'OrdersController@index')->name('order.search');
Route::get('/add_order/{id}', 'OrdersController@create')->name('add_order');
Route::post('/add_order/{id}', 'OrdersController@store')->name('add_order_form');
Route::delete('/order/{id}/destroy', 'OrdersController@destroy')->name('order.destroy');
Route::post('/edit_order/{id}', 'OrdersController@update')->name('edit_order_form');
Route::get('/edit_order/{id}', 'OrdersController@edit')->name('order.edit');
Route::get('/order/{id}', 'OrdersController@show')->name('order.show');

Route::get('/edit_order_item/{id}', 'OrdersController@edit_item')->name('order.item_edit');
Route::delete('/order_item/{id}/destroy', 'OrdersController@destroy_item')->name('order_item.destroy');
Route::post('/order_item_edit', 'OrdersController@item_update');
Route::post('/order_item_add', 'OrdersController@item_add');
});

