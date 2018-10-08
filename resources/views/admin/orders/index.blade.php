@extends('admin.public.admin')

@section('main')
<!-- 内容 -->
<div class="col-md-10">
	
	<ol class="breadcrumb">
		<li><a href="#"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
		<li><a href="#">订单管理</a></li>
		<li class="active">订单列表</li>

		<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
	</ol>

	<!-- 面版 -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<button class="btn btn-danger">订单展示</button>
			
			<p class="pull-right tots" >共有  条数据</p>
			<form action="" class="form-inline pull-right">
				<div class="form-group">
					<input type="text" name="search" class="form-control" placeholder="请输入你要搜索的内容" id="">
				</div>
				
				<input type="submit" value="搜索" class="btn btn-success">
			</form>


		</div>
		<table class="table-bordered table table-hover">
			<th>订单号</th>
			<th>用户</th>
			<th>收货人信息</th>
			<th>状态</th>
			<th>下单时间</th>
			<th>操作</th>

			@foreach($data as $value)
			<tr>
				<td><a href="/admin/order/list?code={{$value->order_num}}">{{$value->order_num}}</a></td>
				<td>{{$value->name}}</td>
				<td>
					<a href="/admin/order/addr?id={{$value->addr_id}}">收货人信息</a>
				</td>
				<td>{{$value->name}}</td>
				<td>{{$value->time}}</td>


				<td>
					@if($value->orderstatu_id==6)
						<a href="javascript:;">修改状态</a>
					@else
						<a href="/admin/order/edit?id={{$value->orderstatu_id}}&code={{$value->order_num}}">修改状态</a>
					@endif
					
				</td>
			</tr>
			@endforeach


			
		</table>
		<!-- 分页效果 -->
		<div class="panel-footer">
			{{$data->links()}}
		</div>
	</div>
</div>
@endsection