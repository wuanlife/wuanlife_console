<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Index extends Controller
{

    public function index()
    {
        $list = $this->get_user_data();
        $this->assign('list',$list);
        return $this->fetch('user');
    }

    public function get_user_data(){
        $start = date('Y-m-').'01 00:00:00';
        $end = date('Y-m-t').' 23:59:59';
        $rs= \think\Db::name('user_base')
            ->join('post_detail','user_base.id = post_detail.user_base_id AND post_detail.createTime >= :start AND post_detail.createTime <= :end AND post_detail.floor = 1','LEFT')
            ->field('id AS user_id,nickname AS user_name,Email AS user_email,COUNT(post_base_id) AS num')
            ->bind(['start'=>$start,'end'=>$end])
            ->group('user_base.id')
            ->order('num DESC,id DESC')
            ->paginate(30);
        return $rs;
    }

}
