<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/10/8
 * Time: 11:28
 */
class ServerController
{
    private $server;
    function __construct($ip = '0.0.0.0', $port = '9501')
    {
        $this->server = new swoole_server($ip, $port, SWOOLE_BASE, SWOOLE_SOCK_TCP);
		    $this->serverOn();
        $this->serverSet();
    }

    /**
    * 注册事件回调函数  
    */
   public function serverOn()
   {
   		$this->server->on('Connect', 'my_onConnect');
		$this->server->on('Receive', 'my_onReceive');
		$this->server->on('Close', 'my_onClose');
   }

   /**
    * 设置运行时参数
    */

   public function serverSet(array $set = array())
   {
   		if(empty($set)){
			$this->server->set(array(
				'worker_num' => 4,
				'daemonize'  => true,
				'backlog' 	 => 128,
			));
   		}else{
   			$this->server->set($set);
   		}
   }

   /**
    * 启动服务器
    */
   public function serverStart()
   {
   		$this->server->start();
   }

}
$server = new ServerController();
