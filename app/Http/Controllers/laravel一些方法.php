<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class laravel一些方法 extends Controller
{
    public function articleList(Request $request)
    {
        $data = $request->all();
        $db = DB::table('article as a')
            ->join('type as b','a.type','=','b.id')
            ->select([
                'a.id','a.title','a.content','a.status',DB::raw("FROM_UNIXTIME(createtime,'%Y-%m-%d %H:%i:%s') as date"),'a.imgurl','a.recom','b.name'
            ]);
        if(!empty($data['startTime'])){
            $db->where('createtime','>=',strtotime($data['startTime']));
        }
        if(!empty($data['endTime'])){
            $db->where('createtime','<=',strtotime($data['endTime']));
        }
        if(!empty($data['title'])){
            $db->where('title','=',$data['title']);
        }
        $lists = $db->get();
        return view('admin.article.article_list',[
            'lists' => $lists,
            'startTime' => !empty($data['startTime'])?$data['startTime']:'',
            'endTime' => !empty($data['endTime'])?$data['endTime']:'',
            'title' => !empty($data['title'])?$data['title']:'',
        ]);
    }

    function tt()
    {
        $size= (int)$request->size;
        $page= (int)$request->page;
        if(empty($page)) $page =1;
        if(empty($size)) $size =10;
        $ofsset = $size * ($page -1);
// var_dump($name);
        $threatlistmodel = new ThreatList();

        $total = $threatlistmodel->where(function($query) use ($data){
            $data['name'] && $query->where("name","like","%".$data['name']."%");
            isset($data['level']) && $query->where("level",$data['level']);
            isset($data['is_tb']) && $query->where("is_tb",$data['is_tb']);
            $data['end_at'] && $query->where("find_at","<=",$data['end_at'].' 23:59:59');
            $data['start_at'] && $query->where("find_at","=>",$data['start_at'].' 00:00:01');
            $query->where("is_state",1);
        })->count();
//var_dump($total);
        $list = $threatlistmodel->where(function($query) use ($data){
            $data['name'] && $query->where("name","like","%".$data['name']."%");
            isset($data['level']) && $query->where("level",$data['level']);
            isset($data['is_tb']) && $query->where("is_tb",$data['is_tb']);
            $data['end_at'] && $query->where("find_at","<=",$data['end_at'].' 23:59:59');
            $data['start_at'] && $query->where("find_at",">=",$data['start_at'].' 00:00:01');
            $query->where("is_state",1);
        })->orderBy("id","desc")->offset($ofsset)->limit($size)->get()->each(function($item){
            $con_info = json_decode(unserialize($item->count_con),true);
            $item['ip_count'] = $con_info["total"];
            unset($item->count_con);

        });
    }
}
