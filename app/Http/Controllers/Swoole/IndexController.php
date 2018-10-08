<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/9/21
 * Time: 11:16
 */

namespace App\Http\Controllers\Swoole;


use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    private $server;
    private $user      = [];
    private $blacklist = [];
    /*function __construct($ip = 0, $port = 0)
    {
        if ($ip !== 0 && $port !== 0){
            $this->server = new swoole_server('127.0.0.1',9501);
        }
    }*/

    public function index()
    {
    
        return view('swoole.index',[

        ]);
    }

    public function websocket()
    {
        return view('swoole.websocket',[

        ]);
    }

    public function server()
    {
        return view('swoole.server',[

        ]);
    }
}