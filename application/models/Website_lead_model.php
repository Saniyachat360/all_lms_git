<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class website_lead_model extends CI_model {
	public $process_name;
	public $role;
	public $user_id;
	public $location;
	function __construct() {
		parent::__construct();
		//Session Values
		$this -> process_name = $this -> session -> userdata('process_name');
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> process_id = $this -> session -> userdata('process_id');
		//Select Table
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master';
			$this -> table_name1 = 'lead_followup';
			$this -> table_name2 = 'request_to_lead_transfer';
			$this->selectElement='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';
		}
		elseif ($this -> process_id == 8) {
			$this -> table_name = 'lead_master_evaluation';
			$this -> table_name1 = 'lead_followup_evaluation';
			$this -> table_name2 = 'request_to_lead_transfer_evaluation';
			$this->selectElement='l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id';
			
		} 
		elseif ($this -> process_id == 10) {
			$this -> table_name = 'lead_master_insurance';
			$this -> table_name1 = 'lead_followup_insurance';
			$this -> table_name2 = 'request_to_lead_transfer_evaluation';
			$this->selectElement='l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id';
			
		}
		else {
			$this -> table_name = 'lead_master_all';
			$this -> table_name1 = 'lead_followup_all';
			$this -> table_name2 = 'request_to_lead_transfer_all';
			$this->selectElement='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';
		}
		//Excecutive array
		$this -> executive_array = array("3", "8", "10", "12", "14");
		$this -> tl_array = array("2","7", "9", "11", "13");

	}

	public function select_campaign() {
		/*---check count as per group & user--*/
		if ($_SESSION['role'] != 1) {

			$user_id = $_SESSION['user_id'];

			$this -> db -> select('c.campaign_name');
			$this -> db -> from('tbl_user_group u');
			$this -> db -> join('tbl_campaign c', 'c.group_id=u.group_id');
			$this -> db -> where('u.user_id', $user_id);
			$query1 = $this -> db -> get() -> result();

			$c = count($query1);
			if (count($query1) > 0) {
				$t = ' ( ';
				for ($i = 0; $i < $c; $i++) {
					if ($i == 0) {
						if ($query1[$i] -> campaign_name == 'New Car') {
							$t = $t . "enquiry_for != 'Used Car'";
						} else {
							$t = $t . "enquiry_for = '" . $query1[$i] -> campaign_name . "'";
						}
					} else {
						$t = $t . " or enquiry_for ='" . $query1[$i] -> campaign_name . "'";
					}
				}

				$st = $t . ')';

			}
			$st;
		}

		$this -> db -> select('enquiry_for');
		$this -> db -> from('lead_master u');
		$this -> db -> join('tbl_campaign c', 'c.campaign_name=u.enquiry_for');
		$this -> db -> where('lead_source', 'Facebook');
		if ($_SESSION['role'] != 1) {
			$this -> db -> where($st);
		}
		$this -> db -> group_by('u.enquiry_for');
		$query = $this -> db -> get();
		return $query -> result();
	}

	function select_manager_remark($id) {

		$this -> db -> select('remark ');
		$this -> db -> from('tbl_manager_remark');
		$this -> db -> where('lead_id', $id);
		$this -> db -> order_by('remark_id', 'desc');
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();
	}

	//Select feedback
	function select_feedback() {
		//$process_id = $_SESSION['process_id'];
		$this -> db -> select('*');
		$this -> db -> from('tbl_feedback_status');
		$this -> db -> where('fstatus!=', 'Deactive');
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();

	}

	//Select Next Action

	function select_next_action() {
		//$process_id = $_SESSION['process_id'];
		$this -> db -> select('*');
		$this -> db -> from('tbl_nextaction');
		$this -> db -> where('nextActionstatus!=', 'Deactive');
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();
	}

	//Select Group
	function select_group() {
		$this -> db -> select('group_id,group_name');
		$this -> db -> from('tbl_group');
		$query = $this -> db -> get();
		return $query -> result();
	}

	//Select CSE name
	public function select_telecaller() {
		$query = $this -> db -> query("select role_name from lmsuser where role=2") -> result();

		if (isset($query[0])) {$role_name = $query[0] -> role_name;
		}
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		if ($_SESSION['role'] == 2 && $role_name = 'CSE Team Leader') {
			$this -> db -> where('role', 3);
		}
		if ($_SESSION['role'] == 5) {
			$this -> db -> join('tbl_mapdse md', 'md.dse_id=l.id');
			$this -> db -> where('tl_id', $_SESSION['user_id']);
		}

		$this -> db -> order_by('fname', 'asc');
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function select_dse_tl_id() {
		$assign_to = $_SESSION['user_id'];
		$query = $this -> db -> query("select dse_id from tbl_mapdse where tl_id='$assign_to'") -> result();
		$c = count($query);
		$t = ' ( ';
		if (count($query) > 0) {

			foreach ($query as $row) {
				$t = $t . "assign_to_dse = " . $row -> dse_id . " or ";

			}
			$t = $t . "  assign_to_dse = " . $assign_to;

		} else {
			$t = $t . " assign_to_dse = " . $assign_to;
		}
		$at = $t . ')';

		return $at;
	}

	public function checkgroupcampaignname() {
		/*---check count as per group & user--*/
		if ($_SESSION['role'] != 1) {

			$user_id = $_SESSION['user_id'];

			$this -> db -> select('c.campaign_name');
			$this -> db -> from('tbl_user_group u');
			$this -> db -> join('tbl_campaign c', 'c.group_id=u.group_id');
			$this -> db -> where('u.user_id', $user_id);
			$query1 = $this -> db -> get() -> result();

			$c = count($query1);
			if (count($query1) > 0) {
				$t = ' ( ';
				for ($i = 0; $i < $c; $i++) {
					if ($i == 0) {
						if ($query1[$i] -> campaign_name == 'New Car') {
							$t = $t . "enquiry_for != 'Used Car'";
						} else {
							$t = $t . "enquiry_for = '" . $query1[$i] -> campaign_name . "'";
						}
					} else {
						$t = $t . " or enquiry_for ='" . $query1[$i] -> campaign_name . "'";
					}
				}
				$t = $t . " or lead_source ='' ";
				$st = $t . ')';

			}

			return $st;
		}

	}

	// Select All Lead Details
	public function select_lead($enq) {

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
		//get filter data
		$enq = str_replace('%20', ' ', $enq);

		if($this->process_id =='10')
		{

			$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,l.customer_location,l.comment,l.insurance_type,
			f3.calling_remark, f3.assign_to as iassign_to, f3.contactibility, f3.date as icall_date, f3.nextfollowupdate as inextfollowupdate, f3.nextfollowuptime as inextfollowuptime,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f3.date as dse_date,f3.nextfollowupdate as dse_nfd,f3.nextfollowuptime as dse_nftime,f3.comment as dse_comment, 
			l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			,'.$this->selectElement);

		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join($this -> table_name1 . ' f3', 'f3.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');

		}else{
		$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,l.customer_location,
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

		}

	
		
		if($this->process_id==8)
		{
		if($_SESSION['sub_poc_purchase']==2)
			{
				$this -> db -> where('l.nextAction_for_tracking', 'Evaluation Done');
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.tracking_followup_id', 'left');
			}
			else {
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			}			
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		//	$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
		}
		else {
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		
			$this -> db -> where('l.process', $this -> process_name);
		}
				if($_SESSION['role_name']=='Manager' && $_SESSION['user_id']!=31){
				$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$this->user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
					{
						$where='mp.location_id in ('.$location_id.')';
					$this -> db -> where($where);
					//$query=$query.'And  in ('.$location_id.')';
					}
				}
		}
			
		//If select Campaign Name
		if ($enq != '' && $enq != 'All') {
			if ($enq == 'Website') {
				$this -> db -> where('lead_source', '');
			} else {
				//echo $enq;
				$name = explode('%23', $enq);
				if ($name[0] == 'Facebook') {
					$this -> db -> where('enquiry_for', $name[1]);
					$this -> db -> where('lead_source', 'Facebook');
				} else {
					$this -> db -> where('lead_source', $name[1]);
				}
			}
		}
		
		//if search contact no
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		//If user DSE Tl
		if ($this -> role == 5) {
			$this -> db -> where('assign_to_dse_tl', $this -> user_id);
		} elseif ($this -> role == 4) {
			$this -> db -> where('assign_to_dse', $this -> user_id);
		} 
		elseif ($this -> role == 15) {
			$this -> db -> where('assign_to_e_tl', $this -> user_id);
		}
		elseif ($this -> role == 16) {
			$this -> db -> where('assign_to_e_exe', $this -> user_id);
		}
		elseif (in_array($this -> role, $this -> executive_array)) {
			$this -> db -> where('assign_to_cse', $this -> user_id);
		} elseif (in_array($this -> role, $this -> tl_array)) {
			
			if($_SESSION['role_name']=='Manager' || $_SESSION['role_name']=='Auditor')
			{
				//$w="(assign_by_cse_tl='$this->user_id' or assign_by_cse_tl=0)";
			}
			else
				{
					$w="(assign_by_cse_tl='$this->user_id' or assign_by_cse_tl=0)";
					$this -> db -> where($w);
				}
			
			//$this -> db -> where('assign_by_cse_tl', $this -> user_id);
		}
	
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');

		//Limit
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		if($_SESSION['user_id']==538){
			//echo $this->db->last_query();
		}
	
		return $query -> result();
	}
	

    // Insurance table all lead details
//     public function select_insurance_lead_count($enq){
//         	$enq = str_replace('%20', ' ', $enq);
// 		$this -> db -> select('count(enq_id) as count_lead');
// 		$this -> db -> from('lead_master_insurance l');
//     }



	// Select All Lead Details
	public function select_lead_count($enq) {
			//get filter data	
		$enq = str_replace('%20', ' ', $enq);
		$this -> db -> select('count(enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
	
					
		if($_SESSION['role_name']=='Manager' && $_SESSION['user_id']!=31){
					if($this->process_id==8)
		{
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			
			}else{
				$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			
		
			}
		
		$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');
		
			
			
			
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$this->user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
					{
						$where='mp.location_id in ('.$location_id.')';
					$this -> db -> where($where);
					//$query=$query.'And  in ('.$location_id.')';
					}
				}
		}
		if($this->process_id==8)
		{
		if($_SESSION['sub_poc_purchase']==2)
			{
				$this -> db -> where('l.nextAction_for_tracking', 'Evaluation Done');
				//$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.tracking_followup_id', 'left');
			}
			}else{
					$this -> db -> where('l.process', $_SESSION['process_name']);
			}
	
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		// check process
		if ($this -> role == 5) {
			//$this -> db -> where($assign_to_dse);
			$this -> db -> where('assign_to_dse_tl', $this -> user_id);
		} elseif ($this -> role == 4) {
			$this -> db -> where('assign_to_dse', $this -> user_id);
		}elseif ($this -> role == 15) {
			$this -> db -> where('assign_to_e_tl', $this -> user_id);
		}
		elseif ($this -> role == 16) {
			$this -> db -> where('assign_to_e_exe', $this -> user_id);
		} elseif (in_array($this -> role, $this -> executive_array)) {
			$this -> db -> where('assign_to_cse', $this -> user_id);
		} elseif (in_array($this -> role, $this -> tl_array)) {
			if($_SESSION['role_name']=='Manager' || $_SESSION['role_name']=='Auditor')
			{
				//$w="(assign_by_cse_tl='$this->user_id' or assign_by_cse_tl=0)";
			}
			else
			{
			$w="(assign_by_cse_tl='$this->user_id' or assign_by_cse_tl=0)";
			
			$this -> db -> where($w);
			}
			
		}
		
		$this -> db -> order_by('l.enq_id', 'desc');
		$query = $this -> db -> get();
		
	//	echo $this->db->last_query();
		return $query -> result();
		
	/*	//get filter data	
		$enq = str_replace('%20', ' ', $enq);
		$this -> db -> select('count(enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
			if($this->process_id==8)
		{
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
			
			}else{
				$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
				$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> where('l.process', $_SESSION['process_name']);
			}
		
		$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');
		
		//If select Campaign Name
		if ($enq != '' && $enq != 'All') {
			if ($enq == 'Website') {
				$this -> db -> where('lead_source', '');
			} else {
				//echo $enq;
				$name = explode('%23', $enq);
				if ($name[0] == 'Facebook') {
					$this -> db -> where('enquiry_for', $name[1]);
					$this -> db -> where('lead_source', 'Facebook');
				} else {
					$this -> db -> where('lead_source', $name[1]);
				}
			}
		}
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		// check process
		if ($this -> role == 5) {
			//$this -> db -> where($assign_to_dse);
			$this -> db -> where('assign_to_dse_tl', $this -> user_id);
		} elseif ($this -> role == 4) {
			$this -> db -> where('assign_to_dse', $this -> user_id);
		}elseif ($this -> role == 15) {
			$this -> db -> where('assign_to_e_tl', $this -> user_id);
		}
		elseif ($this -> role == 16) {
			$this -> db -> where('assign_to_e_exe', $this -> user_id);
		} elseif (in_array($this -> role, $this -> executive_array)) {
			$this -> db -> where('assign_to_cse', $this -> user_id);
		} elseif (in_array($this -> role, $this -> tl_array)) {
			if($_SESSION['role_name']=='Manager' || $_SESSION['role_name']=='Auditor')
			{
				//$w="(assign_by_cse_tl='$this->user_id' or assign_by_cse_tl=0)";
			}
			else
			{
			$w="(assign_by_cse_tl='$this->user_id' or assign_by_cse_tl=0)";
			
			$this -> db -> where($w);
			}
			
		}
		if($_SESSION['role_name']=='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$this->user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
					{
						$where='mp.location_id in ('.$location_id.')';
					$this -> db -> where($where);
					//$query=$query.'And  in ('.$location_id.')';
					}
				}
		}
		$this -> db -> order_by('l.enq_id', 'desc');
		$query = $this -> db -> get();
		
		//echo $this->db->last_query();
		return $query -> result();*/

	}

	public function select_accessories_list($enq_id) {
		$this -> db -> select('*');
		$this -> db -> from('accessories_order_list a ');
		$this -> db -> join('make_models m', 'm.model_id=a.model');
		$this -> db -> where('enq_id', $enq_id);
		$this -> db -> where('a.status!=', '-1');
		$query = $this -> db -> get();
		return $query -> result();
	}

	public function select_model() {
		$this -> db -> select('model_name,model_id');
		$this -> db -> from('make_models');
		$this -> db -> where('make_id', 1);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function select_all_model() {
		$this -> db -> select('model_name,model_id');
		$this -> db -> from('make_models');

		$query = $this -> db -> get();
		return $query -> result();

	}

	public function select_variant($new_model) {
		$this -> db -> select('variant_name,variant_id');
		$this -> db -> from('model_variant');
		$this -> db -> where('model_id', $new_model);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function select_variant_new() {
		$this -> db -> select('variant_name,variant_id');
		$this -> db -> from('model_variant');
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function select_make() {
		$this -> db -> select('make_name,make_id');
		$this -> db -> from('makes');
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function select_model_id($old_make) {
		$this -> db -> select('model_name,model_id');
		$this -> db -> from('make_models');
		$this -> db -> where('make_id', $old_make);
		$query = $this -> db -> get();
		return $query -> result();

	}

	function lmsuser($location) {
		$role = "(role!=1 and role!=2)";
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_location l', 'l.location_id=u.location', 'left');
		$this -> db -> where('status !=', 0);
		$this -> db -> where($role);
		$this -> db -> where('l.location', $location);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	public function select_location() {
		$this -> db -> select('location_id,location');
		$this -> db -> from('tbl_location');
		$query = $this -> db -> get();

		return $query -> result();
	}

	public function select_lead_source() {

		$this -> db -> select('*');
		$this -> db -> from('lead_source');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	public function lms_details($id) {
		//Get user all details
		if($this->process_id=='6' || $this->process_id=='7' ){
			$this -> db -> select('l.enq_id,l.name,l.email,l.alternate_contact_no,l.contact_no,l.address,,l.feedbackStatus,l.nextAction,l.eagerness,
		l.service_type,l.service_center,l.km,l.pick_up_date,l.pickup_required,l.buyer_type,l.color,l.manf_year,l.ownership,l.accidental_claim,
		l.budget_from,l.budget_to,l.quotated_price,l.evaluation_within_days,expected_price,l.fuel_type,l.reg_no,
		l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_address,l.appointment_status,l.appointment_rating,l.appointment_feedback,
		l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,l.customer_occupation,l.customer_corporate_name,l.customer_designation,
		m1.model_name as old_model,
		m2.make_name as old_make,
		bm1.make_name as buy_make,
		bm2.model_name as buy_model,
		m.model_name,
		v.variant_name,l.esc_level1,l.esc_level2,l.esc_level3,l.esc_level1_remark,l.esc_level2_remark,l.esc_level3_remark,l.esc_level1_resolved,
		l.esc_level2_resolved,l.esc_level3_resolved,l.esc_level1_resolved_remark,l.esc_level2_resolved_remark,l.esc_level3_resolved_remark');
		}else if($this->process_id=='8'){
				$this -> db -> select('
		m2.make_id as old_make_id,m2.make_name as old_make_name,
		m1.model_id as old_model_id,m1.model_name as old_model_name,
		v1.variant_id as old_variant_id,v1.variant_name as old_variant_name,
		
		l.quotated_price,l.evaluation_within_days,l.enq_id,name,l.email,l.address,l.alternate_contact_no,l.contact_no,l.comment,l.enquiry_for,l.created_date,l.created_time,l.process,l.assign_to_e_tl,l.assign_to_e_exe,l.assign_by_cse_tl,l.assign_to_cse,l.buyer_type,l.feedbackStatus,l.nextAction,
		l.old_make,l.old_model,l.old_variant,l.fuel_type,l.reg_no,l.reg_year,l.manf_year,l.color,l.ownership,l.km,l.type_of_vehicle,l.outright,l.old_car_owner_name,l.photo_uploaded,l.hp,l.financier_name,l.accidental_claim,l.accidental_details,l.insurance_type,l.insurance_company,l.insurance_validity_date,l.tyre_conditon,l.engine_work,l.body_work,l.vechicle_sale_category,l.refurbish_cost_bodyshop,l.refurbish_cost_mecahanical,l.refurbish_cost_tyre,l.refurbish_other,l.total_rf,l.price_with_rf_and_commission,l.expected_price,l.selling_price,l.bought_at,l.bought_date,l.payment_date,l.payment_mode,l.payment_made_to,
		l.esc_level1 ,l.esc_level1_remark,l.esc_level2 ,l.esc_level2_remark ,l.esc_level3 ,esc_level3_remark,esc_level1_resolved,esc_level2_resolved,esc_level3_resolved,esc_level1_resolved_remark,esc_level2_resolved_remark,esc_level3_resolved_remark');
			}else{
		$this -> db -> select('l.enq_id,l.name,l.email,l.alternate_contact_no,l.contact_no,l.address,,l.feedbackStatus,l.nextAction,l.eagerness,
		l.service_type,l.service_center,l.km,l.pick_up_date,l.pickup_required,l.buyer_type,
		l.bank_name,l.loan_type,l.reg_no,l.roi,l.los_no,l.tenure,l.loanamount,l.dealer,
		m.model_name,l.esc_level1,l.esc_level2,l.esc_level3,l.esc_level1_remark,l.esc_level2_remark,l.esc_level3_remark,l.esc_level1_resolved,
		l.esc_level2_resolved,l.esc_level3_resolved,l.esc_level1_resolved_remark,l.esc_level2_resolved_remark,l.esc_level3_resolved_remark');
		}
		$this -> db -> from($this->table_name.' l');
		//$this -> db -> join($this->table_name1.' f', 'f.id=l.cse_followup_id', 'left');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		if($this->process_id=='8'){
			$this -> db -> join('model_variant v1', 'v1.variant_id=l.old_variant', 'left');
			}
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');
		$this -> db -> join('makes bm1', 'bm1.make_id=l.buy_make', 'left');
		$this -> db -> join('make_models bm2', 'bm2.model_id=l.buy_model', 'left');
		//$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');

		$this -> db -> where('l.enq_id', $id);
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function followup_detail($id) {
		//Get user All Followup Details
			if($this->process_id=='6' || $this->process_id=='7'){
				$this -> db -> select('u.fname,u.lname,
		f.contactibility,f.feedbackStatus,f.nextAction,f.assign_to,f.date as call_date,f.created_time,f.nextfollowuptime,f.comment,f.nextfollowupdate,f.pick_up_date,f.visit_status,f.visit_location,f.visit_booked,f.visit_booked_date,f.sale_status,f.car_delivered,f.appointment_type,f.appointment_status,f.appointment_date,f.appointment_time');
			
				}else if($this->process_id=='8'){
						$this -> db -> select('u.fname,u.lname,	f.id as followup_id,f.created_time,f.comment,f.date as call_date,f.contactibility,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime,f.feedbackStatus,f.nextAction,f.appointment_type,f.appointment_status,f.appointment_date,f.appointment_time' );
		
			}else{
		$this -> db -> select('u.fname,u.lname,
		f.contactibility,f.feedbackStatus,f.nextAction,f.created_time,f.nextfollowuptime,f.assign_to,f.date as call_date,f.comment,f.nextfollowupdate,f.pick_up_date,f.executive_name,f.login_status_name,f.disburse_amount,f.disburse_date,f.process_fee,f.emi,f.approved_date,f.file_login_date,f.appointment_type,f.appointment_status,f.appointment_date,f.appointment_time');
			}
		$this -> db -> from($this->table_name.' l');
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join($this->table_name1.' f', 'f.leadid=l.enq_id');
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to', 'left');

		$this -> db -> where('f.leadid', $id);
		$this -> db -> order_by('f.id', 'desc');
		$query = $this -> db -> get();
		return $query -> result();

	}
///////////////////////////////// Complaint Functions ///////////////////////////////////////////////
public function select_complaint($enq)
	{
		$enq = str_replace('%20', ' ', $enq);
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
		$this->db->select('l.complaint_id,l.complaint_id,l.lead_source,l.business_area,l.name,l.contact_no,l.email,l.service_center,l.created_date,l.assign_to_cse,l.nextAction,l.feedbackStatus,l.comment,
		f.date,f.nextfollowupdate,f.nextfollowuptime,f.comment as cse_comment,
		CONCAT (u.fname," ",u.lname) as cse_name');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		$this->db->join('lmsuser u','u.id=l.assign_to_cse','left');
		if (in_array($this -> role, $this -> executive_array)) {
			$this -> db -> where('assign_to_cse', $this -> user_id);
		} elseif (in_array($this -> role, $this -> tl_array)) {
			
			if($_SESSION['role_name']=='Manager' || $_SESSION['role_name']=='Auditor')
			{
				//$w="(assign_by_cse_tl='$this->user_id' or assign_by_cse_tl=0)";
			}
			else
				{
					$w="(assign_by_cse_tl='$this->user_id' or assign_by_cse_tl=0)";
					$this -> db -> where($w);
				}
			
			//$this -> db -> where('assign_by_cse_tl', $this -> user_id);
		}
		if($_SESSION['role_name']=='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$this->user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
					{
						$where='mp.location_id in ('.$location_id.')';
					$this -> db -> where($where);
					//$query=$query.'And  in ('.$location_id.')';
					}
				}
		}
		//if search contact no
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}

		//Limit
		$this -> db -> limit($rec_limit, $offset);
		$this -> db -> group_by('l.complaint_id');
			$this -> db -> order_by('l.complaint_id', 'desc');
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	public function select_complaint_count($enq)
	{
		$enq = str_replace('%20', ' ', $enq);
		$this->db->select('count(l.complaint_id) as lead_count');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		//If select Campaign Name
		if ($enq != '' && $enq != 'All') {
			if ($enq == 'Website') {
				$this -> db -> where('lead_source', '');
			} else {
				//echo $enq;
				$name = explode('%23', $enq);
				if ($name[0] == 'Facebook') {
					$this -> db -> where('enquiry_for', $name[1]);
					$this -> db -> where('lead_source', 'Facebook');
				} else {
					$this -> db -> where('lead_source', $name[1]);
				}
			}
		}
	
		elseif (in_array($this -> role, $this -> executive_array)) {
			$this -> db -> where('assign_to_cse', $this -> user_id);
		} elseif (in_array($this -> role, $this -> tl_array)) {
			if($_SESSION['role_name']=='Manager' || $_SESSION['role_name']=='Auditor')
			{
				//$w="(assign_by_cse_tl='$this->user_id' or assign_by_cse_tl=0)";
			}
			else
			{
			$w="(assign_by_cse_tl='$this->user_id' or assign_by_cse_tl=0)";
			
			$this -> db -> where($w);
			}
			
		}
		if($_SESSION['role_name']=='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$this->user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
					{
						$where='mp.location_id in ('.$location_id.')';
					$this -> db -> where($where);
					//$query=$query.'And  in ('.$location_id.')';
					}
				}
		}
			if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
			
		$query=$this->db->get();
		return $query->result();
	}
public function complaint_details($complaint_id)
{
		$this->db->select('l.complaint_id,l.alternate_contact_no,l.address,l.complaint_id,l.lead_source,l.business_area,l.name,l.contact_no,l.email,l.service_center,l.created_date,l.assign_to_cse,l.nextAction,l.feedbackStatus,l.comment,
		f.date,f.nextfollowupdate,f.nextfollowuptime,f.comment as cse_comment,
		CONCAT (u.fname," ",u.lname) as cse_name');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		$this->db->join('lmsuser u','u.id=l.assign_to_cse','left');
		$this->db->where('l.complaint_id',$complaint_id);
		$query=$this->db->get();
		return $query->result();
}
public function complaint_followup_detail($id) {
		//Get user All Followup Details
			
				$this -> db -> select('u.fname,u.lname,
		f.contactibility,f.feedbackStatus,f.nextAction,f.assign_to,f.date as call_date,f.created_time,f.nextfollowuptime,f.comment,f.nextfollowupdate');	
		$this -> db -> from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to', 'left');

		$this -> db -> where('f.complaint_id', $id);
		$this -> db -> order_by('f.id', 'desc');
		$query = $this -> db -> get();
		return $query -> result();

	}
public function select_leads_flow($enq_id) {

		$this -> db -> select('u.fname,u.lname,u1.fname as u1name,u1.lname as u1lname,r.created_date');
		$this -> db -> from($this->table_name2.' r');
		$this -> db -> join('lmsuser u', 'u.id=r.assign_to');
		$this -> db -> join('lmsuser u1', 'u1.id=r.assign_by');
		if ('lead_id' != '') {
			$this -> db -> where('lead_id', $enq_id);
		}
		$query = $this -> db -> get();
		$this->db->last_query();
		return $query -> result();
	}
	
	
	
	public function select_ebook_count($lead_source=null){
		
		
		$payment_fromdate=$this->input->post('payment_fromdate');
		$payment_todate=$this->input->post('payment_todate');
		$payment_status=$this->input->post('payment_status');
		ini_set('memory_limit', '-1');

	
		//get filter data
	//$enq = str_replace('%20', ' ', $enq);
		$this -> db -> select('distinct(customer_id)');

		$this -> db -> from('tbl_payment_customer l');
	
		// Check date
		if($payment_todate !='' && $payment_fromdate != ''){
			$this -> db -> where("l.created_date>=",$payment_fromdate);
			$this -> db -> where("l.created_date<=",$payment_todate);
			
		}
		$this->db->where('l.page_source',$lead_source);
		// check status
		if($payment_status !=''){
			$this -> db -> where("l.payment_status",$payment_status);
		}
		//if search contact no
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.customer_mobile_no  LIKE '%$contact%'");
		}
	
	if(!empty($_POST['contact_no'])){
		//Limit
		$this -> db -> limit('100');
		}
	
		
		$query = $this -> db -> get();
		
	
		return $query -> result();

		
	}
		public function select_ebook_lead($lead_source=null) {

		$payment_fromdate=$this->input->post('payment_fromdate');
		$payment_todate=$this->input->post('payment_todate');
		$payment_status=$this->input->post('payment_status');
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
		//get filter data
	//$enq = str_replace('%20', ' ', $enq);
		$this -> db -> select(' m.model_name,v.variant_name, l.customer_name as name,l.customer_email_id as email,l.customer_mobile_no as contact_no,l.created_date,l.edbms_id,l.customer_id,
			l.customer_reg_no,l.showroom_location,l.amount,r.color_name,l.razorpay_payment_id,l.payment_status,l.created_time,l.razorpay_order_id,l.status
			');

		$this -> db -> from('tbl_payment_customer l');
	$this -> db -> join('make_models m','m.model_id=l.customer_model','left');
		$this -> db -> join('model_variant v','v.variant_id=l.customer_variant','left');
	$this -> db -> join('tbl_color r','r.color_id=l.model_color','left');
		// Check date
		if($payment_todate !='' && $payment_fromdate != ''){
			$this -> db -> where("l.created_date>=",$payment_fromdate);
			$this -> db -> where("l.created_date<=",$payment_todate);
			
		}
		
		// check status
		if($payment_status !=''){
			$this -> db -> where("l.payment_status",$payment_status);
		}
		$this->db->where('l.page_source',$lead_source);
		//if search contact no
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.customer_mobile_no  LIKE '%$contact%'");
		}

		$this -> db -> group_by('l.customer_id');
		$this -> db -> order_by('l.customer_id', 'desc');
		if($payment_todate ==''){
		//Limit
		$this -> db -> limit($rec_limit, $offset);
		}
		if(!empty($_POST['contact_no'])){
		//Limit
		$this -> db -> limit('100');
		}
		$query = $this -> db -> get();
		if($_SESSION['user_id']==538){
			//echo $this->db->last_query();
		}
	//echo $this->db->last_query();
		return $query -> result();

	}
		public function ebook_lead_download() {

		$payment_fromdate=$this->input->get('payment_fromdate');
		$payment_todate=$this->input->get('payment_todate');
		$payment_status=$this->input->get('payment_status');
		$lead_source=$this->input->get('lead_source');
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
		//get filter data
	//$enq = str_replace('%20', ' ', $enq);
		$this -> db -> select(' m.model_name,v.variant_name, l.customer_name as name,l.customer_email_id as email,l.customer_mobile_no as contact_no,l.created_date,l.edbms_id,l.customer_id,
			l.customer_reg_no,l.showroom_location,l.amount,r.color_name,l.razorpay_payment_id,l.payment_status,l.status,l.razorpay_order_id
			');

		$this -> db -> from('tbl_payment_customer l');
	$this -> db -> join('make_models m','m.model_id=l.customer_model','left');
		$this -> db -> join('model_variant v','v.variant_id=l.customer_variant','left');
	$this -> db -> join('tbl_color r','r.color_id=l.model_color','left');
		// Check date
		if($payment_todate !='' && $payment_fromdate != ''){
			$this -> db -> where("l.created_date>=",$payment_fromdate);
			$this -> db -> where("l.created_date<=",$payment_todate);
			
		}
		
		// check status
		if($payment_status !=''){
			$this -> db -> where("l.payment_status",$payment_status);
		}
		$this->db->where('l.page_source',$lead_source);
		//if search contact no
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.customer_mobile_no  LIKE '%$contact%'");
		}

		$this -> db -> group_by('l.customer_id');
		$this -> db -> order_by('l.customer_id', 'desc');
		if($payment_todate ==''){
		//Limit
		$this -> db -> limit($rec_limit, $offset);
		}
		if(!empty($_POST['contact_no'])){
		//Limit
		$this -> db -> limit('100');
		}
		$query = $this -> db -> get();
		if($_SESSION['user_id']==538){
			//echo $this->db->last_query();
		}
	//echo $this->db->last_query();
		return $query -> result();

	}
	
	public function insert_edbms(){
	    $customer_id=$this->input->post('customer_id');
	    $edbms_id=$this->input->post('edbms_id');
	    $this->db->query("UPDATE `tbl_payment_customer` SET `edbms_id`='$edbms_id' WHERE customer_id='$customer_id'");
	
	
}
/////////////////////////////////////////////////////////////////////////////////////////////////
}
?>
