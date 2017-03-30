<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Post as PostModel;

class Post extends Controller
{
	public function get_post(){
		$post=new PostModel();
	    $list = $post->get_post();
	  //  print_r($list);
	    $this->assign('list',$list);
	    return $this->fetch('index');
	}
}