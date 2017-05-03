<?php
namespace app\index\controller;

use app\index\model\User as UserModel;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\Url;

class User extends Controller
{
    // 获取用户数据列表并输出
    /**
     * User constructor.
     * @param Request $request
     */
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
				//Session::set('id', $rs['id']);
				Session::set('nickname', $rs['nickname']);
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
		$data['user_id'] = input('user_id'); // 获取某个get变量
        if(empty($data['user_id'])){
            //$this->error('重置密码失败！');
			echo '重置密码失败！';
        }else{
			$data['password'] = md5('123456');
			$user_model = new UserModel();
			$user_model->re_psw($data);
            //$this->success('重置密码为123456成功！');
			echo '重置密码为123456成功！';
		}

	}
}