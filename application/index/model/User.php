<?php
namespace app\index\model;
use think\Model;
use think\DB;

class User extends Model
{
    public function get_user($pn){
        $all_num = Db::table('user_base')->count();
        $page_num     = 16;                                       //每页条数
        $pageCount =ceil($all_num/$page_num);                //总页数
        if ($pageCount == 0){
            $pageCount =1;
        }
        if($pn > $pageCount){
            $pn = $pageCount;
        }
        $pn         =empty($pn)?1:$pn;                    //当前页数
        $pn         =(int)$pn;                              //安全强制转换
        $limit_st     =($pn-1)*$page_num;                     //起始数
        $start = date('Y-m-').'01 00:00:00';
        $end = date('Y-m-t').' 23:59:59';
        $sql = 'SELECT id AS user_id,nickname AS user_name,	email AS user_email,COUNT(post_base_id) as num '
            .'FROM user_base '
            .'LEFT JOIN post_detail ON user_base.id = post_detail.user_base_id '
            ."AND post_detail.create_time >= :start "
            ."AND post_detail.create_time <= :end "
            .'AND post_detail.floor = 1 '
            .'GROUP BY user_id '
            .'ORDER BY num DESC,id DESC '
            .'LIMIT :limit_st,:page_num';
        $parms = ['start'=>$start,'end'=>$end,'limit_st'=>$limit_st,'page_num'=>$page_num];
        $rs = [
            'all_num' => $all_num,
            'pn'      => $pn,
            'user'    => Db::query($sql,$parms),
            'page_count' => $pageCount
        ];
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
