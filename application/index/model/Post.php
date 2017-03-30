<?php
namespace app\index\model;
use think\Model;
use think\DB;

class Post extends Model{
	public function get_post(){
		$post=Db::table('post_base')
		->join('post_detail','post_base.id=post_detail.post_base_id')
		->where('floor',1)
		->order('create_time desc')
		->select();
		return $post;
	}

}