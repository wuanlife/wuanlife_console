<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/* wuan后台管理主控制器
*
*
*
*
*/

class Wuan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('wuan_model');

	}


	public function login() {

		//登陆
		$this->load->helper('form');
		$this->load->view('wuan_console/login_1');

	}

	public function index() {
		//设置默认进入页面 （无用）
		
		$this->load->view('wuan_console/team_mangement_1');
	}
//--------------------------------------------------------------------------
	public function team_mangement_1() {

		//后台管理主界面控制器


		

		$data['user_base'] = $this->wuan_model->get_user_base_id('02');
		//获取表user_detail表中authorization = 2 的 user_base_id

		$data['id'] = array();
		
		foreach ($data['user_base'] as $key) {

			$data['id'][] = $key['user_base_id'];
			
		}
		//print_r($data['id'][0]);
		
		$data['new'] = array();
		//$data['id_id'] = array();
		
 		$n = count($data['id']);

		for( $a=0; $a<$n; $a++)
		{
			$query = $this->wuan_model->get_admin($data['id']["$a"]);
			$data['new'][] = $query[0];

		}

		//获取表中1数据 taotao
		$data['adminname_1'] = $this->wuan_model->get_login_admin(1);


		$data['adminname'] = $data['adminname_1']['nickname'];
		//print_r($data['user']);
		$this->load->view('wuan_console/team_mangement_1',$data);
	}

	
//-----------------------------------------------------------------------------
	public function logining()
	{
		/**
		*登陆过程
		*
		*/
		//载入表单验证类
		$this->load->library('form_validation');

		//设置验证规则

		$this->form_validation->set_rules('adminname','用户名','required');
		$this->form_validation->set_rules('adminpwd','密码','required');
		
		//开始验证
		$status = $this->form_validation->run();

		if($status)
		{

			//验证成功
			//从页面获取用户名和密码
			$adminname = $this->input->post('adminname');
			$adminpwd  = $this->input->post('adminpwd');


			//在表user_detail中查找03权限的id

			$data['superadmin_id'] = $this->wuan_model->get_user_base_id('03');

			// 0 array user_base_id 1
			// 1 array user_base_id 83


			$n = count($data['superadmin_id']);
			//获取数组行数
			
			
			for($i=0; $i<$n;$i++)
			{
				//通过循环将每一项的id、nickname、password写入数组$data中

				$data[$i]['id'] = $data['superadmin_id'][$i]['user_base_id'];

				$nick = $this->wuan_model->get_login_admin($data[$i]['id']);
				$data[$i]['nickname'] = $nick['nickname'];
				
				$pwd = $this->wuan_model->search_md5($data[$i]["id"]);
				$data[$i]['password'] = $pwd['password'];
				
				if($data[$i]['nickname'] == $adminname)
				{
					//echo ($data[$i]['nickname']);
					//echo $adminlogin_id = $i;
					break;
					//获取$i
				}
			}
			///////////////////////////////////////////////////

			if(!isset($_SESSION))
			{
				session_start();
			}

			$_SESSION['i'] = $i;
			$_SESSION['data'] = $data[$i]['id'];
			echo "-----------1-";
			print_r($_SESSION['i']);
			print_r($_SESSION['data']);

			///////////////////////////////////////////////////



			//echo ($n."<br />".$i);
			$data['id_3'] = array();
			foreach ($data['superadmin_id'] as $key)
				{

					$data['id_3'][] = $key['user_base_id'];
			
				}
				//print_r($data['id_3']);
				//  [0] => 1
				//  [1] => 83
				
				$login_id = $data['id_3'][$i];
				




			// $data['adminname_1'] = $this->wuan_model->get_login_admin($data[$_SESSION['i']]['id']);
		
			// $admin['search_supername'] = $data['adminname_1']['nickname'];

			//print_r($admin['search_supername']);

			$md5_sql = $this->wuan_model->search_md5($login_id);
			$md5_pwd = md5($adminpwd);

			if($md5_pwd == $md5_sql['password'])
			{
				//验证成功
				
				$data['user_base'] = $this->wuan_model->get_user_base_id('02');
				//print_r($data['user_base']);
				$data['id'] = array();
	
				//
				foreach ($data['user_base'] as $key)
				{

					$data['id'][] = $key['user_base_id'];
			
				}
				//print_r($data['id']);
				//print_r($data['id'][0]);
		
				$data['new'] = array();
				//$data['id_id'] = array();
		
 				$n = count($data['id']);

				for( $a=0; $a<$n; $a++)
				{
					$query = $this->wuan_model->get_admin($data['id']["$a"]);
					$data['new'][] = $query[0];

				}

			//获取表中1数据 taotao
			$data['adminname_1'] = $this->wuan_model->get_login_admin($data[$_SESSION['i']]['id']);
			$data['adminname'] = $data['adminname_1']['nickname'];
		
			$this->load->view('wuan_console/team_mangement_1',$data);

			}
			else
			{
			$this->load->helper('form');
			echo '用户名或密码错误！';
			$this->load->view('wuan_console/login_1');
			}


		}
		else
		{
			$this->load->helper('form');
			$this->load->view('wuan_console/login_1');
		}

	 }
	///////////////////////////////////////////////////////////////////////////////////////////////////////

	public function delete ($item)
	{
		//echo $item;
		$this->wuan_model->change_auth_user($item);

		//获取表user_detail表中authorization = 2 的 user_base_id

		$data['user_base'] = $this->wuan_model->get_user_base_id('02');

		$data['id'] = array();
		
		//
		foreach ($data['user_base'] as $key) {

			$data['id'][] = $key['user_base_id'];
			
		}
		//print_r($data['id'][0]);
		
		$data['new'] = array();
		$data['id_id'] = array();
		
 		$n = count($data['id']);

		for( $a=0; $a<$n; $a++)
		{
			$query = $this->wuan_model->get_admin($data['id']["$a"]);
			$data['new'][] = $query[0];

		}



		// for( $a=0; $a<$n; $a++)
		// {
		// 	$data['id_name'] = $this->wuan_model->get_admin($a);

		// }
		if(!isset($_SESSION))
			{
				session_start();
			}

			print_r($_SESSION['i']);
			
			print_r($_SESSION['data']);




		//获取表中1数据 taotao
		$data['adminname_1'] = $this->wuan_model->get_login_admin($_SESSION['data']);
		$data['adminname'] = $data['adminname_1']['nickname'];
		//print_r($data['user']);
		$this->load->view('wuan_console/team_mangement_1',$data);


		/////////////////////////////////////////////////////////////

		//$this->Wuan->index();
		//$this->load->view('wuan/logining');

		//echo "<script>alert('删除成功');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";


	}
		public function add()
		{
		
		$this->load->view('wuan_console/add');
		
		}

	public function adding()
	{
		//表单验证
		$this->load->library('form_validation');

		$this->form_validation->set_rules('nickname','昵称','required');

		//获取前台传回的nickname
		$nickname = $this->input->post('nickname');

		$id = array();

		//如果nickname不为空
		if(!empty($nickname))
		{

			//获取nickname对应的id

			$id =$this->wuan_model->search_id($nickname);
			
			$auth = $this->wuan_model->search_auth($id['id']);
			
			if($auth['authorization'] == 1)
			{
				$this->wuan_model->change_auth($id['id']);
			}



			//--复制team_mangement_1代码---------------
			$data['user_base'] = $this->wuan_model->get_user_base_id('02');

			$data['id'] = array();
			
			foreach ($data['user_base'] as $key) 
			{
				$data['id'][] = $key['user_base_id'];
			}
		
			$data['new'] = array();
			$data['id_id'] = array();
		
 			$n = count($data['id']);

			for( $a=0; $a<$n; $a++)
			{
				$query = $this->wuan_model->get_admin($data['id']["$a"]);
				$data['new'][] = $query[0];
			}

if(!isset($_SESSION))
			{
				session_start();
			}

			print_r($_SESSION['i']);
			
			print_r($_SESSION['data']);


		//获取表中1数据 taotao
		$data['adminname_1'] = $this->wuan_model->get_login_admin($_SESSION['data']);
		$data['adminname'] = $data['adminname_1']['nickname'];
		//print_r($data['user']);
		$this->load->view('wuan_console/team_mangement_1',$data);

			//---复制结束--------------
		}
	}

}