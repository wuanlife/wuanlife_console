<?php
namespace app\index\model;
use think\Model;
use think\DB;

class Post extends Model{


	public function get_post($pn){
		$post=Db::table('post_base')
		->join('post_detail','post_base.id=post_detail.post_base_id')
		->where('floor',1)
		->order('create_time desc')
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
    public function search_post($pname){
		$post=Db::table('post_base')
		->join('post_detail','post_base.id=post_detail.post_base_id')
		->where('floor',1)
		->where('title','like',"%$pname%")
		->order('create_time desc')
		->paginate(10,false,[
			'query' => array('pname'=>$pname),
		]);
        return $post;

    }

}