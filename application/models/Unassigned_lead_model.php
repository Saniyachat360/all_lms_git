<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class unassigned_lead_model extends CI_model {
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
		 if($this->process_id==6 || $this->process_id==7)
		{
			$this->table_name='lead_master';
			$this->table_name1='lead_followup';		
			$this->selectElement='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';
			
		}elseif($this->process_id==8){
				$this -> table_name = 'lead_master_evaluation';
			$this -> table_name1 = 'lead_followup_evaluation';
				$this->selectElement='l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id';
			
		}
		else
		{
			$this->table_name='lead_master_all';		
			$this->table_name1='lead_followup_all';	
			$this->selectElement='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';			
		}
		$this -> executive_array = array("3", "8", "10", "12", "14");
		$this -> tl_array = array("2", "7", "9", "11", "13");

	}
public function select_default_close_lead_status()
	{
		$status_query=$this->db->query("select nextActionName from tbl_add_default_close_lead_status where process_id='$this->process_id'")->result();
		if(count($status_query)>0)
		{
			$default_close_lead_status=$status_query[0]->nextActionName;
			//echo $default_close_lead_status;
			$default_close_lead_status=json_decode($default_close_lead_status);
			return $default_close_lead_status;
		}		
	}
	// Unassign leads
	public function select_lead_location() {
		//Pending Attened Leads
		ini_set('memory_limit', '-1');
	//	$str_arr = unserialize(urldecode($_GET['id']));
	//	print_r($str_arr);
	//	echo $str_arr[0];
		$getUserid = $this -> input -> get('id');
		$userid = $getUserid;
		if ($userid == '') {
			$userid = $this -> user_id;
		}
		$role = $this -> input -> get('role');
		if ($role == '') {
			$role = $this -> role;
		}
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
			
	$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			,'.$this->selectElement);

		
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($this->process_id==8)
		{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
		}
		else {
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> where('l.process', $this -> process_name);
		}
$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('l.nextAction',array_values($default_close_lead_status));			
		}
		//$this -> db -> where('l.nextAction!=', "Close");
		if ($role == '5' && $getUserid == '') {
			$this -> db -> where('l.assign_to_dse_tl', $this -> user_id);
			$this -> db -> where('l.assign_to_dse', 0);
		} elseif ($role == '5' && $getUserid != '') {
			$this -> db -> where('l.assign_to_dse_tl', $userid);
			$this -> db -> where('l.assign_to_dse', 0);
		} elseif ($role == '4') {
			$this -> db -> where('l.assign_to_dse_tl', 0);
			$this -> db -> where('l.assign_to_dse', $this -> user_id);
		
		
		}elseif ($role == '15' && $getUserid == '') {
			$this -> db -> where('l.assign_to_e_tl', $this -> user_id);
			$this -> db -> where('l.assign_to_e_exe', 0);
		} elseif ($role == '15' && $getUserid != '') {
			$this -> db -> where('l.assign_to_e_tl', $userid);
			$this -> db -> where('l.assign_to_e_exe', 0);
		} elseif ($role == '16') {
			$this -> db -> where('l.assign_to_e_tl', 0);
			$this -> db -> where('l.assign_to_e_exe', $this -> user_id);
		} elseif (in_array($role, $this -> executive_array)) {

			$this -> db -> where('l.assign_by_cse_tl', 0);
			$this -> db -> where('l.assign_to_cse', $this -> user_id);

		} elseif (in_array($role, $this -> tl_array) && $getUserid == '') {
			$this -> db -> where('l.assign_by_cse_tl', 0);
		} elseif (in_array($role, $this -> tl_array) && $getUserid != '') {
			$this -> db -> where('l.assign_by_cse_tl', 0);
		}
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
	
	
	//Download unassigned leads
	public function downloadLeads() {
			//Pending Attened Leads
		ini_set('memory_limit', '-1');
	//	$str_arr = unserialize(urldecode($_GET['id']));
	//	print_r($str_arr);
	//	echo $str_arr[0];
		$getUserid = $this -> input -> get('id');
		$userid = $getUserid;
		if ($userid == '') {
			$userid = $this -> user_id;
		}
		$role = $this -> input -> get('role');
		if ($role == '') {
			$role = $this -> role;
		}
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
			
	$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			,'.$this->selectElement);

		
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($this->process_id==8)
		{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
		}
		else {
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> where('l.process', $this -> process_name);
		}
$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('l.nextAction',array_values($default_close_lead_status));			
		}
		//$this -> db -> where('l.nextAction!=', "Close");
		if ($role == '5' && $getUserid == '') {
			$this -> db -> where('l.assign_to_dse_tl', $this -> user_id);
			$this -> db -> where('l.assign_to_dse', 0);
		} elseif ($role == '5' && $getUserid != '') {
			$this -> db -> where('l.assign_to_dse_tl', $userid);
			$this -> db -> where('l.assign_to_dse', 0);
		} elseif ($role == '4') {
			$this -> db -> where('l.assign_to_dse_tl', 0);
			$this -> db -> where('l.assign_to_dse', $this -> user_id);
		
		
		}elseif ($role == '15' && $getUserid == '') {
			$this -> db -> where('l.assign_to_e_tl', $this -> user_id);
			$this -> db -> where('l.assign_to_e_exe', 0);
		} elseif ($role == '15' && $getUserid != '') {
			$this -> db -> where('l.assign_to_e_tl', $userid);
			$this -> db -> where('l.assign_to_e_exe', 0);
		} elseif ($role == '16') {
			$this -> db -> where('l.assign_to_e_tl', 0);
			$this -> db -> where('l.assign_to_e_exe', $this -> user_id);
		} elseif (in_array($role, $this -> executive_array)) {

			$this -> db -> where('l.assign_by_cse_tl', 0);
			$this -> db -> where('l.assign_to_cse', $this -> user_id);

		} elseif (in_array($role, $this -> tl_array) && $getUserid == '') {
			$this -> db -> where('l.assign_by_cse_tl', 0);
		} elseif (in_array($role, $this -> tl_array) && $getUserid != '') {
			$this -> db -> where('l.assign_by_cse_tl', 0);
		}
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
	//	$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();


	}
	
	

	//Count of unassigned leads
	public function select_lead_count_location() {
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

		$this -> db -> select('count(enq_id) as count_lead,count(enq_id) as pending_attened_count_lead');

		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($this->process_id==8)
		{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
		}
		else {
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> where('l.process', $this -> process_name);
		}
	$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('l.nextAction',array_values($default_close_lead_status));			
		}
		//$this -> db -> where('l.nextAction!=', "Close");
		if ($role == '5' && $getUserid == '') {
			$this -> db -> where('l.assign_to_dse_tl', $this -> user_id);
			$this -> db -> where('l.assign_to_dse', 0);
		} elseif ($role == '5' && $getUserid != '') {
			$this -> db -> where('l.assign_to_dse_tl', $userid);
			$this -> db -> where('l.assign_to_dse', 0);
		} elseif ($role == '4') {
			$this -> db -> where('l.assign_to_dse_tl', 0);
			$this -> db -> where('l.assign_to_dse', $this -> user_id);
		}elseif ($role == '15' && $getUserid == '') {
			$this -> db -> where('l.assign_to_e_tl', $this -> user_id);
			$this -> db -> where('l.assign_to_e_exe', 0);
		} elseif ($role == '15' && $getUserid != '') {
			$this -> db -> where('l.assign_to_e_tl', $userid);
			$this -> db -> where('l.assign_to_e_exe', 0);
		} elseif ($role == '16') {
			$this -> db -> where('l.assign_to_e_tl', 0);
			$this -> db -> where('l.assign_to_e_exe', $this -> user_id);
		}  elseif (in_array($role, $this -> executive_array)) {

			$this -> db -> where('l.assign_by_cse_tl', 0);
			$this -> db -> where('l.assign_to_cse', $this -> user_id);

		} elseif (in_array($role, $this -> tl_array) && $getUserid == '') {
			$this -> db -> where('l.assign_by_cse_tl', 0);
		} elseif (in_array($role, $this -> tl_array) && $getUserid != '') {
			$this -> db -> where('l.assign_by_cse_tl', 0);
		}

		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	
	
	
	
	
	
	
	
	
	
	
	// Unassign leads
	public function select_lead_location_wise() {
		//Pending Attened Leads
		ini_set('memory_limit', '-1');
		$id = json_decode($_GET['id_array']);
		print_r($id);

		$userid = $id;
		$getUserid = $id;
		if ($userid == '') {
			$userid = $this -> user_id;
		}
		$role =  json_decode($_GET['role_array']);
		if ($role == '') {
			$role = $this -> role;
		}
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
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
		$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('l.nextAction',array_values($default_close_lead_status));			
		}
		//$this -> db -> where('l.nextAction!=', "Close");
		for($i=0;$i<count($getUserid);$i++){
		if ($role[$i] == '5' && $getUserid[$i] != '') {
			//$where_id="(l.assign_to_dse_tl='$user_id[$i]')"
			$this -> db -> where('l.assign_to_dse_tl', $userid[$i]);
			
			$this -> db -> where('l.assign_to_dse', 0);
		} elseif (in_array($role[$i], $this -> tl_array) && $getUserid[$i] != '') {
			$this -> db -> where('l.assign_by_cse_tl', 0);
		}
		}
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		echo $this->db->last_query();
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

		$this -> db -> select('count(enq_id) as count_lead,count(enq_id) as pending_attened_count_lead');

		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');

		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');

		$this -> db -> where('l.process', $this -> process_name);
		$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('l.nextAction',array_values($default_close_lead_status));			
		}
	//	$this -> db -> where('l.nextAction!=', "Close");
		if ($role == '5' && $getUserid == '') {
			$this -> db -> where('l.assign_to_dse_tl', $this -> user_id);
			$this -> db -> where('l.assign_to_dse', 0);
		} elseif ($role == '5' && $getUserid != '') {
			$this -> db -> where('l.assign_to_dse_tl', $userid);
			$this -> db -> where('l.assign_to_dse', 0);
		} elseif ($role == '4') {
			$this -> db -> where('l.assign_to_dse_tl', 0);
			$this -> db -> where('l.assign_to_dse', $this -> user_id);
		} elseif (in_array($role, $this -> executive_array)) {

			$this -> db -> where('l.assign_by_cse_tl', 0);
			$this -> db -> where('l.assign_to_cse', $this -> user_id);

		} elseif (in_array($role, $this -> tl_array) && $getUserid == '') {
			$this -> db -> where('l.assign_by_cse_tl', 0);
		} elseif (in_array($role, $this -> tl_array) && $getUserid != '') {
			$this -> db -> where('l.assign_by_cse_tl', 0);
		}

		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

// Unassign leads
	public function select_escalation_level($feedback,$feedback1) {
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
			l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			,'.$this->selectElement);

		
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($this->process_id==8)
		{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
		}
		else {
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> where('l.process', $this -> process_name);
		}
		//$this -> db -> where('l.process', $this -> process_name);
		//$this -> db -> where('f.escalation_type', $feedback);
			$this -> db -> where($feedback, "Yes");
			$this -> db -> where($feedback1, " ");
		if ($role == 5 && $getUserid == '') {
			$this -> db -> where("l.assign_to_dse", $userid);
		} elseif ($role == 5 && $getUserid != '') {

			$this -> db -> where("l.assign_to_dse_tl", $userid);
		} elseif ($role == 4 ) {
			$this -> db -> where("l.assign_to_dse", $userid);
			
		}elseif ($role == 15 && $getUserid == '') {
			$this -> db -> where("l.assign_to_e_exe", $userid);
		} elseif ($role == 15 && $getUserid != '') {

			$this -> db -> where("l.assign_to_e_tl", $userid);
		} elseif ($role == 16 ) {
			$this -> db -> where("l.assign_to_e_exe", $userid);
			
		} elseif (in_array($role, $this -> executive_array)) {

			$this -> db -> where("l.assign_to_cse", $userid);
			
		} elseif (in_array($role, $this -> tl_array) && $getUserid == '') {
			$this -> db -> where('assign_to_cse', $userid);
		} elseif (in_array($role, $this -> tl_array) && $getUserid != '') {
			$this -> db -> where('assign_by_cse_tl', $userid);
		}
		
		$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('l.nextAction',array_values($default_close_lead_status));			
		}
		/*$this -> db -> where('l.nextAction!=', "Close");
		$this -> db -> where('l.nextAction!=', "Booked From Autovista");*/
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	//Count of unassigned leads
	public function select_lead_count_escalation_level($feedback,$feedback1) {
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

		$this -> db -> select('count(distinct (enq_id)) as count_lead');

		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
	
		if($this->process_id==8)
		{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
		}
		else {
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> where('l.process', $this -> process_name);
		}
		//$this -> db -> where('f.escalation_type',$feedback);
			$this -> db -> where($feedback, "Yes");
			$this -> db -> where($feedback1, " ");
		if ($role == 5 && $getUserid == '') {
			$this -> db -> where("l.assign_to_dse", $userid);
		} elseif ($role == 5 && $getUserid != '') {

			$this -> db -> where("l.assign_to_dse_tl", $userid);
		} elseif ($role == 4 ) {
			$this -> db -> where("l.assign_to_dse=", $userid);
			
		} elseif ($role == 15 && $getUserid == '') {
			$this -> db -> where("l.assign_to_e_exe", $userid);
		} elseif ($role == 15 && $getUserid != '') {

			$this -> db -> where("l.assign_to_e_tl", $userid);
		} elseif ($role == 16 ) {
			$this -> db -> where("l.assign_to_e_exe", $userid);
			
		}elseif (in_array($role, $this -> executive_array)) {

			$this -> db -> where("l.assign_to_cse=", $userid);
			
		} elseif (in_array($role, $this -> tl_array) && $getUserid == '') {
			$this -> db -> where('assign_to_cse', $userid);
		} elseif (in_array($role, $this -> tl_array) && $getUserid != '') {
			$this -> db -> where('assign_by_cse_tl', $userid);
		}
		
		$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('l.nextAction',array_values($default_close_lead_status));			
		}
		/*$this -> db -> where('l.nextAction!=', "Close");
		$this -> db -> where('l.nextAction!=', "Booked From Autovista");*/
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
public function downloadLeads_e($feedback,$feedback1) {
	
		ini_set('memory_limit', '-1');
		
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
			l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			,'.$this->selectElement);

		
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($this->process_id==8)
		{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
		}
		else {
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> where('l.process', $this -> process_name);
		}
		//$this -> db -> where('l.process', $this -> process_name);
		//$this -> db -> where('f.escalation_type', $feedback);
			$this -> db -> where($feedback, "Yes");
			$this -> db -> where($feedback1, " ");
		if ($role == 5 && $getUserid == '') {
			$this -> db -> where("l.assign_to_dse", $userid);
		} elseif ($role == 5 && $getUserid != '') {

			$this -> db -> where("l.assign_to_dse_tl", $userid);
		} elseif ($role == 4 ) {
			$this -> db -> where("l.assign_to_dse", $userid);
			
		}elseif ($role == 15 && $getUserid == '') {
			$this -> db -> where("l.assign_to_e_exe", $userid);
		} elseif ($role == 15 && $getUserid != '') {

			$this -> db -> where("l.assign_to_e_tl", $userid);
		} elseif ($role == 16 ) {
			$this -> db -> where("l.assign_to_e_exe", $userid);
			
		} elseif (in_array($role, $this -> executive_array)) {

			$this -> db -> where("l.assign_to_cse", $userid);
			
		} elseif (in_array($role, $this -> tl_array) && $getUserid == '') {
			$this -> db -> where('assign_to_cse', $userid);
		} elseif (in_array($role, $this -> tl_array) && $getUserid != '') {
			$this -> db -> where('assign_by_cse_tl', $userid);
		}
		$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('l.nextAction',array_values($default_close_lead_status));			
		}
		/*$this -> db -> where('l.nextAction!=', "Close");
		$this -> db -> where('l.nextAction!=', "Booked From Autovista");*/
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		//$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	/************************************* Complaint Functions *********************************************/
	
		// Unassign leads
	public function select_lead_complaint() {
		//Pending Attened Leads
		ini_set('memory_limit', '-1');
	//	$str_arr = unserialize(urldecode($_GET['id']));
	//	print_r($str_arr);
	//	echo $str_arr[0];
		$getUserid = $this -> input -> get('id');
		$userid = $getUserid;
		if ($userid == '') {
			$userid = $this -> user_id;
		}
		$role = $this -> input -> get('role');
		if ($role == '') {
			$role = $this -> role;
		}
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
			
$this->db->select('l.complaint_id,l.complaint_id,l.lead_source,l.business_area,l.name,l.contact_no,l.email,l.service_center,l.created_date,l.assign_to_cse,l.nextAction,l.feedbackStatus,l.comment,
		f.date,f.nextfollowupdate,f.nextfollowuptime,f.comment as cse_comment,
		CONCAT (u.fname," ",u.lname) as cse_name');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		$this->db->join('lmsuser u','u.id=l.assign_to_cse','left');
		
		
		if (in_array($role, $this -> executive_array)&& $getUserid == '') {

			$this -> db -> where('l.assign_by_cse_tl', 0);
			$this -> db -> where('l.assign_to_cse', $userid);

		}elseif (in_array($role, $this -> executive_array)&& $getUserid != '') {

			$this -> db -> where('l.assign_by_cse_tl', 0);
			$this -> db -> where('l.assign_to_cse', $userid);

		} elseif (in_array($role, $this -> tl_array) && $getUserid == '') {
			$this -> db -> where('l.assign_by_cse_tl', 0);
		} elseif (in_array($role, $this -> tl_array) && $getUserid != '') {
			$this -> db -> where('l.assign_by_cse_tl', 0);
		}

		$this -> db -> group_by('l.complaint_id');
		$this -> db -> order_by('l.complaint_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		return $query -> result();

	}
	
//Count of unassigned leads
	public function select_lead_count_complaint() {
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

		$this -> db -> select('count(l.complaint_id) as count_lead');

	$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		$this->db->join('lmsuser u','u.id=l.assign_to_cse','left');
		
		
		if (in_array($role, $this -> executive_array)&& $getUserid == '') {

			$this -> db -> where('l.assign_by_cse_tl', 0);
			$this -> db -> where('l.assign_to_cse', $userid);

		}elseif (in_array($role, $this -> executive_array)&& $getUserid != '') {

			$this -> db -> where('l.assign_by_cse_tl', 0);
			$this -> db -> where('l.assign_to_cse', $userid);

		} elseif (in_array($role, $this -> tl_array) && $getUserid == '') {
			$this -> db -> where('l.assign_by_cse_tl', 0);
		} elseif (in_array($role, $this -> tl_array) && $getUserid != '') {
			$this -> db -> where('l.assign_by_cse_tl', 0);
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
	
	/******************************************************************************************************/

}
?>
