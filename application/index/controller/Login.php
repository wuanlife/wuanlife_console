<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Login as Log;

/*
 *
 *
 *  为写任务5，临时创建控制器，验证登陆 陈超 2017-4-16
 *
 */

class Login extends Controller
{
    public function index()
    {

        if(request()->isPost()){
            $login=new Log;
            $status=$login->login(input('email'),input('password'));
            if($status==1){
                return $this->success('登录成功，正在跳转！','Index/Super/lst');
            }elseif($status==2){
                return $this->error('账号或者密码错误!');
            }elseif($status==4){
                return $this->error('您的权限不够，请用超级管理员账号登陆！');
            }else{
                 return $this->error('用户不存在!');
            }
        }
        return $this->fetch('login');
    }

    public function logout(){
        session(null);
        return $this->success('退出成功！',url('index'));
    }


    













}
