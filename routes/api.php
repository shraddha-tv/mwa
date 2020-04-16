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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:api')->namespace('API')->group(function () {
    Route::namespace('API')->group(function () {


    //route api for user show, create, update, delete
    // Route::get('users/{var}', 'UserController@getControler');
    // Route::post('users/{var}', 'UserController@postControler');
    Route::apiResource('users', 'UserController');

});
