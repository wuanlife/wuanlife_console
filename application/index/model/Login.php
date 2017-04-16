<?php
namespace app\index\model;

use think\Model;

/*
 *
 *
 *  为写任务5，临时创建控制器，验证登陆 陈超 2017-4-16
 *
 */

class Login extends Model
{
    public function login($Email,$password){
    	$admin= \think\Db::name('user_base')->where('Email','=',$Email)->find();
    	if($admin){
    		if($admin['password']==md5($password)){
    			\think\Session::set('id',$admin['id']);
    			\think\Session::set('Email',$admin['Email']);
                $detail = \think\Db::name('user_detail')->where('user_base_id','eq',$admin['id'])->find();
                if($detail['authorization'] == '03'){
                    \think\Session::set('authorization',$detail['authorization']);
                    return 1;
                }else{
                    return 4;
                }
    		}else{
    			return 2;
    		}

    	}else{
    		return 3;
    	}
    }
}
