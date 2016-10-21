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


	//登陆
	public function login()
	{
		$this->load->view('wuan_console/login');
	}

	public function logining()
	{
		//登陆过程
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

			//在表user_detail中查找03权限的id
			$data['superadmin_id'] = $this->wuan_model->get_superadmin_id('03');

			$n = count($data['superadmin_id']);

			for($i=0; $i<$n;$i++)
			{
				//通过循环将每一项的id、nickname、password写入数组$data中

				$data[$i]['id'] = $data['superadmin_id'][$i]['user_base_id'];

				$nick = $this->wuan_model->get_login_admin_nickname($data[$i]['id']);
				$data[$i]['nickname'] = $nick['nickname'];
				
				$pwd = $this->wuan_model->get_login_admin_password($data[$i]["id"]);
				$data[$i]['password'] = $pwd['password'];
				
				if($data[$i]['nickname'] == $adminname)
				{
					//echo ($data[$i]['nickname']);
					//echo $adminlogin_id = $i;
					break;
					//获取$i
				}
			}

			//保存$i和对应的id到session
			if(!isset($_SESSION))
			{
				session_start();
			}

			$_SESSION['i'] = $i;
			//$_SESSION['i_id'] = $data[$i]['id'];

		

			$login_id = $data[$i]['id'];
		
			$superadmin_md5 = $this->wuan_model->search_pswmd5($login_id);
		
			$md5_pwd = md5($adminpwd);

			if($md5_pwd == $superadmin_md5['password'])
			{
				//验证成功

				$data['admin'] = $this->wuan_model->insertdata();

				//获取$i 登陆的用户
				$data['adminname_1'] = $this->wuan_model->get_login_admin_nickname($data[$_SESSION['i']]['id']);
				$data['adminname'] = $data['adminname_1']['nickname'];

				if(!isset($_SESSION))
				{
					session_start();
				}

				$_SESSION['data'] =$data;
			
				$this->load->view('wuan_console/head',$data);
				$this->load->view('wuan_console/left');
				$this->load->view('wuan_console/team_mangement');
			}
			else
			{
				$this->load->helper('form');
				echo '用户名或密码错误！';
				$this->load->view('wuan_console/login');
			}


		}
		else
		{
			$this->load->helper('form');
			$this->load->view('wuan_console/login_1');
		}

			//echo "123";

			//print_r($data['admin']);
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
		
		$nickname = $this->input->post('nickname');

		if(!empty($nickname))
		{
			//获取nickname对应的id

			$id = $this->wuan_model->search_id($nickname);

			$auth = $this->wuan_model->search_auth($id['id']);

			if($auth['authorization'] == 1)
			{
				$this->wuan_model->change_auth($id['id']);
			}


			if(!isset($_SESSION))
				{
					session_start();
				}
				//echo "---";

				$_SESSION['data']['admin']= $this->wuan_model->insertdata();

			$this->load->view('wuan_console/head',$_SESSION['data']);
			$this->load->view('wuan_console/left');
			$this->load->view('wuan_console/team_mangement',$_SESSION['data']);
		}
	}

	public function delete($item)
	{
		$this->wuan_model->change_auth_user($item);

		if(!isset($_SESSION))
			{
				session_start();
			}

			$_SESSION['data']['admin']= $this->wuan_model->insertdata();

		$this->load->view('wuan_console/head',$_SESSION['data']);
		$this->load->view('wuan_console/left');
		$this->load->view('wuan_console/team_mangement');

	}

	public function star_mangement()
	{
		if(!isset($_SESSION))
			{
				session_start();
			}
		


		//-------------------------------------------------------------------
		
		//把表group_detail的group_base_id保存在一个数组里 不要重复数据
		
		//print_r($data);

		//载入分页类
		// $this->load->library('pagination');
		// $perPage = 20;
		//配置项设置
		// $config['base_url'] = site_url('wuan/star_mangement');
		// $config['total_rows'] = $this->db->count_all_results('group_base');
		// $config['per_page'] = $perPage;
		// $config['uri_segment'] = 3;
		// $config['prev_link'] = '上一页';
		// $config['next_link'] = '下一页';
		// $config['first_link'] = '第一页';
		// $config['last_link'] = '最后一页';

		// $this->pagination->initialize($config);
		
		// $data['links'] = $this->pagination->create_links();
		
		// $offset = $this->uri->segment(3);
		// $this->db->limit($perPage,$offset);
		

		//$data['starinfo'] = $this->wuan_model->get_starinfo_20();
		//print_r($data['starinfo']);
		
		//$d = $this->wuan_model->distinct();

		//获取delete= 0 的星球id
		$starid = $this->wuan_model->get_starid_delete(0);
		//print_r($starid);
		//for ($i=0; $i<count($starid); $i++) {
		foreach ($starid as $key) {
			
		
			//获取星球id name 和介绍
			$info= $this->wuan_model->get_star_id_name_g($key['id']);

			//根据星球id获取管理员id
			$userid = $this->wuan_model->groupid_to_userid($key['id']);
			$owner = $this->wuan_model->get_login_admin_nickname($userid['user_base_id']);
			$data['starinfo'][$key['id']]['id'] = $info['id'];
			$data['starinfo'][$key['id']]['name'] = $info['name'];
			$data['starinfo'][$key['id']]['g_introduction'] = $info['g_introduction'];
			$data['starinfo'][$key['id']]['owner'] = $owner['nickname'];
		}

		$this->load->view('wuan_console/head',$_SESSION['data']);
		$this->load->view('wuan_console/left');
		$this->load->view('wuan_console/star_mangement',$data);

	}

	public function team_mangement()
	{
		if(!isset($_SESSION))
			{
				session_start();
			}
		
		$this->load->view('wuan_console/head',$_SESSION['data']);
		$this->load->view('wuan_console/left');
		$this->load->view('wuan_console/team_mangement');


	}

}

 ?>