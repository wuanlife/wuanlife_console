<?php
namespace app\index\model;
use think\Model;
use think\DB;

class User extends Model
{
    public function get_user(){
        $start = date('Y-m-').'01 00:00:00';
        $end = date('Y-m-t').' 23:59:59';
        $rs= \think\Db::name('user_base')
            ->join('post_detail','user_base.id = post_detail.user_base_id AND post_detail.create_time >= :start AND post_detail.create_time <= :end AND post_detail.floor = 1','LEFT')
            ->field('id AS user_id,nickname AS user_name,email AS user_email,COUNT(post_base_id) AS num')
            ->bind(['start'=>$start,'end'=>$end])
            ->group('user_base.id')
            ->order('num DESC,id DESC')
            ->paginate(10);
        return $rs;
    }
    public function re_psw($data)
    {
        $sql = 'update user_base set password = :password where id = :id ';
        $parms = ['password'=>$data['password'],'id'=>$data['user_id']];

        return Db::query($sql,$parms);
    }

    public function login($data)
    {
        $sql = 'SELECT authorization AS auth,id '
            .'FROM user_detail '
            .'JOIN user_base ON user_base.id = user_detail.user_base_id '
            .'WHERE email = :email '
            .'AND password = :password ';
        $parms = ['password'=>$data['password'],'email'=>$data['email']];

        return Db::query($sql,$parms);
    }


}
