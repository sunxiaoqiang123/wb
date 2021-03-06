@extends('admin.layout')

@section('content')

 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        类别管理
        <small>编辑</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="#">类别管理</a></li>
        <li class="active">编辑类别</li>
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
              <h3 class="box-title">快速编辑</h3>
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
            <form role="form" enctype="multipart/form-data" method="post" action="{{ url('/admin/category') }}/{{ $data->id }} ">
              {{ method_field("PUT") }}
              {{ csrf_field() }}
              <input type="hidden" name="id" value="{{ $data->id }}">
              <div class="box-body">
                  @if(session('info'))
                  <div class="alert alert-danger">
                      {{ session('info') }}
                  </div>
                  @endif
                <div class="form-group">
                  <label for="exampleInputName">类名</label>
                  <input type="text" value="{{ $data->name }}" name="name" class="form-control" id="exampleInputName" placeholder="请输入类别名">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">logo</label>
                  <input type="file" name="blogo" id="exampleInputFile">
                  <p class="help-block">请选择合适的logo</p>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">父类名</label>
                  <input type="text" value="{{ empty($aa->name)?'微博内容':$aa->name }}" name="name1" class="form-control" id="exampleInputEmail1" readonly="readonly">
                </div>

      
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">编辑</button>
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

  