<?php
/**
 * 分类广告管理
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/3/1
 * Time: 15:13
 */

namespace App\Http\Controllers\Admin\Sys;


use App\Http\Controllers\Controller;

class TypesAdsController extends Controller
{
    public function stypeslist ()
    {
        return view('admin.sys.types.index');
    }
}