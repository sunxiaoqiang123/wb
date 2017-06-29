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

//类,请求方式
Route::get('/', function () {
	//view,解析模板
    return view('welcome');
});

//后台主页
Route::get('/admin/index','Admin\IndexController@index');

//用户管理
Route::get('/admin/user/add','Admin\UserController@add');
Route::post('/admin/user/insert','Admin\UserController@insert');