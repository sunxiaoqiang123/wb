@extends('admin.layout')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        分类管理
        <small>添加</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#">分类管理</a></li>
        <li class="active">添加分类</li>
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
            <form role="form" enctype="multipart/form-data" method="post" action="{{ url('/admin/category') }} ">
              {{ csrf_field() }}
              <div class="box-body">
                  @if(session('info'))
                  <div class="alert alert-danger">
                      {{ session('info') }}
                  </div>
                  @endif
                <div class="form-group">
                  <label for="exampleInputName">分类名</label>
                  <input type="text" value="{{ old('name')}}" name="name" class="form-control" id="exampleInputName" placeholder="请输入分类名">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">logo</label>
                  <input type="file" name="img" id="exampleInputFile">
                  <p class="help-block">请选择合适的logo</p>
                </div>
                <div class="form-group">
                	<label for="exampleInputName">父分类</label>
                	<select name="pid" class="form-control">
                		<option value="0">根分类</option>
                		@foreach($data as $key => $val)
							<option value="{{ $val->id }}">{{ $val->name }}</option>
                		@endforeach
                	</select>
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