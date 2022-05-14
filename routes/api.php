<?php

use Illuminate\Http\Request;

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
Route::post('register', "Api\AuthController@register");
Route::post('login', "Api\AuthController@login");

Route::middleware('auth:api')->group(function () {

    Route::post('logout', "Api\AuthController@logout");
    
    Route::prefix("articles")->group(function() {
        Route::get("/", "Api\ArticleController@index");
        Route::get("{id}", "Api\ArticleController@get");
        Route::post("create", "Api\ArticleController@save");
        Route::post("update/{id}", "Api\ArticleController@update");
    });

});