<?php
/**
 * 商品详情
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/2/24
 * Time: 16:57
 */

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoodsController extends Controller
{
    public function index ()
    {
        return view('home.goods');
    }
}