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

		// 行程分類
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
		Route::get('level/ajaxLevel/{cId}', 'Admin\\CategoryLevel@ajaxCategoryLevel');


		// 相簿
		Route::get('album', 'Admin\\Album@index');
		Route::get('album/add', 'Admin\\Album@add');
		Route::get('album/detail/{id}', 'Admin\\Album@detail');
		Route::post('album/ajaxAdd', 'Admin\\Album@ajaxAdd');
		Route::post('album/ajaxUpdate/{id}', 'Admin\\Album@ajaxUpdate');
		Route::post('album/ajaxDelete', 'Admin\\Album@ajaxDelete');
		Route::post('album/ajaxCover/{id}', 'Admin\\Album@ajaxCover');
		Route::get('album/ajaxAlbum/{cId}', 'Admin\\Album@ajaxCategoryAlbum');

		Route::get('picture/index/{aId}', 'Admin\\AlbumPicture@index');
		Route::get('picture/add/{aId}', 'Admin\\AlbumPicture@add');
		Route::get('picture/detail/{id}', 'Admin\\AlbumPicture@detail');
		Route::post('picture/ajaxAdd', 'Admin\\AlbumPicture@ajaxAdd');
		Route::post('picture/ajaxDelete/{aId}', 'Admin\\AlbumPicture@ajaxDelete');

		// 行程
		Route::get('tour', 'Admin\\Tour@index');
		Route::get('tour/add', 'Admin\\Tour@add');
		Route::get('tour/detail/{id}', 'Admin\\Tour@detail');
		Route::post('tour/ajaxAdd', 'Admin\\Tour@ajaxAdd');
		Route::post('tour/ajaxUpdate/{id}', 'Admin\\Tour@ajaxUpdate');

		

		Route::get('news', 'Admin\\News@index');
		Route::get('news/add', 'Admin\\News@add');
		Route::get('news/detail/{id}', 'Admin\\News@detail');
		Route::post('news/ajaxAdd', 'Admin\\News@ajaxAdd');
		Route::post('news/ajaxUpdate/{id}', 'Admin\\News@ajaxUpdate');

	});
});