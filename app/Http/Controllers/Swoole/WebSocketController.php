<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/9/26
 * Time: 13:56
 */
class WebSocket
{   
    private $db;
    private $user;
    private $server;
    function __construct($ip,$port)
    {
        //$this->db = require_once 'Db.php';
        $this->server = new swoole_websocket_server($ip, $port);
        $this->server->on('open', function(swoole_websocket_server $server, $request){
            echo "handshaks success with fd=={$request->fd}\n";
            $this->user($request->fd, 'add');
            $this->countOnline($request->fd);
        });

        /******************************************/
        $this->server->on('message', function(swoole_websocket_server $server, $frame){
                $this->broadcast($frame->data, $frame->fd, 'many_people');
        });
        /*$this->server->on('request', function ($request, $response) {
            // 接收http请求从get获取message参数的值，给用户推送
            // $this->server->connections 遍历所有websocket连接用户的fd，给所有用户推送
            foreach ($this->server->connections as $fd) {
                $this->server->push($fd, $request->get['message']);
            }
        });*/

        /**************************************/
        $this->server->on('close', function($ser, $fd){
            $closefd = $this->user[$fd];
            unset($this->user[$fd]);
            $this->broadcast('退出了聊天'.json_encode($closefd), $closefd, 'exit');
            $this->countOnline($fd);
        });
        $this->server->start();

    }



    private function user($fd, $action = null)
    {
        switch ($action) {
            case 'add':
                if(!isset($this->user[$fd])){
                    $this->user[$fd] = [
                        'fd' => $fd
                    ];
                };
                break;
            default:
                # code...
                break;
        }
    }



    /**
     * 发送消息给客户端
     */
    private function broadcast($data = '', $fd = '', $type = 'many_people')
    {
        foreach ($this->user as $key => $value) {
                $this->server->push($value['fd'], json_encode(['data' => $data,'self_fd' => $fd, 'type' => $type]));
        }
        /*if($type == 'first_people'){
            $this->server->push($fd, json_encode(['data' => $data,'fd' => $fd, 'type' => $type, 'people_num' => count($this->user)]));
        }else{
            foreach ($this->user as $key => $value) {
                $this->server->push($value['fd'], json_encode(['data' => $data,'fd' => $fd, 'type' => $type, 'people_num' => count($this->user)]));
            }
        }*/

    }

    private function countOnline($fd)
    {
        $x = count($this->user);
        $this->server->push($fd, json_encode(['self_fd' => $fd, 'type' => 'self_fd', 'people_num' => $x]));
        foreach ($this->user as $key => $value) {
                $this->server->push($value['fd'], json_encode(['self_fd' => $fd, 'type' => 'first_login', 'people_num' => count($this->user)]));
        }
    }

}
$websocker = new WebSocket("0.0.0.0", 9502);
