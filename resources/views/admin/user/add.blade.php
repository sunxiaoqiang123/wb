@extends('admin.layout')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        用户管理
        <small>添加</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#">用户管理</a></li>
        <li class="active">添加用户</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">快速添加</h3>
            </div>

            @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" enctype="multipart/form-data" method="post" action="{{ url('/admin/user/insert') }} ">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputName">用户名</label>
                  <input type="text" value="{{ old('name')}}" name="name" class="form-control" id="exampleInputName" placeholder="请输入用户名">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">邮箱</label>
                  <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="请输入邮箱">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">密码</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="请输入密码">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword2">确认密码</label>
                  <input type="password" name="repass" class="form-control" id="exampleInputPassword2" placeholder="请确认密码">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">头像</label>
                  <input type="file" name="img" id="exampleInputFile">

                  <p class="help-block">请选择合适的头像</p>
                </div>
      
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">添加</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

          <!-- Form Element sizes -->

          <!-- /.box -->

        
          <!-- /.box -->

          <!-- Input addon -->
         
          <!-- /.box -->

        </div>
        <!--/.col (left) -->
        <!-- right column -->
      
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

@endsection