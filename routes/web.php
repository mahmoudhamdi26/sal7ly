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




//Categories
Route::get('/categories', 'CategoryController@getIndex');
Route::get('/categories/index', 'CategoryController@getIndex');
Route::get('/categories/create', 'CategoryController@getCreate');
Route::post('/categories/create', 'CategoryController@postStore');
Route::get('/categories/edit/{id}', 'CategoryController@getEdit');
Route::post('/categories/edit/{id}', 'CategoryController@postUpdate');
Route::get('/categories/delete/{id}', 'CategoryController@getDestroy');

//Users
Route::get('/users', 'UsersController@getIndex');
Route::get('/users/index', 'UsersController@getIndex');
Route::get('/users/create', 'UsersController@getCreate');
Route::post('/users/create', 'UsersController@postStore');
Route::get('/users/edit/{id}', 'UsersController@getEdit');
Route::post('/users/edit/{id}', 'UsersController@postUpdate');
Route::get('/users/delete/{id}', 'UsersController@getDestroy');

//DeviceType
Route::get('/devices', 'DeviceTypeController@getIndex');
Route::get('/devices/index', 'DeviceTypeController@getIndex');
Route::get('/devices/create', 'DeviceTypeController@getCreate');
Route::post('/devices/create', 'DeviceTypeController@postStore');
Route::get('/devices/edit/{id}', 'DeviceTypeController@getEdit');
Route::post('/devices/edit/{id}', 'DeviceTypeController@postUpdate');
Route::get('/devices/delete/{id}', 'DeviceTypeController@getDestroy');

//Services
Route::get('/services', 'ServicesController@getIndex');
Route::get('/services/index', 'ServicesController@getIndex');
Route::get('/services/create', 'ServicesController@getCreate');
Route::post('/services/create', 'ServicesController@postStore');
Route::get('/services/edit/{id}', 'ServicesController@getEdit');
Route::post('/services/edit/{id}', 'ServicesController@postUpdate');
Route::get('/services/delete/{id}', 'ServicesController@getDestroy');

//JobTypes
Route::get('/job-types', 'JobTypeController@getIndex');
Route::get('/job-types/index', 'JobTypeController@getIndex');
Route::get('/job-types/create', 'JobTypeController@getCreate');
Route::post('/job-types/create', 'JobTypeController@postStore');
Route::get('/job-types/edit/{id}', 'JobTypeController@getEdit');
Route::post('/job-types/edit/{id}', 'JobTypeController@postUpdate');
Route::get('/job-types/delete/{id}', 'JobTypeController@getDestroy');


//JobRequests
Route::get('/job-requests', 'JobReqController@getIndex');
Route::get('/job-requests/index', 'JobReqController@getIndex');
Route::post('/job-requests/update/{id}', 'JobReqController@update');
Route::get('/job-requests/delete/{id}', 'JobReqController@getDestroy');

Route::get('images/{image}', 'ImageController@getImage');
//Logs
Route::get('/logs', 'LogsController@getIndex');
Route::get('/logs/index', 'LogsController@getIndex');