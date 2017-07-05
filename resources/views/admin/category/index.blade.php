@extends('admin.layout')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     	  @if(session('info'))
          <div class="alert alert-danger">
              {{ session('info') }}
          </div>
          @endif
      <h1>

        分类管理
        <small>列表</small>
      </h1>

      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">分类管理</a></li>
        <li class="active">列表</li>
      </ol>
    </section>

    <!-- Main content -->
    
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>ID</th>
                  <th>分类名</th>
                  <th>logo</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>

                @foreach($data as $key=>$val)
                <tr class="parent">
	              <td class="ids">{{ $val->id }}</td>
	              <td class="name">{{ $val->name }}</td>
                <td> <img style="width:50px;height:50px;" src="/uploads/blogo/{{ $val->blogo }}" ></td>
                <td class="name">{{ $val->status ==1?'正常':'关闭' }}</td> 
	              <td><a href="{{ url('/admin/category') }}/{{ $val->id }}/edit">编辑</a>
	              <a class="del" href="#">删除</a>
	              </td>
					<form style="display:none;" action="{{ url('/admin/category') }}/{{ $val->id }}" method="post">
						{{ method_field('DELETE') }}
						{{ csrf_field() }}
	              	</form>
					
			      </tr>
                @endforeach
             
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

@section('js')
	<script type="text/javascript">
		$('.del').on('click',function(){

			$(this).parent().next().submit();		
		});					

	</script>

@endsection