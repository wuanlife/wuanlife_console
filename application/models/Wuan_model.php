<?php 

class wuan_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}
	
	public function searchinfo($adminname)
	{
		$q ="select ub.id id,ub.nickname nickname,ub.password password,ud.authorization uauth from user_base ub,user_detail ud where ub.nickname = '{$adminname}' and ub.id=ud.user_base_id";
		$query = $this->db->query($q);
		return $query->row_array();
	}

	public function get_login_admin_nickname($id)
	{
		$data = $this->db->select('nickname')->from('user_base')->where("id = $id")->get()->row_array();
		return $data;
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
		$q ="select ub.id id,ub.nickname nickname,ud.authorization uauth from user_base ub,user_detail ud where ub.id=ud.user_base_id and ud.authorization = 02 ";
		$data['admin'] = $this->db->query($q)->result_array();
		return $data['admin'];
	}

	public function change_auth_user($value)
	{
		$q = "update user_detail set authorization = '01' where user_base_id = $value";
		$query = $this->db->query($q);
	}

	public function get_starinfo()
	{
		$q = "select id,name,g_introduction from group_base";
		$query = $this->db->query($q);
		return $query->result_array();
	}
	
	public function get_starinfo1($id)
	{
		$q = "select id,name,`delete`,`private`,g_introduction from group_base where id = $id";
		$query = $this->db->query($q);
		return $query->row_array();
	}
	
	public function groupid_to_userid($id)
	{
		$data = $this->db->query("select user_base_id from group_detail where group_base_id = $id and authorization=01");
		return $data->row_array();
	}

	public function get_starid($page)
	{
		//获取星球id
		$q = "select id from group_base";
		$query = $this->db->query($q);
		$all_num = $query->num_rows();
		$page_num     =20;                 //每页条数
        $page_all_num =ceil($all_num/$page_num);                //总页数
        if ($page_all_num == 0){
            $page_all_num =1;
        }
        if($page > $page_all_num){
            $page = $page_all_num;
        }
        $page         =empty($page)?1:$page;                    //当前页数
        $page         =(int)$page;                              //安全强制转换
        $limit_st     =($page-1)*$page_num;                     //起始数
		$p = "SELECT id FROM group_base ORDER BY id LIMIT $limit_st,$page_num ";
		$query = $this->db->query($p);
		$result['data'] = $query->result_array();
		$result['pan'] = $page_all_num;
		return $result;
	}
	
	//修改星球名称函数 @author 阿萌
	public function upd_star_name($id,$name){
		$q="update group_base set name='{$name}' where id={$id}";
		$query=$this->db->query($q);
	}
	//星球名称重复检测 @author 阿萌
	public function check_star_name_equal($name){
		$query=$this->db->query("select * from group_base where name='{$name}'");
		return $query->num_rows();
	}
	//获得全部星球主人姓名信息 @author 阿萌
	public function get_user_all_id(){
		$data = $this->db->query("select id,nickname from user_base order by id asc");
		return $data->result_array();
	}
	//获得星球主人信息for id @author 阿萌
	public function get_star_user_id($starid){
		$data = $this->db->query("select gb.id gid,gb.name gname,ub.id uid,ub.nickname uname from group_base gb,group_detail gd,user_base ub where gb.id=gd.group_base_id and gd.user_base_id=ub.id and gb.id={$starid} and gd.authorization=01");
		return $data->row_array();
	}
	//修改星球主人函数 @author 阿萌
	public function upd_star_user($gid,$uid){
		$a = $this->db->query("update group_detail set authorization='03' where group_base_id={$gid} and authorization='01'");
		$b = $this->db->query("select authorization from group_detail where group_base_id={$gid} and user_base_id={$uid} and authorization='03'");
		$c = $b->num_rows();
		if(!empty($c)){
			$query=$this->db->query("update group_detail set authorization='01' where group_base_id={$gid} and user_base_id={$uid}");
		}else{
			$data = array(
						'group_base_id' => $gid,
						'user_base_id'  => $uid,
			            'authorization' => '01'
			);
			$d = $this->db->insert('group_detail', $data);
		}
	}
}

?>
