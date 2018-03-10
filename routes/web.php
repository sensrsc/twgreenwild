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

// Route::get('/', function () {
//     return view('front/home', ['device' => 'desktop']);
// });

// Route::get('/reserve_car', function () {
//     return view('front/reserve_car', ['device' => 'desktop']);
// });

Route::get('/', 'Index@index');
Route::match(['get', 'post'], 'register', 'Register@index');
Route::match(['get', 'post'], 'login', 'Login@index');
Route::get('/logout', 'Login@logout');
Route::get('/reserve_car', 'Reserve@index');
Route::post('/reserve/create', 'Reserve@createReserve');

Route::group(['middleware' => 'front'], function () {
    Route::get('activities/{id}', 'Activities@index');

    Route::get('activity/{id}', 'Activity@index');

    Route::get('member/info', function () {
        return view('front/member_info');
    });

    Route::get('member', 'Member@index');
    Route::get('member/order', 'Member@order');

    Route::get('test/testroute', 'Test@testroute');

});

Route::get('test/paytest', 'Test@paytest');
Route::get('test/payview', 'Test@payview');
Route::get('test/paycredit', 'Test@paycredit');
Route::get('test/payatm', 'Test@payatm');
Route::get('test/checkmac', 'Test@checkmac');
Route::get('test/test', 'Test@test');
Route::get('test/modeltest', 'Test@modeltest');
Route::get('test/sessiontest', 'Test@sessiontest');

Route::post('test/returnurl', 'Test@returnurl');
Route::post('test/infourl', 'Test@infourl');

Route::post('ecpay/returnurl', 'Ecpay@returnurl');
Route::post('ecpay/infourl', 'Ecpay@infourl');

// Admin
Route::group(['prefix' => 'admin'], function () {
    Route::match(['GET', 'POST'], '/', 'Admin\\Login@index');
    Route::match(['GET', 'POST'], '/login', 'Admin\\Login@index');
    Route::get('login/captcha', 'Admin\\Login@captcha');
    Route::get('logout', 'Admin\\Login@logout');

    Route::group(['middleware' => 'admin'], function () {
        Route::get('index', 'Admin\\Index@index');
        Route::get('index/test', 'Admin\\Index@test');

        Route::get('admin', 'Admin\\Admin@index');
        Route::get('admin/add', 'Admin\\Admin@add');
        Route::get('admin/detail/{id}', 'Admin\\Admin@detail');
        Route::post('admin/ajaxAdd', 'Admin\\Admin@ajaxAdd');
        Route::post('admin/ajaxUpdate/{id}', 'Admin\\Admin@ajaxUpdate');

        // 首頁輪播
        Route::get('slide', 'Admin\\Slide@index');
        Route::get('slide/add', 'Admin\\Slide@add');
        Route::get('slide/detail/{id}', 'Admin\\Slide@detail');
        Route::post('slide/ajaxAdd', 'Admin\\Slide@ajaxAdd');
        Route::post('slide/ajaxUpdate/{id}', 'Admin\\Slide@ajaxUpdate');
        Route::post('slide/ajaxDelete', 'Admin\\Slide@ajaxDelete');

        // 行程分類
        Route::get('category', 'Admin\\Category@index');
        Route::get('category/add', 'Admin\\Category@add');
        Route::get('category/detail/{id}', 'Admin\\Category@detail');
        Route::post('category/ajaxAdd', 'Admin\\Category@ajaxAdd');
        Route::post('category/ajaxUpdate/{id}', 'Admin\\Category@ajaxUpdate');
        Route::get('category/ajaxDescription/{id}', 'Admin\\Category@ajaxCategoryDescription');

        Route::get('level/index/{cId}', 'Admin\\CategoryLevel@index');
        Route::get('level/add/{cId}', 'Admin\\CategoryLevel@add');
        Route::get('level/detail/{id}', 'Admin\\CategoryLevel@detail');
        Route::post('level/ajaxAdd', 'Admin\\CategoryLevel@ajaxAdd');
        Route::post('level/ajaxUpdate/{id}', 'Admin\\CategoryLevel@ajaxUpdate');
        Route::post('level/ajaxDelete', 'Admin\\CategoryLevel@ajaxDelete');
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
        // 相片
        Route::get('picture/index/{aId}', 'Admin\\AlbumPicture@index');
        Route::get('picture/add/{aId}', 'Admin\\AlbumPicture@add');
        Route::get('picture/detail/{id}', 'Admin\\AlbumPicture@detail');
        Route::post('picture/ajaxAdd', 'Admin\\AlbumPicture@ajaxAdd');
        Route::post('picture/ajaxDelete/{aId}', 'Admin\\AlbumPicture@ajaxDelete');
        Route::get('picture/ajaxAlbumPicture/{aId}', 'Admin\\AlbumPicture@ajaxAlbumPicture');
        // 活動影音
        Route::get('video', 'Admin\\Video@index');
        Route::get('video/add', 'Admin\\Video@add');
        Route::get('video/detail/{id}', 'Admin\\Video@detail');
        Route::post('video/ajaxAdd', 'Admin\\Video@ajaxAdd');
        Route::post('video/ajaxUpdate/{id}', 'Admin\\Video@ajaxUpdate');
        Route::post('video/ajaxDelete', 'Admin\\Video@ajaxDelete');

        // 最新消息
        Route::get('news', 'Admin\\News@index');
        Route::get('news/add', 'Admin\\News@add');
        Route::get('news/detail/{id}', 'Admin\\News@detail');
        Route::post('news/ajaxAdd', 'Admin\\News@ajaxAdd');
        Route::post('news/ajaxUpdate/{id}', 'Admin\\News@ajaxUpdate');

        // 行程
        Route::get('tour', 'Admin\\Tour@index');
        Route::get('tour/add', 'Admin\\Tour@add');
        Route::get('tour/detail/{id}', 'Admin\\Tour@detail');
        Route::post('tour/ajaxAdd', 'Admin\\Tour@ajaxAdd');
        Route::post('tour/ajaxUpdate/{id}', 'Admin\\Tour@ajaxUpdate');
        Route::post('tour/ajaxRecommend/{id}', 'Admin\\Tour@ajaxRecommend');
        // 行程不接單
        Route::get('tour/notaccept/{id}', 'Admin\\Tour@notaccept');
        Route::post('tour/ajaxUpdateDate/{id}', 'Admin\\Tour@ajaxUpdateNotAccept');

        // 教練
        Route::get('coach', 'Admin\\Coach@index');
        Route::get('coach/add', 'Admin\\Coach@add');
        Route::get('coach/detail/{id}', 'Admin\\Coach@detail');
        Route::post('coach/ajaxAdd', 'Admin\\Coach@ajaxAdd');
        Route::post('coach/ajaxUpdate/{id}', 'Admin\\Coach@ajaxUpdate');
        Route::post('coach/ajaxDelete', 'Admin\\Coach@ajaxDelete');
        // meta相關訓練、證照、經歷
        Route::get('coachmeta/index/{type}/{cId}', 'Admin\\Coachmeta@index');
        Route::get('coachmeta/add/{type}/{cId}', 'Admin\\Coachmeta@add');
        Route::get('coachmeta/detail/{id}', 'Admin\\Coachmeta@detail');
        Route::post('coachmeta/ajaxAdd', 'Admin\\Coachmeta@ajaxAdd');
        Route::post('coachmeta/ajaxUpdate/{id}', 'Admin\\Coachmeta@ajaxUpdate');
        Route::post('coachmeta/ajaxDelete/{cId}', 'Admin\\Coachmeta@ajaxDelete');

        // 筆記
        Route::get('notes', 'Admin\\Notes@index');
        Route::get('notes/add', 'Admin\\Notes@add');
        Route::get('notes/detail/{id}', 'Admin\\Notes@detail');
        Route::post('notes/ajaxAdd', 'Admin\\Notes@ajaxAdd');
        Route::post('notes/ajaxUpdate/{id}', 'Admin\\Notes@ajaxUpdate');
        Route::post('notes/ajaxDelete', 'Admin\\Notes@ajaxDelete');

        // 預約叫車
        Route::get('reserveorder', 'Admin\\ReserveOrder@index');
        Route::get('reserveorder/info/{id}', 'Admin\\ReserveOrder@info');

        // 系統變數
        Route::get('system', 'Admin\\SystemVariable@index');
        Route::get('system/add', 'Admin\\SystemVariable@add');
        Route::get('system/detail/{id}', 'Admin\\SystemVariable@detail');
        Route::post('system/ajaxAdd', 'Admin\\SystemVariable@ajaxAdd');
        Route::post('system/ajaxUpdate/{id}', 'Admin\\SystemVariable@ajaxUpdate');

    });
});
