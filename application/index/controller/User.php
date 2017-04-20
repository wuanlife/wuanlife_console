<?php
namespace app\index\controller;

use app\index\model\User as UserModel;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class User extends Controller
{
    // 获取用户数据列表并输出
    public function __construct(Request $request)
    {
        parent::__construct($request);
		if(empty(Session::get()))
		{
            if($request->controller()!='user'&&$request->action()!='index'&&$request->action()!='login')
            {
                $this->error('请先登录系统！',url('User/index'));
            }
		}
    }


    public function index()
	{
        Session::clear();
	    return $this->fetch('index');
	}

	public function login()
	{
		$user=new UserModel();
		$data['email'] = Request::instance()->get('email');
		$data['password'] = md5(Request::instance()->get('password'));
		$re = $user->login($data);
        //print_r($re);exit;
        if(!empty($re)){
            $rs = $re[0];
            if(in_array($rs['auth'],['02','03'])) {
				Session::set('auth', $rs['auth']);
				Session::set('id', $rs['id']);
                echo '登录成功';
			}else{
                echo '您不是管理员';
            }

        }else{
            echo '邮箱或者密码错误！';
        }

	}

	public function get_user()
	{
		$user=new UserModel();
		$pn = Request::instance()->get('pn');
		$list = $user->get_user();
		$this->assign('list',$list);
		return $this->fetch('user');
	}

	public function re_psw()
	{
		$data['user_id'] = Request::instance()->get('user_id'); // 获取某个get变量
        if(empty($data['user_id'])){
            echo '重置密码失败';
        }
		$data['password'] = md5('123456');
		$user_model = new UserModel();
		$user_model->re_psw($data);
        echo $data['user_id'];
        //echo '重置密码为123456成功';
	}
}