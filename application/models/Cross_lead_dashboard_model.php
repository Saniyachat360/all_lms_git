<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class cross_lead_dashboard_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}

public function cross_lead_dashboard(){
	$user_id=$_SESSION['user_id'];
$this->db->select('*');
$this->db->from('tbl_process');
$this->db->where('process_name!=','Complaint');
$query=$this->db->get()->result();
foreach ($query as $row) {
	
	$live_lead=$this->live_leads($user_id,$row->process_name);
	$converted_lead=$this->converted_leads($user_id,$row->process_name);
	$lost_lead=$this->lost_leads($user_id,$row->process_name);
	$total_leads=$this->total_leads($user_id,$row->process_name);
	$select_data[]=array('process'=>$row->process_name,'user_id'=>$user_id,'live_lead'=>$live_lead,'converted_lead'=>$converted_lead,'lost_leads'=>$lost_lead,'total_leads'=>$total_leads);
}
	
	return $select_data;
	
}
public function total_leads($user_id,$process_name){
	if($process_name=='New Car' || $process_name=='POC Sales' )	{
		$table_name='lead_master';
	}else if($process_name=='POC Purchase'){
		$table_name='lead_master_evaluation';
	}else{
		$table_name='lead_master_all';
	}
	
	$this->db->select('count(enq_id) as lead_count');
	$this->db->from($table_name);
	$this->db->where('cross_lead_user_id',$user_id);
	$this->db->where ('process',$process_name);

	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	return $t_lead=$query[0]->lead_count;
	
}
public function live_leads($user_id,$process_name){
	if($process_name=='New Car' || $process_name=='POC Sales' )	{
		$table_name='lead_master';
	}else if($process_name=='POC Purchase'){
		$table_name='lead_master_evaluation';
	}else{
		$table_name='lead_master_all';
	}
	
	$this->db->select('count(enq_id) as lead_count');
	$this->db->from($table_name);
	$this->db->where('cross_lead_user_id',$user_id);
	$this->db->where ('process',$process_name);
	$this->db->where('nextaction!=','Close');
	$this->db->where('nextaction!=','Booked From Autovista');
	$query=$this->db->get()->result();
	return $t_lead=$query[0]->lead_count;
	
}
public function converted_leads($user_id,$process_name){
	if($process_name=='New Car' || $process_name=='POC Sales' )	{
		$table_name='lead_master';
	}else if($process_name=='POC Purchase'){
		$table_name='lead_master_evaluation';
	}else{
		$table_name='lead_master_all';
	}
	
	$this->db->select('count(enq_id) as lead_count');
	$this->db->from($table_name);
	$this->db->where('cross_lead_user_id',$user_id);
	$this->db->where ('process',$process_name);
	$this->db->where('nextaction','Booked From Autovista');
	$query=$this->db->get()->result();
	return $t_lead=$query[0]->lead_count;
}
public function lost_leads($user_id,$process_name){
	if($process_name=='New Car' || $process_name=='POC Sales' )	{
		$table_name='lead_master';
	}else if($process_name=='POC Purchase'){
		$table_name='lead_master_evaluation';
	}else{
		$table_name='lead_master_all';
	}
	
	$this->db->select('count(enq_id) as lead_count');
	$this->db->from($table_name);
	$this->db->where('cross_lead_user_id',$user_id);
	$this->db->where ('process',$process_name);
	$this->db->where('nextaction','Close');
$query=$this->db->get()->result();
	return $t_lead=$query[0]->lead_count;
}
public function select_lead($id,$process,$name) {
		if($process=='New Car' || $process=='POC Sales' )	{
		$table_name='lead_master';
		$ftable_name='lead_followup';
	}else if($process=='POC Purchase'){
		$table_name='lead_master_evaluation';
		$ftable_name='lead_followup_evaluation';
	}else{
		$table_name='lead_master_all';
		$ftable_name='lead_followup_all';
	}
	
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(6);
		
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}		if($process=='POC Purchase'){
		$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			,l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id,l.cross_lead_escalation_remark');
		}else{
				$this -> db -> select('
			ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			,l.assign_to_dse,l.assign_to_dse_tl,l.dse_followup_id,l.cross_lead_escalation_remark');
			
		}
		$this -> db -> from($table_name.' l');
		$this -> db -> join($ftable_name.' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');	
			if($process=='POC Purchase'){
		$this -> db -> join( 'lead_followup f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		}else{
			$this -> db -> join( 'lead_followup f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		}
		$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');		$process_name = $this -> input -> post('process_id');				
		
		$this -> db -> where('l.process', $process);	
		
		$this->db->where('cross_lead_user_id',$id);
		
		if($name=='total'){	}
		else if($name=='live'){
			$this->db->where('l.nextaction!=','Close');
			$this->db->where('l.nextaction!=','Booked From Autovista');
		}else if($name=='lost'){
			$this->db->where('l.nextaction','Close');
		}else if($name=='converted'){
			$this->db->where('l.nextaction','Booked From Autovista');
		}
		
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		//Limit
		$this -> db -> limit($rec_limit, $offset);
		$query1 = $this -> db -> get()-> result();
	//echo $this->db->last_query();				
		return $query1;
	}

	// Select All Lead Details
	public function select_lead_count($id,$process,$name) {
	ini_set('memory_limit', '-1');
	if($process=='New Car' || $process=='POC Sales' )	{
		$table_name='lead_master';
		$ftable_name='lead_followup';
	}else if($process=='POC Purchase'){
		$table_name='lead_master_evaluation';
		$ftable_name='lead_followup_evaluation';
	}else{
		$table_name='lead_master_all';
		$ftable_name='lead_followup_all';
	}
	
	
		$this -> db -> select('count(enq_id) as count_lead');

		$this -> db -> from($table_name.' l');
		$this -> db -> where('l.process', $process);	
		
		$this->db->where('cross_lead_user_id',$id);
		
			if($name=='total'){	}
		else if($name=='live'){
			$this->db->where('nextaction!=','Close');
			$this->db->where('nextaction!=','Booked From Autovista');
		}else if($name=='lost'){
			$this->db->where('nextaction','Close');
		}else if($name=='converted'){
			$this->db->where('nextaction','Booked From Autovista');
		}
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		return $query -> result();


	}
}
?>
