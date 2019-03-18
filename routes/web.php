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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();
//Route::auth();

Route::get('/', 'SiteController@index'); //->name('home');
Route::get('/home', 'HomeController@index')->name('home');

//Route::controller('/auth', 'LoginController');
Route::get('/auth/login', 'LoginController@getLogin');
Route::post('/auth/login', 'LoginController@postLogin');
Route::get('/auth/register', 'LoginController@getRegister');
Route::post('/auth/register', 'LoginController@postRegister');
Route::get('/auth/logout', 'LoginController@getLogout');
Route::post('/auth/restore-pass', 'LoginController@postResetPassword');

Route::get('/acl', 'ACLController@getIndex');
Route::post('/acl/create', 'ACLController@postCreateRole');
Route::get('/acl/assign-role/{id}/{function_id}', 'ACLController@getToggleAssignFunction');
Route::get('/acl/delete/{id}', 'ACLController@getDelete');


Route::get('/accounts', 'AccountsController@getIndex');
Route::get('/accounts/filter', 'AccountsController@getFilter');
Route::get('/accounts/create', 'AccountsController@getCreate');
Route::post('/accounts/create', 'AccountsController@postCreate');
Route::get('/accounts/edit/{id}', 'AccountsController@getEdit');
Route::post('/accounts/edit/{id}', 'AccountsController@postUpdate');
Route::get('/accounts/activate/{id}', 'AccountsController@getActivate');
Route::get('/accounts/deactivate/{id}', 'AccountsController@getDeactivate');
Route::post('/accounts/update-password/{id}', 'AccountsController@postUpdatePassword');
Route::post('/accounts/reset-password/{id}', 'AccountsController@postUpdatePasswordAdmin');
Route::get('/accounts/delete/{id}', 'AccountsController@getDelete');
Route::get('/accounts/edit-profile', 'AccountsController@getProfile');
Route::post('/accounts/edit-profile', 'AccountsController@postUpdateProfile');
Route::post('/accounts/update-profile-password', 'AccountsController@postUpdateProfilePassword');

//Countries
Route::get('/countries', 'CountryController@getIndex');
Route::get('/countries/index', 'CountryController@getIndex');
Route::get('/countries/show/{id}', 'CountryController@getShow');
Route::get('/countries/create', 'CountryController@getCreate');
Route::post('/countries/create', 'CountryController@postStore');
Route::get('/countries/edit/{id}', 'CountryController@getEdit');
Route::post('/countries/edit/{id}', 'CountryController@postUpdate');
Route::get('/countries/delete/{id}', 'CountryController@getDestroy');
