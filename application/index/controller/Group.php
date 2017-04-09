<?php 
namespace app\index\controller;

use app\index\model\Group as GroupModel;
use think\Controller;
use think\Request;
use think\Session;

class Group extends Controller
{
    // 获取用户数据列表并输出
    public function __construct(Request $request)
    {
        parent::__construct($request);
        // if(empty($_GET)&&empty(Session::get()))
        // {
        //     echo $this->fetch('index');exit;
        // }
    }

	 public function get_group()
	{
		$group = new GroupModel();
		$pn = Request::instance()->get('pn');
		$list = $group->get_group($pn);
		echo "$pn";
		$this->assign('all_num',$list['all_num']);
		$this->assign('pn',$list['pn']);
		$this->assign('page_count',$list['page_count']);
		$this->assign('list',$list['group']);
		return $this->fetch('get_group');
	}

	public function search_group()
	{
		$g = new GroupModel();
		$gname = Request::instance()->get('gname');
		$list = $g->search_group($gname);
		//print_r($gname);
		//返回星球名称对应的id、主人、是否私密
		//
		
		$this->assign('all_num',$list['all_num']);
		$this->assign('pn',$list['pn']);
		$this->assign('page_count',$list['page_count']);
		$this->assign('list',$list['group']);
		return $this->fetch('get_group');
	}

	public function rename()
	{

	}
}