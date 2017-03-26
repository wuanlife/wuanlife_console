<?php
namespace app\index\controller;

use app\index\model\User as UserModel;
use think\Controller;

class User extends Controller
{
    // 获取用户数据列表并输出
	public function index()
	{
	    // 分页输出列表 每页显示5条数据
	    $list = UserModel::paginate(5);
	    $this->assign('list',$list);
	    return $this->fetch();
	}
}