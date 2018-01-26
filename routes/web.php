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



// Admin
Route::group(['prefix' => 'admin'], function () {
	Route::match(['GET', 'POST'], '/', 'Admin\\Login@index');	
	Route::match(['GET', 'POST'], '/login', 'Admin\\Login@index');
	Route::get('login/captcha', 'Admin\\Login@captcha');
	Route::get('logout', 'Admin\\Login@logout');

	Route::group(['middleware' => 'admin'], function () {
		Route::get('index', 'Admin\\Index@index');

		Route::get('admin', 'Admin\\Admin@index');
		Route::get('admin/add', 'Admin\\Admin@add');
		Route::get('admin/detail/{id}', 'Admin\\Admin@detail');
		Route::post('admin/ajaxAdd', 'Admin\\Admin@ajaxAdd');
		Route::post('admin/ajaxUpdate/{id}', 'Admin\\Admin@ajaxUpdate');


		Route::get('category', 'Admin\\Category@index');
		Route::get('category/add', 'Admin\\Category@add');
		Route::get('category/detail/{id}', 'Admin\\Category@detail');
		Route::post('category/ajaxAdd', 'Admin\\Category@ajaxAdd');
		Route::post('category/ajaxUpdate/{id}', 'Admin\\Category@ajaxUpdate');

		Route::get('level/index/{cId}', 'Admin\\CategoryLevel@index');
		Route::get('level/add/{cId}', 'Admin\\CategoryLevel@add');
		Route::get('level/detail/{id}', 'Admin\\CategoryLevel@detail');
		Route::post('level/ajaxAdd', 'Admin\\CategoryLevel@ajaxAdd');
		Route::post('level/ajaxUpdate/{id}', 'Admin\\CategoryLevel@ajaxUpdate');
		

		Route::get('news', 'Admin\\News@index');
		Route::get('news/add', 'Admin\\News@add');
		Route::get('news/detail/{id}', 'Admin\\News@detail');
		Route::post('news/ajaxAdd', 'Admin\\News@ajaxAdd');
		Route::post('news/ajaxUpdate/{id}', 'Admin\\News@ajaxUpdate');

	});
});