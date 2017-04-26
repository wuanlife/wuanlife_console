<?php 
namespace app\index\controller;

use app\index\model\Group as GroupModel;
use think\Controller;
use think\Request;
use think\Session;
use think\Model;

class Group extends Controller
{
    // 获取用户数据列表并输出
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $value = Session::get();
        if(empty($value))
        {
		 	if($request->controller()!='user'&&$request->action()!='index'&&$request->action()!='login')
		 	{
		 		$this->error('请先登录系统！',url('User/index'));
		 	}
		 }
    }

	 public function get_group()
	{
        $g = new GroupModel();
        $page = input('page');
        $rs = $g->get_group($page);
        $this->assign('page',$page);
        $this->assign('list',$rs);
        return $this->fetch('group');
	}

	public function search_group()
	{
		$g = new GroupModel();
		$gname = input('gname');
        $page = input('page');
		$list = $g->search_group($gname);
        $this->assign('list',$list);
        $this->assign('page',$page);
        return $this->fetch('group');
	}

	/*
	*change_gname1跳转页面
	*change_gname2改变星球名
	*/
	public function change_gname1()
	{
		$g = new GroupModel();
		$gname = input('new_gname');
        $page = input('pn');
		$list = $g->search_group_full($gname);
		$this->assign('list',$list);
        $this->assign('page',$page);
		return $this->fetch('change_gname');
	}

	public function change_gname2()
	{
		//用星球名查找。如果存在显示错误，假如不存在，更新星球名
		$g = new GroupModel();
		$new_gname = input('new_gname');
        $old_gname = input('old_gname');
        $page = input('pn');
		$gid = input('gid');
		$rs = $g->search_group_full($new_gname);
        //var_dump($rs->isEmpty());exit;
		 if ($rs->isEmpty()) {
             $update = $g->update_gname($gid,$new_gname);
             $this->success('更改成功！','get_group?page='.$page);
		 }
		 else
		 {
             if($new_gname == $old_gname)
             {
                 echo "<script language=javascript>alert('和原星球名一致，请重新输入！');history.back();</script>";
             }
             else
             {
                 echo "<script language=javascript>alert('星球已存在');history.back();</script>";
             }
		 }
	}


/*
*
*更改星球主人change_uname1跳转页面change_gname2更改
**/
	public function change_uname1()
	{
		$g = new GroupModel();
		$gname = input('gname');
        $page = input('pn');
		$list = $g->search_group_full($gname);
        $member = $g->get_group_member($list[0]['gid']);
        $this->assign('list',$list);
        $this->assign('member',$member);
        $this->assign('page',$page);
        return $this->fetch('change_uname');
	}

	public function change_uname2()
	{
		//用星球名查找。如果存在 显示错误，假如不存在，更新星球名
		$g = new GroupModel();

		$new_uname = input('new_uname'); //新主人名
		$gid = input('gid');				//星球id
		$old_uid = input('old_uid');		//旧主人id
        $page = input('pn');
		$urs = $g->search_user_info($gid,$new_uname);
		if(empty($urs[0]['uid']))
		{
			$this->error('您输入的用户不是该星球的成员！');
		}
		else
		{
			$new_uid = $urs[0]['uid'];
			$g->update_user_authorization($gid,$new_uid,$old_uid);
			$this->success('修改星球主人成功！','get_group?page='.$page);
			}
	}
}