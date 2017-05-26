<?php
namespace app\index\model;
use think\Model;
use think\DB;

class User extends Model
{
    public function get_user(){
        $start = date('Y-m-d 00:00:00',strtotime('-1month'));
        $end = date('Y-m-d 23:59:59');
        $rs= Db::name('user_base')
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
//        $sql = 'update user_base set password = :password where id = :id ';
//        $parms = ['password'=>$data['password'],'id'=>$data['user_id']];
//        return Db::query($sql,$parms);
        return Db::table('user_base')
            ->where('id',$data['user_id'])
            ->setField('password', $data['password']);
    }

    public function login($data)
    {
        $sql = 'SELECT authorization AS auth,id,nickname '
            .'FROM user_detail '
            .'JOIN user_base ON user_base.id = user_detail.user_base_id '
            .'WHERE email = :email '
            .'AND password = :password ';
        $parms = ['password'=>$data['password'],'email'=>$data['email']];

        return Db::query($sql,$parms);
    }
    public function search_user($s)
    {
        $rs = Db::name('user_base')
            ->where('nickname LIKE :uname')
            ->field('id AS user_id,nickname AS user_name,email AS user_email,"-" AS num')
            ->bind(['uname'=>"%$s%"])
            ->paginate(10,false,[
                'query' => array('uname'=>$s),

            ]);
        return $rs;
    }


}
