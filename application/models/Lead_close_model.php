<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Lead_close_model extends CI_model {
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
		$this -> process_id = $_SESSION['process_id'];
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
			
		} else {
			$this -> table_name = 'lead_master_all';
			$this -> table_name1 = 'lead_followup_all';
			$this -> table_name2 = 'request_to_lead_transfer_all';
			$this->selectElement='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';
		}
		//Excecutive array
		$this -> executive_array = array("3", "8", "10", "12", "14");
		$this -> tl_array = array("2","7", "9", "11", "13");

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
		if($_SESSION['user_id']==438){
	//		echo $this->db->last_query();
		}
	
		return $query -> result();

	}

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
	public function mass_lead_transfer(){
	echo $company_id_array=$this->input->post('company_id_transfer');
	$lost_type=$this->input->post('lost_type');
	$followupdate=$this->input->post('followupdate');

	$com=explode(',', $company_id_array);
	echo $c= count($com);
	for($i=0;$i<$c;$i++)
	{
		echo "<br>";
		echo $enq_id=$com[$i];	
		$get_detail=$this->db->query("select l.enq_id,f.id,f.feedbackStatus
			from lead_master l
			join lead_followup f 
			 where l.enq_id='$enq_id' and f.nextAction='Close Pending'")->result();
		if(count($get_detail)>0)
		{ 
		if($lost_type =='lost')
		{
			$feedbackStatus=$get_detail[0]->feedbackStatus;
			$followup_id=$get_detail[0]->id;
			$this->db->query("update lead_master set nextAction='Close' and feedbackStatus='$feedbackStatus' where enq_id='$enq_id'");
			$this->db->query("update lead_followup set nextAction='Close'  where id='$followup_id'");
		}else
		{
			$this->db->query("update lead_followup set nextfollowupdate='$followupdate'  where id='$followup_id'");
		}
	}
		
	}
	if($this->db->affected_rows()>0){
		 $this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong>Company Transferred Successfully...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
	}else{
					$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Company Not transferred  ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		
	}
}
	

/////////////////////////////////////////////////////////////////////////////////////////////////
}
?>
