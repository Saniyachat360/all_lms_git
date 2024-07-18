<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Break_reports_model extends CI_model
{
	function __construct()
	{
		parent::__construct();
		$this->role = $this->session->userdata('role');
		$this->user_id = $this->session->userdata('user_id');
		$this->process_id = $this->session->userdata('process_id');
		$this->process_name = $this->session->userdata('process_name');
	}

	function select_location()
	{
		$this -> db -> select('l.location_id,l.location');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_manager_process p','p.location_id=l.location_id');
		$this->db->where('p.process_id',$this->process_id);
		$this -> db -> where('p.user_id', $this->user_id);
		$this -> db -> where('p.status !=','-1');
		//$this -> db -> where('l.location_status =', 'Active');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}


	function select_leads_break($location, $to_date)
	{
		$this->db->select('*');
		$this->db->from('tbl_break_time tb');
		$this->db->join('lmsuser u', 'u.id=tb.user_id');
		$this->db->join('tbl_manager_process p', 'p.user_id=u.id');
		$this->db->join('tbl_location l', 'l.location_id=p.location_id');
		$this->db->join('tbl_mapdse m', 'm.dse_id=u.id', 'left');
		$this->db->where('p.location_id', $location);
		$this->db->where('p.process_id', $this->process_id);
		$this->db->where('u.status', 1);
		$this->db->where('tb.created_date', $to_date);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}


	public function select_break_time_excel_download()
	{
		$location = $this->input->get('location');
		$to_date = $this->input->get('to_date');
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this->uri->segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this->db->select('*');
		$this->db->from('tbl_break_time tb');
		$this->db->join('lmsuser u', 'u.id=tb.user_id');
		$this->db->join('tbl_manager_process p', 'p.user_id=u.id');
		$this->db->join('tbl_location l', 'l.location_id=p.location_id');
		$this->db->join('tbl_mapdse m', 'm.dse_id=u.id', 'left');
		$this->db->where('p.location_id', $location);
		$this->db->where('p.process_id', $this->process_id);
		$this->db->where('u.status', 1);
		$this->db->where('tb.created_date', $to_date);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}



	
}
