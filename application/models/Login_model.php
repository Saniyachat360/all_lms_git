<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class login_model extends CI_model {
	function __construct() {
		parent::__construct();
			$this -> today = date('Y-m-d');
		$this -> time = date('h:i:s A');
		$this -> user_id = $this -> session -> userdata('user_id');
	}

	public function form_submit($username, $password) {
		$this -> db -> select('role,id,fname,lname,location');
		$this -> db -> from('lmsuser');
		$this -> db -> where('email', $username);
		$this -> db -> where('password', $password);

		$this -> db -> limit(1);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function form_submit1($username, $password) {
		$order=" FIELD(p.process_id,'6', '7','8','9' ,'1', '4', '5')";
		$this -> db -> select('role,role_name,id,fname,lname,p1.process_id,u.agent_username,u.agent_password,p1.process_name,p.location_id as location_id,l.location,u.cross_lead_user');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process p','p.user_id=u.id');
		$this -> db -> join('tbl_process p1','p1.process_id=p.process_id');
		
		$this -> db -> join('tbl_location l','l.location_id=p.location_id');
		$this -> db -> where('email', $username);
		$this -> db -> where('password', $password);
		$this -> db -> where('u.status', 1);
		$this->db->order_by($order);
		$this -> db -> limit(1);
		$query = $this -> db -> get();
		echo $this->db->last_query();
		return $query -> result();

	}

		public function update_status($id, $process_id) {
	    
			$query = $this -> db -> query("select * from tbl_login_history where login_date='$this->today' and user_id='$id' 
		 ") -> result();
		if (count($query) > 0) {
		} else {

		$query = $this -> db -> query("insert into tbl_login_history (user_id,login_time,login_date)
		values('$id','$this->time','$this->today')");
	}
	$data = array('is_active' => 'Online');
		$this -> db -> where('id', $id);
		$this -> db -> update('lmsuser', $data);
	}
		public function change_status() {
		    		$query = $this -> db -> query("select * from tbl_login_history where login_date='$this->today' and user_id='$this->user_id' ") -> result();

		if (count($query) > 0) 
			{$login_id=$query[0]->login_id;
			$insert = $this -> db -> query("UPDATE tbl_login_history set logout_time= '$this->time' where login_id='$login_id'");
		$data = array('is_active' => 'Offline');
		$this -> db -> where('id', $this->user_id);
		$this -> db -> update('lmsuser', $data);
	}
	}
	public function select_user_group($id) {
		$this -> db -> select('g.group_name,g.group_id');
		$this -> db -> from('tbl_group g');
		$this -> db -> join('tbl_user_group u', 'u.group_id=g.group_id', 'left');
		$this -> db -> where('u.user_id', $id);
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function get_right($id) {
		$this -> db -> select('*');
		$this -> db -> from('tbl_rights');
		$this -> db -> where('user_id', $id);
		$query = $this -> db -> get();
		return $query -> result();
	}
public function get_rights_complaint($id) {
		$this -> db -> select('*');
		$this -> db -> from('tbl_rights_complaint');
		$this -> db -> where('user_id', $id);
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function get_rights_financef($id) {
		$this -> db -> select('*');
		$this -> db -> from('tbl_rights_financem');
		$this -> db -> where('user_id', $id);
		$query = $this -> db -> get();
		return $query -> result();
	}
public function get_rights_report($id) {
		$this -> db -> select('*');
		$this -> db -> from('tbl_rights_report');
		$this -> db -> where('user_id', $id);
		$query = $this -> db -> get();
		return $query -> result();
	}
public function get_rights_purchase_tracking($id) {
		$this -> db -> select('*');
		$this -> db -> from('tbl_rights_poc_purchase_tracking');
		$this -> db -> where('user_id', $id);
		$query = $this -> db -> get();
		return $query -> result();
	}
public function get_rights_cross_lead($id) {
		$this -> db -> select('*');
		$this -> db -> from('tbl_rights_cross_lead');
		$this -> db -> where('user_id', $id);
		$query = $this -> db -> get();
		return $query -> result();
	}
}
?>
