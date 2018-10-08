<?php

/**
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/4/2
 * Time: 15:49
 */

namespace App\Http\Controllers\Starltd;

use App\Http\Controllers\Controller;
use App\Http\Utils\Integral\Manual;
use App\Http\Utils\Integral\Order;
use App\Http\Utils\Integral\Time;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class IntegralController extends Controller
{
    protected $page_size = 6;

    const INTEGRAL_NOT_FOUND_ROLES = '该积分规则不存在';
    const INTEGRAL_NOT_FOUND_ROLES_HISTORY = '该商户积分规则历史不存在';
    const INTEGRAL_NOT_FOUND_LUCK_TASK = '该商户还没有幸运红包规则结算详情';
    const INTEGRAL_NOT_FOUND_DAY_TASK = '该商户还没有天天红包规则结算详情';
    const INTEGRAL_NOT_FOUND_MANUAL_TASK = '该商户还没有手动红包规则结算详情';
    const INTEGRAL_NOT_FOUND_ORDER = '该商户还没有线上或线下结算详情';
    const INTEGRAL_SHOP_NOT_FOUND_ROLES = '该商户(用户)没有该积分规则';
    const INTEGRAL_NOT_ENOUGH = '该商户(用户)没有足够的积分';
    const INTEGRAL_ALREADY_HAS_LUCK_ROLES = '已经创建了幸运积分红包规则';
    const INTEGRAL_ALREADY_SHOP_ACCOUNT = '改商户已经有积分账户';
    const INTEGRAL_NOT_FOUND_FLOW = '该商户(用户)没有流水详情';
    const INTEGRAL_NOT_ALLOW_REFUND = '该消费不能退款';
    const INTEGRAL_ORDER_ALREADY_FINISH = '该笔订单已经完成';

    /**
     * 商户流水
     * @param Request $request
     * @param $shop_id
     * @param $page
     */
    public function shopFlow(Request $request, $shop_id, $page)
    {
        $start = null;
        $end = null;
        $type = null;
        $search = null;
        $page_size = $this->page_size;
        $query = DB::table('shop_flow')
            ->select(['shop_flow.*'])
            ->when(true, function ($query) {
                $userDatabase = env('DB_DATABASE_USER', '');
                $query->addSelect(Db::raw("case left(`shop_flow`.`user_id`, 1)
                when 'v' then (select `nickname` from {$userDatabase}`wx_user` where `id` = substring(`shop_flow`.`user_id`, 2))
                when 'a' then (select `nickname` from {$userDatabase}`alipay_user` where `id` = substring(`shop_flow`.`user_id`, 2))
                else (select `nickname` from {$userDatabase}`user_info` where `user_id` = `shop_flow`.`user_id`)
                end as nickname
                "));
                $query->addSelect(DB::raw("CASE LEFT(`shop_flow`.`user_id`, 1)
                WHEN 'v' THEN '匿名用户无手机号'
                WHEN 'a' THEN '匿名用户无手机号' 
                ELSE (SELECT mobile FROM {$userDatabase}`user`  WHERE `id` = `shop_flow`.`user_id`)
                END as mobile"));
                $query->addSelect(DB::raw("CASE LEFT(`shop_flow`.`user_id`, 1)
                WHEN 'v' THEN ''
                WHEN 'a' THEN '' 
                ELSE (SELECT avatar FROM {$userDatabase}`user_info`  WHERE `user_id` = `shop_flow`.`user_id`)
                END as avatar"));
            })->when($start, function ($query) use ($start) {
                $query->where('shop_flow.create_time', '>=', $start);
            })->when($end, function ($query) use ($end) {
                $query->where('shop_flow.create_time', '<=', $end);
            })->when($type, function ($query) use ($type) {
                if ($type == 'in') {
                    $query->where('shop_flow.integral', '>=', 0);
                } elseif ($type == 'out') {
                    $query->where('shop_flow.integral', '<', 0);
                }
            })
            ->where([
                'shop_flow.shop_id' => $shop_id
            ]);
        $base = Db::table(Db::raw(sprintf("(%s) temp", $query->toSql())))
            ->setBindings($query->getBindings())
            ->when($search, function ($query) use ($search) {
                $query->whereRaw('concat(temp.mobile,temp.nickname,temp.order_num) like ?', "%{$search}%");
            });
        $flow = $base->orderBy('temp.id', 'desc')->offset(($page - 1) * $page_size)
            ->limit($page_size)->get();
        dump($flow);
    }

    public function entrance (Request $request)
    {
        $this->validate($request, [
            'userId'       => 'required|alpha_num',
            'shopId'       => 'required|alpha_num',
            'type'         => 'required|in:line,shade',
            'orderNo'      => 'required|string|min:1|max:255',
            'total'        => 'required|integer|min:0',
            'amount'       => 'required|integer|min:0',
            'integral'     => 'required|integer|min:0',
            'cashRatio'    => 'required|numeric|min:0',
            'inteRatio'    => 'required|numeric|min:0',
            'popularize'   => 'array',
            'distribution' => 'array',
        ]);
        $orderId = Db::table('orders')
            ->where([
                'order_num' => $request->input('orderNo'),
            ])->first(['id']);
        if (!is_null($orderId)) {
            throw new \Exception(self::INTEGRAL_ORDER_ALREADY_FINISH, 202);
        }
        $order = new Order(
            $request->input('type'),
            $request->input('shopId'),
            $request->input('userId'),
            $request->input('orderNo'),
            $request->input('total'),
            $request->input('amount'),
            $request->input('integral'),
            $request->input('cashRatio'),
            $request->input('inteRatio'),
            $request->input('popularize', []),
            $request->input('distribution', [])
        );
        return $this->json($order->account());
    }

    /**
     * 手动任务
     * @param Request $request
     */
    public function shopManualTasks(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|array',
            'shop_id' => 'required|alpha_num',
            'day_return' => 'required|integer|min:1',
            'day_every' => 'required|integer|min:1',
        ]);
        $ids = array_values(array_filter(array_unique(
            $request->input('user_id')),
            function ($value) {
                return is_numeric($value);
            }));

        $manual = new Manual(
            $request->input('shop_id'),
            $ids,
            $request->input('day_return'),
            $request->input('day_every')
        );
        $manual->run();
        return $this->json('成功');
    }
    /*----------------------------------------------------------------------*/
    /**
     * 停止/开启 所有用户红包分发
     * @param $status
     * @param $type
     * @param $shop_id
     * @return \App\Http\Utils\Response
     */
    public function shopTasksStatus($status, $type, $shop_id)
    {
        $base = DB::table('shop')
            ->where(['shop' => $shop_id]);
        if ($status === 'start') {
            if ($type === 'day') {
                $base->update([
                    'day_enabled' => 'true',
                    'update_time' => Time::current(),
                ]);
            } elseif ($type === 'luck') {
                $base->update([
                    'luck_enabled' => 'true',
                    'update_time'  => Time::current(),
                ]);
                return $this->json('开启幸运红包成功');
            } else {
                $base->update([
                    'mal_enabled' => 'true',
                    'update_time' => Time::current(),
                ]);
                return $this->json('开启手动红包成功');
            }
        } elseif ($status === 'stop') {
            if ($type === 'day') {
                $base->update([
                    'day_enabled' => 'false',
                    'update_time' => Time::current(),
                ]);
                return $this->json('关闭天天红包成功');
            } elseif ($type === 'luck') {
                $base->update([
                    'luck_enabled' => 'false',
                    'update_time'  => Time::current(),
                ]);
                return $this->json('关闭幸运红包成功');
            } else {
                $base->update([
                    'mal_enabled' => 'false',
                    'update_time' => Time::current(),
                ]);
                return $this->json('关闭手动红包成功');
            }
        } else {
            if ($type === 'day') {
                return $this->json($base->value('day_enabled'));
            } elseif ($type === 'luck') {
                return $this->json($base->value('luck_enabled'));
            } else {
                return $this->json($base->value('mal_enabled'));
            }
        }
    }

    public function userTasksStatus($status, $type, $shop_id, $user_id)
    {
        if (is_numeric($user_id)) {
            $user_id = DB::table(env('DB_DATABASE_USER', '') . 'user as user')
                ->select('id as user_id')
                ->where(['id' => $user_id])
                ->union(function ($query) use ($user_id) {
                    $query->select(DB::raw("concat('v',id) as user_id"))
                        ->from(env('DB_DATABASE_USER', '') . 'wx_user as v_user')
                        ->where(['user_id' => $user_id]);
                })
                ->union(function ($query) use ($user_id) {
                    $query->select(DB::raw("concat('v',id) as user_id"))
                        ->from(env('DB_DATABASE_USER', '') . 'alipay_user as a_user')
                        ->where(['user_id' => $user_id]);
                })
                ->distinct()
                ->pluck('user_id')
                ->toArray();
        } else {
            $user_id = explode(',', $user_id);
        }

        $base = DB::table('user')
            ->whereIn('user_id', $user_id)
            ->where(['shop_id' => $shop_id]);
        if ($status === 'start') {
            if ($type === 'day') {
                $base->update([
                    'day_enabled' => 'true',
                    'update_time' => Time::current(),
                ]);
                return $this->json('开启天天积分红包成功');
            } else if ($type === 'luck') {
                $base->update([
                    'luck_enabled' => 'true',
                    'update_time'  => Time::current(),
                ]);
                return $this->json('开启幸运积分红包成功');
            } else {
                $base->update([
                    'mal_enabled' => 'true',
                    'update_time' => Time::current(),
                ]);
                return $this->json('开启手动积分红包成功');
            }
        } else {
            if ($type === 'day') {
                $base->update([
                    'day_enabled' => 'false',
                    'update_time' => Time::current(),
                ]);
                return $this->json('关闭天天积分红包成功');
            } else if ($type === 'luck') {
                $base->update([
                    'luck_enabled' => 'false',
                    'update_time'  => Time::current(),
                ]);
                return $this->json('关闭幸运积分红包成功');
            } else {
                $base->update([
                    'mal_enabled' => 'false',
                    'update_time' => Time::current(),
                ]);
                return $this->json('关闭手动积分红包成功');
            }
        }
    }

    /**
     * 清空 天天红包任务(用户)
     * @param $type
     * @param $shop_id
     * @param $user_id
     */
    public function clearUserTasks($type, $shop_id, $user_id)
    {
        if (is_numeric($user_id)) {
            $user_id = DB::table(env('DB_DATABASE_USER', '') . 'user as user')
                ->select('id as user_id')
                ->where(['id' => $user_id])
                ->union(function ($query) use ($user_id) {
                    $query->select(DB::raw("concat('v',id) as user_id "))
                        ->where(['user_id' => $user_id]);
                })->union(function ($query) use ($user_id) {
                    $query->select(DB::raw("CONCAT('a',id) as user_id"))
                        ->from(env('DB_DATABASE_USER', '') . 'alipay_user as a_user')
                        ->where('user_id', $user_id);
                })->distinct()
                ->pluck('user_id')
                ->toArray();
        } else {
            $user_id = explode(',', $user_id);
        }
        $base = DB::table('task')
            ->whereIn('user_id', $user_id)
            ->where('shop_id', $shop_id);
        if ($type === 'day') {
            $base->where('type', 'day')
                ->update([
                    'enabled'     => 'false',
                    'count'       => 0,
                    'update_time' => Time::current(),
                ]);
            return $this->json('清空天天积分红包成功');
        } elseif ($type === 'luck') {
            $base->where('type', 'luck')
                ->update([
                    'enabled'     => 'false',
                    'count'       => 0,
                    'update_time' => Time::current(),
                ]);
            return $this->json('清空幸运积分红包成功');
        } else {
            $base->where('type', 'manual')
                ->update([
                    'enabled'     => 'false',
                    'count'       => 0,
                    'update_time' => Time::current(),
                ]);
            return $this->json('清空手动积分红包成功');
        }
    }

    /**
     * 停止 天天红包任务(任务)
     * @param $status
     * @param $task_ids
     * @return \App\Http\Utils\Response
     */
    public function taskStatus($status, $task_ids)
    {
        $ids = array_values(array_filter(array_unique(explode(',', $task_ids)), function ($value) {
            return is_numeric($value);
        }));
        if ($status === 'start') {
            DB::table('task')
                ->whereIn('id', $ids)
                ->update([
                    'enabled'     => 'true',
                    'update_time' => Time::current(),
                ]);
            return $this->json('开启成功');
        } else {
            Db::table('task')
                ->whereIn('id', $ids)
                ->update([
                    'enabled'     => 'false',
                    'update_time' => Time::current(),
                ]);
            return $this->json('关闭成功');
        }
    }

    /**
     * 清空 天天红包任务(任务)
     */
    public function clearTasks($task_ids)
    {
        $ids = array_values(array_filter(array_unique(explode(',', $task_ids)), function ($value) {
            return is_numeric($value);
        }));
        DB::table('task')
            ->whereIn('id', $ids)
            ->update([
                'enabled'     => 'false',
                'count'       => 0,
                'update_time' => Time::current(),
            ]);
        return $this->json('清空成功');
    }
}
