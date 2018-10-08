<?php
/**
 * Created by PhpStorm.  captcha
 * User: xf
 * Date: 2018/2/23
 * Time: 17:27
 */

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Http\Utils\Code\Code;
use Illuminate\Http\Request;
use Mews\Captcha\Captcha;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index ()
    {
        return view('admin.login');
    }

    public function login (Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'captcha' => 'required|captcha'
        ]);
        if ($validator->fails()) {
            dd($validator->errors()->all());
        }

        session(['admin' => 'admin']);
        return  redirect('admin/index/index');

        /*$validator = $this->validate($request, [
            'captcha' => 'required|captcha'
        ]);*/
    }
}