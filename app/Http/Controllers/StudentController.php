<?php
/**
 * Created by PhpStorm.
 * User: xf
 * Date: 2017/12/16
 * Time: 17:43
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function upload (Request $request)
    {
        if ($request->isMethod('POST')) {
            dump($_FILES);
            $file = $request->file('source');
            //文件是否上传成功
            if ($file->isValid()) {
                //原文件名
                $OriginalName = $file->getClientOriginalName();
                //扩展名
                $ext = $file->getClientOriginalExtension();
                //文件类型
                $type = $file->getClientMimeType();
                //临时绝对路径
                $realPath = $file->getRealPath();

                $filename = date('Y-m-d-H-i-s') . '_' . uniqid() . '.' .$ext;
                $bool = Storage::disk('uploads')->put($filename,file_get_contents($realPath));
                var_dump($bool);
            }
            dd($file);
            exit();
        }
        return view('student/upload');
    }

    public function mail ()
    {
         Mail::raw('邮件内容', function ($message) {
             $message->from('18190910980@163.com', 'xf-laravel发送邮箱');
             $message->subject('邮件的主题测试');
             $message->to('1130389807@qq.com');
             $message->attach('qweq');
         });
    }

    /**
     * 存缓存
     */
    public function cache1 ()
    {
        //put
        //Cache::put('key1','vale',10);

        //add ：key1不存在则设置
        $bool = Cache::add('key2','val2',10);

        //forever() : 永久保留
        Cache::forever('key3','val3');

        //has : 判断 K值是否存在
        if (Cache::has('key3')){
           var_dump(Cache::get('key3'));
        }else{
            var_dump('不存在！');
        }
    }


    /**
     *取缓存
     */
    public function cache2 ()
    {
        //get() 取出缓存 不删除
        //$val = Cache::get('key2');

        //pull() 取出缓存后删除
        //$val = Cache::pull('key3');

        //forget() 从缓存中删除对象 返回 bool
        //$bool = Cache::forget('key1');
        //var_dump($bool);
    }

    /**
     * Debug模式 开启  关闭
     */
    public function error ()
    {
        //$name = 'error';
        //var_dump($name);

        return view('student.error');
    }

    /**
     * 异常处理
     */
    public function http ()
    {
        $studentd = null;
        if ($studentd == null ) {
            abort('404');
        }
    }

    /**
     * 日志
     */
    public function logs ()
    {
        //Log::info('这是一个info级别的日志');
        //Log::warning('这是一个warning级别的日志');

        Log::error('这是一个数组',['name'=>'小米','age'=>18]);
    }

    /***********************************队列************************/
    public function queue ()
    {
        //写入 jobs 表中
        dispatch(new SendEmail('1130389807@qq.com'));
        //php artisan queue:listen   队列监听器
    }
    /**********************************/
    function action1()
    {
        // 1、
        /*$admins = Db::table('admin')
            ->get();
        $name = $admins->sum(function ($value) {
            return $value->id;
        });

        $admins = Db::table('admin')
            ->sum('id');
        dump($name);*/

        //2、
        $goodss = Db::table('goods')
            ->select(['goods.types_id','goods.title','goods.info','num'])
            ->addSelect(DB::raw("SUM(goods.num) as numall"))
            ->get();
        dump($goodss);
    }



    public function action2 ()
    {
        $items = [
            ['id' => 0,'name' => 'aa'],
            ['id' => 1,'name' => 'bb'],
            ['id' => 2,'name' => 'cc'],
            ['id' => 3,'name' => 'dd'],
        ];
        $foundCommodity = function ($id) use ($items) {
            foreach ($items as $item) {
                if ($item['id'] == $id) {
                    return $item;
                }
            }
            throw new \Exception('qweqwewq', 404);
        };
        dump($foundCommodity(2));
    }

    public function action3 ()
    {
        $items = [
            ['id' => 0,'name' => 'aa'],
            ['id' => 1,'name' => 'bb'],
            ['id' => 2,'name' => 'cc'],
            ['id' => 3,'name' => 'dd'],
        ];
        $aa = 'aa';
        $bb = 'bb';
        $dt = array_reduce($items,function ($id, $names) use ($aa, $bb) {
            return $names['id'] + $id;
        } );
        dump($dt);
    }

    function action4()
    {
        print_r(111);
        //dump(sprintf('%sshop_info as shop_info', ' '));
        $cars=array("Volvo","BMW","Toyota","Honda","Mercedes","Opel");
        dd(array_chunk($cars,2));
    }
}