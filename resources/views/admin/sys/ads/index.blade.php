@extends('admin.public.admin')

@section('main')


<!-- 内容 -->
<div class="col-md-10">
	
	<ol class="breadcrumb">
		<li><a href="#"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
		<li><a href="#">系统管理</a></li>
		<li class="active">广告列表</li>

		<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
	</ol>

	<!-- 面版 -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<button class="btn btn-danger">广告展示</button>
			<a href="/admin/sys/create" class="btn btn-success">广告添加</a>
			
			<p class="pull-right tots" >共有 条数据</p>
			<form action="" class="form-inline pull-right">
				<div class="form-group">
					<input type="text" name="search" class="form-control" placeholder="请输入你要搜索的内容" id="">
				</div>
				
				<input type="submit" value="搜索" class="btn btn-success">
			</form>


		</div>
		<table class="table-bordered table table-hover">
			<th><input type="checkbox" name="" id="">	</th>
			<th>ID</th>
			<th>IMG</th>
			<th>TITLE</th>
			<th>HREF</th>
			<th>SORT</th>

			<th>操作</th>
			
			@foreach($data as $value)
				<tr>
					<td><input type="checkbox" name="" id=""></td>
					<td>{{$value->id}}</td>
					<td><img width="100px" src="{{$value->img}}" alt=""></td>
					<td>{{$value->title}}</td>
					<td>{{$value->href}}</td>
					<td>{{$value->sort}}</td>
					<td>
						<a >修改</a>
						<a onclick="del(this, {{$value->id}})">删除</a>
					</td>

				</tr>
			@endforeach


		</table>
		<!-- 分页效果 -->
		<div class="panel-footer">
			{{ $data->links() }}
		</div>
	</div>
</div>
<script>
	var url = {
	    'del' : "{{url('/admin/sys/deletes')}}"
	};
    function del(obj, id) {
        $.post(url.del + '/' + id, {'_token':'{{ csrf_token() }}','_method':'delete'}, function (re) {
            if (re['code'] == 1) {
                layer.msg(re['msg'],{icon:6, time:1000}, function () {
                    $(obj).parents('tr').remove();
                });
            } else {
                layer.msg(re['msg'],{icon:5, time:1000});
            }
        })
    }
</script>
@endsection
