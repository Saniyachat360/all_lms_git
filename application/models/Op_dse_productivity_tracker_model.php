<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Op_dse_productivity_tracker_model extends CI_model {
	function __construct() {
		parent::__construct();
		parent::__construct();
		$this -> today = date('Y-m-d');
		$this -> process_name = $this -> session -> userdata('process_name');
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');

		$this -> process_id = $_SESSION['process_id'];
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master';
			$this -> table_name1 = 'lead_followup';
			$this -> selectElement = 'l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id,ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			';

		} elseif ($this -> process_id == 8) {
			$this -> table_name = 'lead_master_evaluation';
			$this -> table_name1 = 'lead_followup_evaluation';
		$this -> selectElement = 'l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id,ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			';

		} else {
			$this -> table_name = 'lead_master_all';
			$this -> table_name1 = 'lead_followup_all';
			$this -> selectElement = 'l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';
		}
		$this -> executive_array = array("3", "8", "10", "12", "14");
		$this -> tl_array = array("2", "7", "9", "11", "13");
	}

	public function assign_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('assign_to_e_exe', $dse_id);
			$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
			$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('assign_to_dse', $dse_id);
			$this -> db -> where('l.assign_to_dse_date>=', $from_date);
			$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
		
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function assign_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($this->process_id==8){
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id ', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('assign_to_e_exe', $dse_id);
			$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
			$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('assign_to_dse', $dse_id);
			$this -> db -> where('l.assign_to_dse_date>=', $from_date);
			$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
	
		
		
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function total_booked_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('assign_to_e_exe', $dse_id);
				$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('assign_to_dse', $dse_id);
				$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
		$this -> db -> where('l.nextAction', 'Booked From Autovista');
	
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function total_booked_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($this->process_id==8){
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.nextAction', 'Booked From Autovista');
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
	
		}else{
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.nextAction', 'Booked From Autovista');
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
	
		}
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function home_visit_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');		
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where('l.assign_to_e_exe',$dse_id);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->where('f.appointment_type','Home Visit');		
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function home_visit_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($this->process_id==8){
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$dse_id);
		}else{
		$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');	
		
		$this->db->where('f.appointment_type','Home Visit');	
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function home_visit_conducted_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');		
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where('l.assign_to_e_exe',$dse_id);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->where('f.appointment_type','Home Visit');
		$this->db->where('f.appointment_status','Conducted');			
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function home_visit_conducted_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($this->process_id==8){
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');	
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> where('l.evaluation','Yes');
		$this->db->where('l.assign_to_e_exe',$dse_id);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');	
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');
		
		$this->db->where('f.appointment_type','Home Visit');
		$this->db->where('f.appointment_status','Conducted');		
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function home_visit_not_conducted_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');		
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where('l.assign_to_e_exe',$dse_id);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->where('f.appointment_type','Home Visit');
		$this->db->where('f.appointment_status','Not Conducted');			
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function home_visit_not_conducted_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($this->process_id==8){
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$dse_id);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');	
		$this->db->where('f.appointment_type','Home Visit');
		$this->db->where('f.appointment_status','Not Conducted');		
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function showroom_visit_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');		
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where('l.assign_to_e_exe',$dse_id);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->where('f.appointment_type','Showroom Visit');
			
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function showroom_visit_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($this->process_id==8){
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$dse_id);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');
		$this->db->where('f.appointment_type','Showroom Visit');
			
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function showroom_visit_conducted_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');		
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where('l.assign_to_e_exe',$dse_id);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->where('f.appointment_type','Showroom Visit');
		$this->db->where('f.appointment_status','Conducted');			
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function showroom_visit_conducted_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
if ($this -> process_id == 8) {
	$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$dse_id);
}else{
	$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this->db->where('l.assign_to_dse',$dse_id);
}
		
			$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');	
		$this->db->where('f.appointment_type','Showroom Visit');
		$this->db->where('f.appointment_status','Conducted');		
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function showroom_visit_not_conducted_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');		
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where('l.assign_to_e_exe',$dse_id);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->where('f.appointment_type','Showroom Visit');
		$this->db->where('f.appointment_status','Not Conducted');			
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function showroom_visit_not_conducted_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($this->process_id==8){
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$dse_id);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');	
		$this->db->where('f.appointment_type','Showroom Visit');
		$this->db->where('f.appointment_status','Not Conducted');		
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function test_drive_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');		
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
				$this->db->where('l.assign_to_e_exe',$dse_id);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
				$this->db->where('l.assign_to_dse',$dse_id);
		}
	
		$this->db->where('f.appointment_type','Test Drive');			
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function test_drive_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if ($this -> process_id == 8) {
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$dse_id);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');	
		$this->db->where('f.appointment_type','Test Drive');		
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function test_drive_conducted_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');		
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where('l.assign_to_e_exe',$dse_id);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->where('f.appointment_type','Test Drive');
		$this->db->where('f.appointment_status','Conducted');			
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function test_drive_conducted_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if ($this -> process_id == 8) {
		$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$dse_id);
		}else{
		$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this->db->where('l.assign_to_dse',$dse_id);
		}

				$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');	
		$this->db->where('f.appointment_type','Test Drive');
		$this->db->where('f.appointment_status','Conducted');		
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function test_drive_not_conducted_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');		
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
				$this->db->where('l.assign_to_e_exe',$dse_id);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
				$this->db->where('l.assign_to_dse',$dse_id);
		}
	
		$this->db->where('f.appointment_type','Test Drive');
		$this->db->where('f.appointment_status','Not Conducted');			
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function test_drive_not_conducted_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if ($this -> process_id == 8) {
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$dse_id);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');	
		$this->db->where('f.appointment_type','Test Drive');
		$this->db->where('f.appointment_status','Not Conducted');		
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function evaluation_allotted_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');		
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where('l.assign_to_e_exe',$dse_id);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->where('f.appointment_type','Evaluation Allotted');
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function evaluation_allotted_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if ($this -> process_id == 8) {
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$dse_id);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this->db->where('l.assign_to_dse',$dse_id);
		}
		
			$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');	
		$this->db->where('f.appointment_type','Evaluation Allotted');
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function evaluation_conducted_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');		
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where('l.assign_to_e_exe',$dse_id);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where('l.assign_to_dse',$dse_id);
		}
		
		$this->db->where('f.appointment_type','Evaluation Allotted');
		$this->db->where('f.appointment_status','Conducted');			
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function evaluation_conducted_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
			if ($this -> process_id == 8) {
		$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$dse_id);
			}else{
		$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this->db->where('l.assign_to_dse',$dse_id);
			}
	
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');	
		$this->db->where('f.appointment_type','Evaluation Allotted');
		$this->db->where('f.appointment_status','Conducted');		
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function evaluation_not_conducted_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');		
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
				$this->db->where('l.assign_to_e_exe',$dse_id);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
				$this->db->where('l.assign_to_dse',$dse_id);
		}
	
		$this->db->where('f.appointment_type','Evaluation Allotted');
		$this->db->where('f.appointment_status','Not Conducted');			
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function evaluation_not_conducted_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if ($this -> process_id == 8) {
		$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$dse_id);
		}else{
		$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this->db->where('l.assign_to_dse',$dse_id);
		}
		$this->db->join($this -> table_name1 .' f','l.enq_id=f.leadid');	
		$this->db->where('f.appointment_type','Evaluation Allotted');
		$this->db->where('f.appointment_status','Not Conducted');		
		$this -> db -> where('l.created_date>=', $from_date);
		$this -> db -> where('l.created_date<=', $to_date);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	}
?>