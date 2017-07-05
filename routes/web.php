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

//路由群组
Route::group(['middleware'=> 'adminlogin'],function(){
	//用户管理
	Route::get('/admin/user/add','Admin\UserController@add');
	Route::post('/admin/user/insert','Admin\UserController@insert');
	Route::get('/admin/user/index','Admin\UserController@index');
	Route::get('/admin/user/edit/{id}','Admin\UserController@edit');
	Route::get('/admin/user/delete/{id}','Admin\UserController@delete');
	Route::post('/admin/user/update','Admin\UserController@update');
	//ajax 操作
	Route::post('/admin/user/ajaxrename','Admin\UserController@ajaxRename');

	//分类管理 资源漏油
	Route::resource('/admin/category',"Admin\CategoryController");

	//微博管理
	Route::resource('/admin/post', 'Admin\PostController');

});

//后台登录
Route::get('/admin/login',"Admin\LoginController@login");
Route::post('/admin/dologin',"Admin\LoginController@dologin");
Route::get('/admin/logout',"Admin\LoginController@logout");

//验证码
Route::get('/kit/captcha/{tmp}', 'Admin\KitController@captcha');