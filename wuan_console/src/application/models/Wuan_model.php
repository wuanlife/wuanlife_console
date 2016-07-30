<?php 
class Wuan_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

	// public function get_admin($adminname = false )
	// {
	// 	$query = $this->db->get('adminlist',array('adminname' => $adminname));
	// 	return $query->row_array();
	// }

	public function get_username()
	{
		$query = $this->db->get('userlist');
		return $query->result_array();
	}

	public function get_adminname()
	{
		$query = $this->db->get('adminlist');
		return $query->result_array();
	}

	public function get_login_admin()
	{
		$query = "select `login_admin` From login_admin where Id = (select max(Id) from login_admin)";
		$query = $this->db->query($query);
		return $query->row();
		//return $query->db->get('login_admin');
	}

	public function search($adminname)
	{
		//在数据库中查询admin账号用于验证
		//$sql= "select adminpwd from adminlist where adminname = $con";
		$query = $this->db->get_where('adminlist',array('adminname' =>$adminname));
		return $query->row_array();
	}

	public function delete($item)
	{
		//删除数据
		$this->db->delete('userlist',array('Id' =>$item));
	}
	public function add($row)
	{
		$this->db->insert('userlist',$row);
	}

	public function max($table)
	{
		//$query = "select MAX(Id) from userlist";
		$query = "select Max(Id) from $table";
		$query = $this->db->query($query);
		return $query->row_array();

		//return $query = $this->db->insert_id();
	}
	
}



 ?>