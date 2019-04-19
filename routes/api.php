<?php

use Illuminate\Http\Request;

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

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/logout', 'AuthController@logout');

Route::get('/requests', 'JobRequestController@all')->name('requests.all');
Route::post('/request', 'JobRequestController@store')->name('requests.store');
Route::put('/request/{id}', 'JobRequestController@update')->name('requests.update');
Route::delete('/request/{id}', 'JobRequestController@destroy')->name('requests.destroy');