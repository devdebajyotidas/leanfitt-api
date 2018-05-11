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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'API'], function () {

    Route::post('account/login', 'UserController@login');
    Route::post('account/signup', 'UserController@signup');
    Route::post('account/recovery', 'UserController@recovery');
    Route::post('account/recovery/check', 'UserController@verifyEmailOtp');
    Route::post('account/recovery/reset', 'UserController@resetPassword');

});