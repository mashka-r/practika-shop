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

Route::get('/', 'MainController@index')->name('index');
Route::get('/categories', 'MainController@categories')->name('categories');

Route::get('/register', 'API\RegisterController@show')->name('register');
Route::get('/login', 'API\LogController@show')->name('login');

Route::group(['prefix' => 'basket', ], function() {
    Route::post('/add/{id}', 'BasketController@basketAdd')->name('basket-add');
    Route::get('/', 'BasketController@basket')->name('basket');
    Route::get('/place', 'BasketController@basketPlace')->name('basket-place');
    Route::post('/remove/{id}', 'BasketController@basketRemove')->name('basket-remove');
    Route::post('/place', 'BasketController@basketConfirm')->name('basket-confirm');
});  

Route::get('/{category}', 'MainController@category')->name('category');
Route::get('/{category}/{product?}', 'MainController@product')->name('product');
