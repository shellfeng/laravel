<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Title</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="/style/admin/bs/css/bootstrap.min.css">
    <script src="/style/admin/bs/js/jquery.min.js"></script>
    <script src="/style/admin/bs/js/bootstrap.min.js"></script>
    <script src="/style/layer/layer.js"></script>
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<div class="people_num" style="border-color:red;height: 40px;width: 200px;border-style:solid;"></div>
<div class="content" style="height: 400px;width: 600px;border-color:#2E2D3C;border-style:solid;">
</div>
<div style="top: 20px">
    <textarea class="message" style="border-color: #00b7ee;height: 50px;width: 600px;"></textarea>
</div>
<input type="button" value="提交">
</body>
<script type="application/javascript">
    var wsServer = 'ws://192.168.110.128:9502';
    var ws = new WebSocket(wsServer);
    var fd = 0;
    /**
     *  CONNECTING：值为0，表示正在连接。
        OPEN：值为1，表示连接成功，可以通信了。
        CLOSING：值为2，表示连接正在关闭。
        CLOSED：值为3，表示连接已经关闭，或者打开连接失败。
     */
    switch (ws) {
        case WebSocket.CONNECTING:
            // do something
            break;
        case WebSocket.OPEN:
            // do something
            break;
        case WebSocket.CLOSING:
            // do something
            break;
        case WebSocket.CLOSED:
            // do something
            break;
        default:
            // this never happens
            break;
    }
/*****************1************/
    //实例对象的onopen属性，用于指定连接成功后的回调函数。
    $("input[type='button']").click(function () {
        var ms = $('.message').val();
        $('.message').val('');
            ws.send(ms);
    });
    /*ws.onopen = function () {
        ws.send('可能否');
    };*/

    ws.onmessage = function(event) {
        var css = '';
        var data = JSON.parse(event.data);

        if (data.type == 'self_fd'){
            fd = data.self_fd;
        }
        if (data.type == 'first_login'){
            $(".people_num").html('当前在线人数：' + data.people_num)
        }
        if(fd == data.self_fd) {
            css = "float:right";
        }else if (data.type == 'exit'){
            css = "float:left;color: red";
        }else {
            css = "float:left";
        }

        if (data.type != 'self_fd' && data.type != 'first_login'){
            $(".content").append('<div style="float:left;height: 20px;width: 100%"><span style="'+ css +'">'+ data.data +'</span></div>')
        }


            // 处理数据
    };

    //如果要指定多个回调函数，可以使用addEventListener方法。
    /*ws.addEventListener('open', function (event) {
        ws.send('Hello Server!');
    });*/
// /*****************2************/
//     //实例对象的onclose属性，用于指定连接关闭后的回调函数。
//     ws.onclose = function(event) {
//         var code = event.code;
//         var reason = event.reason;
//         var wasClean = event.wasClean;
//         // handle close event
//     };
//
//     ws.addEventListener("close", function(event) {
//         var code = event.code;
//         var reason = event.reason;
//         var wasClean = event.wasClean;
//         // handle close event
//     });
//
// /*****************3************/
//     //实例对象的onmessage属性，用于指定收到服务器数据后的回调函数。
//     ws.onmessage = function(event) {
//         var data = event.data;
//         // 处理数据
//     };
//
//     ws.addEventListener("message", function(event) {
//         var data = event.data;
//         // 处理数据
//     });
//     //注意，服务器数据可能是文本，也可能是二进制数据（blob对象或Arraybuffer对象）。
//     ws.onmessage = function(event){
//         if(typeof event.data === String) {
//             console.log("Received data string");
//         }
//
//         if(event.data instanceof ArrayBuffer){
//             var buffer = event.data;
//             console.log("Received arraybuffer");
//         }
//     };
//     //除了动态判断收到的数据类型，也可以使用binaryType属性，显式指定收到的二进制数据类型。
//     // 收到的是 blob 数据
//     ws.binaryType = "blob";
//     ws.onmessage = function(e) {
//         console.log(e.data.size);
//     };
//
//     // 收到的是 ArrayBuffer 数据
//     ws.binaryType = "arraybuffer";
//     ws.onmessage = function(e) {
//         console.log(e.data.byteLength);
//     };
// /*****************4************/
//     //实例对象的send()方法用于向服务器发送数据。
//     ws.send('your message');
//     //发送 Blob 对象的例子。
//     var file = document
//         .querySelector('input[type="file"]')
//         .files[0];
//     ws.send(file);
//     //发送 ArrayBuffer 对象的例子。
//     // Sending canvas ImageData as ArrayBuffer
//     var img = canvas_context.getImageData(0, 0, 400, 320);
//     var binary = new Uint8Array(img.data.length);
//     for (var i = 0; i < img.data.length; i++) {
//         binary[i] = img.data[i];
//     }
//     ws.send(binary.buffer);
//
// /*****************5************/
//     //实例对象的bufferedAmount属性，表示还有多少字节的二进制数据没有发送出去。它可以用来判断发送是否结束。
//     var data = new ArrayBuffer(10000000);
//     ws.send(data);
//
//     if (ws.bufferedAmount === 0) {
//         // 发送完毕
//     } else {
//         // 发送还没结束
//     }
</script>
</html>