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

Route::group(['middleware' => ['auth:web']], function() {
    Route::get('/home', 'HomeController@index')->name('home');
    
    Route::group(['prefix' => '/networks'], function(){
        Route::get('/create', "NetworksController@create");

        Route::post('/store', 'NetworksController@store')->name('network_store');
    });

    Route::group(['prefix' => '/containers'], function() {
        Route::get('/show/{id}', 'ContainersController@show');
        Route::get('/create', 'ContainersController@create');

        Route::post('/store', 'ContainersController@store')->name('container_store');
        Route::post('/start', 'ContainersController@start');
    });

});
