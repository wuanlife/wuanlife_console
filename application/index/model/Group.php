<?php
namespace app\index\model;
use think\Model;
use think\DB;

class Group extends Model
{
	public function get_group($pn){

        $all_num = Db::table('group_base')->count();
        $page_num     = 10;                                       //每页条数
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

        $sql = 'select gb.id gid,gb.name gname,gb.private private,ub.id uid,ub.nickname uname from group_base gb,group_detail gd,user_base ub where gb.id=gd.group_base_id and gd.user_base_id=ub.id and gd.authorization=01 '
         .'LIMIT :limit_st,:page_num';
        $parms = ['limit_st'=>$limit_st,'page_num'=>$page_num];
        
        $rs = [
            'all_num' => $all_num,
            'pn'      => $pn,
            'group'    => Db::query($sql,$parms),
            'page_count' => $pageCount
        ];
        return $rs;
    }
    public function search_group($s)
    {
    	//echo "Model is run <br />";
        
    	$sql ="SELECT gb.id gid,gb.name gname,gb.private private,ub.id uid,ub.nickname uname from group_base gb,group_detail gd,user_base ub where gb.id=gd.group_base_id and gd.user_base_id=ub.id and gd.authorization=01 and gb.name = '{$s}'";
    	
    	$rs = [
            'all_num' => 1,
            'pn'      => 1,
            'group'    => Db::query($sql),
            'page_count' => 1
        ];
        return $rs;
    }
    public function update_gname($gid,$new_gname)
    {
        $sql = "UPDATE group_base set name = '{$new_gname}' where id = {$gid}";
        Db::query($sql);
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
        $sql1 = "update group_detail set authorization ='01' where group_base_id = {$gid} and user_base_id = {$new_uid}";
        $sql2 = "update group_detail set authorization ='03' where group_base_id = {$gid} and user_base_id = {$old_uid}";
        Db::query($sql2);
        Db::query($sql1);

    }

}