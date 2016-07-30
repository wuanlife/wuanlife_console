<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wuan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('wuan_model');
	}

	//$data['user'] = $this->wuan_model->get_username();

	public function login() {

		//登陆页面
		$this->load->view('wuan_console/login');

	}

	public function index() {


		//获取表userlist数据
		// $data['user'] = $this->wuan_model->get_username();
		
		// //登陆人的名称
		// $data['a'] = $this->wuan_model->get_login_admin();
		// print_r ($data['a']);
		// $data['adminname'] = $data['a']->login_admin;
		
		$this->load->view('wuan_console/team_mangement');
	}

	public function team_mangement() {

		//获取表userlist数据
		$data['user'] = $this->wuan_model->get_username();

		//获取登陆用户名
		$data['adminname'] = $this->wuan_model->get_login_admin()->login_admin;
		//print_r ($data['adminname']);

		$this->load->view('wuan_console/team_mangement',$data);

	}

	

	public function logining()
	{
		//验证管理员登陆
		//echo $_POST['adminname'];
		//echo $_POST['adminpwd'];
		
		//view login传回来的数据
		$adminname = $this->input->post('adminname');
		$adminpwd  = $this->input->post('adminpwd');
		

		//在数据库中查找对应的行
		//$date['adminname'] = $this->wuan_model->get_adminname();
		$admin['search'] = $this->wuan_model->search($adminname);

		if($adminpwd == $admin['search']['adminpwd'])
		{
			//验证成功
			$date['user'] = $this->wuan_model->get_username();
			$date['adminname'] = $admin['search']['adminname'];


			//登陆用户写入数据库////////////////////////////////////
			$max = $this->wuan_model->max('login_admin');
			$data['add_login_admin'] = array('Id' => $max['Max(Id)']+1,
				 'login_admin' => $date['adminname'],
				 'login_time'  => date('y-m-d h:i:s',time()));

		$query = $this->db->insert('login_admin',$data['add_login_admin']);
			

			$this->load->view('wuan_console/team_mangement',$date);

		}
		////////////////////////////////////////////////////////////////
		else
		{
			echo "登陆失败";
			$this->load->view('wuan_console/login');
			
		}

	}
	public function delete ($item)
	{
		//echo $item;
		$this->wuan_model->delete($item);

		echo "<script>alert('删除成功');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";


	}
		public function add()
	{
		
		$this->load->view('wuan_console/add');
		
	}

	public function adding()
	{
		$nickname = $this->input->post('nickname');
		//获取从页面返回的nickname
		$max = $this->wuan_model->max('userlist');
		//获取最大ID
		//print_r ($max);
		//$Max_Id = $max->Id
		$data['userlist'] = array('Id' => $max['Max(Id)']+1,
				 'nickname' => $nickname);

		$query = $this->db->insert('userlist',$data['userlist']);
		$this->load->view('wuan_console/add');
		//echo $this->db->insert_id();
	}




		// print_r ($date['adminname'];
		// 	foreach $date['adminname'] as $date_item
		// for(int $i,i<=$date)
		// {
		// 	if($adminname = )
		// }

//		if($_POST['adminname'])

		//echo $date['adminname'][0]['Id'];
	

		// if ($this->form_validation->run() === FALSE)


		// public function team_mangement() {
		// 	$this->load->view('wuan_console/team_mangement')	
}