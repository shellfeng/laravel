<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// 后台登录页
Route::get('admin/index', 'Admin\LoginController@index');
// 登录
Route::post('admin/login', 'Admin\LoginController@login');

Route::get('imgsys/{one?}/{two?}/{three?}/{four?}/{five?}/{six?}/{seven?}/{eight?}/{nine?}',function(){
    // \App\Util\ImageRoute::imageStorageRoute();
});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'adminLogin'], function () {
    // 后台首页
    Route::get('index/index', 'AdminController@adminList');
    //文件上传
    Route::post('common/upload', 'CommonController@upload');

    Route::group(['prefix' => 'admin'], function(){
        // 后台管理员管理
        Route::get('adminlist','AdminController@adminlist');
        // 插入操作
        Route::post('store','AdminController@store');
        // 修改页面
        Route::get('edit/{id}','AdminController@edit');
        // 修改
        Route::put('update','AdminController@update');
        // 修改状态
        Route::post('upstatus','AdminController@upstatus');
        // 删除操作
        Route::delete('destroy/{id}','AdminController@destroy');
    });

    Route::group(['prefix' => 'types'], function(){
        //商品分类
        Route::get('index','TypesController@index');
        //创建分类页
        Route::get('create','TypesController@create');
        //添加数据
        Route::post('store','TypesController@store');
        //修改数据页面
        Route::get('edit/{id}','TypesController@edit');
        //修改数据
        Route::put('update','TypesController@update');
        // 删除操作
        Route::delete('destroy/{id}','TypesController@destroy');
    });

    Route::group(['prefix' => 'user'], function(){
        //用户
        Route::get('userlist','UserController@userlist');
        //添加数据
        Route::post('store','UserController@store');
        //修改数据页面
        Route::get('edit/{id}','UserController@edit');
        //修改数据
        Route::put('update','UserController@update');
        // 删除操作
        Route::delete('destroy/{id}','UserController@destroy');
    });

    Route::group(['prefix' => 'sys'], function(){
        //系统管理
        Route::get('syslist', 'Sys\ConfigController@syslist');
        //修改
        Route::post('configstore', 'Sys\ConfigController@store');

        //轮播图管理
        Route::get('sliderlist', 'Sys\SliderController@sliderlist');
        //添加数据
        Route::post('store', 'Sys\SliderController@store');
        //删除轮播图
        Route::delete('del/{id}', 'Sys\SliderController@del');


        Route::post('upload', 'Sys\SliderController@upload');

        // 广告管理
        Route::get('adslist', 'Sys\AdsController@adslist');
        //添加页面
        Route::get('create', 'Sys\AdsController@create');
        //添加页面
        Route::post('insert', 'Sys\AdsController@inserts');
        //删除
        Route::delete('deletes/{id}', 'Sys\AdsController@deletes');


        // 分类广告管理
        Route::get('stypeslist', 'Sys\TypesAdsController@stypeslist');
    });
    // 后台分类管理
    //Route::resource('admin/admin','AdminController');

    //后台商品管理
    Route::group(['prefix' => 'goods'], function (){
        Route::get('goodsList','GoodsController@goodsList');
        //商品添加页面
        Route::get('create','GoodsController@create');
        //商品添加
        Route::post('store','GoodsController@store');
        // 删除操作
        Route::delete('destroy/{id}','GoodsController@destroy');
    });

    //订单管理
    Route::group(['prefix' => 'order'], function (){
        Route::get('index','OrderController@index');
    });
});

Route::group(['namespace' => 'Home', 'prefix' => 'home'], function () {
    // 前台首页
    //Route::get('index/index', 'CacheController@index');

    // 分类页面
    Route::get('type/index/{id}', 'TypeController@index');

    // 商品详情
    Route::get('goods/index/{id}', 'GoodsController@index');
});


/************************************************Redis***************************************************************/
Route::group(['namespace' => 'Redis', 'prefix' => 'redis'], function (){
    Route::get('index','IndexController@index');
    Route::get('index1','IndexController@index1');
    Route::get('publish','IndexController@publish');
    Route::get('subscribe1','IndexController@subscribe1');
    Route::get('subscribe2','IndexController@subscribe2');
    Route::get('subscribe3','IndexController@subscribe3');

    Route::get('redis/index','RedisController@index');
    Route::get('index1','RedisController@index1');
});

Route::group(['namespace' => 'Redis', 'prefix' => 'queue'], function (){
    Route::get('store','PodcastController@store');
});


/*************************************************Student*************************************************************/
Route::group(['namespace' => 'Student', 'prefix' => 'student'], function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::any('student/upload', 'StudentController@upload');
    Route::any('student/mail', 'StudentController@mail');

    Route::any('student/cache1', 'StudentController@cache1');
    Route::any('student/cache2', 'StudentController@cache2');


    Route::any('student/error', 'StudentController@error');
    Route::any('student/http', 'StudentController@http');
    Route::any('student/logs', 'StudentController@logs');
    Route::any('student/queue', 'StudentController@queue');


    Route::any('student/action1', 'StudentController@action1');
    Route::any('student/action2', 'StudentController@action2');
    Route::any('student/action3', 'StudentController@action3');
    Route::any(' student/action4', 'StudentController@action4');



    Route::any('studenttow/request1', 'StudentTowController@request1');


//开启 session
    Route::group(['middleware'=>['web']], function (){
        Route::any('studenttow/session1', 'StudentTowController@session1');
        Route::any('studenttow/session2', 'StudentTowController@session2');
    });

    Route::any('studenttow/response', 'StudentTowController@response');
    Route::any('studenttow/getResponse', [
        'as'  => 'getResponse',
        'uses'=> 'StudentTowController@getResponse']);

// 宣传页面
    Route::any('studenttow/activity0',['uses'=>'StudentTowController@activity0']);
//活动页面 启用中间件
    Route::group(['middleware' => ['activity']], function (){
        Route::any('studenttow/activity1',['uses'=>'StudentTowController@activity1']);
        Route::any('studenttow/activity2',['uses'=>'StudentTowController@activity2']);
    });
});

/*************************************************Student*************************************************************/
Route::group(['namespace' => 'Swoole', 'prefix' => 'swoole'], function(){
    Route::get('index','IndexController@index');
    Route::get('websocket','IndexController@websocket');
    Route::get('server','IndexController@server');
});


/********************表单*视图************************/
/**
 * 加入前缀my2，意思是在里头的所有路由地址都以my2开头
 */
Route::group(['prefix' => 'form'], function (){
    Route::any('index',['uses'=>'FormController@index']);
    Route::any('createForm',['uses'=>'FormController@createForm']);
    Route::any('create',['uses'=>'FormController@create']);
});

Route::any('index/{id?}',['uses'=>'FormController@index']);
Route::any('createForm/{page:1}',['uses'=>'FormController@createForm']);
Route::any('create',['uses'=>'FormController@create']);

Route::get('action/{id?}', function ($id = 1){
    return '测试路由 id = '.$id;
});



/*************************************练习控制器*****************************/
//  App\Providers\RouteServiceProvider->boot
Route::any('form/action/{id?}',['uses'=>'FormController@actionController']);

//  命名路由
Route::any('form/route/{id?}',['uses'=>'FormController@routeName'])
    ->name('route');


/*****************************测试中间件************************************/
Route::group(['namespace' => 'Studentmiddle', 'prefix' => 'middle'], function (){

    // 中间件 两种写法
    /*Route::group(['middleware' => ['action']], function (){
        Route::post('index','IndexController@index');
    });*/
    Route::post('index','IndexController@index')->middleware('action');
});



/**
 * 学习存放文件
 */
/*Route::group(['namespace' => 'Learning', 'prefix' => 'learning'], function () {
    Route::get('index','CacheController@index');
    Route::get('add','CacheController@add');
    Route::get('pullcache','CacheController@pullCache');
    Route::get('getcache','CacheController@getCache');
    Route::get('setput','CacheController@setput');
    Route::get('getdt','CacheController@getdt');
});*/


