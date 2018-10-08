<?php

/**
 * 系统管理
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/3/1
 * Time: 15:08
 */
namespace App\Http\Controllers\Admin\Sys;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function syslist ()
    {
        return view('admin.sys.config.index');
    }


    public function store (Request $request)
    {
            $arr = $request->except('_token');
            $str1 = var_export($arr, true);
            $str = '<?php return '. $str1 . ';?>';
            //写入文件
            file_put_contents('../config/web.php', $str);
            return redirect('/admin/sys/syslist');
    }
}
