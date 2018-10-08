<?php
/**
 * 商品分类
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/2/27
 * Time: 15:26
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TypesController extends Controller
{
    public function data ($data, $pid = 0)
    {
        $newArr = [];
        foreach ($data as $k=>$value) {
            if ($value->pid == $pid) {
                $newArr[$k] = $value;
                $newArr[$k]->child = $this->data($data, $value->id);
            }
        }
        return $newArr;
        //return $data;
    }
    public function index()
    {
        $total = Db::table('types')->count();
        /*$data = Db::table('types')
            ->orderBy('id','desc')
            ->get([
                'id',
                'pid',
                'name',
                'title',
                'path',
                'is_lou',
                'keywords',
                'description'
            ])->toArray();*/
        //$typeslist = $this->build_tree($data);
        //$typeslist = $this->data($data);
        $typeslist = Db::select('select *,concat(path,id) p from types order by p');
        return view('admin.types.index', [
            'data' => $typeslist,
            'total' => $total,
        ]);
    }

    /**
     * 创建分类页
     */
    public function create()
    {
        return view('admin.types.add');
    }

    /**
     * 添加数据  post
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $rules = [
            'name'        => 'required',
            'title'       => 'required',
            'keywords'    => 'required',
            'description' => 'required',
            'sort'        => 'required|integer',
        ];
        $messages = [
            'name.required'        => '请填写分类名',
            'title.required'       => '请填写title',
            'keywords.required'    => '请填写关键字',
            'description.required' => '请填写描述',
            'sort.required'        => '请填写排序',
            'sort.integer'         => '排序为整数',

        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return ['code' => 2, 'msg' => $validator->getMessageBag()->getMessageBag()];
        }

        if (Db::table('types')->insert($data)) {
            $re = ['code' => 1, 'msg' => '添加成功'];
        } else {
            $re = ['code' => 0, 'msg' => '添加失败'];
        }
        return $re;
    }

    /**
     * 修改页
     */
    public function edit ($id)
    {
        $dt = Db::table('types')
            ->where([
                ['id','=',$id]
            ])
            ->first([
                'id',
                'name',
                'title',
                'path',
                'sort',
                'is_lou',
                'keywords',
                'description'
            ]);
        return view('admin.types.edit', [
            'dt' => $dt
        ]);
    }

    /**
     * 修改页
     */
    public function update (Request $request)
    {
        $data = $request->except(['_method','_token']);
        $rules = [
            'name'        => 'required',
            'title'       => 'required',
            'keywords'    => 'required',
            'description' => 'required',
            'sort'        => 'required|integer',
        ];
        $messages = [
            'name.required'        => '请填写分类名',
            'title.required'       => '请填写title',
            'keywords.required'    => '请填写关键字',
            'description.required' => '请填写描述',
            'sort.required'        => '请填写排序',
            'sort.integer'         => '排序为整数',

        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return ['code' => 2, 'msg' => $validator->getMessageBag()->getMessageBag()];
        }

        if (Db::table('types')->where([['id','=',$data['id']]])->update($data)) {
            $re = ['code' => 1, 'msg' => '修改成功'];
        } else {
            $re = ['code' => 0, 'msg' => '修改失败'];
        }
        return $re;
    }

    /**
     * 删除操作 delete
     */
    public function destroy($id)
    {
        //判断是否有子分类
        $isc = Db::table('types')
            ->where([
                ['path', 'like', '%,'.$id.',%']
            ])
            ->value('id');
        if (!empty($isc)) {
            return ['code'=> 0, 'msg' => '请先删除子分类'];
        }
        if (Db::table('types')->delete($id)) {
            $re = ['code' => 1, 'msg' => '删除成功'];
        } else {
            $re = ['code' => 0, 'msg' => '删除失败'];
        }
        return $re;
    }

    /**
     * 所到子类
     * @param type $arr
     * @param type $id
     * @return type
     */
    function find_child(&$arr, $id) {
        $childs = array();
        foreach ($arr as $v) {
            if (isset($v->pid)) {
                $pid = $v->pid;
            } elseif (isset($v->parent_id)) {
                $pid = $v->parent_id;
            }
            if ($pid == $id) {
                $childs[] = $v;
            }
        }
        return $childs;
    }


    /**
     * 找到给定父类的所有子类
     * @param type $rows
     * @param type $root_id
     * @return type
     */
    function build_tree($rows, $pid = 0) {
        $childs = $this->find_child($rows, $pid);
        if (empty($childs)) {
            return null;
        }
        foreach ($childs as $v) {
            if (isset($v->id)) {
                $id = $v->id;
            }
            $rescurTree = $this->build_tree($rows, $id);
            if (null != $rescurTree) {
                $v->children = $rescurTree;
            }
        }
        return $childs;
    }

}
