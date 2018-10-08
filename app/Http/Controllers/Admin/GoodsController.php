<?php
/**
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/3/6
 * Time: 10:12
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class GoodsController extends Controller
{
    public function goodsList()
    {
        $data = Db::table('goods')
            ->select([
                'id',
                'title',
                'info',
                'img',
                'price',
                'num'
            ])
            ->paginate(5);
        foreach ($data as $v) {
            $v->tupian = Db::table('goodsimg')
                ->where([
                    ['goods_id', '=', $v->id]
                ])
                ->get();
        }
        return view('admin.goods.index', [
            'data' => $data
        ]);
    }

    /**
     * 添加商品页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $types = Db::select('select types.*,concat(path,id) p from types order by p');
        foreach ($types as $v) {
            $arr = explode(',', $v->path);
            $size = count($arr);
            $v->size = $size - 2;
            $v->html = str_repeat('|--', $v->size) . $v->name;
        }
        return view('admin.goods.create', [
            'data' => $types
        ]);
    }

    /**
     * 添加商品
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'title'    => 'required',
            'info'     => 'required',
            'types_id' => 'required',
            'price'    => 'required',
            'num'      => 'required',
            'img'      => 'required',
            'imgs'     => 'required',
            'text'     => 'required',
            'config'   => 'required'
        ];
        $messages = [
            'title.required'    => '请输入title',
            'info.required'     => '请输入商品简介',
            'types_id.required' => '请选择所属分类',
            'price.required'    => '请填写价格',
            'img.required'      => '请上传封面',
            'imgs.required'     => '请上传图片',
            'text.required'     => '请输入商品简介2',
            'config.required'   => '请输入商品配置'
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return ['code' => 2, 'msg' => $validator->getMessageBag()->getMessages()];
        }
        $path1 = $request->file('img')->store('public/img');
        $path2 = $request->file('imgs')->store('public/img');
        DB::beginTransaction();
        try {
            $goods_id = Db::table('goods')
                ->insertGetId([
                    'types_id' => $data['types_id'],
                    'title'    => $data['title'],
                    'info'     => $data['info'],
                    'img'      => Storage::url($path1),
                    'price'    => $data['price'],
                    'num'      => $data['num'],
                    'text'     => $data['text'],
                    'config'   => $data['config'],
                ]);
            Db::table('goodsimg')
                ->insert([
                    'goods_id' => $goods_id,
                    'img' => Storage::url($path2),
                ]);
            DB::commit();
            $re = ['code' => 1, 'msg' => '添加成功！'];
            return redirect('/admin/goods/goodsList');
        } catch (\Exception $exception) {
            Db::rollBack();
            $re = json_encode(['code' => 0, 'msg' => 'Add failure'], true);
        }
        return $re;
    }

    public function destroy ($id)
    {
        Db::beginTransaction();
        try {
            $info = Db::table('goods')
                ->where('id', '=', $id)
                ->first();
            $imgs = Db::table('goodsimg')
                ->where('goods_id', '=', $info->id)
                ->get();
            Db::table('goods')
                ->where('id', '=', $id)
                ->delete();

            Db::table('goodsimg')
                ->where('goods_id', '=', $info->id)
                ->delete();

            Storage::delete($info->img);
            foreach ($imgs as $v) {
                Storage::delete($v->img);
            }
            Db::commit();
            $re = ['code' => 1, 'msg' => '删除成功！'];
        } catch (\Exception $exception){
            Db::rollBack();
            return  $exception->getMessage();
            $re = ['code' => 0, 'msg' => '删除失败！'];
        }
        return $re;
    }
}