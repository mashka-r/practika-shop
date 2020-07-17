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

Route::post('/register', 'API\RegisterController@register')->name('api-register');
Route::post('/login', 'API\LogController@login')->name('api-login');

Route::middleware('auth:api')->group(function () {

    Route::group(['prefix' => 'lk-kab'], function() {
        Route::get('/show', 'API\UserController@show');
        Route::post('/update', 'API\UserController@update'); 
        Route::get('/delete', 'API\UserController@delete');
        Route::get('/logout', 'API\LogController@logout')->name('api-logout');
    });
});

Route::group(['prefix' => 'admin'], function() {
    Route::post('/login', 'API\LogController@login');
    
    Route::middleware('auth:api')->group(function () {
        Route::resource('users', 'API\AdminController')->only([
            'index', 'store', 'show', 'update', 'destroy'
        ]);
        Route::get('/logout', 'API\LogController@logout');
    });
});

Route::group(['prefix' => 'manager'], function() {
    Route::post('/login', 'API\LogController@login');

    Route::middleware('auth:api')->group(function () {
        Route::resource('orders', 'API\ManagerController')->only([
            'index', 'show', 'update'
        ]);
        Route::resource('products', 'API\ProductController')->only([
            'index', 'store', 'show', 'update', 'destroy'
        ]);
        Route::resource('categories', 'API\CategoryController')->only([
            'index', 'store', 'show', 'update', 'destroy'
        ]);
        Route::get('/logout', 'API\LogController@logout');
    });
});

