<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login_out_report_model extends CI_model
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Kolkata');
		$this->today = date('Y-m-d');
		$this->time = date('h:i:s A');
	}
	public function select_users()
	{
		$this->db->select('fname,lname,id');
		$this->db->from('lmsuser');
		$query = $this->db->get();
		return $query->result();
	}	

	public function filter_daily($sd, $ed, $id, $type)
	{
		// ini_set('memory_limit', '-1');
		// $rec_limit = 15;
		// $page = $this->uri->segment(4);
		// if (isset($page)) {
		// 	$page = $page + 1;
		// 	$offset = $rec_limit * $page;
		// } else {
		// 	$page = 0;
		// 	$offset = 0;
		// }

		$type = $this->input->post('type');
		$id = $this->input->post('user_name');
		// extract($id);

		$user_name = $this->input->post('user_name');
		// print_r($user_name);
		// die;		

		$this->db->select('u.id,u.fname,u.lname,h.user_id,h.logout_time,h.login_time,h.login_date');
		$this->db->select('u.id,CONCAT(u.fname, ' . '," ",' . ', u.lname) AS user_name');
		// $this->db->limit($rec_limit, $offset);
		$this->db->from('tbl_login_history h');
		$this->db->join('lmsuser u', 'u.id=h.user_id');	
		

		if ($user_name != '') {		
			if (!in_array("ALL", $user_name)) {
				$this -> db -> where_in('h.user_id', array_values($user_name));
			}			
		}
		// $this->db->where_in('u.id', array_values($id));
		$this->db->where('h.login_date >=', $sd);
		$this->db->where('h.login_date <=', $ed);
		
			
		$query = $this->db->get()->result();
		// echo $this->db->last_query();
		// 	exit;
		if (count($query) > 0) {
			foreach ($query as $row) {

				$select_user[] = array('user_id' => $row->user_id,'user_name' => $row->user_name, 'logout_time' => $row->logout_time, 'login_date' => $row->login_date, 'login_time' => $row->login_time);
			}
		} else {
			$select_user[] = '';
		}
		return $select_user;
	}	
}
