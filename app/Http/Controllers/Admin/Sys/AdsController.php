<?php
/**
 * 广告管理
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/3/1
 * Time: 15:12
 */

namespace App\Http\Controllers\Admin\Sys;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdsController extends Controller
{
    public function adslist ()
    {
        $data = Db::table('ads')
            ->paginate(2);
        return view('admin.sys.ads.index', [
            'data' => $data
        ]);
    }

    /**
     * 添加商品页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        return view('admin.sys.ads.create');
    }

    /**
     * 添加商品页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function inserts(Request $request)
    {
        $data = $request->all();
        $path = $request->file('img')->store('public/img');
        DB::beginTransaction();
        try{
            Db::table('ads')
                ->insert([
                    'img' => Storage::url($path),
                    'sort' => $data['sort'],
                    'href' => $data['href'],
                    'title' => $data['title'],
            ]);
            Db::commit();
        } catch (\Exception $exception){
            Db::rollBack();
        }
        return redirect('/admin/sys/adslist');
    }

    public function deletes ($id)
    {
        $info = Db::table('ads')
            ->value('img');
        Db::beginTransaction();
        try{
            Db::table('ads')
                ->delete($id);
            Storage::delete($info);
            Db::commit();
            $re = ['code' => 1, 'msg' => '删除成功！'];
        } catch (\Exception $exception){
            Db::rollBack();
            $re = ['code' => 0, 'msg' => '删除失败！'];
        }
        return $re;
    }
}
