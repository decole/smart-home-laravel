<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('index');
});

Route::get('/','HomeController@index')->name('index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/sensors', 'MqttSensorController');

Route::resource('/types', 'DeviceTypeController');

Route::resource('/locations', 'DeviceLocationController');
