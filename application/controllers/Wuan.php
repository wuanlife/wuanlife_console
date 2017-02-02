<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* 午安后台主控制器
*/
class Wuan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('wuan_model');
    }


    //登录
    public function login()
    {

        if(!isset($_SESSION))
        {
            session_start();
            session_destroy();
            //var_dump($_SESSION);
        }
        $this->load->view('wuan_console/login');
    }

    public function welcome()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        //登录过程
        //载入表单验证类
        $this->load->library('form_validation');

        //设置验证规则
        $this->form_validation->set_rules('adminname'.'用户名','required');
        $this->form_validation->set_rules('adminpwd','密码','required');
        //开始验证
        $status = $this->form_validation->run();
        if ($status)
        {
            $adminname = $this->input->post('adminname');
            $adminpwd  = $this->input->post('adminpwd');
            $data = $this->wuan_model->searchinfo("$adminname");

            if($data['uauth']=='01' || empty($data['uauth']))
            {
                $this->load->helper('form');
                echo '您不是管理员或用户未注册！';
                $this->load->view('wuan_console/login');
            }
            else
            {
                $login_id = $data['id'];

                $superadmin_md5 = $data['password'];

                $md5_pwd = md5($adminpwd);

                if($md5_pwd == $superadmin_md5)
                {
                        //验证成功
                        unset($data['password']);
                        $_SESSION['data'] =$data;
                        //$data['admin']= $this->wuan_model->insertdata();

                        $_SESSION['data']['status']='欢迎';
                        //var_dump($data);
                        $this->load->view('wuan_console/head',$_SESSION['data']);
                        $this->load->view('wuan_console/left',$_SESSION['data']);
                        $this->load->view('wuan_console/welcome');

                }
                else
                {
                    $this->load->helper('form');
                    echo '密码错误！';
                    $this->load->view('wuan_console/login');
                }
            }
        }else{
            echo '操作非法，您已被强制退出。';
            session_destroy();
            $this->load->view('wuan_console/login');
        }
    }

    public function adding()
    {
        //增加管理员
        if(!isset($_SESSION))
        {
            session_start();
        }
        if(!empty($_SESSION['data']['uauth'])&&$_SESSION['data']['uauth']=='03'){
            $nickname = $this->input->get('nickname');
            if(!empty($nickname)||$nickname==0)
            {
            //如果输入不为空

            //获取nickname对应的id
            $id = $this->wuan_model->search_id($nickname);


                if(empty($id)){
                    $data['msg'] = '该用户尚未注册，请检查！';
                }else{
                    $auth = $this->wuan_model->search_auth($id['id']);

                    if($auth['authorization'] == 1)
                    {
                        $this->wuan_model->change_auth($id['id']);
                        $data['msg'] = '添加成功！';
                    }else{
                        $data['msg'] = '该用户已是管理员，操作无效！';
                    }

                //echo "---";
                }
                    $data['admin']= $this->wuan_model->insertdata();

                    //$this->load->view('wuan_console/head',$_SESSION['data']);
                    //$this->load->view('wuan_console/left');


            }
            else{
                $data['msg'] = "用户名为空，请重新输入！";
                //$this->load->view('wuan_console/add');
            }
            $this->load->view('wuan_console/team_management',$data);
        }else{
            echo '操作非法，您已被强制退出。';
            session_destroy();
            $this->load->view('wuan_console/login');
        }
    }

    public function delete($item)
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        if(!empty($_SESSION['data']['uauth'])&&$_SESSION['data']['uauth']=='03'){
        $this->wuan_model->change_auth_user($item);
        $data['msg'] = '删除成功!';

        $data['admin']= $this->wuan_model->insertdata();
/*
        $this->load->view('wuan_console/head',$_SESSION['data']);
        $this->load->view('wuan_console/left');
*/      $this->load->view('wuan_console/team_management',$data);

        }else{
            echo '操作非法，您已被强制退出。';
            session_destroy();
            //$this->load->view('wuan_console/login');
        }

    }

    public function forrs($pn){
        $starid = $this->wuan_model->get_starid($pn);
        foreach ($starid['data'] as $key) {


            //获取星球id name 和介绍
            $info= $this->wuan_model->get_starinfo1($key['id']);

            //根据星球id获取管理员id
            $userid = $this->wuan_model->groupid_to_userid($key['id']);


            $owner = $this->wuan_model->get_login_admin_nickname($userid['user_base_id']);
            $data['starinfo'][$key['id']]['id'] = $info['id'];
            $data['starinfo'][$key['id']]['name'] = $info['name'];
            if ($info['delete'] == 0) {
                $data['starinfo'][$key['id']]['status'] = "正常";
            }else{
                $data['starinfo'][$key['id']]['status'] = "已隐藏";
            }
            if ($info['private'] == 0) {
                $data['starinfo'][$key['id']]['private'] = "";
            }else{
                $data['starinfo'][$key['id']]['private'] = "私密";
            }
            //$data['starinfo'][$key['id']]['status'] = $info['delete'];
            $data['starinfo'][$key['id']]['g_introduction'] = $info['g_introduction'];

            $data['starinfo'][$key['id']]['owner'] = $owner['nickname'];
            $data['starinfo'][$key['id']]['owner_id'] = $userid['user_base_id'];
        }

            if(!empty($data['starinfo'])){
            sort($data['starinfo']);
            }else{
                $data['starinfo']=array();
            }
            $data['pn'] = $pn;
            $data['pan'] = $starid['pan'];
        return $data;
    }
    public function star_management()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }

        //获取delete= 0 的星球id

        //print_r($starid);
        //for ($i=0; $i<count($starid); $i++) {
        $_SESSION['data']['status']='星球管理';
        if(!empty($_SESSION['data']['uauth'])&&in_array($_SESSION['data']['uauth'],array('02','03')))
        {
            $data = $this->forrs(1);
            $this->load->view('wuan_console/head',$_SESSION['data']);
            $this->load->view('wuan_console/left');
            $this->load->view('wuan_console/star_management',$data);
        }
        else{
            echo '操作非法，您已被强制退出。';
            session_destroy();
            $this->load->view('wuan_console/login');
        }

    }

    public function team_management()
    {
        if(!isset($_SESSION))
        {
            session_start();
        }
        $_SESSION['data']['status']='成员管理';
        if(!empty($_SESSION['data']['uauth'])&&$_SESSION['data']['uauth']=='03'){
            $data['admin']= $this->wuan_model->insertdata();
            $this->load->view('wuan_console/head',$_SESSION['data']);
            $this->load->view('wuan_console/left');
            $this->load->view('wuan_console/team_management',$data);
        }else{
            echo '操作非法，您已被强制退出。';
            session_destroy();
            $this->load->view('wuan_console/login');
        }

    }


    //星球名修改 @author 阿萌
    public function star_name_upd($id){
        if(!isset($_SESSION))
        {
            session_start();
        }
        if(!empty($_SESSION['data']['uauth'])&&in_array($_SESSION['data']['uauth'],array('02','03'))){
            $data['starinfo'] = $this->wuan_model->get_starinfo1($id);
            $data['pn'] = $this->input->get('pn');
            $this->load->view('wuan_console/star_name_upd',$data);
        }else{
            echo '操作非法，您已被强制退出。';
            session_destroy();
            $this->load->view('wuan_console/login');
        }
    }

    public function change_page(){
        $status = $this->input->get('note');
        $pn = $this->input->get('pn');
        if($status==' '){
            ++$pn;
        }elseif($status=='-'){
            --$pn;
        }
        //var_dump($status);
        $data = $this->forrs($pn);
        if($data['pn']>=$data['pan']){
            $data['pn']=$data['pan'];
        }
        $this->load->view('wuan_console/star_management',$data);
    }

    public function star_name_upding($id){

        $status = $this->input->get('starname');
        $pn = $this->input->get('pn');

        if($status||$status==0)
        {
            $nickname=$this->wuan_model->get_starinfo1($id)['name'];
            if($nickname==$status){
                $data = $this->forrs($pn);
            $data['ms'] = '未作任何修改！';
            $this->load->view('wuan_console/star_management',$data);
            }else{
            if($this->wuan_model->check_star_name_equal($status)>0){
                var_dump($nickname);
                echo '星球名重复了，请重新输入！';
                $this->star_name_upd($id);
            }
            else{
            $this->wuan_model->upd_star_name($id,$status);
            //$this->load->view('wuan_console/star_management',$data);
            //redirect('wuan/star_management');
            //echo '修改成功！';
            $data = $this->forrs($pn);
            $data['ms'] = '修改成功！';
            $this->load->view('wuan_console/star_management',$data);
            }
            }
        }
        else
        {
            echo '星球名不能为空，请重新输入！';
            $this->star_name_upd($id);
        }
    }

    //星球主人修改 @author 阿萌
    public function star_user_upd($id){
        if(!isset($_SESSION))
        {
            session_start();
        }
        if(!empty($_SESSION['data']['uauth'])&&in_array($_SESSION['data']['uauth'],array('02','03'))){
            $data['userlist']= $this->wuan_model->get_user_all_id($id);
            $data['starinfo']= $this->wuan_model->get_star_user_id($id);
            $data['pn']= $this->input->get('pn');
            $this->load->view('wuan_console/star_user_upd',$data);
        }else{
            echo '操作非法，您已被强制退出。';
            session_destroy();
            $this->load->view('wuan_console/login');
        }
    }
    public function star_user_upding($gid){
        if(!isset($_SESSION))
        {
            session_start();
        }
        $uid= $this->input->get('uid');
        $pn= $this->input->get('pn');
        if($uid){
            $this->wuan_model->upd_star_user($gid,$uid);
            $data = $this->forrs($pn);
            $data['ms'] = '修改成功！';
            $this->load->view('wuan_console/star_management',$data);
        }else{
            echo '操作非法，您已被强制退出。';
            session_destroy();
            $this->load->view('wuan_console/login');
        }

    }

    public function groupcp(){
        $status = $this->uri->segment(5);
        $pn = $this->uri->segment(4);
        $gid = $this->uri->segment(3);
        $data = $this->wuan_model->get_starinfo1($gid);
        if($status==1){
            if($data['delete']==0){
                $field['delete']=1;
            }elseif($data['delete']==1){
                $field['delete']=0;
            }
        }elseif($status==2){
            if($data['private']==0){
                $field['private']=1;
            }elseif($data['private']==1){
                $field['private']=0;
            }
        }

        $this->db->update('group_base',$field,array('id'=>$gid));
        $data = $this->forrs($pn);
        $data['ms'] = '操作成功！';
        $this->load->view('wuan_console/star_management',$data);
    }
}

 ?>