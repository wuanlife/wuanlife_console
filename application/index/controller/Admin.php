<?php
/*
 *
 *  此表为做管理任务临时添加表，用来显示管理员列表，陈超  2017-4-16
 *
 */


namespace app\index\controller;


class Admin extends Base
{
    public function lst()
    {
    	$adminres= \think\Db::name('user_base')->paginate(10);
    	$this->assign('adminres',$adminres);
        return $this->fetch();
    }

    public function add()
    {
    	if(request()->isPost()){
    		$data=[
    			'email'=>input('email'),
    			'password'=>md5(input('password')),
    		];
    		$validate = \think\Loader::validate('Admin');
    		if($validate->check($data)){
	    		$db= \think\Db::name('admin')->insert($data);
	    		if($db){
	    			return $this->success('添加管理员成功！','lst');
	    		}else{
	    			return $this->error('添加管理员失败！');
	    		}
    		}else{
    			return $this->error($validate->getError());
    		}
    		return;
    	}
        return $this->fetch();
    }

    public function edit(){
        $id=input('id');
    	if(request()->isPost()){
            $userinfo=\think\Db::name('admin')->find($id);
            $password=$userinfo['password'];
    		$data=[
    			'id'=>input('id'),
    			'username'=>input('username'),
    			'password'=>input('password') ? md5(input('password')) : $password,
    		];
    		$validate = \think\Loader::validate('Admin');
    		if($validate->scene('edit')->check($data)){
    			if($db=\think\Db::name('admin')->update($data)){
    			return $this->success('修改管理员成功！','lst');
	    		}else{
	    			return $this->error('修改管理员失败！');
				}
    		}else{
    			return $this->error($validate->getError());
    		}
    		

    		return;
    	}
    	$admins=db('admin')->find($id);
    	$this->assign('admins',$admins);
    	return $this->fetch();

    }

    public function del(){
    	$id=input('id');
        if($id==1){
            return $this->error('初始化管理员不允许删除！');
        }
    	if(db('admin')->delete($id)){
    		return $this->success('删除管理员成功！','lst');
    	}else{
    		return $this->error('删除管理员失败！');
    	}
    }













}
