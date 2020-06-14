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

Route::prefix('/secure')->group(function () {

    Route::get('/', 'Api\SecureApi@index');

    Route::get('/state', 'Api\SecureApi@state');

    Route::post('/post', 'Api\SecureApi@post');

});

Route::any('/alice', 'AliceController@index');

Route::prefix('/alice_home')->group(function () {
    /**
     *  Ресурс	                    Описание	                                    Метод
     *  /v1.0/	                    Проверка доступности Endpoint URL провайдера	HEAD
     *  /v1.0/user/unlink	        Оповещение о разъединении аккаунтов	            POST
     *  /v1.0/user/devices	        Информация об устройствах пользователя	        GET
     *  /v1.0/user/devices/query	Информация о состояниях устройств пользователя	POST
     *  /v1.0/user/devices/action	Изменение состояния у устройств                 POST
     */

    Route::get('/', 'Api\SmartHomeApi@index');

    Route::get('/v1.0/', 'Api\SmartHomeApi@index');

    Route::post('/v1.0/user/unlink', 'Api\SmartHomeApi@unlink');

    Route::get('/v1.0/user/devices', 'Api\SmartHomeApi@devices');

    Route::post('/v1.0/user/devices/query', 'Api\SmartHomeApi@devicesQuery');

    Route::post('/v1.0/user/devices/action', 'Api\SmartHomeApi@devicesAction');

});

Route::any('/greenhouse', 'MqttHistoryController@get');
