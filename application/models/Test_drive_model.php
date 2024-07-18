<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Test_drive_model extends CI_model {
	public $process_name;
	public $role;
	public $user_id;
	public $table_name;
	public $executive_array;
	function __construct() {
		parent::__construct();
		$this->today=date('Y-m-d');
		$this -> process_name = $this -> session -> userdata('process_name');
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');

		$this -> process_id = $_SESSION['process_id'];
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master';
			$this -> table_name1 = 'lead_followup';
		} else {
			$this -> table_name = 'lead_master_all';
			$this -> table_name1 = 'lead_followup_all';
		}
		$this -> executive_array = array("3", "8", "10", "12", "14");
		$this -> tl_array = array("2", "7", "9", "11", "13");
	}
	//Download unassigned leads
	public function downloadLeads() {
		$getUserid = $this -> input -> get('id');
		$userid = $getUserid;
		if ($userid == '') {
			$userid = $this -> user_id;
		}
		$role = $this -> input -> get('role');
		if ($role == '') {
			$role = $this -> role;
		}
		$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.assign_to_dse,assign_to_dse_tl,l.cse_followup_id,l.dse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km,l.nextAction,l.feedbackStatus');

		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
	
		$this -> db -> where('l.process', $this -> process_name);
	//	$this -> db -> where('l.nextAction', "Test Drive");
		if ($role == 5 && $getUserid == '') {
			$this -> db -> where("l.assign_to_dse", $userid);
			$this -> db -> where('f2.appointment_type', "Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
			//$this -> db -> where('f2.td_hv_date', $this->today);
			
		} elseif ($role == 5 && $getUserid != '') {

			$this -> db -> where("l.assign_to_dse_tl", $userid);
			$this -> db -> where('f2.appointment_type', "Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
			//$this -> db -> where('f2.td_hv_date', $this->today);
		} elseif ($role == 4 ) {
			//$dse_id = $_SESSION['user_id'];
			$this -> db -> where("l.assign_to_dse=", $userid);
			$this -> db -> where('f2.appointment_type', "Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
			//$this -> db -> where('f2.td_hv_date', $this->today);
			
		} elseif (in_array($role, $this -> executive_array)) {

			$this -> db -> where("l.assign_to_cse=", $userid);
			$this -> db -> where('f1.appointment_type', "Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
			//$this -> db -> where('f1.td_hv_date', $this->today);
			
		} elseif (in_array($role, $this -> tl_array) && $getUserid == '') {
			$this -> db -> where('assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type', "Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
			//$this -> db -> where('f1.td_hv_date', $this->today);
		} elseif (in_array($role, $this -> tl_array) && $getUserid != '') {
			$this -> db -> where('assign_by_cse_tl', $userid);
			$this -> db -> where('f1.appointment_type', "Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
		//	$this -> db -> where('f1.td_hv_date', $this->today);
		}
		if($role=1 && $getUserid == ''){
				$where="((f2.appointment_type='Test Drive' and f2.appointment_date='". $this->today ."')or(f1.appointment_type='Test Drive' and f1.appointment_date='". $this->today."'))";
			$this -> db -> where($where);
		}
		$this -> db -> order_by('l.enq_id', 'desc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();

		return $query1;

	}
	// Unassign leads
	public function select_lead_location_wise() {
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$getUserid = $this -> input -> get('id');
		$userid = $getUserid;
		if ($userid == '') {
			$userid = $this -> user_id;
		}
		$role = $this -> input -> get('role');
		if ($role == '') {
			$role = $this -> role;
		}
		$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.assign_to_dse,assign_to_dse_tl,l.cse_followup_id,l.dse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.nextAction,l.feedbackStatus');

		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');

		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');

		$this -> db -> where('l.process', $this -> process_name);
	//	$this -> db -> where('l.nextAction', "Test Drive");
		if ($role == 5 && $getUserid == '') {
			$this -> db -> where("l.assign_to_dse", $userid);
			$this -> db -> where('f2.appointment_type', "Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
			//$this -> db -> where('f2.td_hv_date', $this->today);
			
		} elseif ($role == 5 && $getUserid != '') {

			$this -> db -> where("l.assign_to_dse_tl", $userid);
			$this -> db -> where('f2.appointment_type', "Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
			//$this -> db -> where('f2.td_hv_date', $this->today);
		} elseif ($role == 4 ) {
			//$dse_id = $_SESSION['user_id'];
			$this -> db -> where("l.assign_to_dse=", $userid);
			$this -> db -> where('f2.appointment_type', "Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
			//$this -> db -> where('f2.td_hv_date', $this->today);
			
		} elseif (in_array($role, $this -> executive_array)) {

			$this -> db -> where("l.assign_to_cse=", $userid);
			$this -> db -> where('f1.appointment_type', "Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
			//$this -> db -> where('f1.td_hv_date', $this->today);
			
		} elseif (in_array($role, $this -> tl_array) && $getUserid == '') {
			$this -> db -> where('assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type', "Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
			//$this -> db -> where('f1.td_hv_date', $this->today);
		} elseif (in_array($role, $this -> tl_array) && $getUserid != '') {
			$this -> db -> where('assign_by_cse_tl', $userid);
			$this -> db -> where('f1.appointment_type', "Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
			//$this -> db -> where('f1.td_hv_date', $this->today);
		}
		if($role=1 && $getUserid == ''){
				$where="((f2.appointment_type='Test Drive' and f2.appointment_date='". $this->today ."')or(f1.appointment_type='Test Drive' and f1.appointment_date='". $this->today."'))";
			$this -> db -> where($where);
		}
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	//Count of unassigned leads
	public function select_lead_count_location_wise() {
		//Pending Attened Leads
		$getUserid = $this -> input -> get('id');
		$userid = $getUserid;
		if ($userid == '') {
			$userid = $this -> user_id;
		}
		$role = $this -> input -> get('role');
		if ($role == '') {
			$role = $this -> role;
		}

		$this -> db -> select('count(enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');

		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');

		$this -> db -> where('l.process', $this -> process_name);
		//$this -> db -> where('l.nextAction', "Test Drive");
		if ($role == 5 && $getUserid == '') {
			$this -> db -> where("l.assign_to_dse", $userid);
			$this -> db -> where('f2.appointment_type', "Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
			//$this -> db -> where('f2.td_hv_date', $this->today);
			
		} elseif ($role == 5 && $getUserid != '') {

			$this -> db -> where("l.assign_to_dse_tl", $userid);
			$this -> db -> where('f2.appointment_type', "Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
			//$this -> db -> where('f2.td_hv_date', $this->today);
		} elseif ($role == 4 ) {
			//$dse_id = $_SESSION['user_id'];
			$this -> db -> where("l.assign_to_dse=", $userid);
			$this -> db -> where('f2.appointment_type', "Test Drive");
			$this -> db -> where('f2.appointment_date', $this->today);
			//$this -> db -> where('f2.td_hv_date', $this->today);
			
		} elseif (in_array($role, $this -> executive_array)) {

			$this -> db -> where("l.assign_to_cse=", $userid);
			$this -> db -> where('f1.appointment_type', "Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
			//$this -> db -> where('f1.td_hv_date', $this->today);
			
		} elseif (in_array($role, $this -> tl_array) && $getUserid == '') {
			$this -> db -> where('assign_to_cse', $userid);
			$this -> db -> where('f1.appointment_type', "Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
			//$this -> db -> where('f1.td_hv_date', $this->today);
		} elseif (in_array($role, $this -> tl_array) && $getUserid != '') {
			$this -> db -> where('assign_by_cse_tl', $userid);
			$this -> db -> where('f1.appointment_type', "Test Drive");
			$this -> db -> where('f1.appointment_date', $this->today);
			//$this -> db -> where('f1.td_hv_date', $this->today);
		}
		
		if($role=1 && $getUserid == ''){
				$where="((f2.appointment_type='Test Drive' and f2.appointment_date='". $this->today ."')or(f1.appointment_type='Test Drive' and f1.appointment_date='". $this->today."'))";
			$this -> db -> where($where);
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	

}
?>
