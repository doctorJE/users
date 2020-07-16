<?php

use Illuminate\Http\Request;
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

Route::group(['namespace' => 'v1', 'prefix' => 'v1'], function () {
    Route::group(['prefix' => '/user'], function () {
        Route::post('/create', 'UserController@create');
        Route::post('/delete', 'UserController@delete');
        Route::post('/pwd/change', 'UserController@changePassword');
    });
});
