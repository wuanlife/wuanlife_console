<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Post as PostModel;

class Post extends Controller
{
	public function get_post($pn=null){
		if ($pn==null) {
			$pn=1;
		}
		$post=new PostModel();
	    $list = $post->get_post($pn);
	    $pnNum=$post->pn_num();
	    $this->assign('list',$list);
	    $this->assign('pnNum',$pnNum);
	    return $this->fetch('index');
	}

	public function search_post($p_title=null){
		$post=new PostModel();
		$list=$post->search_post($p_title);
	}




}