@extends('admin.public.admin')

@section('main')

<!-- 引入CSS -->
<link rel="stylesheet" type="text/css" href="/webuploader/webuploader.css">
<!-- 引入JQ -->
<script type="text/javascript" src="/webuploader/webuploader.min.js"></script>
<!-- 内容 -->
<div class="col-md-10">
	
	<ol class="breadcrumb">
		<li><a href="#"><span class="glyphicon glyphicon-home"></span> 首页</a></li>
		<li><a href="#">系统管理</a></li>
		<li class="active">轮播图列表</li>

		<button class="btn btn-primary btn-xs pull-right"><span class="glyphicon glyphicon-refresh"></span></button>
	</ol>

	<!-- 面版 -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<button class="btn btn-danger">轮播图展示</button>
			<a href="javascript:;" data-toggle="modal" data-target="#add" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> 添加轮播图</a>

			
			<p class="pull-right tots" >共有 12 条数据</p>
			<form action="" class="form-inline pull-right">
				<div class="form-group">
					<input type="text" name="search" class="form-control" placeholder="请输入你要搜索的内容" id="">
				</div>
				
				<input type="submit" value="搜索" class="btn btn-success">
			</form>


		</div>
		<table class="table-bordered table table-hover">
			<th>ID</th>
			<th>图片</th>
			<th>链接</th>
			<th>title</th>
			<th>排序</th>
			<th>操作</th>
			@foreach($data as $v)
			<tr>
				<td>{{$v->id}}</td>
				<td><img width="100px" src="{{$v->img}}" alt=""></td>
				<td>{{$v->href}}</td>
				<td>{{$v->title}}</td>
				<td>{{$v->order}}</td>
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
				<h4 class="modal-title">添加轮播图</h4>
			</div>
			<div class="modal-body">
				<form action="/admin/sys/store" method="post" enctype="multipart/form-data">
					{{csrf_field()}}
					<div class="form-group">
						<label for="">Title</label>
						<input type="text" name="title" class="form-control" placeholder="title" id="">
						
					</div>
					<div class="form-group">
						<label for="">跳转地址</label>
						<input type="text" name="href" class="form-control" placeholder="友情连接" id="">
					</div>
					<div class="form-group">
						<label for="">排序</label>
						<input type="number" name="order"  class="form-control" placeholder="数值越大越靠前" id="">
					</div>
					<div class="form-group">
						<label for="">图片</label>
						<input type="file" name="img" id="uploads">
					</div>
					<div class="form-group pull-right">
						<input type="submit" value="提交" class="btn btn-success">
						<input type="reset" value="重置" class="btn btn-danger">
					</div>

					<div style="clear:both"></div>
				</form>
			</div>
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--dom结构部分-->
<div id="uploader-demo">
	<!--用来存放item-->
	<div id="fileList" class="uploader-list"></div>
	<div id="filePicker">选择图片</div>
</div>
<script src="/style/admin/bs/js/jquery.form.js"></script>
<script>
// 当所有HTML代码都加载完毕
var url = {
    'insert' : "{{ url('/admin/sys/store') }}",
    'del'    : "{{ url('/admin/sys/del') }}",
    'upload' : "{{ url('/admin/sys/upload') }}"
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

var consts = {
    //上传文件路径
    'base_url' : '/webuploader',
    //缩略图 宽度
    'thumbnailWidth' : 100,
    //缩略图 宽度
    'thumbnailHeight' : 100,
};

/*uploader = WebUploader.create({
    auto: false,
    // swf文件路径
    swf: consts.base_url + '/Uploader.swf',

    // 文件接收服务端。
    server: url.upload,

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#myPicker',

    // formData: { "name": name, "desc": desc},

    prepareNextFile:true,
    chunked: true,  // 分片上传大文件
    chunkRetry: 10, // 如果某个分片由于网络问题出错，允许自动重传多少次？
    thread: 100,// 最大上传并发数
    method: 'POST',
    fileSizeLimit: 1024,

    // 只允许选择图片文件。
    accept: {
        title: 'HTML5组态文件',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'img/!*'
    }

});


//当文件被加入队列之前触发
uploader.on('beforeFileQueued', function (file) {
    //如果是单文件上传，把旧的文件地址传过去
    if (!p.multiple) {
        if (p.sendurl.indexOf("action=itemcode") > 0) {
            if ($("#txtItemCode").val() == '') {
                layer.msg('请先填写商品编码再上传图片！');
                //layer.alert('请先填写商品编码再上传图片！');
                return false;
            }
            data.formData= { "name": name, "desc": desc};
        }
    }
});


uploader.on('fileQueued', function (file) {
    $("#listFile").append('<div id="' + file.id + '" class="item">' +
        '<h4 class="info">' + file.name + '</h4>' +
        '<p class="state">等待上传...</p>' +
        '</div>');
});

uploader.on('uploadProgress', function (file, percentage) {
    var li = $('#' + file.id),
        percent = li.find('.progress .progress-bar');
    // 避免重复创建
    if (!percent.length) {
        percent = $('<div class="progress progress-striped active">' +
            '<div class="progress-bar" role="progressbar" style="width: 0%">' +
            '</div>' +
            '</div>').appendTo(li).find('.progress-bar');
    }
    li.find('p.state').text('上传中');
    percent.css('width', percentage * 100 + '%');
});

uploader.on('uploadSuccess', function (file) {
    $('#' + file.id).find('p.state').text('已上传');
});

uploader.on('uploadError', function (file) {
    $('#' + file.id).find('p.state').text('上传出错');
});

uploader.on('uploadComplete', function (file) {
    $('#' + file.id).find('.progress').fadeOut();
    //$("#editModal").fadeOut(2000, window.location.reload());
    //destory();
    //$("#editModal").destory();
});


//当某个文件的分块在发送前触发，主要用来询问是否要添加附带参数，大文件在开起分片上传的前提下此事件可能会触发多次。

uploader.on('uploadBeforeSend', function (obj, data, headers) {
    // data.DelFilePath = parentObj.siblings(".upload-path").val();
    //  data.ItemCode = $("#txtItemCode").val();
    data.formData= { "name": name, "desc": desc};
});

uploader.on('all', function (type) {
    if (type === 'startUpload') {
        state = 'uploading';
    } else if (type === 'stopUpload') {
        state = 'paused';
    } else if (type === 'uploadFinished') {
        state = 'done';
    }
    if (state === 'uploading') {
        $('#btnBeginUpload').text('暂停上传');
    } else {
        $('#btnBeginUpload').text('开始上传');
    }
});

/!*} else {
    geap.alertPostMsgDefault("请选择一个文件!", "info");
}
});*!/


// 点击上传事件

$('#btnSave').bind('click', function () {
    var  name = $("#txtName").val();
    var  id = $("#txtId").val();

    if (!name || name.length == 0) {
        alert("请填写名称");
        return false;
    }
    var obj = new Object();
    obj.name = name;
    obj.id = id;
    uploader.options.formData = obj;
    //  uploader.options.formData = { "name": name, "id": id, };
    if (state === 'uploading') {
        uploader.stop();
    } else {
        uploader.upload();
    }
});*/


 // 初始化Web Uploader
var uploader = WebUploader.create({
    // 选完文件后，是否自动上传。
    auto: true,
    // swf文件路径
    swf: consts.base_url + '/Uploader.swf',
    // 文件接收服务端。
    server: url.upload,

    formData: { '_token':'{{ csrf_token() }}'},

    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#filePicker',
    // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/*'
    }
});

// 当有文件添加进来的时候
uploader.on( 'fileQueued', function( file ) {
    var $li = $(
            '<div id="' + file.id + '" class="file-item thumbnail">' +
            '<img>' +
            '<div class="info">' + file.name + '</div>' +
            '</div>'
        ),
        $img = $li.find('img');


    // $list为容器jQuery实例
	$("#fileList").append( $li );

    // 创建缩略图
    // 如果为非图片文件，可以不用调用此方法。
    // thumbnailWidth x thumbnailHeight 为 100 x 100
    uploader.makeThumb( file, function( error, src ) {
        if ( error ) {
            $img.replaceWith('<span>不能预览</span>');
            return;
        }
        $img.attr( 'src', src );
    }, consts.thumbnailHeight, consts.thumbnailHeight);
});

// 文件上传过程中创建进度条实时显示。
uploader.on( 'uploadProgress', function( file, percentage ) {
    var $li = $( '#'+file.id ),
        $percent = $li.find('.progress span');

    // 避免重复创建
    if ( !$percent.length ) {
        $percent = $('<p class="progress"><span></span></p>')
            .appendTo( $li )
            .find('span');
    }

    $percent.css( 'width', percentage * 100 + '%' );
});

// 文件上传成功，给item添加成功class, 用样式标记上传成功。
uploader.on( 'uploadSuccess', function( file, response  ) {
    console.log(response);
    $( '#'+file.id ).addClass('upload-state-done');
});

// 文件上传失败，显示上传出错。
uploader.on( 'uploadError', function( file, response) {
    var $li = $( '#'+file.id ),
        $error = $li.find('div.error');

    // 避免重复创建
    if ( !$error.length ) {
        $error = $('<div class="error"></div>').appendTo( $li );
    }

    $error.text('上传失败');
});

// 完成上传完了，成功或者失败，先删除进度条。
uploader.on( 'uploadComplete', function( file, response) {
    $( '#'+file.id ).find('.progress').remove();
});

</script>
@endsection
