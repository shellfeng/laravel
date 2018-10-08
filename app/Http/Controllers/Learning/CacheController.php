<?php

/**
 * 缓存
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/3/9
 * Time: 14:22
 */
namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheController extends Controller
{
    /**
     *put方式写入缓存
     */
    public function index ()
    {
        $data = DB::table('user')->get();
        Cache::put('data-put', $data,2);
    }

    /**
     *add 方法只会把暂时不存在于缓存中的缓存项放入缓存，如果存放成功将返回 true ，否则返回 false
     */
    public function add ()
    {
        $data = DB::table('user')->get();
        Cache::add('data-add', $data,2);
    }

    /**
     *forever 方法可以用来将缓存项永久存入缓存中，因为这些缓存项不会过期，所以必须通过 forget 方法手动删除
     */
    public function forever ()
    {
        $data = DB::table('user')->get();
        Cache::forever('data-put', $data);
    }

    /**
     * pull方式获取缓存  获取立即删除
     */
    public function pullCache ()
    {
        dd(Cache::pull('data-add'));
    }

    /**
     * get方式获取缓存 不删除
     */
    public function getCache ()
    {
        dump(Cache::get('data-add','没有数据'));
    }

    /**
     * forget 方法从缓存中移除一个项目
     */
    public function forget ()
    {
        dump(Cache::forget('data-add'));
    }

    /**
     * flush 方法清空所有缓存
     */
    public function flush ()
    {

        dump(Cache::flush());
    }

    /******************************缓存标签**************************************/
    public function setput ()
    {
        // .env  CACHE_DRIVER=array
        Cache::tags(['people', 'artists'])->put('name', '枫之蕴', 1);

    }

    public function getdt ()
    {
        // .env  CACHE_DRIVER=array
       $dt = Cache::tags(['people', 'artists'])->get('name');
       dump($dt);
    }
}
