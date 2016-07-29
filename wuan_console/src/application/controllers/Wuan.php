<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wuan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('wuan_model');
	}

	public function index() {

		$data['user'] = $this->news_model->get_username();
		$data['adminname'] = "";
		$this->load->view('wuan_console/team_mangement',$data);
	}

	public function team_mangement() {

		$date['user'] = $this->wuan_model->get_username();
		$this->load->view('wuan_console/team_mangement',$date);

		//$date['namelist'] = $this->wuan_console_model->get_username();
	}

	public function login() {

		$this->load->view('wuan_console/login');

	}

	public function yanzheng()
	{
		//验证管理员登陆
		//echo $_POST['adminname'];
		//echo $_POST['adminpwd'];
		
		//view传回来的数据
		$adminname = $this->input->post('adminname');
		$adminpwd = $this->input->post('adminpwd');
		

		//在数据库中查找对应的行
		//$date['adminname'] = $this->wuan_model->get_adminname();
		$admin['search'] = $this->wuan_model->search($adminname);

		if($adminpwd == $admin['search']['adminpwd'])
		{
			//验证成功
			$date['user'] = $this->wuan_model->get_username();
			$date['adminname'] = $admin['search']['adminname'];

			$this->load->view('wuan_console/team_mangement',$date);

		}
		else
		{
			$this->load->view('wuan_console/login');
			echo "登陆失败";
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

	public function addd()
	{
		$nickname = $this->input->post('nickname');
		//获取从页面返回的nickname
		$max = $this->wuan_model->max();
		//获取最大ID
		
		$data = array('Id' => $max[0]['Id'], 'nickname' => $nickname);
	
		

		$query=$this->db->insert('userlist',$data);
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