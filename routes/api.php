<?php

use Illuminate\Support\Facades\Route;

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

Route::post('/register', 'API\Authentication\RegisterController@register');
Route::post('/login', 'API\Authentication\LogController@login');

Route::get('/catalog/{product?}', 'API\Catalog\MainController@index')->name('catalog');
Route::group(['prefix' => 'categories'], function() {
    Route::get('/{category?}', 'API\Catalog\MainController@categories');
    Route::get('/{category}/{product}', 'API\Catalog\MainController@product');
});

Route::group(['prefix' => 'basket', ], function() {
    Route::get('/', 'API\Basket\BasketController@basketCheck');
    Route::get('/add/{product}', 'API\Basket\BasketController@basketAdd');
    Route::get('/remove/{product}', 'API\Basket\BasketController@basketRemove');
    Route::post('/confirm', 'API\Basket\BasketController@basketConfirm');
});  

Route::middleware('auth:api')->group(function () {

    Route::middleware('role')->group(function () {
        Route::resource('products', 'API\Catalog\ProductController');
        Route::resource('categories', 'API\Catalog\CategoryController');
        Route::resource('orders', 'API\Manager\ManagerController');
    });

    Route::group(['prefix' => 'admin'], function() {
        Route::resource('users', 'API\Admin\AdminController');
    });

    Route::group(['prefix' => 'users'], function() {
        Route::get('/show', 'API\Users\UserController@show');
        Route::post('/update', 'API\Users\UserController@update');
        Route::get('/delete', 'API\Users\UserController@delete');
        Route::get('/orders/show/{order?}', 'API\Users\OrderController@show');
        Route::post('/orders/update/{order}', 'API\Users\OrderController@update');
        Route::get('/orders/delete/{order}', 'API\Users\OrderController@delete');

        Route::group(['prefix' => 'basket', ], function() {
            Route::get('/', 'API\Basket\BasketController@basketCheck');
            Route::get('/add/{product}', 'API\Basket\BasketController@basketAdd');
            Route::get('/remove/{product}', 'API\Basket\BasketController@basketRemove');
            Route::post('/confirm', 'API\Basket\BasketController@basketConfirm');
        });  
    });

    Route::get('/logout', 'API\Authentication\LogController@logout');
});
