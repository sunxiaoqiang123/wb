<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        $data = \DB::table('category')->select("*",\DB::raw("concat(path,',',id) AS sort_path"))->orderBy('sort_path')->get();
        //处理类级别
        foreach ($data as $key => $val) {
            //数path逗号数量
            $num = substr_count($val->path,',');
            $data[$key]->name = str_repeat('|---', $num).$data[$key]->name;

        }
        return view('admin.category.index',['title'=>'分类列表','data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //添加
    public function create()
    {
        //拼接字段排序按照原始select语句查询排序
        $data = \DB::table('category')->select("*",\DB::raw("concat(path,',',id) AS sort_path"))->orderBy('sort_path')->get();

        //处理类级别
        foreach ($data as $key => $val) {
            //数path逗号数量
            $num = substr_count($val->path,',');
            $data[$key]->name = str_repeat('|---', $num).$data[$key]->name;

        }
        return view('admin.category.add',['title'=> '分类添加','data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required|unique:category',
            'img' => 'required|image'
        ],[
            'name.required' => '类名不能为空',
            'name.unique' => '类名已经存在',
            'img.required' => '您没有上传logo图片',
            'img.image' => '上传图片规则有误',
        ]);

        $data = $request->except('_token','img');

        //获取扩展名上传图片
        $ext = $request->file('img')->extension();
        //随机文件名
        $filename = time().mt_rand(100000,999999).'.'.$ext;
        //移动
        $request->file('img')->move('uploads/blogo',$filename);

        //添加data数据
        $data['blogo'] = $filename;
        // dd($data);
        //查询父类path
        if($data['pid'] == 0)
        {
            $data['path'] = 0;
            $data['status'] = 1;
        }else
        {
            $parent_path = \DB::table('category')->where('id',$data['pid'])->first()->path;
            $data['path'] = $parent_path.','.$data['pid'];
            $data['status'] = 1;
        }


        //执行插入
        $res = \DB::table('category')->insert($data);
        if($res)
        {
            return redirect('/admin/category/create') ->with(['info' => '添加成功']);
        }else
        {
            return redirect('/admin/category/create') ->with(['info' => '添加失败']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = \DB::table('category')->where('id',$id)->first();
        // dd($data);
        $aa = \DB::table('category')->where('id',$data->pid)->first();
        // dd($aa);
        // dd($data);
        return view('admin.category.edit',['title' => '分类编辑','data' => $data,'aa' => $aa]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required|unique:category',
        ],[
            'name.required' => '类名不能为空',
            'name.unique' => '类名已经存在',
        ]);

        //查询老图片
        $blogo = \DB::table('category')->where('id',$id)->first()->blogo;
        // dd($blogo);
        //判断有没有修改图片
        if($request->hasFile('blogo'))
        {
            if($request->file('blogo')->isValid())
            {
                //获取扩展名
                $ext = $request->file('blogo')->extension();
                //随机名
                $filename = time().mt_rand(100000,999999).'.'.$ext;
                //移动
                $request->file('blogo')->move('uploads/blogo',$filename);

                //删除老图片并且判断是否存在
                if(file_exists('uploads/blogo/'.$blogo) && $blogo != 'default.jpg')
                {
                    unlink('uploads/blogo/'.$blogo);
                }
                // $data['blogo'] = $filename;
            }

            $data = $request->except('_token','name1','_method','blogo');
            $data['id'] = $id;
            $data['blogo'] = $filename;
        }else
        {
            $data = $request->except('_token','name1','_method');
            $data['id'] = $id;
        }

        // dd($data);

        $res = \DB::table('category')->where('id',$id)->update($data);
        if($res)
        {
            return redirect('/admin/category')-> with(['info' => '更新成功']);
        }else
        {
            return back() -> with(['info' => '更新失败']);
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $res = \DB::table('category')->where('pid',$id)->first();
        if($res)
        {
            return back() -> with(['info' => '存在子类不允许删除']);
        }else
        {
            $res1 = \DB::table('category')->delete($id);
            if($res1)
            {
                return redirect('/admin/category')-> with(['info' => '更新成功']);
            }else
            {
            return back() -> with(['info' => '更新失败']);
            }
        }
    }
}
