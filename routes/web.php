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

Route::resource('/', 'MainController');
Route::get('/main/rack/{area}', 'MainController@getRack');
Route::get('/main/bin-location/{rack}', 'MainController@getBinLocation');
Route::get('/main/bin/{binlocation}', 'MainController@getBin');
Route::post('/item', 'MainController@storeItem');
Route::get('/item/detail/{id}', 'MainController@detailItem');
Route::get('/item/edit/{id}', 'MainController@editItem');
Route::put('/item/update/{id}', 'MainController@updateItem');
Route::delete('/item/delete/{id}', 'MainController@deleteItem');
Route::get('/info/item/{id}', 'MainController@infoItem');
Route::get('/item/index', 'MainController@itemIndex')->name('item.list-index');
Route::post('/mutation', 'MainController@storeMutation');

Auth::routes();
Route::group(['middleware' => ['admin']],function(){
    Route::get('/admin', 'AdminController@index')->name('admin');
    Route::resource('/user', 'UserController');
    Route::put('/user/changepassword/{id}', 'UserController@changePassword');
    Route::resource('/area', 'AreaController');
    Route::resource('/rack', 'RackController');
    Route::resource('/bin-location', 'BinLocationController');
    Route::resource('/bin', 'BinController');
});