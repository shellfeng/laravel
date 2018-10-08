<?php
/**
 * 分类控制器
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/2/24
 * Time: 16:51
 */

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index ()
    {
        return view('home.type');
    }
}