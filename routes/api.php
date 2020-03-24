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

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

    Route::group(['middleware' => ['auth:api', 'is_admin']], function () {
        Route::resource('news', 'NewsController', ['only' => ['store', 'update', 'destroy']]);
        Route::resource('photo', 'PhotoController', ['only' => ['store', 'update', 'destroy']]);
        Route::resource('user', 'UserController', ['only' => ['store', 'update', 'destroy', 'show', 'index']]);
    });

    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('/like/{model}/{id}', 'LikeController@store');
        Route::delete('/like/{model}/{id}', 'LikeController@destroy');
        Route::resource('news', 'NewsController', ['only' => ['index', 'show']]);
        Route::resource('photo', 'PhotoController', ['only' => ['index', 'show']]);
    });

    Route::post('login', 'UserController@login');
    Route::post('register', 'UserController@register');

});
