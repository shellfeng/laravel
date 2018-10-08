<?php
/**
 * 轮播图管理
 * Created by PhpStorm.
 * User: xf
 * Date: 2018/3/1
 * Time: 15:12
 */

namespace App\Http\Controllers\Admin\Sys;


use App\Http\Controllers\Controller;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{

    public function sliderlist()
    {

        $img = 'storage/img/3qHU62Y2Z0vEbOWex8mslLtOgDvkCpWYt1mt3qef.jpeg';
        $img1 = 'public/img/zzj5YBuhaL9bA6hra9LXvxIs4qAdndRP5tFZamL9.jpeg';
        $img2 = '3qHU62Y2Z0vEbOWex8mslLtOgDvkCpWYt1mt3qef.jpeg';
        Storage::delete($img1);
        $lists = Db::table('slider')
            ->paginate(6);
        return view('admin.sys.slider.index',[
            'data' => $lists
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $rules = [
            'title' => 'required',
            'order' => 'required',
            'img'   => 'required'
        ];
        $messages = [
            'title.required' => '请输入title',
            'order.required' => '请输入排序数字',
            'img.required'   => '请上传图片',
        ];
        $validator = Validator::make($data, $rules, $messages);
        if ($validator->fails()) {
            return ['code' => 2, 'msg' => $validator->getMessageBag()->getMessages()];
        }
        $path = $request->file('img')->store('public/img');
        $result = DB::table('slider')
            ->insert([
                'img'     => Storage::url($path),
                'realimg' => $path,
                'order'   => $data['order'],
                'title'   => $data['title'],
                'href'    => $data['href'],
            ]);
        if ($result) {
            $re = ['code' => 1, 'msg' => '添加成功！'];
            return redirect('/admin/sys/sliderlist');
        } else {
            return  $re = ['code' => 0, 'msg' => '添加失败！'];
        }

        //return $re;
    }

    public function upload(Request $request)
    {
        $path = $request->file('file')->store('public/img');
        $path = Storage::url($path);

        return json_encode(['code' => 0, 'msg' => $path]);
    }

    public function del ($id)
    {
        $realimg = Db::table('slider')
            ->where([
                ['id','=',$id]
            ])
            ->value('realimg');
        if (Db::table('slider')->where([['id' ,'=', $id]])->delete()) {
            Storage::delete($realimg);
            //Storage::delete(['file1.jpg', 'file2.jpg']);
            $re = ['code' =>1, 'msg' => '删除成功'];
        } else {
            $re = ['code' =>0, 'msg' => '删除失败'];
        }
        return $re;
    }

    public function uploado(Request $request)
    {
        if ($request->isMethod('POST')) {
            $file = $request->file('source');
            //文件是否上传成功
            if ($file->isValid()) {
                //原文件名
                $OriginalName = $file->getClientOriginalName();
                //扩展名
                $ext = $file->getClientOriginalExtension();
                //文件类型
                $type = $file->getClientMimeType();
                //临时绝对路径
                $realPath = $file->getRealPath();

                $filename = date('Y-m-d-H-i-s') . '_' . uniqid() . '.' . $ext;
                $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
                var_dump($bool);
            }
            dd($file);
            exit();
        }
        return view('student/upload');
    }
}
