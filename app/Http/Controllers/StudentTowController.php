<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StudentTowController extends Controller
{
    public function request1 (Request $request)
    {
        //1. 取值
        //echo $request->input('name');
        //echo $request->input('sex','未知');
        /*if ($request->has('name')){
            echo $request->input('name');
        }else{
            echo '无参数name';
        }*/

        //$res = $request->all();
        //dd($res);

        //2. 判断请求类型
        //echo $request->method();

        /*if ($request->isMethod('GET')){
            echo 'yes';
        }else{
            echo 'no';
        }*/

        /*if ($request->ajax()) {
            echo 'yes';
        }else{
            echo 'no';
        }*/

        // 判断请求的是否是 路由 -> request1
        //$res = $request->is('request1');
        //$res = $request->is('student/*');
        //var_dump($res);
        //$url = $request->url();
        //dd($url);
    }

    public function session1 (Request $request)
    {
        //1、HTTP request session();
        //$request->session()->put('key1','value1');
        //echo $request->session()->get('key1');

        // 2、session() 辅助函数
        //session()->put('key2','value2');
        //echo session()->get('key2');

        //3、Session类
        //Session::put('key3','value3');
        //echo Session::get('key3','参数不存在');
        //    数组形式存储数据
        /*Session::put([
            'name'=>'小米',
            'sex'=>'男',
            'age'=>18,
        ]);*/

        //把session放到Session的数组中  TODO 错误
        //Session::push('student', 'seam');
        //Session::push('student', 'imooc');
        //$re = Session::get('student','参数不存在');

        //4、 取数据，取玩就删除
        //$re = Session::pull($request->input('type'),'参数不存在');

        //5、判断某个 K 是否存在
        //Session::has('key1');

        //6、获取session 所有值
        // Session::all();
        //7、删除session
            //删除指定 K值
        //Session::forget('key1');
            //删除所有K
        //Session::flush();

        //8、暂存数据，只能被取出一次
        Session::flash('key-flash','val-flash');
    }

    public function session2 (Request $request)
    {
        /*dump ($request->input('type'));
        dump(Session::all());
        if (Session::has($request->input('type'))) {
            dd('参数'.$request->input('type').'存在session中');
        }else {
            dd('参数' . $request->input('type') . '不存在session中');
        }*/
        dump(Session::get('key-flash','key-flash不存在'));
    }

    /*************************响应**********************/
    public function getResponse (Request $request)
    {
        dump($request->input());
        return Session::get('message', '暂无信息');
    }

    public function response ()
    {
        //1、响应 json
        /*$data = [
            'code' => 1,
            'msg' => 'success',
            'data' => 'seam'
        ];
        var_dump($data);
        return  response()->json($data);*/

        // 2、 重定向 要有return
        //return  redirect('studenttow/getResponse');

        /*return  redirect('studenttow/getResponse')->with('message', '我是快闪数据');*/

        /*return redirect()->action('StudentTowController@getResponse')
            ->with('message','我是快闪数据');*/

        //route()
        /*return redirect()->route('getResponse')
            ->with('message','我是快闪数据');*/

        return redirect()->back();
    }

    /*********************中间件***********************/
    // 活动宣传页
    public function activity0 ()
    {
        return '活动快要开始拉，敬请期待';
    }
    // 活动宣传页
    public function activity1 ()
    {
        return '活动进行中，谢谢你的参与1';
    }
    // 活动宣传页
    public function activity2 ()
    {
        return '活动进行中，谢谢你的参与2';
    }
}
