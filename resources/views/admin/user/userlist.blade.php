@extends('admin.public.admin')

@section('main')
<!-- 内容 -->
<div class="col-md-10">
	
	<ol class="breadcrumb">
		<li><a href="#"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
		<li><a href="#">用户管理</a></li>
		<li class="active">用户列表</li>

		<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
	</ol>

	<!-- 面版 -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<button class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> 批量删除</button>
			<a href="javascript:;" data-toggle="modal" data-target="#add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> 添加用户</a>
			
			<p class="pull-right tots" >共有 10 条数据</p>
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
			<th>NAME</th>
			<th>PASS</th>
			<th>上次登录时间</th>
			<th>状态</th>
			<th>操作</th>
			@foreach($data as $v)
			<tr>
				<td><input type="checkbox" name="" id="" value="{{ $v->id }}"></td>
				<td>{{ $v->id }}</td>
				<td>{{ $v->name }}</td>
				<td>{{ $v->pass }}</td>
				<td>{{ $v->login_time }}</td>
				<td>
					<span class="btn btn-success">开启</span>
				</td>
				<td><a href="/user/admin/edit" class="glyphicon glyphicon-pencil"></a>&nbsp;&nbsp;&nbsp;<a href="" class="glyphicon glyphicon-trash"></a></td>
			</tr>
			@endforeach
		</table>
		<!-- 分页效果 -->
		<div class="panel-footer">
			{{ $data->links() }}
		</div>
	</div>
</div>

<div class="modal fade" id="add">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">添加用户</h4>
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
						<label for="">email</label>
						<input type="text" name="email" class="form-control" placeholder="请输入用户名" id="">
						<div id="emailInfo"></div>
					</div>

					<div class="form-group">
						<label for="">电话</label>
						<input type="text" name="tel" class="form-control" placeholder="请输入用户名" id="">
						<div id="telInfo"></div>
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
						<label for="">地址</label>
						<input type="text" name="aid" class="form-control" placeholder="请输入用户名" id="">
						<div id="aidInfo"></div>
					</div>

					<div class="form-group">
						<label for="">状态</label>
						<br>
						<input type="radio" name="status" checked value="0" id="">正常
						<input type="radio" name="status" value="1" id="">禁用
					</div>
					{{ csrf_field() }}
					<div class="form-group pull-right">
						<input type="submit" value="提交" class="btn btn-success">
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
	    'create' : "{{ url('/admin/user/store') }}",
	};
	$("input[type='submit']").click(function () {
        $.post(url.create, $("form").serialize(), function (re) {
            if (re['code'] == 1) {
                layer.msg(re['msg'],{icon:6, time:1000}, function () {
                    $(".close").click();
                    $("#reset").click();
                    $("#userInfo").html('');
                    $("#passInfo").html('');
                    location.reload();
                });
            }else if (re['code'] == 2){
                var str = '';
                if (re['msg'].name) {
                    str = "<div class='alert alert-danger'>"+ re['msg'].name +"</div>";
                } else {
                    str = "<div class='alert alert-success'>OK</div>"
                }
                $("#userInfo").html(str);

                if (re['msg'].pass) {
                    str = "<div class='alert alert-danger'>"+ re['msg'].pass +"</div>";
                } else {
                    str = "<div class='alert alert-success'>OK</div>"
                }
                $("#passInfo").html(str);

                if (re['msg'].tel) {
                    str = "<div class='alert alert-danger'>"+ re['msg'].tel +"</div>";
                } else {
                    str = "<div class='alert alert-success'>OK</div>"
                }
                $("#telInfo").html(str);

                if (re['msg'].email) {
                    str = "<div class='alert alert-danger'>"+ re['msg'].email +"</div>";
                } else {
                    str = "<div class='alert alert-success'>OK</div>"
                }
                $("#emailInfo").html(str);

                if (re['msg'].aid) {
                    str = "<div class='alert alert-danger'>"+ re['msg'].aid +"</div>";
                } else {
                    str = "<div class='alert alert-success'>OK</div>"
                }
                $("#aidInfo").html(str);

            } else {
                layer.msg(re['msg'],{icon:5, time:1000});
            }
        })
    });

</script>
@endsection
