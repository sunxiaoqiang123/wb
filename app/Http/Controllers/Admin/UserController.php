<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //add
    public function add()
    {

    	return view('admin.user.add',['title' => '用户添加']);
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
	    $data['password'] = encrypt($data['password']);
        //加密
	    // $data['password'] = \Hash::make($data['password']);
        // if(\Hash::check('123456',$data['password']))
        // {
        //     echo '密码正确';
        // }
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
    	$res = \DB::table('users')->insert(
    		$data
    	);

        if($res)
        {
            return redirect('/admin/user/index');
        }else
        {
            return back() -> with(['info' => '添加失败']);
        }

    	// dd($data);

    }

    //用户列表
    public function index(Request $request)
    {   

        $num = $request->input('num',10);

        $keywords = $request->input('keywords','');
        //查询数据库
        $data = \DB::table('users')->where('name','like','%'.$keywords.'%')->paginate($num);
        // dd($request);

        return view('admin.user.index',['request' => $request->all(),'title'=>'用户列表','data' => $data]);
    }

    //ajax 修改同户名
    public function ajaxRename(Request $request)
    {

        // dd($request->all());
        
        $res = \DB::table('users')->where('name',$request->input('name'))->first();
        // dd($res);
        if($res)
        {
            return response() -> json(0);
        }else
        {
            $res = \DB::table('users')->where('id',$request->input('id'))->update(['name'=>$request->input('name')]);
            if($res)
            {
                return response()->json('1');
            }else
            {
                return response()->json('2');
            }
        }
        
        
    }

    //edit
    public function edit($id)
    {
        $data = \DB::table('users')->where('id',$id)->first();
        return view('admin.user.edit',['title' => '用户编辑','data' => $data]);
    }

    //update
    public function update(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:users|min:6|max:18',
            'email' => 'email',
            'img' => 'image'

       
        ],[
            'name.required' => '用户名不能为空',
            'name.unique' => '用户名已经存在',
            'name.min' => '用户名最小6个字符',
            'name.max' => '用户名不能超过18位',
            'email.email' => '您输入的邮箱有误',
            'img.image' => '上传图片规则有误',
        ]);

        $data = $request->except('_token','id');
        //查询老图片
        $oldimg = \DB::table('users')->where('id',$request->id)->first()->img;
        // dd($data);
        if($request->hasFile('img'))
        {
            //检测文件是否有效
            if($request->file('img')->isValid())
            {
                //获取扩展名
                $ext = $request->file('img')->extension();
                //随机文件名
                $filename = time().mt_rand(100000,999999).'.'.$ext;
                //移动
                $request->file('img')->move('uploads/img',$filename);
                //删除老图片并且判断存在否
                if(file_exists('./uploads/img/'.$oldimg) && $oldimg != 'default.jpg')
                {
                    unlink('./uploads/img/'.$oldimg);
                }
                //添加data数据
                $data['img'] = $filename;
            }
        }

        //处理更新时间
        $data['updated_at'] = date('Y-m-d H:i:s');

        $res = \DB::table('users')->where('id',$request->id)->update($data);
        if($res)
        {
            return redirect('/admin/user/index')-> with(['info' => '更新成功']);
        }else
        {
            return back() -> with(['info' => '更新失败']);
        }

    }



    //delete
    public function delete($id)
    {   
        $aa = \DB::table('users')->where('id',$id)->first();
        $res = \DB::table('users')->delete($id);
        if($res)
        {   
            //同时删除图片
            if(file_exists('./uploads/img/'.$aa->img) && $aa->img != 'default.jpg')
            {
                unlink('./uploads/img/'.$aa->img);
            }
            return redirect('/admin/user/index')->with(['info' => '删除成功']);
        }else
        {
            return back() -> with(['info' => '删除失败']);
        }
    }
}
