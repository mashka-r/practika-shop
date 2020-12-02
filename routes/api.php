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

Route::group(['prefix' => 'catalog'], function() {
    Route::resource('products', 'API\Catalog\Product\ProductController');
    Route::resource('categories', 'API\Catalog\Category\CategoryController');
});

Route::group(['prefix' => 'basket', ], function() {
    Route::get('/', 'API\Basket\BasketController@basketCheck');
    Route::get('/add/{product}', 'API\Basket\BasketController@basketAdd');
    Route::get('/remove/{product}', 'API\Basket\BasketController@basketRemove');
    Route::post('/confirm', 'API\Basket\BasketController@basketConfirm');
});  

Route::middleware('auth:api')->group(function () {

    Route::group(['prefix' => 'admin'], function() {
        Route::middleware('admin')->group(function () {
            Route::resource('users', 'API\Admin\User\AdminController');
            Route::resource('products', 'API\Admin\Product\ProductController');
            Route::resource('categories', 'API\Admin\Category\CategoryController');
            Route::resource('orders', 'API\Admin\Order\OrderController');
        });
    });

    Route::group(['prefix' => 'clients'], function() {
        Route::middleware('client')->group(function () {
            Route::resource('users', 'API\Users\User\UserController');
            Route::resource('orders', 'API\Users\Order\OrderController');

            Route::group(['prefix' => 'basket', ], function() {
                Route::get('/', 'API\Basket\BasketController@basketCheck');
                Route::get('/add/{product}', 'API\Basket\BasketController@basketAdd');
                Route::get('/remove/{product}', 'API\Basket\BasketController@basketRemove');
                Route::post('/confirm', 'API\Basket\BasketController@basketConfirm');
            }); 
        });  
    });

    Route::group(['prefix' => 'manager'], function() {
        Route::middleware('manager')->group(function () {
            Route::resource('products', 'API\Manager\Product\ProductController');
            Route::resource('categories', 'API\Manager\Category\CategoryController');
            Route::resource('orders', 'API\Manager\Order\ManagerController');
        });
    });

    Route::get('/logout', 'API\Authentication\LogController@logout');
});
