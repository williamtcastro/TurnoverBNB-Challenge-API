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

Route::post('/product/bulk', 'App\Http\Controllers\ProductController@storeMany');
Route::put('/product/bulk', 'App\Http\Controllers\ProductController@updateMany');
Route::delete('/product/bulk', 'App\Http\Controllers\ProductController@destroyMany');
Route::resource('/product', 'App\Http\Controllers\ProductController');

Route::get('/', function () {
    return ["message" => @'hello'];
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
