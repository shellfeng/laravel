<?php
/**
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/1/25
 * Time: 14:50
 */

namespace App\Http\Controllers;


use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;

class FormController extends Controller
{
    protected $page_size = 3;

    public function index(Request $request)
    {
        phpinfo();
        // 学生列表页
        $list = DB::table('users')->paginate($this->page_size);

        return view('form.index', [
            'users' => $list,
        ]);
    }

    /**
     * 新增数据页面
     */
    public function createForm(Request $request)
    {
        if ($request->isMethod('POST')){
            $data = $request->input();
            if (Users::create($data)) {
                return redirect('form/index')->with('success','添加成功');
            } else {
                return redirect('form/createForm')->with('error','添加失败');
            }
        }
        return view('form.create');
    }

    public function create(Request $request)
    {
        $data = $request->input();
        /*$this->validate($request,[
            'name' => 1
        ]);*/
        $users = new Users();
        $users->name = $data['name'];
        $users->email = $data['email'];
        $users->password = $data['password'];
        $users->remember_token = $data['remember_token'];
        if ($users->save()) {
            return redirect('form/index')->with('success','添加成功');
        } else {
            return redirect('form/createForm')->with('error','添加失败');
        }
    }

    public function actionController ($id = 4)
    {
        return 'FormController/actionController  id = '.$id;
    }

    public function routeName ($id = 3)
    {
        return '命名路由';
    }

    /**
     * TODO 错误
     * @return string
     */
    public function getIndex ()
    {
        return '隐式路由控制器--FormController/index';
    }

    /**********************************视图*******************************/

    /**
     * 视图
     */
    public function acView ()
    {

    }
}
