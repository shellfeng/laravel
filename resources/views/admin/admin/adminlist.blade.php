@extends('admin.public.admin')

@section('main')
<!-- 内容 -->
<div class="col-md-10">
	
	<ol class="breadcrumb">
		<li><a href="/admin/index/index"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
		<li><a href="/admin/admin/adminlist">管理员管理</a></li>
		<li class="active">管理员列表</li>

		<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
	</ol>

	<!-- 面版 -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> 批量删除</button>
			<!-- <a href="/admin/admin/create" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> 添加管理员</a> -->
			<a href="javascript:;" data-toggle="modal" data-target="#add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> 添加管理员</a>
			
			<p class="pull-right tots" >共有 <span class="js-total">{{$total}}</span> 条数据</p>
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
			<th>用户名</th>
			<th>加入时间</th>
			<th>上次登录时间</th>
			<th>状态</th>
			<th>操作</th>
			@foreach($data as $v)
			<tr>
				<td><input type="checkbox" name="" id=""></td>
				<td>{{$v->id}}</td>
				<td>{{$v->name}}</td>
				<td>{{$v->login_time}}</td>
				<td>{{$v->create_time}}</td>
				<td>
					@if ($v->status == 1)
						<span class="btn btn-danger" onclick="upstatus(this, {{$v->id}}, {{$v->status}})">禁用</span>
					@elseif ($v->status == 0)
						<span class="btn btn-success" onclick="upstatus(this, {{$v->id}}, {{$v->status}})">正常</span>
					@endif

				</td>
				<td>
					<a href="/admin/admin/edit/{{$v->id}}" class="glyphicon glyphicon-pencil"></a>&nbsp;&nbsp;&nbsp;
					<a href="javascript:" class="glyphicon glyphicon-trash" onclick="del(this, {{$v->id}})"></a>
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
<!-- 添加页面模态框 -->
<div class="modal fade" id="add">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">添加管理员</h4>
			</div>
			<div class="modal-body">
				<form action="" onsubmit="return false;" id="formAdd">
				{{--<form action="{{  url('admin/admin/store') }}" id="formAdd" method="post">--}}
					<div class="form-group">
						<label for="">用户名</label>
						<input type="text" name="name" class="form-control" placeholder="请输入用户名" id="">
						<div id="userInfo"></div>
					</div>
					<div class="form-group">
						<label for="">密码</label>
						<input type="password" name="pass" class="form-control" placeholder="请输入新密码" id="">
						<div id="passInfo"></div>
					</div>
					<div class="form-group">
						<label for="">确认密码</label>
						<input type="password" name="repass" class="form-control" placeholder="请再次输入密码" id="">
						<div id="repassInfo"></div>
					</div>
					<div class="form-group">
						<label for="">状态</label>
						<br>
						<input type="radio" name="status" checked value="0" id="">正常
						<input type="radio" name="status" value="1" id="">禁用
					</div>
					{{ csrf_field() }}
					<div class="form-group pull-right">
						<input type="submit" value="提交" onclick="add()" class="btn btn-success">
						<input type="reset" id="reset" value="重置" class="btn btn-danger">
					</div>

					<div style="clear:both"></div>
				</form>
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	var url = {
	    'insert' :  "{{ url('admin/admin/store') }}",
		'del' : "{{ url('admin/admin/destroy') }}",
		'upstatus' : "{{ url('admin/admin/upstatus') }}"
	};
	// 添加的处理操作
	function add(){
		// 提交到下一个页面
		$.post(url.insert,$("#formAdd").serialize(),function(data){
			if (data['code'] == 1) {
                layer.msg(data['msg'],{icon:6, time:1000}, function () {
                    $(".close").click();
                    $("#reset").click();
                    $("#userInfo").html('');
                    $("#passInfo").html('');
                    location.reload();
                });
			}else if (data['code'] == 2){
			    var str = '';
			    if (data['msg'].name) {
                    str = "<div class='alert alert-danger'>"+ data['msg'].name +"</div>";
                } else {
                    str = "<div class='alert alert-success'>OK</div>"
                }
                $("#userInfo").html(str);

                if (data['msg'].pass) {
                    str = "<div class='alert alert-danger'>"+ data['msg'].pass +"</div>";
                } else {
                    str = "<div class='alert alert-success'>OK</div>"
                }
                $("#passInfo").html(str);

			} else {
                layer.msg(data['msg'],{icon:5, time:1000});
			}
		});
	}
	
	function del(obj, id) {
		$.post(url.del + '/' + id,{'_token':'{{ csrf_token() }}','_method':'delete'}, function (re) {
			if (re['code']) {
                layer.msg(re['msg'],{icon:6, time:1000}, function () {
                    var total = $(".js-total").html();
                    $(".js-total").html(--total);
					$(obj).parents('tr').remove();
                });
			} else {
                layer.msg(re['msg'],{icon:5, time:1000});
			}
        })
    }

    function upstatus(obj, id, status) {
		var statu = status == 1 ? 0 : 1;
		 var htmls   = status == 1 ? '禁用' : '正常';
		  $.post(url.upstatus,{id:id, status:statu, '_token':'{{ csrf_token() }}'}, function (re) {
			if (re['code']) {
                layer.msg(re['msg'],{icon:6, time:1000}, function () {
					location.reload();
                });
			} else {
                layer.msg(re['msg'],{icon:5, time:1000});
			}
        })
    }
</script>
@endsection
