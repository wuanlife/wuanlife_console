<?php
namespace app\index\model;
use think\Model;
use think\DB;

class Post extends Model{


	public function get_post($pn){
		$page=5;
		$start=($pn-1)*$page;
		$post=Db::table('post_base')
		->join('post_detail','post_base.id=post_detail.post_base_id')
		->where('floor',1)
		->order('create_time desc')
		->limit($start,$page)
		->paginate(10);
		return $post;
	}

	public function pn_num(){
		$page=5;
		$post=Db::table('post_base')
		->select();
		$pn_num=ceil(count($post)/$page);
		return $pn_num;
	}


}