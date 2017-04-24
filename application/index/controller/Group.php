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
		// if(empty(Session::get()))
		// {
		// 	if($request->controller()!='user'&&$request->action()!='index'&&$request->action()!='login')
		// 	{
		// 		$this->error('请先登录系统！',url('User/index'));
		// 	}
		// }
    }

	 public function get_group()
	{
		$group = new GroupModel();
		$pn = Request::instance()->get('pn');
		$list = $group->get_group($pn);
		//echo "$pn";
		$this->assign('all_num',$list['all_num']);
		$this->assign('pn',$list['pn']);
		$this->assign('page_count',$list['page_count']);
		$this->assign('list',$list['group']);
		return $this->fetch('group');
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
		return $this->fetch('group');
	}

	/*
	*change_gname1跳转页面
	*change_gname2改变星球名
	*/
	public function change_gname1()
	{
		//echo "112233";
		$g = new GroupModel();
		$gname = Request::instance()->get('new_gname');
		$list = $g->search_group($gname);
		$this->assign('list',$list);

		return $this->fetch('change_gname');
	}

	public function change_gname2()
	{
		//用星球名查找。如果存在显示错误，假如不存在，更新星球名
		$g = new GroupModel();
		$new_gname = Request::instance()->get('new_gname');
		$gid = Request::instance()->get('gid');
		//$gid =1;
		// echo "$new_gname";
		// echo "$gid";
		$rs = $g->search_group($new_gname);

		 if (isset($rs['group'][0]['gname'])) {
		 	if($new_gname == $rs['group'][0]['gname'])
			{
				echo "<script language=javascript>alert('和原星球名一致，请重新输入！');history.back();</script>";
			}
			else
			{
				echo "<script language=javascript>alert('星球已存在');history.back();</script>";
			}
		 }
		 else
		 {
		 	$update = $g->update_gname($gid,$new_gname);
		 	echo "更改成功";
		 	echo "<a href = 'http://127.0.0.1/wuanlife_console/public/index.php/group/get_group'>back</a>";
		 }
	}


/*
*
*更改星球主人change_uname1跳转页面change_gname2更改
**/
	public function change_uname1()
	{
		//echo "112233";
		$g = new GroupModel();
		$gname = Request::instance()->get('gname');
		//echo "$gname";
		$list = $g->search_group($gname);
		$this->assign('list',$list);

		 return $this->fetch('change_uname');
	}

	public function change_uname2()
	{
		//用星球名查找。如果存在 显示错误，假如不存在，更新星球名
		$g = new GroupModel();

		$new_uname = Request::instance()->get('new_uname'); //新主人名
		$gid = Request::instance()->get('gid');				//星球id
		$old_uid = Request::instance()->get('old_uid');		//旧主人id
		//echo "新主人名 : $new_uname"."<br />"."星球id : $gid"."<br />"."旧主人id : $old_uid"."<br />";

		//$urs = $g->search_alluser_info($gid);
		$urs = $g->search_user_info($gid,$new_uname);
		if(empty($urs[0]['uid']))
		{
			echo "输入不正确";
		}
		else
		{
			$new_uid = $urs[0]['uid'];
		//echo "$new_uid";
			$g->update_user_authorization($gid,$new_uid,$old_uid);
			echo "更改成功";
			echo "<a href = 'http://127.0.0.1/wuanlife_console/public/index.php/group/get_group'>back</a>";
		}
		// if (isset($rs['glist'][0])) 
		// {
		// 	//
		// }
		// else
		// {

		// }
		//$gid =1;
		// echo "$new_gname";
		// echo "$gid";
		//$list = $g->search_group_info($gid);
		//print_r($list);
	}
}