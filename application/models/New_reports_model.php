<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class new_reports_model extends CI_model {
	function __construct() {
		parent::__construct();
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> process_id = $this -> session -> userdata('process_id');
			$this -> process_name = $this -> session -> userdata('process_name');
		//Select Table
		if ($this -> process_id == 6 || $this -> process_id == 7 ) {
			$this -> table_name = 'lead_master l';
			$this -> table_name1 = 'lead_followup f';
			}
		else if ($this -> process_id == 8)
			{
				$this -> table_name = 'lead_master_evaluation l';
			$this -> table_name1 = 'lead_followup_evaluation f';
			} else {
			$this -> table_name = 'lead_master_all l';
			$this -> table_name1 = 'lead_followup_all f';
	
		}
	
		
	}
	function select_location() {
		$this -> db -> select('l.location_id,l.location');
		$this -> db -> from('tbl_manager_process m');
		$this -> db -> join('tbl_location l','l.location_id=m.location_id');
		$this -> db -> where('m.status!=', '-1');
		$this->db->where('l.location_id !=','38');
		if($this->role==5){
			$this -> db -> where('l.location_id', $_SESSION['location_id']);
		}
		if($this->role==4){
			$this -> db -> where('l.location_id', $_SESSION['location_id']);
		}
		//if($_SESSION['user_id']!=1){
		$this -> db -> where('user_id', $_SESSION['user_id']);
		//}
		$this -> db -> where('m.process_id', $this->process_id);
		$this->db->group_by('l.location_id');
		$this->db->order_by('l.location','asc');
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();

	}

	function select_dse($location) {
		$this -> db -> select('concat(u.fname," ",u.lname) as dse_name,u.id');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
		$this -> db -> join('tbl_mapdse d','d.dse_id=u.id');
		$this -> db -> where('m.location_id', $location);
		if($this->role==5){
			$this -> db -> where('d.tl_id', $_SESSION['user_id']);
		}
		if($this->role==4){
			$this -> db -> where('u.id', $_SESSION['user_id']);
		}
			$this -> db -> where('u.id!=', 1);
			if($this->process_id == 8){
				$this -> db -> where('u.role', 16);
			}else{
				$this -> db -> where('u.role', 4);
			}
			
		$this -> db -> where('u.status', 1);
		$this->db->order_by('u.fname','asc');
		$query = $this -> db -> get();
	//		echo $this->db->last_query();
		return $query -> result();

	}
	/******************************************************* DSE Performance Reprot *****************************************/
/*public function search_dse_performance($from_date,$to_date)
{
	$location=$this->input->post('location');
	$dse_name=$this->input->post('user_id');

	$this->db->select("u.fname,u.lname,u.id,l.location");
	$this -> db -> from('lmsuser u');
	$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
	$this -> db -> join('tbl_location l','l.location_id=m.location_id');
	$this->db->where('m.process_id',$this->process_id);
	if($location!=''){
		$this -> db -> where('m.location_id', $location);
	}
	if($dse_name!=''){
		$this -> db -> where('u.id', $dse_name);
	}
		$this -> db -> where('u.id!=', 1);
			$this -> db -> where('u.role', 4);
	$this->db->order_by('u.fname','asc');
	$query=$this->db->get()->result();
	if(count($query)>0)
	{
	foreach ($query as $row) {
	$assign_leads=$this->assign_leads($row->id,$from_date,$to_date);
	$pending_new_leads=$this->pending_new_leads($row->id,$from_date,$to_date);
	$new_leads=$this->new_leads($row->id,$from_date,$to_date);
	$pending_followup_leads=$this->pending_followup_leads($row->id,$from_date,$to_date);
	$live_leads=$this->live_leads($row->id,$from_date,$to_date);	
	$total_lost_leads=$this->total_lost_leads($row->id,$from_date,$to_date);
	$co_dealer_lost_leads=$this->co_dealer_lost_leads($row->id,$from_date,$to_date);
	$other_lost_leads=$this->other_lost_leads($row->id,$from_date,$to_date);
	$booked_leads=$this->booked_leads($row->id,$from_date,$to_date);
	$esc_level1_value='esc_level1';
	$esc_level1_leads=$this->esc_level_leads($row->id,$from_date,$to_date,$esc_level1_value);
	$esc_level2_value='esc_level2';
	$esc_level2_leads=$this->esc_level_leads($row->id,$from_date,$to_date,$esc_level2_value);
	$esc_level3_value='esc_level3';
	$esc_level3_leads=$this->esc_level_leads($row->id,$from_date,$to_date,$esc_level3_value);
	$esc_level1_resolved_value='esc_level1_resolved';
	$esc_level1_resolved_leads=$this->esc_level_leads($row->id,$from_date,$to_date,$esc_level1_resolved_value);
	$esc_level2_resolved_value='esc_level2_resolved';
	$esc_level2_resolved_leads=$this->esc_level_leads($row->id,$from_date,$to_date,$esc_level2_resolved_value);
	$esc_level3_resolved_value='esc_level3_resolved';
	$esc_level3_resolved_leads=$this->esc_level_leads($row->id,$from_date,$to_date,$esc_level3_resolved_value);
	$select_data[]=array('location'=>$row->location,'dse_id'=>$row->id,'dse_fname'=>$row->fname,'dse_lname'=>$row->lname,'assign_lead'=>$assign_leads,'pending_new_leads'=>$pending_new_leads,'pending_followup_leads'=>$pending_followup_leads,'live_leads'=>$live_leads,'total_lost_leads'=>$total_lost_leads,'co_dealer_lost_leads'=>$co_dealer_lost_leads,'other_lost_leads'=>$other_lost_leads,'booked_leads'=>$booked_leads
	,'esc_level1_leads'=>$esc_level1_leads,'esc_level2_leads'=>$esc_level2_leads,'esc_level3_leads'=>$esc_level3_leads,
	'esc_level1_resolved_leads'=>$esc_level1_resolved_leads,'esc_level2_resolved_leads'=>$esc_level2_resolved_leads,'esc_level3_resolved_leads'=>$esc_level3_resolved_leads,
	'new_leads'=>$new_leads);
	}
	}
else {
	$select_data=array();
}
	return $select_data;
}*/
	/******************************************************* DSE Performance Reprot *****************************************/
public function dse_performance($location,$dse_name,$from_date,$to_date)
{
	$location_dse1=array();
	$get_locations=$this->select_location();
	foreach($get_locations as $location_dse) {
	
        $location_dse1[] = $location_dse->location_id; 
}
	$this->db->select("u.fname,u.lname,u.id,l.location");
	$this -> db -> from('lmsuser u');
	$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
	$this -> db -> join('tbl_location l','l.location_id=m.location_id');
	$this->db->where('m.process_id',$this->process_id);
	if($location!=''){
		if($location =='All'){
			$this -> db -> where_in('m.location_id', $location_dse1);
			
		}else{
		$this -> db -> where('m.location_id', $location);
		}
	}
	if($dse_name!=''){
		$this -> db -> where('u.id', $dse_name);
	}
		$this -> db -> where('u.id!=', 1);
		$this -> db -> where('u.status', 1);
			if($this->process_id == 8){
				$this -> db -> where('u.role', 16);
			}else{
				$this -> db -> where('u.role', 4);
			}
			
	$this->db->order_by('l.location','asc');
	$query=$this->db->get()->result();
	if(count($query)>0)
	{
	foreach ($query as $row) {
	$assign_leads=$this->assign_leads($row->id,$from_date,$to_date);
	$pending_new_leads=$this->pending_new_leads($row->id,$from_date,$to_date);
	$new_leads=$this->new_leads($row->id,$from_date,$to_date);
	$pending_followup_leads=$this->pending_followup_leads($row->id,$from_date,$to_date);
	$live_leads=$this->live_leads($row->id,$from_date,$to_date);	
	$total_lost_leads=$this->total_lost_leads($row->id,$from_date,$to_date);
	$co_dealer_lost_leads=$this->co_dealer_lost_leads($row->id,$from_date,$to_date);
	$other_lost_leads=$this->other_lost_leads($row->id,$from_date,$to_date);
	$booked_leads=$this->booked_leads($row->id,$from_date,$to_date);
	$esc_level1_value='esc_level1';
	$esc_level1_leads=$this->esc_level_leads($row->id,$from_date,$to_date,$esc_level1_value);
	$esc_level2_value='esc_level2';
	$esc_level2_leads=$this->esc_level_leads($row->id,$from_date,$to_date,$esc_level2_value);
	$esc_level3_value='esc_level3';
	$esc_level1_resolved_value='esc_level1_resolved';
	$esc_level1_resolved_leads=$this->esc_level_leads($row->id,$from_date,$to_date,$esc_level1_resolved_value);
	$esc_level2_resolved_value='esc_level2_resolved';
	$esc_level2_resolved_leads=$this->esc_level_leads($row->id,$from_date,$to_date,$esc_level2_resolved_value);
	$esc_level3_resolved_value='esc_level3_resolved';
	$esc_level3_resolved_leads=$this->esc_level_leads($row->id,$from_date,$to_date,$esc_level3_resolved_value);
	$esc_level3_leads=$this->esc_level_leads($row->id,$from_date,$to_date,$esc_level3_value);
	$select_data[]=array('location'=>$row->location,'dse_id'=>$row->id,'dse_fname'=>$row->fname,'dse_lname'=>$row->lname,'assign_lead'=>$assign_leads,'pending_new_leads'=>$pending_new_leads,'pending_followup_leads'=>$pending_followup_leads,'live_leads'=>$live_leads,'total_lost_leads'=>$total_lost_leads,'co_dealer_lost_leads'=>$co_dealer_lost_leads,'other_lost_leads'=>$other_lost_leads,'booked_leads'=>$booked_leads
	,'esc_level1_leads'=>$esc_level1_leads,'esc_level2_leads'=>$esc_level2_leads,'esc_level3_leads'=>$esc_level3_leads,
	'esc_level1_resolved_leads'=>$esc_level1_resolved_leads,'esc_level2_resolved_leads'=>$esc_level2_resolved_leads,'esc_level3_resolved_leads'=>$esc_level3_resolved_leads,
	'new_leads'=>$new_leads
	);
	}
	}
else {
	$select_data=array();
}
	return $select_data;
}
public function esc_level_leads($id,$from_date,$to_date,$esc_level1_value)
{
	$this->db->select('count(distinct l.enq_id) as leadCount');
	$this->db->from($this -> table_name);
	
	$this -> db -> where($esc_level1_value, "Yes");
	if($this->process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('assign_to_e_exe',$id);
		$this -> db -> where('l.assign_to_e_exe_date>=',$from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=',$to_date);
		}else
		{
			$this -> db -> where('l.process', $this->process_name);
			$this->db->where('assign_to_dse',$id);
			$this -> db -> where('l.assign_to_dse_date>=',$from_date);
		$this -> db -> where('l.assign_to_dse_date<=',$to_date);
		}
		
	$query=$this->db->get();
	$query=$query->result();
	$assign_count=$query[0]->leadCount;
	return $assign_count;
	
}

public function assign_leads($id,$from_date,$to_date)
{
	$this->db->select('count(distinct l.enq_id) as leadCount');
	$this->db->from($this -> table_name);

	if($this->process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where('assign_to_e_exe',$id);
		$this -> db -> where('l.assign_to_e_exe_date >=',$from_date);
		$this -> db -> where('l.assign_to_e_exe_date <=',$to_date);
		}else
		{
				
			
			$this->db->where('assign_to_dse',$id);
			$this -> db -> where('l.process', $this->process_name);
			$this -> db -> where('l.assign_to_dse_date>=',$from_date);
		$this -> db -> where('l.assign_to_dse_date<=',$to_date);
		}
		
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$assign_count=$query[0]->leadCount;
	return $assign_count;
	
}
public function new_leads($id,$from_date,$to_date)
{
	$today=date('Y-m-d');
	$this->db->select('count(distinct l.enq_id) as leadCount');
	
	$this->db->from($this -> table_name);
	
	
	$this -> db -> where('l.nextAction!=', "Close");	
	if($this->process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('assign_to_e_exe',$id);
		$this->db->where('exe_followup_id',0);
		$this->db->where('assign_to_e_exe_date',$today);
		$this -> db -> where('l.assign_to_e_exe_date>=',$from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=',$to_date);
		}else
		{
			
			$this->db->where('assign_to_dse',$id);
			$this->db->where('dse_followup_id',0);
			$this -> db -> where('l.process', $this->process_name);
			$this->db->where('assign_to_dse_date',$today);
			$this -> db -> where('l.assign_to_dse_date>=',$from_date);
			$this -> db -> where('l.assign_to_dse_date<=',$to_date);
		}
		
	$query=$this->db->get();
	$query=$query->result();
	$pending_new_lead_count=$query[0]->leadCount;
	return $pending_new_lead_count;
}
public function pending_new_leads($id,$from_date,$to_date)
{
	$today=date('Y-m-d');
	$this->db->select('count(distinct l.enq_id) as leadCount');
	
	$this->db->from($this -> table_name);
	
	
	$this -> db -> where('l.nextAction!=', "Close");	
	if($this->process_id==8){
			$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where('assign_to_e_exe',$id);
			$this->db->where('exe_followup_id',0);
			$this->db->where('assign_to_e_exe_date<',$today);
			$this -> db -> where('l.assign_to_e_exe_date>=',$from_date);
			$this -> db -> where('l.assign_to_e_exe_date<=',$to_date);
		}else
		{
			
			$this->db->where('assign_to_dse',$id);
			$this->db->where('dse_followup_id',0);
			$this -> db -> where('l.process', $this->process_name);
			$this->db->where('assign_to_dse_date<',$today);
			$this -> db -> where('l.assign_to_dse_date>=',$from_date);
			$this -> db -> where('l.assign_to_dse_date<=',$to_date);
		}
		
	$query=$this->db->get();
	$query=$query->result();
	$pending_new_lead_count=$query[0]->leadCount;
	return $pending_new_lead_count;
}
public function pending_followup_leads($id,$from_date,$to_date)
{
	$today=date('Y-m-d');
	$this->db->select('count(distinct l.enq_id) as leadCount');
	
	$this->db->from($this -> table_name);
	
	
	if($this->process_id==8){
		$this->db->join($this -> table_name1,'l.exe_followup_id=f.id');
	
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$id);
		$this -> db -> where('l.assign_to_e_exe_date>=',$from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=',$to_date);
		}else
		{
			$this->db->join($this -> table_name1,'l.dse_followup_id=f.id');
	
			
			$this->db->where('l.assign_to_dse',$id);
			$this -> db -> where('l.process', $this->process_name);
			$this -> db -> where('l.assign_to_dse_date>=',$from_date);
			$this -> db -> where('l.assign_to_dse_date<=',$to_date);
		}

	$this -> db -> where('f.nextfollowupdate <', $today);
	$this -> db -> where('f.nextfollowupdate!=', '0000-00-00');
	$this -> db -> where('l.nextAction!=', "Close");	
	
	$query=$this->db->get();
	$query=$query->result();
	$pending_new_lead_count=$query[0]->leadCount;
	return $pending_new_lead_count;
}
public function live_leads($id,$from_date,$to_date)
{
	$today=date('Y-m-d');
	$this->db->select('count(distinct l.enq_id) as leadCount');
	
	$this->db->from($this -> table_name);
	
	
	if($this->process_id==8){
		$this->db->join($this -> table_name1,'l.exe_followup_id=f.id');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$id);
	$this -> db -> where('l.exe_followup_id !=', '0');
	$this -> db -> where('l.assign_to_e_exe_date>=',$from_date);
	$this -> db -> where('l.assign_to_e_exe_date<=',$to_date);
		}else
		{
			$this->db->join($this -> table_name1,'l.dse_followup_id=f.id');
			
			$this->db->where('l.assign_to_dse',$id);
			$this -> db -> where('l.process', $this->process_name);
			$this -> db -> where('l.dse_followup_id !=', '0');
			$this -> db -> where('l.assign_to_dse_date>=',$from_date);
			$this -> db -> where('l.assign_to_dse_date<=',$to_date);
		}
	
	$this -> db -> where('l.nextAction !=', 'Booked From Autovista');
	$this -> db -> where('l.nextAction !=', 'Close');	
	
	$query=$this->db->get();
	$query=$query->result();
	$pending_new_lead_count=$query[0]->leadCount;
	return $pending_new_lead_count;
}
public function total_lost_leads($id,$from_date,$to_date)
{
	$today=date('Y-m-d');
	$this->db->select('count(distinct l.enq_id) as leadCount');
	
	$this->db->from($this -> table_name);
	
	
	
	if($this->process_id==8){
	
		$this->db->join($this -> table_name1,'l.exe_followup_id=f.id');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$id);
		$this -> db -> where('l.assign_to_e_exe_date>=',$from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=',$to_date);
		}else
		{
			$this->db->join($this -> table_name1,'l.dse_followup_id=f.id');
			$this -> db -> where('l.process', $this->process_name);
			$this->db->where('l.assign_to_dse',$id);
			$this -> db -> where('l.assign_to_dse_date>=',$from_date);
	$this -> db -> where('l.assign_to_dse_date<=',$to_date);
		}
	
	$this -> db -> where('l.nextAction', 'Close');
	$query=$this->db->get();
	$query=$query->result();
	$pending_new_lead_count=$query[0]->leadCount;
	return $pending_new_lead_count;
}
public function co_dealer_lost_leads($id,$from_date,$to_date)
{
	
	$this->db->select('count(distinct l.enq_id) as leadCount');
	
	$this->db->from($this -> table_name);

	if($this->process_id==8){
		$this->db->join($this -> table_name1,'l.exe_followup_id=f.id');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$id);
		$this -> db -> where('l.assign_to_e_exe_date>=',$from_date);
	$this -> db -> where('l.assign_to_e_exe_date<=',$to_date);
		}else
		{
			$this->db->join($this -> table_name1,'l.dse_followup_id=f.id');
		
			$this->db->where('l.assign_to_dse',$id);
			$this -> db -> where('l.process', $this->process_name);
			$this -> db -> where('l.assign_to_dse_date>=',$from_date);
	$this -> db -> where('l.assign_to_dse_date<=',$to_date);
		}
	
	$this -> db -> where('l.feedbackStatus ', 'Lost to Co-Dealer');
	$this -> db -> where('l.nextAction', 'Close');
	$query=$this->db->get();
	$query=$query->result();
	$pending_new_lead_count=$query[0]->leadCount;
	return $pending_new_lead_count;
}
public function other_lost_leads($id,$from_date,$to_date)
{
	$this->db->select('count(distinct l.enq_id) as leadCount');
	
	$this->db->from($this -> table_name);
	
	
	
	if($this->process_id==8){
		$this->db->join($this -> table_name1,'l.exe_followup_id=f.id');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$id);
		$this -> db -> where('l.assign_to_e_exe_date>=',$from_date);
	$this -> db -> where('l.assign_to_e_exe_date<=',$to_date);
		}else
		{
			$this->db->join($this -> table_name1,'l.dse_followup_id=f.id');
			
			$this->db->where('l.assign_to_dse',$id);
			$this -> db -> where('l.process', $this->process_name);
			$this -> db -> where('l.assign_to_dse_date>=',$from_date);
	$this -> db -> where('l.assign_to_dse_date<=',$to_date);
		}
	
	$this -> db -> where('l.feedbackStatus ', 'Others');
	$this -> db -> where('l.nextAction', 'Close');
	$query=$this->db->get();
	$query=$query->result();
	$pending_new_lead_count=$query[0]->leadCount;
	return $pending_new_lead_count;
}
	public function booked_leads($id, $fromdate, $todate) {

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('l.assign_to_e_exe', $id);
			$this -> db -> where('l.assign_to_e_exe_date>=',$fromdate);
		$this -> db -> where('l.assign_to_e_exe_date<=',$todate);
		} else {
			
			$this -> db -> where('l.assign_to_dse', $id);
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('l.assign_to_dse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_dse_date<=',$todate);
		}
		$this -> db -> where('l.nextAction', 'Booked From Autovista');
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
/******************************************************************************************************************/
/*********************************   DSE Productivity Report  ****************************************************/
/*public function search_productivity()
{
	$location=$this->input->post('location');
	$dse_name=$this->input->post('dse_id');
	$from_date=$this->input->post('from_date');
	$to_date=$this->input->post('to_date');
	$date_type=$this->input->post('date_type');
	if($date_type=='As on Date')
	{
		$to_date=$from_date;
		$from_date='2017-01-01';
	}
	$this->db->select("u.fname,u.lname,u.id,l.location");
	$this -> db -> from('lmsuser u');
	$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
	$this -> db -> join('tbl_location l','l.location_id=m.location_id');
	$this->db->where('m.process_id',$this->process_id);
	if($location!=''){
		$this -> db -> where('m.location_id', $location);
	}
	if($dse_name!=''){
		$this -> db -> where('u.id', $dse_name);
	}
	
	$this -> db -> where('u.role', 4);	
	$this -> db -> where('u.status', 1);
	$this->db->order_by('u.fname','asc');
	$query=$this->db->get();
	
	$query=$query->result();
	if(count($query)>0)
	{
	foreach ($query as $row) {
	$total_call=$this->total_call($row->id,$from_date,$to_date);
	$total_connected=$this->total_connected($row->id,$from_date,$to_date,'Connected');
	$total_not_connected=$this->total_connected($row->id,$from_date,$to_date,'Not Connected');
	$total_call_delay_15=$this->total_call_delay($row->id,$from_date,$to_date,'15');
	$total_call_delay_30=$this->total_call_delay($row->id,$from_date,$to_date,'30');
	$lead_assigned=$this->lead_assigned($row->id,$from_date,$to_date);
	
	$booked=$this->total_booked($row->id,$from_date,$to_date);
	$evaluation_allotted=$this->appointment_count($row->id,$from_date,$to_date,'Evaluation Allotted','');
	$evaluation_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Evaluation Allotted','Conducted');
	$evaluation_not_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Evaluation Allotted','Not Conducted');
	$test_drive=$this->appointment_count($row->id,$from_date,$to_date,'Test Drive','');
	$test_drive_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Test Drive','Conducted');
	$test_drive_not_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Test Drive','Not Conducted');
	$home_visit=$this->appointment_count($row->id,$from_date,$to_date,'Home Visit','');
	$home_visit_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Home Visit','Conducted');
	$home_visit_not_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Home Visit','Not Conducted');
	$showroom_visit=$this->appointment_count($row->id,$from_date,$to_date,'Showroom Visit','');
	$showroom_visit_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Showroom Visit','Conducted');
	$showroom_visit_not_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Showroom Visit','Not Conducted');
	$select_data[]=array('location'=>$row->location,'dse_id'=>$row->id,'dse_fname'=>$row->fname,'dse_lname'=>$row->lname,'total_call'=>$total_call,'total_connected'=>$total_connected,'total_not_connected'=>$total_not_connected,'total_call_delay_15'=>$total_call_delay_15,'total_call_delay_30'=>$total_call_delay_30,'lead_assigned'=>$lead_assigned,'evaluation_allotted'=>$evaluation_allotted,'test_drive'=>$test_drive,'home_visit'=>$home_visit,'showroom_visit'=>$showroom_visit,'booked'=>$booked
	,'home_visit_conducted'=>$home_visit_conducted,'home_visit_not_conducted'=>$home_visit_not_conducted,
	'showroom_visit_conducted'=>$showroom_visit_conducted,'showroom_visit_not_conducted'=>$showroom_visit_not_conducted,'test_drive_conducted'=>$test_drive_conducted,'test_drive_not_conducted'=>$test_drive_not_conducted,'evaluation_conducted'=>$evaluation_conducted,'evaluation_not_conducted'=>$evaluation_not_conducted);
	
	
//	$select_data[]=array('dse_fname'=>$row->fname,'dse_lname'=>$row->lname,'total_call'=>$total_call,'total_connected'=>$total_connected,'total_not_connected'=>$total_not_connected,'total_call_delay_15'=>$total_call_delay_15,'total_call_delay_30'=>$total_call_delay_30,'lead_assigned'=>$lead_assigned,'evaluation_allotted'=>$evaluation_allotted,'test_drive'=>$test_drive,'home_visit'=>$home_visit,'showroom_visit'=>$showroom_visit);
	
	}
	}
else {
	$select_data=array();
}
	return $select_data;
}*/
/*********************************   One pager DSE Productivity Report  ****************************************************/
public function dse_productivity($location,$dse_name,$from_date,$to_date)
{
	$location_dse1=array();
	$get_locations=$this->select_location();
	foreach($get_locations as $location_dse) {
	
        $location_dse1[] = $location_dse->location_id; 
}
	$this->db->select("u.fname,u.lname,u.id,l.location");
	$this -> db -> from('lmsuser u');
	$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
	$this -> db -> join('tbl_location l','l.location_id=m.location_id');
	$this->db->where('m.process_id',$this->process_id);
	if($location!=''){
		if($location =='All'){
			$this -> db -> where_in('m.location_id', $location_dse1);
			
		}else{
		$this -> db -> where('m.location_id', $location);
		}
	}
	if($dse_name!=''){
		
		$this -> db -> where('u.id', $dse_name);
	}
	if($this->process_id==8){
		$this -> db -> where('u.role', 16);	
	}else{
		$this -> db -> where('u.role', 4);	
	}
	
	$this -> db -> where('u.status', 1);
	$this -> db -> where('u.status', 1);
	$this->db->order_by('l.location','asc');
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	//print_r($query);
	if(count($query)>0){
	foreach ($query as $row) {
	$total_call=$this->total_call($row->id,$from_date,$to_date);
	$total_connected=$this->total_connected($row->id,$from_date,$to_date,'Connected');
	$total_not_connected=$this->total_connected($row->id,$from_date,$to_date,'Not Connected');
	$total_call_delay_15=$this->total_call_delay($row->id,$from_date,$to_date,'15');
	$total_call_delay_30=$this->total_call_delay($row->id,$from_date,$to_date,'30');
	$lead_assigned=$this->lead_assigned($row->id,$from_date,$to_date);
	/*$evaluation_allotted=$this->appointment_type($row->id,$from_date,$to_date,'Evaluation Allotted');
	$test_drive=$this->appointment_type($row->id,$from_date,$to_date,'Test Drive');
	$home_visit=$this->appointment_type($row->id,$from_date,$to_date,'Home Visit');
	$showroom_visit=$this->appointment_type($row->id,$from_date,$to_date,'Showroom Visit');*/
	$booked=$this->total_booked($row->id,$from_date,$to_date);
	$evaluation_allotted=$this->appointment_count($row->id,$from_date,$to_date,'Evaluation Allotted','');
	$evaluation_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Evaluation Allotted','Conducted');
	$evaluation_not_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Evaluation Allotted','Not Conducted');
	$test_drive=$this->appointment_count($row->id,$from_date,$to_date,'Test Drive','');
	$test_drive_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Test Drive','Conducted');
	$test_drive_not_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Test Drive','Not Conducted');
	$home_visit=$this->appointment_count($row->id,$from_date,$to_date,'Home Visit','');
	$home_visit_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Home Visit','Conducted');
	$home_visit_not_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Home Visit','Not Conducted');
	$showroom_visit=$this->appointment_count($row->id,$from_date,$to_date,'Showroom Visit','');
	$showroom_visit_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Showroom Visit','Conducted');
	$showroom_visit_not_conducted=$this->appointment_count($row->id,$from_date,$to_date,'Showroom Visit','Not Conducted');
	
		$select_data[]=array('dse_id'=>$row->id,'location'=>$row->location,'dse_fname'=>$row->fname,'dse_lname'=>$row->lname,'total_call'=>$total_call,'total_connected'=>$total_connected,'total_not_connected'=>$total_not_connected,'total_call_delay_15'=>$total_call_delay_15,'total_call_delay_30'=>$total_call_delay_30,'lead_assigned'=>$lead_assigned,'evaluation_allotted'=>$evaluation_allotted,'test_drive'=>$test_drive,'home_visit'=>$home_visit,'showroom_visit'=>$showroom_visit,'booked'=>$booked
		,'home_visit_conducted'=>$home_visit_conducted,'home_visit_not_conducted'=>$home_visit_not_conducted,
	'showroom_visit_conducted'=>$showroom_visit_conducted,'showroom_visit_not_conducted'=>$showroom_visit_not_conducted,'test_drive_conducted'=>$test_drive_conducted,'test_drive_not_conducted'=>$test_drive_not_conducted,'evaluation_conducted'=>$evaluation_conducted,'evaluation_not_conducted'=>$evaluation_not_conducted);
	}	
}else{
		$select_data=array();
	}
		
	
//	$select_data[]=array('dse_fname'=>$row->fname,'dse_lname'=>$row->lname,'total_call'=>$total_call,'total_connected'=>$total_connected,'total_not_connected'=>$total_not_connected,'total_call_delay_15'=>$total_call_delay_15,'total_call_delay_30'=>$total_call_delay_30,'lead_assigned'=>$lead_assigned,'evaluation_allotted'=>$evaluation_allotted,'test_drive'=>$test_drive,'home_visit'=>$home_visit,'showroom_visit'=>$showroom_visit);
	
	
	return $select_data;
}
public function total_call($id,$from_date,$to_date)
{
	$this->db->select('count( l.enq_id) as leadCount');
	$this->db->from($this -> table_name);
	$this->db->join($this -> table_name1,'l.enq_id=f.leadid');
	if($this->process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $this->process_name);
		}
	

	
	$this->db->where('f.assign_to',$id);
	$this->db->where('f.date>=',$from_date);
	$this->db->where('f.date<=',$to_date);
	
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$total_call_count=$query[0]->leadCount;
	return $total_call_count;
	
}
public function total_connected($id,$from_date,$to_date,$contactibility)
{
	$this->db->select('count( l.enq_id) as leadCount');
	$this->db->from($this -> table_name);
	$this->db->join($this -> table_name1,'l.enq_id=f.leadid');
	
	
	if($this->process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $this->process_name);
		}
	
	$this->db->where('f.assign_to',$id);
	$this->db->where('f.contactibility',$contactibility);

	$this->db->where('f.date>=',$from_date);
	$this->db->where('f.date<=',$to_date);
	
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$total_connected_count=$query[0]->leadCount;
	return $total_connected_count;
}
public function lead_assigned($id,$from_date,$to_date)
{
	$this->db->select('count(distinct l.enq_id) as leadCount');
	$this->db->from($this -> table_name);
	if($this->process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$id);
	
	$this->db->where('l.assign_to_e_exe_date>=',$from_date);
	$this->db->where('l.assign_to_e_exe_date<=',$to_date);
		}else
		{
			$this -> db -> where('l.process', $this->process_name);
			$this->db->where('l.assign_to_dse',$id);
	
	$this->db->where('l.assign_to_dse_date>=',$from_date);
	$this->db->where('l.assign_to_dse_date<=',$to_date);
		}
	
	
	
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$total_connected_count=$query[0]->leadCount;
	return $total_connected_count;
}
public function appointment_type($id,$from_date,$to_date,$appointment_type)
{
	$this->db->select('count(distinct l.enq_id) as leadCount');
	$this->db->from($this -> table_name);
	$this->db->join($this -> table_name1,'l.enq_id=f.leadid');
	
	
	if($this->process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $this->process_name);
		}
	
	$this->db->where('f.assign_to',$id);
	$this->db->where('f.appointment_type',$appointment_type);
	$this->db->where('f.appointment_status','Conducted');
	$this->db->where('f.date>=',$from_date);
	$this->db->where('f.date<=',$to_date);
	
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$total_connected_count=$query[0]->leadCount;
	return $total_connected_count;
}
public function appointment_count($id,$from_date,$to_date,$appointment_type,$status)
{
	$this->db->select('count(distinct l.enq_id) as leadCount');
	$this->db->from($this -> table_name);
	$this->db->join($this -> table_name1,'l.enq_id=f.leadid');
	
	
	if($this->process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where('l.assign_to_e_exe',$id);
		}else
		{
			$this -> db -> where('l.process', $this->process_name);
			$this->db->where('l.assign_to_dse',$id);
		}
	
	
	$this->db->where('f.appointment_type',$appointment_type);
	if($status!=''){
		$this->db->where('f.appointment_status',$status);	
		}
	$this->db->where('l.created_date>=',$from_date);
	$this->db->where('l.created_date<=',$to_date);
	
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$total_connected_count=$query[0]->leadCount;
	return $total_connected_count;
}

public function total_booked($id,$from_date,$to_date)
{
	$this->db->select('count( l.enq_id) as leadCount');
	$this->db->from($this -> table_name);
	
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('l.assign_to_e_exe', $id);
			$this->db->where('l.assign_to_e_exe_date>=',$from_date);
			$this->db->where('l.assign_to_e_exe_date<=',$to_date);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('l.assign_to_dse', $id);
			$this->db->where('l.assign_to_dse_date>=',$from_date);
			$this->db->where('l.assign_to_dse_date<=',$to_date);
		}
		$this -> db -> where('l.nextAction', 'Booked From Autovista');


	
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$total_connected_count=$query[0]->leadCount;
	return $total_connected_count;
}

public function total_call_delay($id,$from_date,$to_date,$time)
{
	$this->db->select('count(distinct l.enq_id) as leadCount');
	$this->db->from($this -> table_name);
	$this->db->join($this -> table_name1,'l.enq_id=f.leadid');
	
	
	$this->db->where('l.process',$this -> process_name);
	
	$this->db->where('f.assign_to',$id);
	//$this->db->where('l.assign_to_cse_time ',$contactibility);

	$this->db->where('f.date>=',$from_date);
	$this->db->where('f.date<=',$to_date);
	
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$total_connected_count=$query[0]->leadCount;
	return $total_connected_count;
}


	}
?>