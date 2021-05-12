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
    return view('main');
});

Auth::routes();
Route::group(['middleware' => ['admin']],function(){
    Route::get('/admin', 'AdminController@index')->name('admin');
    Route::resource('/user', 'UserController');
    Route::put('/user/changepassword/{id}', 'UserController@changePassword');
    Route::resource('/area', 'AreaController');
    Route::resource('/rack', 'RackController');
});