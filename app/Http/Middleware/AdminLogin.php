<?php
/**
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/1/31
 * Time: 14:39
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;


class AdminLogin
{
    public function handle ($request, Closure $next, $role = null)
    {
        //return $next($request);
        // 判断后台是否登录
        if (session('admin')) {
            return $next($request);
        } else {
            return redirect('admin/index');
        }


    }
}