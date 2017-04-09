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
		
		$this->assign('all_num',$list['all_num']);
		$this->assign('pn',$list['pn']);
		$this->assign('page_count',$list['page_count']);
		$this->assign('list',$list['group']);
		return $this->fetch('get_group');
	}
}