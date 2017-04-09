<?php
namespace app\index\model;
use think\Model;
use think\DB;

class Group extends Model
{
	public function get_group($pn){
		echo "345";

        $all_num = Db::table('group_base')->count();
        $page_num     = 15;                                       //每页条数
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

        $sql = 'select id,name,private from group_base '
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
}