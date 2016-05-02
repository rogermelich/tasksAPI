<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::group(['prefix' => 'api/v1', 'middleware' => 'auth:api'], function () {
//    Route::post('/short', 'UrlMapperController@store');
//});
//
//Auth::guard('api')->user();

Route::get('/auth/login', function(){
    return("No tens Accés a l'API");
});

Route::group(['prefix' => 'api', 'middleware' => 'throttle:6,10'], function () {
    Route::get('people', function () {
        return Person::all();
    });
});