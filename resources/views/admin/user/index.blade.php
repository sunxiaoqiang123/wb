@extends('admin.layout')

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        用户管理
        <small>列表</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">用户管理</a></li>
        <li class="active">列表</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    <form action="{{ url('/admin/user/index') }}" method="x">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">查看用户</h3>
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
                  <th>用户名</th>
                  <th>邮箱</th>
                  <th>头像</th>
                  <th>操作</th>
                </tr>
                </thead>
                <tbody>

                @foreach($data as $key=>$val)
                <tr class="parent">
                  <td class="ids">{{ $val->id }}</td>
                  <td class="name">{{ $val->name }}
                  </td>
                  <td>{{ $val->email }}</td>
                  <td><img style="width:50px;height:50px;" src="/uploads/img/{{ $val->img }}" ></td>
                  <td><a href="{{ url('/admin/user/edit') }}/{{ $val->id }}">编辑</a>|<a class="del" href="#" data-toggle="modal" data-target="#myModal">删除</a></td>
                
                </tr>
                @endforeach
             
                </tbody>
                
              </table>
              {{ $data->appends($request)->links() }}
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

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	
	$('.name').one('dblclick',aaa);

	function aaa(){

		var td = $(this);

		// alert('111');
		//获取ID
		var id = $(this).parent('.parent').find('.ids').html();
		// alert(id);
		//获取原来的值
		var oldName = $(this).html();

		var inp = $("<input type='text'>");
		inp.val(oldName);
		$(this).html(inp);

		//直接选中
		inp.select();

		inp.on('blur',function(){
			//获取新的用户名
			var newName = inp.val();

			//执行ajax
			$.ajax('/admin/user/ajaxrename',{
				type:'POST', 
				data:{id:id,name:newName},
				success:function(data){
					// console.log(data);
					if(data == '0')
					{
						alert('用户名已存在');
					}
					else if(data == '1')
					{
						td.html(newName);
					}else
					{
						alert('修改失败');
					}
					
				},
				error:function(data){
					alert('数据异常');
				},
				dataType:'json'

				

			});

			td.one('dblclick',aaa);

		});
		
	}
	 var id = 0;

	 $('.del').on('click',function(){
		id = $(this).parents('.parent').find('.ids').html();
		// alert(id);
	 });

</script>

@endsection