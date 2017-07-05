<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class LoginController extends Controller
{
    //
    public function login()
    {
    	return view('admin.login.login'); 
    }

    public function dologin(Request $request)
    {
    	$data = $request->except('_token');
    	//验证是否记住我
    	$remember = \Cookie::get('remember_token');
    	if($remember)
    	{
    		$abc = \DB::table('users')->where('remember_token',$remember)->first();
    		session(['master' => $abc]);
    		return redirect('/admin/index') -> with(['info' => '登录成功']);
    	}
    	// dd($request->all());
    	
    	// $pas = Crypt::encrypt($data['password']);
    	// dd($pas);
    	// 判断验证码是否正确
    	$code = session('code');
    	if($code != $data['code'])
    	{
    		return back() ->with(['info' => '验证码错误']);
    	}

    	$res = \DB::table('users')->where('name',$data['name'])->first();
    	if(!$res)
    	{
    		return back() ->with(['info' => '用户名不存在']);
    	}
    	// 对密码解密
    	$password = decrypt($res->password);
    	// dd($password);
    	if($password != $data['password'])
    	{
    		return back() ->with(['info' => '用户或密码输入错误']);
    	}
    	//将用户存入session
    	session(['master' => $res]);

    	//写入cookie
    	if($request->has('remember'))
    	{
    		\Cookie::queue('remember_token',$res->remember_token,10);
    	}
    	

    	return redirect('/admin/index') -> with(['info' => '登录成功']);

    	// dd(session('master'));
    }

    public function logout(Request $request)
    {
    	$request->session()->forget('master');
    	return redirect('/admin/login')->with(['info' => '退出成功']);
    }
}
