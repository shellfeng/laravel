<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('shop/flow/{id}', 'IntegralController@shopFlow');

/*********************************星程3.0练习代码*********************************************/
Route::group(['namespace' => 'Starltd', 'prefix' => 'starltd'], function (){
    Route::group(['prefix' => 'integral'], function () {
        //商户流水
        Route::get('/shop/flow/{shop_id}/{page}', 'IntegralController@shopFlow');
        Route::post('/entrance', 'IntegralController@entrance');
        /*----------------------------------------------------------------------*/
// 停止所有用户红包分发
        Route::get('shop/{status:stop|start|status}/{type:day|manual|luck}/{shop_id:[\w]+}', 'IntegralController@shopTasksStatus');
// 停止、开启天天红包任务(用户)
        Route::get('/user/{status}/{type}/{shop_id}/{user_id}', 'IntegralController@userTasksStatus')
            ->where('status','stop|start')
            ->where('type','day|manual|luck');
// 清空 天天红包任务(用户)
        Route::get('/user/clear/{type:day|manual|luck}/{shop_id:[\w]+}/{user_id:[\w,]+}', 'IntegralController@clearUserTasks');
// 停止 天天红包任务(任务)
        Route::get('/task/{status}/{task_ids}', 'IntegralController@taskStatus')
            ->where('status','stop|start')
            ->where('stask_ids','[\w,]+');
// 清空 天天红包任务(任务)
        Route::get('/task/clear/{task_ids}', 'IntegralController@clearTasks')
            ->where('task_ids', '[\w,]+');
    });

    /*************************PromotionController*********************************/
    Route::group(['prefix' => 'plans'], function (){
        // 查询
        Route::get('/index/{id}', 'PromotionController@index')
            ->where('id','[0-9]+');
        // 查询
        Route::get('/token/{plan_token}', 'PromotionController@planToken')
            ->where('plan_token','[\w]+');
        // 查询
        Route::get('/lists/{mechanism_id:[\w]+}/{shop_id:[\w]+}/{page:[0-9]+}', 'PromotionController@lists');
    });

    Route::group(['prefix' => 'shop'], function () {
        
        // 推广计划(三级分销)
        Route::get('/teams/{mechanism_id}/{shop_id}/{page}', 'PromotionController@shopTeams')
            ->where('mechanism_id', '[\w]+')
            ->where('shop_id', '[0-9]+')
            ->where('page', '[0-9]+');
        // 分佣详情
        Route::get('/details/{mechanism_id}/{shop_id}/{user_id}/{plan_id}/{page}', 'PromotionController@shopDetails')
            ->where('mechanism_id', '[\w]+')
            ->where('user_id', '[0-9]+')
            ->where('plan_id', '[0-9]+')
            ->where('page', '[0-9]+');
        // 提现审核列表
        Route::get('/withdrawals/lists/{mechanism_id}/{shop_id}/{page}', 'PromotionController@shopWithdrawalsLists')
            ->where('mechanism_id', '[\w]+')
            ->where('shop_id', '[0-9]+')
            ->where('page', '[0-9]+');
        // 推广分红提现审核
        Route::get('/withdrawals/agree/{id}/{status}', 'PromotionController@agreeWithdrawals')
            ->where('id', '[0-9]+')
            ->where('status', 'ok|fail');
        //  对账
        Route::get('/flow/details/{user_id}/{plan_id}/{page}', 'PromotionController@shopFlowDetails')
            ->where('user_id', '[0-9]+')
            ->where('plan_id', '[0-9]+')
            ->where('page', '[0-9]+');
    });
});


