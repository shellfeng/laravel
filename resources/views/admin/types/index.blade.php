@extends('admin.public.admin')

@section('main')
	<!-- 内容 -->
	<div class="col-md-10">

		<ol class="breadcrumb">
			<li><a href="/admin/index/index"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
			<li><a href="/admin/types/index">分类管理</a></li>
			<li class="active">分类列表</li>

			<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
		</ol>

		<!-- 面版 -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> 批量删除</button>
				<a href="/admin/types/create" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> 添加分类</a>

				<p class="pull-right tots" >共有 <span>{{ $total }}</span> 条数据</p>
				<form action="" class="form-inline pull-right">
					<div class="form-group">
						<input type="text" name="" class="form-control" placeholder="请输入你要搜索的内容" id="">
					</div>

					<input type="submit" value="搜索" class="btn btn-success">
				</form>


			</div>
			<table class="table-bordered table table-hover">
				<th><input type="checkbox" name="" id=""></th>
				<th>ID</th>
				<th>分类名</th>
				<th>title</th>
				<th>关键字</th>
				<th>描述</th>
				<th>楼层</th>
				<th>添加子类</th>
				<th>操作</th>
				@foreach($data as $v)
				<tr>
					<td><input type="checkbox" name="" id="" value="{{$v->id}}"></td>
					<td>{{$v->id}}</td>
                    <?php
                    $arr = explode(',',$v->path);
                    $tot = count($arr)-2;
                    ?>
					<td>{{str_repeat("|===",$tot)}}{{$v->name}}</td>
					<td>{{$v->title}}</td>
					<td>{{$v->keywords}}</td>
					<td>{{$v->description}}</td>
					@if($v->is_lou)
						<td><span class="btn btn-success">是</span></td>
					@else
						<td><span class="btn btn-danger">否</span></td>
					@endif

					@if($tot>=2)
						<td><a href="javascript:;" style="color: inherit">添加子类</a></td>
					@else
						<td><a href="/admin/types/create?pid={{$v->id}}&path={{$v->path}}{{$v->id}},">添加子类</a></td>

					@endif
					<td>
						<a href="/admin/types/edit/{{$v->id}}" class="glyphicon glyphicon-pencil"></a>&nbsp;&nbsp;&nbsp;
						<a href="javascript:;" onclick="del({{$v->id}})" class="glyphicon glyphicon-trash"></a>
					</td>
				</tr>
					@endforeach
			</table>
			<!-- 分页效果 -->
			<div class="panel-footer">
				{{--{{ $data->links() }}--}}
			</div>
		</div>
	</div>
<script>
	var url = {
	    'index' : "{{ url('admin/types/index') }}",
	    'del' : "{{ url('admin/types/destroy') }}"
	};
	// 删除数据
	function del(id){
		if (confirm("您确认要删除？")) {
			// 发送post请求
			$.post(url.del + '/' + id,{'_token':"{{csrf_token()}}",'_method':'delete'},function(re){
				if (re['code'] == 1) {
                    layer.msg(re['msg'],{icon:6, time:1000}, function () {
                        location.href = url.index;
                    });
				} else {
                    layer.msg(re['msg'],{icon:5, time:1000});
				}
			})
		};
	}
</script>
@endsection