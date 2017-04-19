<?php
namespace app\index\controller;


/*
 *
 *  此表为管理员添加操作代码    陈超  2017-4-16
 *
 */

class Super extends Base
{
    // 管理员默认列表
    public function lst()
    {
        // 联合查询，获取管理员列表
    	$adminres= \think\Db::name('user_base')->alias('a')->join('user_detail c','c.user_base_id = a.id','LEFT')->field('a.id,a.nickname,a.email,a.regtime,c.authorization')->where('authorization','eq',02)->paginate(10);
        // 结果数据传送到模板
    	$this->assign('adminres',$adminres);
        return $this->fetch();
    }

    // 添加新管理员
    public function add()
    {
        //如果有提交信息，而执行添加管理员
    	if(request()->isPost()){
            // 获取昵称
    		$data=[
    			'nickname'=>input('nickname'),
    		];
            // 查询昵称是否存在
            $user = \think\Db::name('user_base')->where('nickname','=',$data['nickname'])->find();
            // 如果存在执行添加
    		if($user){
                // 获取添加管理员结果
	    		$db= \think\Db::name('user_detail')->where('user_base_id','eq',$user['id'])->update(['authorization'=>'02']);
	    		if($db){
	    			return $this->success('添加管理员成功！','lst');
	    		}else{
	    			return $this->error('添加管理员失败，该用户已经是管理员！');
	    		}
    		}else{
    			return $this->error('该会员昵称不存在！');
    		}
    		return;
    	}
        return $this->fetch();
    }

    // 降级管理员为普通会员
    public function del(){
    	if(input('id')){
            // 获取要降级的管理员ID,并添加要修改结果，01为普通会员，02为管理员，03为超级管理员
            $data=[
                'user_base_id'=>input('id'),
                'authorization'=>'01',
            ];
            // 如果执行成功，返回操作结果
        	if($db=\think\Db::name('user_detail')->update($data)){
        		return $this->success('辞退管理员成功！','lst');
        	}else{
        		return $this->error('辞退管理员失败！');
        	}
        }
    }













}
