@extends('admin.public.admin')

@section('main')
<!-- 内容 -->
<div class="col-md-10">
	
	<ol class="breadcrumb">
		<li><a href="#"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
		<li><a href="#">用户管理</a></li>
		<li class="active">管理员修改</li>

		<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
	</ol>

	<!-- 面版 -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<a href="{{ url('admin/admin/adminlist') }}" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> 管理员页面</a>
			<a href="" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> 修改管理员</a>
		</div>
		<div class="panel-body">
			<form action="">
				<div class="form-group">
					<label for="">用户名</label>
					<input type="text" name="name" class="form-control" id="" value="{{ $data->name }}">
					<div id="userInfo"></div>
				</div>

				<div class="form-group">
					<label for="">密码</label>
					<input type="password" name="pass" class="form-control" id="" value="{{ $data->pass }}">
					<div id="passInfo"></div>
				</div>
				<input type="hidden" name="id" value="{{ $data->id }}">

				<div class="form-group">
					<input type="button" value="提交" class="btn btn-success">
					<input type="reset" value="重置" class="btn btn-danger">
				</div>
			</form>
		</div>
		
	</div>
</div>
<script>
    var url = {
        'up' : "{{ url('admin/admin/update') }}",
		'index':"{{ url('admin/admin/adminlist') }}"
    };
    $("input[type='button']").click(function () {
		var name = $("input[name='name']").val();
		 var pass = $("input[name='pass']").val();
		 var id   = $("input[name='id']").val();
		 $.post(url.up, {
		 'name':name,
		 'pass':pass,
		 'id':id,
		 '_token':'{{ csrf_token() }}',
		 '_method':'put'
		 }, function (re) {
			if (re['code'] == 1) {
                layer.msg(re['msg'],{icon:6, time:1000}, function () {
                    location.href = url.index;
                });
			} else if(re['code'] == 2) {
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
			} else {
                layer.msg(re['msg'],{icon:5, time:1000}, function () {
					location.href = location.href = url.index;
                });
			}
		 })
    })
</script>
@endsection
