<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/telemetry', function (){ return 'telemetry'; })->name('telemetry');

Route::get('/my', function (){ return 'my settings'; })->name('settings');

//Route::get('/my', 'HomeController@index')->name('settings');
