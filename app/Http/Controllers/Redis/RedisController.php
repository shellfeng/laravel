<?php

namespace App\Http\Controllers\Redis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function index ()
    {
        //通过反射机制查看 Redis类的方法
        $reflection = new \ReflectionClass('Redis');
        $fanc = $reflection->getMethods();
        //创建Redis对象
        $redis = new Redis();
        //建立Redis连接
        $redis->connect('127.0.0.1', 6379);
        //操作Redis
        $redis->set('name','张三');
        echo $redis->get('name');
        //关闭Redis连接
        $redis->close();

        //imagettftext();
    }

    public function index1 ()
    {
        Redis::set('name', 'dsdfsdTayloraaaaaaaaa');
        dump(Redis::get('name'));

        $lrange = Redis::lrange('names', 5, 10);
        dd('lrange==='.$lrange);
        $command = Redis::command('lrange', ['name', 5, 10]);
        dump('command=='.$command);
    }
}


