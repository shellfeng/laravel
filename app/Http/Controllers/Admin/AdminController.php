<?php
/**
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/2/23
 * Time: 16:18
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Utils\Response\Response;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class AdminController extends Controller
{
    /**
     * 后台首页
     */
    public function adminList()
    {
        $b = 'b';$a = 'a';
        list($a, $b) = array($b, $a);
        dump($a);
        dump($b);
        throw new Exception("blahblah");

        $total = Db::table('admin')->count();
        $adminarr = Db::table('admin')
            ->orderBy('login_time','asc')
            ->select([
                'id',
                'name',
                'pass',
                'status',
                'login_time',
                'create_time'
            ])
            ->paginate(5);
        return view('admin.admin.adminlist', [
            'data'  => $adminarr,
            'total' => $total,
        ]);
    }

    /**
     * 插入操作  post
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name' => 'required|string|unique:admin,name|between:2,12',
            'pass' => 'required|alpha_dash|same:repass|between:3,12',
        ];
        $messages = [
            'name.required'   => '请输入用户名',
            'name.unique'     => '用户名已存在',
            'name.between'    => '用户名长度不在3-12之间',
            'pass.required'   => '请输入密码',
            'pass.alpha_dash' => '密码只能为字母数字破折号(-)下划线(_)',
            'pass.same'       => '两次密码不一致',
            'pass.between'    => '密码长度不在3-12之间',

        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            //$tt = $validator->errors();  对象形式
            return ['code' => 2, 'msg' => $validator->getMessageBag()->getMessages()];
        }
        $ins = Db::table('admin')
            ->insert([
                'name'       => $data['name'],
                'pass'       => $data['pass'],
                'status'     => $data['status'],
                'login_time' => date('Y-m-d H:i:s', time()),
                'create_time'=> date('Y-m-d H:i:s', time())
            ]);
        if ($ins) {
            $re = ['code' => 1, 'msg' => '添加成功'];
        } else {
            $re = ['code' => 0, 'msg' => '添加成功'];
        }
        return $re;
    }

    /**
     * 修改页面  get
     */
    public function edit($id)
    {
        $dt = Db::table('admin')
            ->where([
                'id' => $id
            ])
            ->first([
                'id',
                'name',
                'pass'
            ]);
        return view('admin.admin.edit', [
            'data' => $dt
        ]);
    }

    /**
     * 更新操作 put
     */
    public function update(Request $request)
    {
        $data = $request->all();
        $rules = [
            'name' => 'required|string|between:2,12',
            'pass' => 'required|alpha_dash|between:3,12',
        ];
        $messages = [
            'name.required'   => '请输入用户名',
            'name.between'    => '用户名长度不在3-12之间',
            'pass.required'   => '请输入密码',
            'pass.alpha_dash' => '密码只能为字母数字破折号(-)下划线(_)',
            'pass.between'    => '密码长度不在3-12之间',

        ];
        $volidator = Validator::make($data, $rules, $messages);
        if ($volidator->fails()){
            return ['code' => 2, 'msg' => $volidator->getMessageBag()->getMessages()];
        }

        $isc = Db::table('admin')
            ->where([
                ['id' ,'!=', $request->input('id')],
                ['name' ,'=', $data['name']]
            ])
            ->first();
        if (!empty($isc)) {
            return ['code' => 0, 'msg' => '用户名已存在'];
        }

        $result = Db::table('admin')
            ->where([
                'id' => $request->input('id')
            ])
            ->update([
                'name' => $data['name'],
                'pass' => $data['pass']
            ]);
        if ($result) {
            $re = ['code' => 1, 'msg' => '修改成功！'];
        } else {
            $re = ['code' => 0, 'msg' => '修改失败！'];
        }
        return $re;
    }

    /**
     * 更新状态 post
     */
    public function upstatus(Request $request)
    {
        $id     = $request->input('id');
        $status = $request->input('status');
        $result = Db::table('admin')
            ->where(['id' => $id])
            ->update([
                'status' => $status
            ]);
        if ($result) {
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
        if (Db::table('admin')->delete($id)) {
            $re = ['code' => 1, 'msg' => '删除成功'];
        } else {
            $re = ['code' => 0, 'msg' => '删除失败'];
        }
        return $re;
    }
}