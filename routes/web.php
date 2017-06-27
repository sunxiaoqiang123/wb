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

Route::get('/mytest',function(){
	return '你好';
});
 
Route::get('/form',function(){
	return view('form');
});

Route::post('/test',function(){
	return 'hello';
});

Route::put('/myput',function(){
	return 'put提交';
});

Route::delete('/mydelete',function(){
	return 'delete提交';
});

// Route::get('/php',function(){
// 	return '这是GETphp';
// });

// Route::post('/php',function(){
// 	return '这是POST php';
// });

// Route::match(['get','post'],'/php',function(){
// 	return '这是get加post';
// });

//路由参数//?就是可以不传.正则约束
Route::get('/news/{id?}/{name?}',function($id,$name="aaa"){
	echo $id."<br>".$name;
	return; 
})->where(['id' => '[0-9]+','name' => '[a-z]+']);


//控制器
Route::get('/mycontro','TestController@index');

//
Route::get('/home/mycontro','Home\TestController@index');

// Route::get('/user/add','UserController@add');
// Route::get('/user/insert','UserController@insert');

//资源控制器
Route::get('/form',function(){
	return view('form');
});
Route::resource('/stu','StuController');
Route::get('/stu/myfunc/a','StuController@myfunc');