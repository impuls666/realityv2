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




//main page route
Route::get('/', 'FilterController@index')->name('index');
//post filter route
Route::post('/', 'FilterController@change')->name('filter');
//filter pre mesto

//all data route
Route::get('data', 'MarkerController@index');
Route::group(['prefix' => 'data'], function () {
    Route::get('mesta/{mesta}','FilterController@mesta');
    Route::get('price/{price};{price2}/kraj/{kraj}/mesto/{mesto}', [
        'uses' => 'FilterController@show',
    ] );
});




// filter route


//kraj filter route
//Route::get('data/kraj/{kraj}', 'FilterController@kraj');
//auth routes
Auth::routes();
//post id route
Route::get('post/{id}', 'Postcontroller@show')->name('post');
//add something route
Route::get('home', 'HomeController@index')->name('home');
//lat long convert route
Route::post('show', 'MarkerController@showlatlong')->name('show');
//add new mark on map route
Route::post('store','MarkerController@store')->name('store');

