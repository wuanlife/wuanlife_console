<?php 

class wuan_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	//在表 user_detail 中依据 权限 找对应的 id
	public function get_superadmin_id($auth)
	{
		$q = "select user_base_id from user_detail where authorization = $auth";
		$query = $this->db->query($q);
		return $query->result_array();
	}

	public function get_login_admin_nickname($id)
	{
		$query = "select `nickname` from user_base where id = $id";
		$query = $this->db->query($query);
		return $query->row_array();
	}

	public function get_login_admin_password($id)
	{
		$query = "select password from user_base where id = $id";
		$query = $this->db->query($query);
		return $query->row_array();
	}

	public function search_pswmd5($id)
	{
		$query = "select password from user_base where id = $id";
		$query = $this->db->query($query);
		return $query->row_array();
	}

	public function search_id($value)
	{
		$q = "select id from user_base where nickname = '" . $value . " '";
		$query = $this->db->query($q);
		return $query->row_array();
	}

	public function search_auth($value)
	{
		$q = "select authorization from user_detail where user_base_id = $value";
		$query = $this->db->query($q);
		return $query->row_array();
	}

	public function change_auth($value)
	{
		$q = "update user_detail set authorization = '02' where user_base_id = $value";
		$query = $this->db->query($q);
	}

	public function insertdata()
	{
		$data['admin_id'] = $this->wuan_model->get_superadmin_id('02');

		$n = count($data['admin_id']);

		for($i=0; $i<$n; $i++)
		{
			$data['admin'][$i]['id'] = $data['admin_id'][$i]['user_base_id'];

			$data['admin'][$i]['nickname'] = $this->wuan_model->get_login_admin_nickname($data['admin_id'][$i]['user_base_id'])['nickname'];
		}
		return $data['admin'];
	}

	public function change_auth_user($value)
	{
		$q = "update user_detail set authorization = '01' where user_base_id = $value";
		$query = $this->db->query($q);
	}


}

?>