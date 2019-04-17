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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::get('email', 'TrackingController@email')->name('email');

Route::group([
    'prefix' => 'tracking',
    'as' => 'tracking.'
], function () {
    Route::post('submit', 'TrackingController@submit')->name('submit');
    Route::get('{code}/view', 'TrackingController@view')->name('view');


});
