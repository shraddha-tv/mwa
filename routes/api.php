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

Route::middleware('auth:api')->namespace('API')->group(function () {
    // Route::namespace('API')->group(function () {


    //route api for user show, create, update, delete
    // Route::post('users/{var}', 'UserController@postControler');
    Route::get('users/{var}', 'UserController@controler');
    Route::apiResource('users', 'UserController');
    
    
    Route::get('goods/{var}', 'GoodsController@controler');
    Route::apiResource('goods', 'GoodsController');


    Route::apiResource('states', 'StateController');


    Route::apiResource('categories', 'GoodCategoryController');

    Route::apiResource('goods_name', 'GoodsNameController');

});
Route::namespace('API')->group(function () {

    Route::get('public/search', 'GoodsController@search');
    Route::post('public/search', 'GoodsController@advancedSearch');
    Route::get('public/farmer/{id}', 'UserController@show');
    Route::get('public/goods/{id}', 'GoodsController@show');

});
