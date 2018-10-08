<?php
/**
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/4/11
 * Time: 15:53
 */

namespace App\Http\Controllers\Starltd;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class PromotionController extends Controller
{
    /**
     * @var int
     */
    protected $page_size = 3;

    const PROMOTION_NOT_FOUND_PLAN = "没有该推广计划";
    const PROMOTION_HAS_NO_PLAN = "没有推广计划";
    const PROMOTION_PLAN_HAS_USED = "推广计划已经被使用";
    const PROMOTION_HAS_JOIN_PLAN = "已经加入该推广计划";
    const PROMOTION_HAS_RELATION = "该商户下已有你的推荐关系";
    const PROMOTION_PARENT_NOT_HAS_RELATION = "没有找商户下的上级关系";
    const PROMOTION_PARENT_NOT_HAS_PLAN = "上级没有加入该计划";
    const PROMOTION_HAS_NOT_JOIN_PLAN = "没有加入该推广计划";
    const PROMOTION_PLAN_HAS_NOT_ENOUGH_AMOUNT = "该推广计划提现金额不足";
    const PROMOTION_NEED_WECHAT = "请先关注公众号";
    const PROMOTION_ORDER_ALREADY_FINISH = "该笔订单已经结算完毕";
    const PROMOTION_HAS_NOT_PLANS_DETAILS = "没有分佣详情";
    const PROMOTION_FLOW_CANNOT_BACK = "该分佣不能扣回";
    const PROMOTION_HAS_NOT_TEAM = "没有推广团队";
    const PROMOTION_HAS_AGREE = "已经审核过该笔记录";
    const PROMOTION_HAS_NO_WITHDRAWALS = "没有提现记录";

    public function index($id)
    {
        $plan = DB::table('promotion_plan')
            ->where(['id' => $id])
            ->first();
        if (is_null($plan)) {
            throw new \Exception(self::PROMOTION_NOT_FOUND_PLAN, 404);
        }
        return $this->json($plan);
    }

    public function planToken($plan_token)
    {
        $plan = DB::table('promotion_plan')
            ->select('promotion_plan.*')
            ->where(['promotion_plan.token' => $plan_token])
            ->addSelect(DB::raw('shop_info.name as shop_name, shop_info.logo as shop_logo'))
            ->leftJoin(sprintf('%sshop_info.name as shop_info', env('DB_DATABASE_USER', '')), function ($join) {
                $join->on('shop_info.id', '=', 'promotion_plan.shop_id');
            })->first();
        if (is_null($plan)) {
            throw new \Exception(self::PROMOTION_NOT_FOUND_PLAN, 404);
        }
        return $this->json($plan);
    }

    public function lists(Request $request, $mechanism_id, $shop_id, $page)
    {
        $this->validate($request, [
            'page_size' => 'integer|min:1',
        ]);
        $base = DB::table('promotion_plan')
            ->where([
                'shop_id' => $shop_id,
                'mechanism_id' => $mechanism_id,
            ]);
        $page_size = $request->input('page_size', $this->page_size);
        $count = $base->count();
        $totalPage = ceil($count / $page_size);
        if ($totalPage == 0) {
            throw new \Exception(self::PROMOTION_HAS_NO_PLAN, 404);
        }
        $page = ($page <= 1) ? 1 : $page;
        $plan = $base->orderBy('id', 'desc')
            ->offset(($page - 1) * $page_size)
            ->limit($page_size)
            ->get();
        return $this->json([
            'page_size'    => (int)$page_size,
            'count'        => (int)$count,
            'total_page'   => (int)$totalPage,
            'current_page' => (int)$page,
            'plan'         => $plan,
        ]);
    }
}
