<?php

namespace App\Http\Controllers\Redis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    public function index()
    {
        Redis::set('name', 'dsdfsdTayloraaaaaaaaa');
        dump(Redis::get('name'));

        //Redis::del('name');
        //dump(Redis::get('name'));

        /*$lrange = Redis::lrange('name', 1, 4);
        dump($lrange);*/

        //2.1 管道命令
        /*Redis::pipeline(function ($pipe) {
            for ($i = 0; $i < 1000; $i++) {
                $pipe->set("key:$i", $i);
            }
        });
        dump(Redis::get('key:2'));*/
    }

    public function index1()
    {  
        dump(Redis::get('key:22'));
        //$blpop = Redis::blpop('name',100);
        //dump($blpop);

    }

    /*************************************start*********************************************/

    public function subscribe1 ()
    {
        set_time_limit(0);
        Redis::subscribe(['test-channel'], function($message,  $channel) {
            file_put_contents('test','获取'. $channel .'频道消息'.$message."\r\n",FILE_APPEND);
            echo $message;
        });
    }

    public function subscribe2 ()
    {
        set_time_limit(0);
        Redis::subscribe(['test-*'], function($message,  $channel) {
            file_put_contents('test','获取'. $channel .'(test-开头)频道消息'.$message."\r\n",FILE_APPEND);
            echo $message;
        });
    }

    public function subscribe3 ()
    {
        set_time_limit(0);
        Redis::subscribe(['*'], function($message,  $channel) {
            file_put_contents('test','获取'. $channel .'(所有)频道消息'.$message."\r\n",FILE_APPEND);
            echo $message;
        });
    }

    /**
     * 发布与订阅
     */
    public function publish ()
    {
        file_put_contents('test2','123456');
        // 路由逻辑...
        Redis::publish('test-channel', json_encode(['action2' => 'barsd']));
    }
    /*************************************end*********************************************/

    public function queue ()
    {
        $this->dispatch(new job);
    }
}
