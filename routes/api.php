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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('/mqtt')->group(function () {

    Route::get('/', 'Api\MqttApi@index');

    Route::get('/get', 'Api\MqttApi@get');

    Route::post('/post', 'Api\MqttApi@post');

});

Route::any('/alice', 'AliceController@index');

Route::any('/greenhouse', 'MqttHistoryController@get');
