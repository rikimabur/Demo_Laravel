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
    return view('BackEnds.layouts.master');
})->name('home');
Auth::routes();
Route::group(['namespace' => 'BackEnds', 'middleware' => 'auth'], function() {

	Route::get('/home', 'HomeController@index');

	Route::resource('users','UserController');

	Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index']);

/*	Route::get('roles',['as'=>'roles.index','uses'=>'RoleController@index','middleware' => ['permission:role-list|role-create|role-edit|role-delete']]);*/

	Route::get('roles/create',['as'=>'roles.create','uses'=>'RoleController@create','middleware' => ['permission:role-create']]);
	Route::post('roles/create',['as'=>'roles.store','uses'=>'RoleController@store','middleware' => ['permission:role-create']]);
	Route::get('roles/{id}',['as'=>'roles.show','uses'=>'RoleController@show']);
	Route::get('roles/{id}/edit',['as'=>'roles.edit','uses'=>'RoleController@edit','middleware' => ['permission:role-edit']]);
	Route::patch('roles/{id}',['as'=>'roles.update','uses'=>'RoleController@update','middleware' => ['permission:role-edit']]);
	Route::delete('roles/{id}',['as'=>'roles.destroy','uses'=>'RoleController@destroy','middleware' => ['permission:role-delete']]);

/*	Route::get('item',['as'=>'item.index','uses'=>'itemController@index','middleware' => ['permission:item-list|item-create|item-edit|item-delete']]);*/
	Route::get('item',['as'=>'item.index','uses'=>'itemController@index']);
	Route::get('item/create',['as'=>'item.create','uses'=>'itemController@create','middleware' => ['permission:item-create']]);
	Route::post('item/create',['as'=>'item.store','uses'=>'itemController@store','middleware' => ['permission:item-create']]);
	Route::get('item/{id}',['as'=>'item.show','uses'=>'itemController@show']);
	Route::get('item/{id}/edit',['as'=>'item.edit','uses'=>'itemController@edit','middleware' => ['permission:item-edit']]);
	Route::patch('item/{id}',['as'=>'item.update','uses'=>'itemController@update','middleware' => ['permission:item-edit']]);
	Route::delete('item/{id}',['as'=>'item.destroy','uses'=>'itemController@destroy','middleware' => ['permission:item-delete']]);
	Route::get('logout',function(){
		Auth::logout();
		return redirect()->home();
	});
});
