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
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * 后台首页
     */
    public function userlist()
    {
        $dt = DB::table('user')
            ->select([
                'id',
                'name',
                'pass',
                'login_time',
            ])
            ->paginate(6);
        return view('admin.user.userlist', [
            'data' => $dt
        ]);
    }

    /**
     * 插入操作  post
     */
    public function store(Request $request)
    {
        $dt = $request->input();
        $rules = [
            'name'  => 'required|string|unique:user,name|between:2,12',
            'pass'  => 'required|alpha_dash|same:repass|between:3,12',
            'email' => 'required|email',
            'tel'   => 'required'
        ];
        $messages = [
            'name.required'   => '请输入用户名',
            'name.unique'     => '用户名已存在',
            'name.between'    => '用户名长度不在3-12之间',
            'pass.required'   => '请输入密码',
            'pass.alpha_dash' => '密码只能为字母数字破折号(-)下划线(_)',
            'pass.same'       => '两次密码不一致',
            'pass.between'    => '密码长度不在3-12之间',
            'email.required'  => '请输入邮箱',
            'email.email'     => '邮箱格式不正确',
            'tel.required'    => '请输入电话号码',

        ];
        $validator = Validator::make($dt, $rules, $messages);
        if ($validator->fails()) {
            //$tt = $validator->errors();  对象形式
            return ['code' => 2, 'msg' => $validator->getMessageBag()->getMessages()];
        }
        $result = Db::table('user')
            ->insert([
                'name'        => $dt['name'],
                'pass'        => $dt['pass'],
                'email'       => $dt['email'],
                'tel'         => $dt['tel'],
                'aid'         => $dt['aid'],
                'status'      => $dt['status'],
                'token'       => base64_encode($dt['name']),
                'login_time'  => date('Y-m-d H:i:s'),
                'create_time' => date('Y-m-d H:i:s')
            ]);
        if ($result) {
            $re = ['code' => 1, 'msg' => '添加成功'];
        } else {
            $re = ['code' => 0, 'msg' => '添加失败'];
        }
        return $re;
    }

    /**
     * 修改页面  get
     */
    public function edit()
    {
        return view('admin.user.edit');
    }

    /**
     * 更新操作 put
     */
    public function update()
    {

    }

    /**
     * 删除操作 delete
     */
    public function destroy()
    {

    }
}
