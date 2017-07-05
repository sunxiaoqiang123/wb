@extends('admin.layout')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        微博管理
        <small>列表</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">微博管理</a></li>
        <li class="active">列表</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <form action="{{ url('/admin/post/index') }}" method="x">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">查看微博</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            	@if(session('info'))
                <div class="alert alert-danger">
                {{ session('info') }}
                </div>
                @endif

            <div class="row">
	            <div class="col-md-2">
	                <div class="form-group"> 
	                  <select name="num" class="form-control">
	                    <option value="10"
						@if(!empty($request['num']) && $request['num'] == '10')
							selected="selected"
						@endif 
	                    >10</option>
	                    <option value="25"
						@if(!empty($request['num']) && $request['num'] == '25')
							selected="selected"
						@endif
	                    >25</option>
	                    <option value="50"
						@if(!empty($request['num']) && $request['num'] == '50')
							selected="selected"
						@endif
	                    >50</option>
	                    <option value="100"
						@if(!empty($request['num']) && $request['num'] == '100')
							selected="selected"
						@endif
	                    >100</option>
	                  </select>
	                </div>
	            </div>
	            <div class="col-md-4 col-md-offset-6">

                	<div class="input-group input-group">
	                <input value="{{ $request['keywords'] or ''}}" type="text" name="keywords" class="form-control">
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-info btn-flat">查询</button>
                    </span>
	              	</div>
              	</div>
              </div>
            </form>
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>作者</th>
                  <th>所属分类</th>
                  <th>标题</th>
                  <th>内容</th>
                  <th>图片</th>
                  <th>点赞数量</th>
                  <th>状态</th>
                  <th>发布时间</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>

               
                <tr class="parent">
                  <td class="ids">1</td>
                  <td class="name">1</td>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                  <td>1</td>
                  <td><img style="width:50px;height:50px;" src="/uploads/img/default.jpg" ></td>
                  <td><a href="#">编辑</a>|<a class="del" href="#" data-toggle="modal" data-target="#myModal">删除</a></td>
                
                </tr>
               
             
                </tbody>
                
              </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

@endsection

