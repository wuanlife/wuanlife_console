<?php
namespace app\index\controller;
use think\Controller;

/*
 *
 *
 *	为写任务5，临时创建控制器，验证登陆 陈超 2017-4-16
 *
 */


class Base extends Controller
{
    public function _initialize()
    {
        if(!session('id')){
             $this->error('请先登录系统！',url('User/index'));
        }
    }
    


    













}
