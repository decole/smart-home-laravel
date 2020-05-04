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

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/margulis', 'HomeController@margulis')->name('margulis');

Route::get('/all-data', 'HomeController@allData')->name('all-data');

Route::get('/secure_system', 'HomeController@secure')->name('secure_system');

Route::get('/fire_secure_system', 'HomeController@firesecure')->name('fire_secure');

Route::get('/watering_system', 'HomeController@watering')->name('watering');

Route::get('/settings', 'HomeController@settings')->name('settings');

Route::get('/contacts', 'HomeController@contacts')->name('contacts');

Route::get('/messages', 'HomeController@messages')->name('messages');

Route::resource('/sensors', 'MqttSensorController');

Route::resource('/relays', 'MqttRelayController');

Route::resource('/types', 'DeviceTypeController');

Route::resource('/locations', 'DeviceLocationController');

Route::resource('/secure', 'SecureController');

Route::resource('/fire_secure', 'FireSecureController');

Route::resource('/history_greenhouse', 'MqttHistoryController');

Route::resource('/scheduler', 'ScheduleController');

Route::resource('/notifications', 'NotificationController');

Route::resource('/weight', 'HistoryWeightController');
