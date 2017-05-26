<?php
namespace app\index\model;
use think\db\Query;
use think\Model;
use think\DB;

class Group extends Model
{
	public function get_group($page){
        $rs = Db::name('group_base gb')
            ->join('group_detail gd','gb.id = gd.group_base_id AND gd.authorization = 01')
            ->join('user_base ub','gd.user_base_id = user_base.id')
            ->field('gb.id AS gid,gb.name AS gname,gb.private,ub.id AS uid,ub.nickname AS uname')
            ->paginate(10,false,[
                'page'=>$page,
                'path'=>url('get_group','',false)."/page/[PAGE].html",
            ]);
        return $rs;
    }
    public function get_group_member($gid)
    {
        $rs = Db::name('user_base ub')
            ->join('group_detail gd','gd.group_base_id = :gid AND gd.user_base_id = ub.id')
            ->bind(['gid'=>"$gid"])
            ->field('ub.id uid,ub.nickname uname,gd.authorization')
            //->select();
            ->paginate(10);
        return $rs;
    }
    public function search_group_full($s)
    {
        $rs = Db::name('group_base gb')
            ->join('group_detail gd','gb.id = gd.group_base_id AND gd.authorization = 01')
            ->join('user_base ub','gd.user_base_id = ub.id AND gb.name LIKE :gname')
            ->field('gb.id AS gid,gb.name AS gname,gb.private,ub.id AS uid,ub.nickname AS uname')
            ->bind(['gname'=>"$s"])
            ->paginate(10);
        return $rs;
    }
    public function search_group($s)
    {
        $rs = Db::name('group_base gb')
            ->join('group_detail gd','gb.id = gd.group_base_id AND gd.authorization = 01')
            ->join('user_base ub','gd.user_base_id = ub.id AND gb.name LIKE :gname')
            ->field('gb.id AS gid,gb.name AS gname,gb.private,ub.id AS uid,ub.nickname AS uname')
            ->bind(['gname'=>"%$s%"])
            ->paginate(10,false,[
                'query' => array('gname'=>$s),

            ]);
        return $rs;
    }
    public function update_gname($gid,$new_gname)
    {
        // $sql = "UPDATE group_base set name = '{$new_gname}' where id = {$gid}";
        // Db::query($sql);
        Db::table('group_base')
            ->where('id',$gid)
            ->update([
                'name'  => $new_gname,
            ]);

    }

    public function search_group_info($gid)
    {
        $sql = " SELECT * FROM `group_detail` WHERE group_base_id = {$gid}";
        $rs = [
            'gid' => $gid,
            'glist'    => Db::query($sql),
        ];
        return $rs;
    }
    public function search_alluser_info($gid)
    {
        $sql0 = "SELECT gb.id gid,gb.name gname,gb.private private,ub.id uid,ub.nickname uname, gd.authorization authorization from group_base gb,group_detail gd,user_base ub where gb.id=gd.group_base_id and gd.user_base_id=ub.id and gb.id = $gid ";
        //$sql = " SELECT * FROM `group_detail` WHERE group_base_id ={$gid} where user_base_id = {$uid}";
        //$rs = array();
        // echo "$gid";
        // echo "$new_uname";
        $rs = Db::query($sql0);
        return $rs;
    }
    public function search_user_info($gid,$new_uname)
    {
        $sql0 = "SELECT gb.id gid,gb.name gname,gb.private private,ub.id uid,ub.nickname uname, gd.authorization authorization from group_base gb,group_detail gd,user_base ub where gb.id=gd.group_base_id and gd.user_base_id=ub.id and gb.id = $gid and ub.nickname = '{$new_uname}' ";
        //$sql = " SELECT * FROM `group_detail` WHERE group_base_id ={$gid} where user_base_id = {$uid}";
        //$rs = array();
        // echo "$gid";
        // echo "$new_uname";
        return Db::query($sql0);
    }
    public function update_user_authorization($gid,$new_uid,$old_uid)
    {
        Db::table('group_detail')
            ->where('group_base_id',$gid)
            ->where('user_base_id',$new_uid)
            ->update([
                'authorization'  => '01',
            ]);
        Db::table('group_detail')
            ->where('group_base_id',$gid)
            ->where('user_base_id',$old_uid)
            ->update([
                'authorization'  => '03',
            ]);
//        $sql1 = "update group_detail set authorization ='01' where group_base_id = {$gid} and user_base_id = {$new_uid}";
//        $sql2 = "update group_detail set authorization ='03' where group_base_id = {$gid} and user_base_id = {$old_uid}";
//        Db::query($sql2);
//        Db::query($sql1);

    }
    public function test()
    {
//        $rs = \think\Db::view('group_base','id AS gid,name AS gname,private')
//            ->view('group_detail','authorization','group_base.id = group_detail.group_base_id AND group_detail.authorization = 01')
//            ->view('user_base','id AS uid,nickname AS uname','group_detail.user_base_id = user_base.id')
//            //->select();//
//            ->paginate(10);
//
//        Db::listen(function($sql,$time,$explain){
//            // 记录SQL
//            echo $sql. ' ['.$time.'s]';
//            // 查看性能分析结果
//            dump($explain);
//        });
//        $rs = Db::name('group_base')
//            ->join('group_detail','group_base.id = group_detail.group_base_id AND group_detail.authorization = 01')
//            ->join('user_base','group_detail.user_base_id = user_base.id')
//            ->field('group_base.id AS gid,group_base.name AS gname,private,user_base.id AS uid,user_base.nickname AS uname')
//            ->paginate(10);
        $rs = Db::name('group_base gb')
            ->join('group_detail gd','gb.id = gd.group_base_id AND gd.authorization = 01')
            ->join('user_base ub','gd.user_base_id = user_base.id')
            ->field('gb.id AS gid,gb.name AS gname,gb.private,ub.id AS uid,ub.nickname AS uname')
            ->paginate(10);
        return $rs;
    }

}