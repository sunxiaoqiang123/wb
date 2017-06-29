<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //add
    public function add()
    {

    	return view('admin.user.add');
    }

    public function insert(Request $request)
    {
    	// dd($request->all());
    	//自带报错
    	$this->validate($request, [
	        'name' => 'required|unique:users|min:6|max:18',
	        'email' => 'email|unique:users',
	        'password' => 'required',
	        'repass' => 'required|same:password',
	        'img' => 'required|image'

	   
	    ],[
	    	'name.required' => '用户名不能为空',
	    	'name.unique' => '用户名已经存在',
	    	'name.min' => '用户名最小6个字符',
	    	'name.max' => '用户名不能超过18位',
	    	'email.email' => '您输入的邮箱有误',
	    	'email.unique' => '邮箱已经注册',
	    	'password.required' => '密码不能为空',
	    	'repass.required' => '确认密码不能为空',
	    	'repass.same' => '密码输入不一致',
	    	'img.required' => '您没有上传图片',
	    	'img.image' => '上传图片规则有误',
	    ]);



    	$data = $request->except('_token','repass');

    	//处理密码
	    // $data['password'] = encrypt($data['password']);

	    $data['password'] = Hash::make($data['password']);

	    //解密
	    // $password = decrypt($data['password']);

    	// dd($data);
    	//图片上传
    	if($request->hasfile('img'))
    	{
    		if($request->file('img')->isValid())
    		{
    			//获取扩展名
    			$ext = $request->file('img')->extension();
    			//随机文件名
    			$filename = time().mt_rand(100000,999999).'.'.$ext;
    			//移动
    			$request->file('img')->move('uploads/img',$filename);

    			//添加data数据
    			$data['img'] = $filename;
    		}
    	}
    	//处理token
    	$data['remember_token'] = str_random(50);
    	//处理时间
    	$time = date('Y-m-d H:i:s');
    	$data['created_at'] = $time;
    	$data['updated_at'] = $time;

    	//执行数据库添加
    	\DB::table('users')->insert(
    		$data
    	);

    	// dd($data);

    }
}
