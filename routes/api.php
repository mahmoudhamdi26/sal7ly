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

Route::post('/forget', 'AuthController@forget');
Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');
Route::post('/login/facebook', 'FacebookController@login');
Route::get('/refresh', 'AuthController@refresh');
Route::post('/logout', 'AuthController@logout');
Route::post('/user/update', 'AuthController@update');
Route::post('/user/mobile/confirm', 'AuthController@confirm_mobile');

Route::get('/requests', 'JobRequestController@all')->name('requests.all');
Route::post('/requests', 'JobRequestController@store')->name('requests.store');
Route::post('/problems', 'JobRequestController@storeProblem')->name('requests.storeProblem');
Route::put('/requests/{id}', 'JobRequestController@update')->name('requests.update');
Route::delete('/requests/{id}', 'JobRequestController@destroy')->name('requests.destroy');

Route::get('/categories', 'JobRequestController@cats')->name('categories.all');
Route::get('/categories/{id}/services', 'JobRequestController@services')->name('services.all');
