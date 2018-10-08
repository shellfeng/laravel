@extends('admin.public.admin')

@section('main')
<!-- 内容 -->
<div class="col-md-10">
	
	<ol class="breadcrumb">
		<li><a href="/admin/index/index"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
		<li><a href="/admin/types/index">分类管理</a></li>
		<li class="active">分类添加</li>

		<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
	</ol>

	<!-- 面版 -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<a href="/admin/types/index" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> 分类页面</a>
			<a href="" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> 添加分类</a>
			
		</div>
		<div class="panel-body">
			<form>
				<div class="form-group">
					<label for="">分类名</label>
					<input type="text" name="name" class="form-control" id="" placeholder="请输入分类名">
					<div id="nameinfo"></div>
				</div>

				<div class="form-group">
					<label for="">TITLE</label>
					<input type="text" name="title" placeholder="请输入TITLE" class="form-control" id="">
					<div id="titleinfo"></div>
				</div>
				<div class="form-group">
					<label for="">关键字</label>
					<input type="text" name="keywords" class="form-control" id="">
					<div id="keywordsinfo"></div>
				</div>
				<div class="form-group">
					<label for="">描述</label>
					<input type="text" name="description" class="form-control" id="">
					<div id="descriptioninfo"></div>
				</div>
				<div class="form-group">
					<label for="">排序</label>
					<input type="text" name="sort" class="form-control" id="">
					<div id="sortinfo"></div>
				</div>

				<div class="form-group">
					<label for="">是否楼层</label>
					<br>
					<input type="radio" name="is_lou" checked value="1"  id="">是
					<input type="radio" name="is_lou" value="0" id="">否
				</div>
				<input type="hidden" name="pid" value="<?php echo isset($_GET['pid'])?$_GET['pid']:0;?>">
				<input type="hidden" name="path" value="<?php echo isset($_GET['path'])?$_GET['path']:'0,';?>">
				{{csrf_field()}}
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
	    'create' : "{{ url('admin/types/store') }}",
	    'index' : "{{ url('admin/types/index') }}"
	};
	$("input[type='button']").click(function () {
		$.post(url.create, $("form").serialize(), function (re) {
			if (re['code'] == 1) {
                layer.msg(re['msg'],{icon:6, time:1000}, function () {
                    location.href = url.index;
                });
			} else if (re['code'] == 2) {
                var str = '';
                if (re['msg'].name) {
                    str = "<div class='alert alert-danger'>"+ re['msg'].name +"</div>";
                } else {
                    str = "<div class='alert alert-success'>OK</div>"
                }
                $("#nameinfo").html(str);

                if (re['msg'].title) {
                    str = "<div class='alert alert-danger'>"+ re['msg'].title +"</div>";
                } else {
                    str = "<div class='alert alert-success'>OK</div>"
                }
                $("#titleinfo").html(str);

                if (re['msg'].keywords) {
                    str = "<div class='alert alert-danger'>"+ re['msg'].keywords +"</div>";
                } else {
                    str = "<div class='alert alert-success'>OK</div>"
                }
                $("#keywordsinfo").html(str);

                if (re['msg'].description) {
                    str = "<div class='alert alert-danger'>"+ re['msg'].description +"</div>";
                } else {
                    str = "<div class='alert alert-success'>OK</div>"
                }
                $("#descriptioninfo").html(str);

                if (re['msg'].sort) {
                    str = "<div class='alert alert-danger'>"+ re['msg'].sort +"</div>";
                } else {
                    str = "<div class='alert alert-success'>OK</div>"
                }
                $("#sortinfo").html(str);
			} else {
                layer.msg(re['msg'],{icon:5, time:1000});
			}
        })
    })
</script>
@endsection