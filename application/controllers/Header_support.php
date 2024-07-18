<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Header_support extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		//$this -> load -> model('assign_transferred_model');
		date_default_timezone_set("Asia/Kolkata");

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	function change_header_data()
	{
		$process_id=$this->input->post('process_id');
	echo $_SESSION['location_id'];
		$q=$this->db->query('select process_name from tbl_process p1 join tbl_manager_process p on p.process_id=p1.process_id where p.process_id="'.$process_id.'" and p.location_id="'.$_SESSION['location_id'].'"')->result();
		echo $this->db->last_query();
		if(count($q)>0)
		{
			echo $t='Location p';
			$this -> session -> set_userdata('process_name', $q[0] -> process_name);
			$this -> session -> set_userdata('process_id', $process_id);
		}
		else {
			$this -> db -> select('p.process_id,p.location_id,p1.process_name,l.location_name');
			$this -> db -> from('tbl_map_process p');
			$this->db->join('tbl_process p1','p1.process_id=p.process_id');
			$this->db->join('tbl_location l','l.location_id=p.location_id');
			//$this -> db -> where('p.location_id', $_SESSION['location_id']);
			$this -> db -> where('p.process_id', $process_id);
			$query = $this -> db -> get()->result();
			if(count($query)>0)
			{
				echo $t='Location p1';
				$this -> session -> set_userdata('process_name', $query[0] -> process_name);
				$this -> session -> set_userdata('location_id', $query[0] -> location_id);
				$this -> session -> set_userdata('location', $query[0] -> location);
				$this -> session -> set_userdata('process_id', $process_id);
				
			}
			else 
			{
				echo $t='Location p2';
				$this -> db -> select('p.process_id,p.location_id,p1.process_name,l.location_name');
				$this -> db -> from('tbl_map_process p');
				$this->db->join('tbl_process p1','p1.process_id=p.process_id');
				$this->db->join('tbl_location l','l.location_id=p.location_id');
				$this -> db -> where('p.user_id', $_SESSION['user_id']);
				$query = $this -> db -> get()->result();
				$this -> session -> set_userdata('process_name', $query[0] -> process_name);
				$this -> session -> set_userdata('location_id', $query[0] -> location_id);
				$this -> session -> set_userdata('location', $query[0] -> location);
				$this -> session -> set_userdata('process_id', $query[0] ->process_id);
				
			}
		}
		
		
	}
}
?>