<?php

/**
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/2/23
 * Time: 16:05
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * 后台首页
     */
    public function index ()
    {
        return view('admin.index');
    }
}