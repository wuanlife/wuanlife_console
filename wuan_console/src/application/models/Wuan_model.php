<?php 
class Wuan_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

	public function get_user_base_id()
	{
		$q = "select user_base_id from user_detail where authorization = 2";
		$query = $this->db->query($q);
		return $query->result_array();
	}

	public function search_id($value)
	{
		# code...
		$q = "select id from user_base where nickname = '" . $value . " '";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	public function change_auth($value)
	{
		$q = "update user_detail set authorization = '02' where user_base_id = $value";
		$query = $this->db->query($q);
	}
	public function change_auth_user($value)
	{
		$q = "update user_detail set authorization = '01' where user_base_id = $value";
		$query = $this->db->query($q);
	}

	public function search_auth($value)
	{
		$q = "select authorization from user_detail where user_base_id = $value";
		$query = $this->db->query($q);
		return $query->row_array();
	}

	public function get_login_admin()
	{
		$query = "select `nickname` from user_base where id = 1";
		$query = $this->db->query($query);
		return $query->result_array();
		//return $query->db->get('login_admin');
	}
	public function get_admin($a)
	{
		$query = "select `id` , `nickname` from user_base where id = $a";
		$query = $this->db->query($query);
		return $query->result_array();

	}
	public function search_md5($id)
	{
		$query = "select password from user_base where id = $id";
		$query = $this->db->query($query);
		return $query->row_array();
	}


}



 ?>