<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class today_followup_model extends CI_model {
	public $process_name;
	public $role;
	public $user_id;
	public 	$location;
	function __construct() {
		parent::__construct();
			//Session Values
		$this->process_name=$this->session->userdata('process_name');
		$this->role=$this->session->userdata('role');
		$this->user_id=$this->session->userdata('user_id');
		$this->process_id=$this->session->userdata('process_id');
		//Select Table
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master';
			$this -> table_name1 = 'lead_followup';
			$this->selectElement='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';
		}
		elseif ($this -> process_id == 8) {
			$this -> table_name = 'lead_master_evaluation';
			$this -> table_name1 = 'lead_followup_evaluation';
			$this->selectElement='l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id';
			
		} else {
			$this -> table_name = 'lead_master_all';
			$this -> table_name1 = 'lead_followup_all';
			$this->selectElement='l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id,l.loan_type,l.login_status_name,f1.file_login_date';
		}
		//Excecutive array
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
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
	public function select_lead_location() {
	//Today followup Leads
		$today = date('Y-m-d');
		ini_set('memory_limit', '-1');
		//Pagination
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		//From Dashboard values
		$getUserid = $this -> input -> get('id');
        $userid=$getUserid;
        if($userid=='')
        {
            $userid=$this->user_id;
        }
        $role = $this -> input -> get('role');
        if($role=='')
        {
            $role=$this->role;
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
			if($_SESSION['sub_poc_purchase']==2)
			{
				$this -> db -> where('l.nextAction_for_tracking', 'Evaluation Done');
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.tracking_followup_id', 'left');
			}
			else
			{
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			}
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
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $getUserid=='') {
			$this -> db -> where('l.assign_to_dse',$this->user_id);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $getUserid!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse_tl!=',0);
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
	//If role DSE TL and Dashboard id blank(for calling task)
		elseif ($role == '15' && $getUserid=='') {
			$this -> db -> where('l.assign_to_e_exe',$this->user_id);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '15' && $getUserid!='')
		{
			$this -> db -> where('l.assign_to_e_tl',$userid);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
	
		elseif ($role == '16') {
			$this -> db -> where('l.assign_to_e_tl!=',0);
			$this -> db -> where('l.assign_to_e_exe', $userid);
			$this -> db -> where('f2.nextfollowupdate', $today);
		
		}
		//If role is all Excecutive and dashboard id is blank(for calling task)
		elseif (in_array($role,$this->executive_array) && $getUserid=='') {
			
			$this -> db -> where('l.assign_to_cse', $this->user_id);
			//$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('f1.nextfollowupdate', $today);
		}
		// If role is all Excecutive and dashboard id is not blank(for dashboard)
		elseif (in_array($role,$this->executive_array) && $getUserid !='') {
			
			$this -> db -> where('l.assign_to_cse', $userid);
			//$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('f1.nextfollowupdate', $today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$this->tl_array) && $getUserid==''){
			$this -> db -> where('l.assign_to_cse', $this->user_id);
			$this -> db -> where('f1.assign_to', $this->user_id);
			$this -> db -> where('f1.nextfollowupdate', $today);
		}
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$this->tl_array) && $getUserid !=''){
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('f1.nextfollowupdate', $today);
		}
		////////////// Time Filter ///////////////////
		$times = strtotime(date("H:i")) + 60*60;
		$timet = date("H:i:s", $times); 
		$times1 = strtotime(date("H:i")) - 60*60;
		$timet1 = date("H:i:s", $times1);
		if($this->input->get('name')=='current')
		{
			if ($this->role == 4 ||$this->role == 5 ||$this->role == 15 ||$this->role == 16) 
			{
				$this->db->where('f2.nextfollowuptime>=',$timet1);
				$this->db->where('f2.nextfollowuptime<=',$timet);
				$this->db->where('f2.nextfollowuptime!=','');
			}
			else
			{
				$this->db->where('f1.nextfollowuptime>=',$timet1);
				$this->db->where('f1.nextfollowuptime<=',$timet);
				$this->db->where('f1.nextfollowuptime!=','');
			}
			
		}
		////////////////////////////////////////////////////////
		$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('l.nextAction',array_values($default_close_lead_status));			
		}
		/*$this -> db -> where('l.nextAction!=', "Close");	
		$this -> db -> where('l.nextAction!=', "Lost");	*/
	
		if(!empty($_POST['contact_no'])){
				$contact=$this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		$this->db->group_by('l.enq_id');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	public function select_lead_count_location() {
		//Today followup Leads
		$today = date('Y-m-d');
		ini_set('memory_limit', '-1');

		//ini_set('memory_limit', '-1');

		$getUserid = $this -> input -> get('id');
        $userid=$getUserid;
        if($userid=='')
        {
            $userid=$this->user_id;
        }
        $role = $this -> input -> get('role');
        if($role=='')
        {
            $role=$this->role;
        }
		$nextfollowupdate = ("lf.nextfollowupdate = '$today'" or "lf.nextfollowupdate = '$day'");
		$this -> db -> select('count(enq_id) as count_lead');
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		
		if($this->process_id==8)
		{
			if($_SESSION['sub_poc_purchase']==2)
			{
				$this -> db -> where('l.nextAction_for_tracking', 'Evaluation Done');
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.tracking_followup_id', 'left');
			}
			else
			{
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			}
		
			
		
			$this -> db -> where('l.evaluation', 'Yes');
		}
		else {
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		
			$this -> db -> where('l.process', $this -> process_name);
		}
		
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $getUserid=='') {
			//$this -> db -> join($this->table_name1.' f','f.id=ln.dse_followup_id');
			$this -> db -> where('l.assign_to_dse',$this->user_id);
				$this -> db -> where('f2.nextfollowupdate', $today);
		}
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $getUserid!='')
		{
			//$this -> db -> join($this->table_name1.' f','f.id=ln.dse_followup_id');
			$this -> db -> where('l.assign_to_dse_tl',$userid);
				$this -> db -> where('f2.nextfollowupdate', $today);
		}
		elseif($role == '4')
		{
			//$this -> db -> join($this->table_name1.' f','f.id=ln.dse_followup_id');
			$this -> db -> where('l.assign_to_dse_tl!=',0);
			$this -> db -> where('l.assign_to_dse', $userid);
				$this -> db -> where('f2.nextfollowupdate', $today);
		}
	//If role DSE TL and Dashboard id blank(for calling task)
		elseif ($role == '15' && $getUserid=='') {
			$this -> db -> where('l.assign_to_e_exe',$this->user_id);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '15' && $getUserid!='')
		{
			$this -> db -> where('l.assign_to_e_tl',$userid);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
	
		elseif ($role == '16') {
			$this -> db -> where('l.assign_to_e_tl!=',0);
			$this -> db -> where('l.assign_to_e_exe', $userid);
			$this -> db -> where('f2.nextfollowupdate', $today);
		
		}
		//If role is all Excecutive and dashboard id is blank(for calling task)
		elseif (in_array($role,$this->executive_array) && $getUserid=='') {
			
			$this -> db -> where('l.assign_to_cse', $this->user_id);
			//$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('f1.nextfollowupdate', $today);
		}
		// If role is all Excecutive and dashboard id is not blank(for dashboard)
		elseif (in_array($role,$this->executive_array) && $getUserid !='') {
			
			$this -> db -> where('l.assign_to_cse', $userid);
			//$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('f1.nextfollowupdate', $today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$this->tl_array) && $getUserid==''){
		//$this -> db -> join($this->table_name1.' f','f.id=ln.cse_followup_id');
			$this -> db -> where('l.assign_to_cse', $this->user_id);
				$this -> db -> where('f1.nextfollowupdate', $today);
		}
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$this->tl_array) && $getUserid !=''){
		
			//$this -> db -> join($this->table_name1.' f','f.id=ln.cse_followup_id');
			$this -> db -> where('l.assign_by_cse_tl', $userid);
				$this -> db -> where('f1.nextfollowupdate', $today);
		}
					////////////// Time Filter ///////////////////
		$times = strtotime(date("H:i")) + 60*60;
		$timet = date("H:i:s", $times); 
		$times1 = strtotime(date("H:i")) - 60*60;
		$timet1 = date("H:i:s", $times1);
		
		if($this->input->get('name')=='current')
		{
			
		
			if ($this->role == 4 ||$this->role == 5 ||$this->role == 15 ||$this->role == 16) 
			{
				
				$this->db->where('f2.nextfollowuptime>=',$timet1);
				$this->db->where('f2.nextfollowuptime<=',$timet);
				$this->db->where('f2.nextfollowuptime!=','');
			}else	{
				
				$this->db->where('f1.nextfollowuptime>=',$timet1);
				$this->db->where('f1.nextfollowuptime<=',$timet);
				$this->db->where('f1.nextfollowuptime!=','');
			}
		}
		////////////////////////////////////////////////////////
		$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('l.nextAction',array_values($default_close_lead_status));			
		}
		/*$this -> db -> where('l.nextAction!=', "Close");	
		$this -> db -> where('l.nextAction!=', "Lost");	*/
		if(!empty($_POST['contact_no'])){
			$contact=$this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();



	}

	public function downloadLeads() {
			//Today followup Leads
		$today = date('Y-m-d');
		ini_set('memory_limit', '-1');
		//From Dashboard values
		$getUserid = $this -> input -> get('id');
        $userid=$getUserid;
        if($userid=='')
        {
            $userid=$this->user_id;
        }
        $role = $this -> input -> get('role');
        if($role=='')
        {
            $role=$this->role;
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
			if($_SESSION['sub_poc_purchase']==2)
			{
				$this -> db -> where('l.nextAction_for_tracking', 'Evaluation Done');
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.tracking_followup_id', 'left');
			}
			else
			{
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
			}
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
		//If role DSE TL and Dashboard id blank(for calling task)
		if ($role == '5' && $getUserid=='') {
			$this -> db -> where('l.assign_to_dse',$this->user_id);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '5' && $getUserid!='')
		{
			$this -> db -> where('l.assign_to_dse_tl',$userid);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
		elseif($role == '4')
		{
			$this -> db -> where('l.assign_to_dse_tl!=',0);
			$this -> db -> where('l.assign_to_dse', $userid);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
		//If role DSE TL and Dashboard id blank(for calling task)
		elseif ($role == '15' && $getUserid=='') {
			$this -> db -> where('l.assign_to_e_exe',$this->user_id);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
		//If role DSE TL and Dashboard id not blank(for dashboard)
		elseif($role == '15' && $getUserid!='')
		{
			$this -> db -> where('l.assign_to_e_tl',$userid);
			$this -> db -> where('f2.nextfollowupdate', $today);
		}
	
		elseif ($role == '16') {
			$this -> db -> where('l.assign_to_e_tl!=',0);
			$this -> db -> where('l.assign_to_e_exe', $userid);
			$this -> db -> where('f2.nextfollowupdate', $today);
		
		}
		//If role is all Excecutive and dashboard id is blank(for calling task)
		elseif (in_array($role,$this->executive_array) && $getUserid=='') {
			
			$this -> db -> where('l.assign_to_cse', $this->user_id);
			//$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('f1.nextfollowupdate', $today);
		}
		// If role is all Excecutive and dashboard id is not blank(for dashboard)
		elseif (in_array($role,$this->executive_array) && $getUserid !='') {
			
			$this -> db -> where('l.assign_to_cse', $userid);
			//$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('f1.nextfollowupdate', $today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$this->tl_array) && $getUserid==''){
			$this -> db -> where('l.assign_to_cse', $this->user_id);
			$this -> db -> where('f1.assign_to', $this->user_id);
			$this -> db -> where('f1.nextfollowupdate', $today);
		}
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$this->tl_array) && $getUserid !=''){
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('f1.nextfollowupdate', $today);
		}
		////////////// Time Filter ///////////////////
		$times = strtotime(date("H:i")) + 60*60;
		$timet = date("H:i:s", $times); 
		$times1 = strtotime(date("H:i")) - 60*60;
		$timet1 = date("H:i:s", $times1);
		if($this->input->get('name')=='current')
		{
			if ($this->role == 4 ||$this->role == 5 ||$this->role == 15 ||$this->role == 16) 
			{
				$this->db->where('f2.nextfollowuptime>=',$timet1);
				$this->db->where('f2.nextfollowuptime<=',$timet);
				$this->db->where('f2.nextfollowuptime!=','');
			}
			else
			{
				$this->db->where('f1.nextfollowuptime>=',$timet1);
				$this->db->where('f1.nextfollowuptime<=',$timet);
				$this->db->where('f1.nextfollowuptime!=','');
			}
			
		}
		$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('l.nextAction',array_values($default_close_lead_status));			
		}
		////////////////////////////////////////////////////////
		
		/*$this -> db -> where('l.nextAction!=', "Close");	
		$this -> db -> where('l.nextAction!=', "Lost");	*/
	
		if(!empty($_POST['contact_no'])){
				$contact=$this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		$this->db->group_by('l.enq_id');
		//$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
/*********************************************** Complaint Functions ***********************************************/
public function select_lead_complaint()
{
		ini_set('memory_limit', '-1');
		$today=date('Y-m-d');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		//From Dashboard values
		$getUserid = $this -> input -> get('id');
        $userid=$getUserid;
        if($userid=='')
        {
            $userid=$this->user_id;
        }
        $role = $this -> input -> get('role');
        if($role=='')
        {
            $role=$this->role;
        }
	
		$this->db->select('l.complaint_id,l.complaint_id,l.lead_source,l.business_area,l.name,l.contact_no,l.email,l.service_center,l.created_date,l.assign_to_cse,l.nextAction,l.feedbackStatus,l.comment,
		f.date,f.nextfollowupdate,f.nextfollowuptime,f.comment as cse_comment,
		CONCAT (u.fname," ",u.lname) as cse_name');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		$this->db->join('lmsuser u','u.id=l.assign_to_cse','left');
		//If role is all Excecutive and dashboard id is blank(for calling task)
			if (in_array($role,$this->executive_array) && $getUserid=='') {
			
			$this -> db -> where('l.assign_to_cse', $this->user_id);
			//$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('f.nextfollowupdate', $today);
		}
		// If role is all Excecutive and dashboard id is not blank(for dashboard)
		elseif (in_array($role,$this->executive_array) && $getUserid !='') {
			
			$this -> db -> where('l.assign_to_cse', $userid);
			//$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('f.nextfollowupdate', $today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$this->tl_array) && $getUserid==''){
			$this -> db -> where('l.assign_to_cse', $this->user_id);
			$this -> db -> where('f.assign_to', $this->user_id);
			$this -> db -> where('f.nextfollowupdate', $today);
		}
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$this->tl_array) && $getUserid !=''){
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('f.nextfollowupdate', $today);
		}
		////////////// Time Filter ///////////////////
		$times = strtotime(date("H:i")) + 60*60;
		$timet = date("H:i:s", $times); 
		$times1 = strtotime(date("H:i")) - 60*60;
		$timet1 = date("H:i:s", $times1);
		if($this->input->get('name')=='current')
		{
		
				$this->db->where('f.nextfollowuptime>=',$timet1);
				$this->db->where('f.nextfollowuptime<=',$timet);
				$this->db->where('f.nextfollowuptime!=','');
			
			
		}
		////////////////////////////////////////////////////////
		$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('l.nextAction',array_values($default_close_lead_status));			
		}
		/*$this -> db -> where('l.nextAction!=', "Close");	
		$this -> db -> where('l.nextAction!=', "Lost");	*/
	
		if(!empty($_POST['contact_no'])){
				$contact=$this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		$this -> db -> group_by('l.complaint_id');
		//Limit
		$this -> db -> limit($rec_limit, $offset);
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $query->result();
}
public function select_lead_count_complaint()
	{
		$today=date('Y-m-d');
		//From Dashboard values
		$getUserid = $this -> input -> get('id');
        $userid=$getUserid;
        if($userid=='')
        {
            $userid=$this->user_id;
        }
        $role = $this -> input -> get('role');
        if($role=='')
        {
            $role=$this->role;
        }
		$this->db->select('count(distinct l.complaint_id) as count_lead');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
			//If role is all Excecutive and dashboard id is blank(for calling task)
			if (in_array($role,$this->executive_array) && $getUserid=='') {
			
			$this -> db -> where('l.assign_to_cse', $this->user_id);
			//$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('f.nextfollowupdate', $today);
		}
		// If role is all Excecutive and dashboard id is not blank(for dashboard)
		elseif (in_array($role,$this->executive_array) && $getUserid !='') {
			
			$this -> db -> where('l.assign_to_cse', $userid);
			//$this -> db -> where('l.assign_to_dse_tl',0);
			$this -> db -> where('f.nextfollowupdate', $today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$this->tl_array) && $getUserid==''){
			$this -> db -> where('l.assign_to_cse', $this->user_id);
			$this -> db -> where('f.assign_to', $this->user_id);
			$this -> db -> where('f.nextfollowupdate', $today);
		}
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$this->tl_array) && $getUserid !=''){
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('f.nextfollowupdate', $today);
		}
		////////////// Time Filter ///////////////////
		$times = strtotime(date("H:i")) + 60*60;
		$timet = date("H:i:s", $times); 
		$times1 = strtotime(date("H:i")) - 60*60;
		$timet1 = date("H:i:s", $times1);
		if($this->input->get('name')=='current')
		{
		
				$this->db->where('f.nextfollowuptime>=',$timet1);
				$this->db->where('f.nextfollowuptime<=',$timet);
				$this->db->where('f.nextfollowuptime!=','');
			
			
		}
		////////////////////////////////////////////////////////
		$default_close_lead_status=$this->select_default_close_lead_status();
		if(isset($default_close_lead_status))
		{
			$this->db->where_not_in('l.nextAction',array_values($default_close_lead_status));			
		}
		/*$this -> db -> where('l.nextAction!=', "Close");	
		$this -> db -> where('l.nextAction!=', "Lost");	*/
	
		if(!empty($_POST['contact_no'])){
				$contact=$this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		$query=$this->db->get();
		return $query->result();
	}

/*******************************************************************************************************************/
}
?>