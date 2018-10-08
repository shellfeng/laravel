<?php
/**
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/3/8
 * Time: 17:07
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index ()
    {
        $data = DB::table('orders')
            ->join('user','user.id','=','orders.user_id')
            ->join('goods','goods.id','=','orders.goods_id')
            ->join('addr','addr.id','=','orders.addr_id')
            ->join('orderstatu','orderstatu.id','=','orders.orderstatu_id')
            ->select([
              'orders.*',
              'user.name',
              'goods.title',
              'goods.img',
              'addr.name',
              'addr.tel',
              'addr.addr',
            ])
            ->paginate(6);
        return view('admin.orders.index', [
            'data' => $data
        ]);
    }



}