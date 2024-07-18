<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class CSE_reports_model extends CI_model {
	public $process_name;
	public $role;
	public $user_id;
	public $table_name;
	public $table_name1;
	function __construct() {
		parent::__construct();
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> process_id = $this -> session -> userdata('process_id');
			$this -> process_name = $this -> session -> userdata('process_name');
		//Select Table
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master l';
			$this -> table_name1 = 'lead_followup f';
			}else if ($this -> process_id == 8)
			{
				$this -> table_name = 'lead_master_evaluation l';
			$this -> table_name1 = 'lead_followup_evaluation f';
			}
				 else {
			$this -> table_name = 'lead_master_all l';
			$this -> table_name1 = 'lead_followup_all f';
	
		}
	
		
	}

/**************************************    CSE Productivity    **********************************************************/
	function select_cse() {
		$this -> db -> select('concat(u.fname," ",u.lname) as cse_name,u.id');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
		$this -> db -> where('m.process_id', $this->process_id);
		$this -> db -> where('m.location_id', 38);
		$this -> db -> where('u.role', 3);
		$this -> db -> where('u.status', 1);
		$this -> db -> group_by('u.id');
		$query = $this -> db -> get();
	//		echo $this->db->last_query();
		return $query -> result();

	}
/*public function search_productivity($from_date,$to_date)
{
	$cse_id=$this->input->post('cse_id');
	
	$this -> db -> select('u.fname,u.lname,u.id');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
		$this -> db -> where('m.process_id', $this->process_id);
		$this -> db -> where('m.location_id', 38);
		$this -> db -> where('u.role', 3);
		if($cse_id!=''){
				$this -> db -> where('u.id', $cse_id);
		}
		$this -> db -> where('u.status', 1);
		$this -> db -> group_by('u.id');
		$query = $this -> db -> get()->result();
		if(count($query)>0){
	foreach ($query as $row) {
	$total_call=$this->total_call($row->id,$from_date,$to_date);
	$total_connected=$this->total_connected($row->id,$from_date,$to_date,'Connected');
	$total_not_connected=$this->total_connected($row->id,$from_date,$to_date,'Not Connected');
	$lead_assigned=$this->lead_assigned($row->id,$from_date,$to_date);
	$evaluation_allotted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Evaluation Allotted','');
	$evaluation_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Evaluation Allotted','Conducted');
	$evaluation_not_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Evaluation Allotted','Not Conducted');
	$test_drive=$this->cse_appointment_count($row->id,$from_date,$to_date,'Test Drive','');
	$test_drive_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Test Drive','Conducted');
	$test_drive_not_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Test Drive','Not Conducted');
	$home_visit=$this->cse_appointment_count($row->id,$from_date,$to_date,'Home Visit','');
	$home_visit_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Home Visit','Conducted');
	$home_visit_not_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Home Visit','Not Conducted');
	$showroom_visit=$this->cse_appointment_count($row->id,$from_date,$to_date,'Showroom Visit','');
	$showroom_visit_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Showroom Visit','Conducted');
	$showroom_visit_not_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Showroom Visit','Not Conducted');
	$sent_to_showroom_leads= $this -> cse_sent_to_showroom_leads($row -> id, $from_date, $to_date);
	
		
	$select_data[]=array('cse_id'=>$row->id,'cse_fname'=>$row->fname,'cse_lname'=>$row->lname,'total_call'=>$total_call,'total_connected'=>$total_connected,'total_not_connected'=>$total_not_connected,'lead_assigned'=>$lead_assigned,'sent_to_showroom_leads'=>$sent_to_showroom_leads,'evaluation_allotted'=>$evaluation_allotted,'test_drive'=>$test_drive,'home_visit'=>$home_visit,'showroom_visit'=>$showroom_visit,
	'home_visit_conducted'=>$home_visit_conducted,'home_visit_not_conducted'=>$home_visit_not_conducted,
	'showroom_visit_conducted'=>$showroom_visit_conducted,'showroom_visit_not_conducted'=>$showroom_visit_not_conducted,'test_drive_conducted'=>$test_drive_conducted,'test_drive_not_conducted'=>$test_drive_not_conducted,'evaluation_conducted'=>$evaluation_conducted,'evaluation_not_conducted'=>$evaluation_not_conducted);
}
		}else{
			$select_data=array();
		}
	return $select_data;
}*/
public function cse_productivity($cse_id,$from_date,$to_date)
{
		$this -> db -> select('u.fname,u.lname,u.id');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
		$this -> db -> where('m.process_id', $this->process_id);
		$this -> db -> where('m.location_id', 38);
		$this -> db -> where('u.role', 3);
		if($cse_id!=''){
				$this -> db -> where('u.id', $cse_id);
		}
		$this -> db -> where('u.status', 1);
		$this -> db -> group_by('u.id');
		$query = $this -> db -> get()->result();
		if(count($query)>0){
	foreach ($query as $row) {
	$total_call=$this->total_call($row->id,$from_date,$to_date);
	$total_connected=$this->total_connected($row->id,$from_date,$to_date,'Connected');
	$total_not_connected=$this->total_connected($row->id,$from_date,$to_date,'Not Connected');
	/*$total_call_delay_15=$this->total_call_delay($row->id,$from_date,$to_date,'15');
	$total_call_delay_30=$this->total_call_delay($row->id,$from_date,$to_date,'30');*/
	$lead_assigned=$this->lead_assigned($row->id,$from_date,$to_date);
	$sent_to_showroom_leads= $this -> cse_sent_to_showroom_leads($row -> id, $from_date, $to_date);
	$evaluation_allotted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Evaluation Allotted','');
	$evaluation_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Evaluation Allotted','Conducted');
	$evaluation_not_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Evaluation Allotted','Not Conducted');
	$test_drive=$this->cse_appointment_count($row->id,$from_date,$to_date,'Test Drive','');
	$test_drive_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Test Drive','Conducted');
	$test_drive_not_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Test Drive','Not Conducted');
	$home_visit=$this->cse_appointment_count($row->id,$from_date,$to_date,'Home Visit','');
	$home_visit_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Home Visit','Conducted');
	$home_visit_not_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Home Visit','Not Conducted');
	$showroom_visit=$this->cse_appointment_count($row->id,$from_date,$to_date,'Showroom Visit','');
	$showroom_visit_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Showroom Visit','Conducted');
	$showroom_visit_not_conducted=$this->cse_appointment_count($row->id,$from_date,$to_date,'Showroom Visit','Not Conducted');
	
		
	$select_data[]=array('cse_id'=>$row->id,'cse_fname'=>$row->fname,'cse_lname'=>$row->lname,'total_call'=>$total_call,'total_connected'=>$total_connected,'total_not_connected'=>$total_not_connected,'lead_assigned'=>$lead_assigned,'sent_to_showroom_leads'=>$sent_to_showroom_leads,'evaluation_allotted'=>$evaluation_allotted,'test_drive'=>$test_drive,'home_visit'=>$home_visit,'showroom_visit'=>$showroom_visit,
	'home_visit_conducted'=>$home_visit_conducted,'home_visit_not_conducted'=>$home_visit_not_conducted,
	'showroom_visit_conducted'=>$showroom_visit_conducted,'showroom_visit_not_conducted'=>$showroom_visit_not_conducted,'test_drive_conducted'=>$test_drive_conducted,'test_drive_not_conducted'=>$test_drive_not_conducted,'evaluation_conducted'=>$evaluation_conducted,'evaluation_not_conducted'=>$evaluation_not_conducted);
}
		}else{
			$select_data=array();
		}
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
		}else
		{
			$this -> db -> where('l.process', $this->process_name);
		}
	
	$this->db->where('l.assign_to_cse',$id);
	
	$this->db->where('l.assign_to_cse_date>=',$from_date);
	$this->db->where('l.assign_to_cse_date<=',$to_date);
	
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$total_connected_count=$query[0]->leadCount;
	return $total_connected_count;
}

public function cse_sent_to_showroom_leads($id, $fromdate, $todate) {

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
	
		$this -> db -> where('l.assign_to_cse', $id);
	

		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
				$this -> db -> where('l.assign_to_e_tl !=', 0);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
				$this -> db -> where('l.assign_to_dse_tl!=', 0);
		}		
		$this -> db -> where('l.assign_to_cse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_cse_date<=',$todate);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}



public function home_visit($id,$from_date,$to_date)
{
	$this->db->select('count(distinct l.enq_id) as leadCount');
	$this->db->from($this -> table_name);
	if($this->process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $this->process_name);
		}
	
	$this->db->where('l.assign_to_cse',$id);
	
	$this->db->where('l.assign_to_cse_date>=',$from_date);
	$this->db->where('l.assign_to_cse_date<=',$to_date);
	
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$total_connected_count=$query[0]->leadCount;
	return $total_connected_count;
}




public function showroom_visit($id,$from_date,$to_date)
{
	$this->db->select('count(distinct l.enq_id) as leadCount');
	$this->db->from($this -> table_name);
	if($this->process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $this->process_name);
		}
	
	$this->db->where('l.assign_to_cse',$id);
	
	$this->db->where('l.assign_to_cse_date>=',$from_date);
	$this->db->where('l.assign_to_cse_date<=',$to_date);
	
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$total_connected_count=$query[0]->leadCount;
	return $total_connected_count;
}



public function test_drive($id,$from_date,$to_date)
{
	$this->db->select('count(distinct l.enq_id) as leadCount');
	$this->db->from($this -> table_name);
	if($this->process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $this->process_name);
		}
	
	$this->db->where('l.assign_to_cse',$id);
	
	$this->db->where('l.assign_to_cse_date>=',$from_date);
	$this->db->where('l.assign_to_cse_date<=',$to_date);
	
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$total_connected_count=$query[0]->leadCount;
	return $total_connected_count;
}




public function evaluation_allotted($id,$from_date,$to_date)
{
	$this->db->select('count(distinct l.enq_id) as leadCount');
	$this->db->from($this -> table_name);
	if($this->process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $this->process_name);
		}
	
	$this->db->where('l.assign_to_cse',$id);
	
	$this->db->where('l.assign_to_cse_date>=',$from_date);
	$this->db->where('l.assign_to_cse_date<=',$to_date);
	
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
	
	$this->db->where('f.date>=',$from_date);
	$this->db->where('f.date<=',$to_date);
	
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$total_connected_count=$query[0]->leadCount;
	return $total_connected_count;
}
public function cse_appointment_count($id,$from_date,$to_date,$appointment_type,$status)
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
	
	$this->db->where('l.assign_to_cse',$id);
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

public function total_call_delay($id,$from_date,$to_date,$time)
{;
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

/**************************************************************************************************************************/
public function select_location()
{
	$this -> db -> select('p.location_id,l.location');	
	//	$this -> db -> from('tbl_location');		
	$this -> db -> from('tbl_map_process p');		
	$this->db->join('tbl_location l','l.location_id=p.location_id');		
	$this -> db -> where('p.process_id', $this->process_id);		
	$this->db->where('p.status !=','-1');		
	$this->db->where('l.location_status !=','Deactive');
	$this->db->order_by('l.location','asc');		
	$query = $this -> db -> get();			
	//echo $this->db->last_query();		
	return $query -> result();
}
public function search_appointment()
{
	$location_id=$this->input->post('location_id');
	$from_date=$this->input->post('from_date');
	$to_date=$this->input->post('to_date');
	$this->db->select('l.location_id,l.location');
	$this -> db -> from('tbl_map_process p');		
	$this->db->join('tbl_location l','l.location_id=p.location_id');		
	$this -> db -> where('p.process_id', $this->process_id);
	if($location_id!=''){
		$this->db->where('l.location_id',$location_id);
	}		
	$this->db->where('p.status !=','-1');		
	$this->db->where('l.location_status !=','Deactive');
	
	$this -> db -> group_by('l.location_id');
	$this->db->order_by('l.location','asc');
		$query = $this -> db -> get()->result();
	//	print_r($query);
		if(count($query)>0){
	foreach ($query as $row) {
	$home_visit_allocated=$this->appointment_count($row->location_id,$from_date,$to_date,'Home Visit','');
	$home_visit_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,'Home Visit','Conducted');
	$home_visit_not_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,'Home Visit','Not Conducted');
	$showroom_visit_allocated=$this->appointment_count($row->location_id,$from_date,$to_date,'Showroom Visit','');
	$showroom_visit_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,'Showroom Visit','Conducted');
	$showroom_visit_not_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,'Showroom Visit','Not Conducted');
	$test_drive_allocated=$this->appointment_count($row->location_id,$from_date,$to_date,'Test Drive','');
	$test_drive_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,'Test Drive','Conducted');
	$test_drive_not_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,'Test Drive','Not Conducted');
	$evaluation_allocated=$this->appointment_count($row->location_id,$from_date,$to_date,'Evaluation Allotted','');
	$evaluation_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,'Evaluation Allotted','Conducted');
	$evaluation_not_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,'Evaluation Allotted','Not Conducted');
	//$select_data[]=array('location'=>$row->location,'home_visit_allocated'=>$home_visit_allocated);
	//,'home_visit_conducted'=>$home_visit_conducted,'home_visit_not_conducted'=>$home_visit_not_conducted);
	//,'showroom_visit_allocated'=>$showroom_visit_allocated,'showroom_visit_conducted'=>$showroom_visit_conducted,'showroom_visit_not_conducted'=>$showroom_visit_not_conducted,'test_drive_allocated'=>$test_drive_allocated,'test_drive_conducted'=>$test_drive_conducted,'test_drive_not_conducted'=>$test_drive_not_conducted,'evaluation_allocated'=>$evaluation_allocated,'evaluation_conducted'=>$evaluation_conducted,'evaluation_not_conducted'=>$evaluation_not_conducted);
		
	$select_data[]=array('location'=>$row->location,'home_visit_allocated'=>$home_visit_allocated,'home_visit_conducted'=>$home_visit_conducted,'home_visit_not_conducted'=>$home_visit_not_conducted,'showroom_visit_allocated'=>$showroom_visit_allocated,'showroom_visit_conducted'=>$showroom_visit_conducted,'showroom_visit_not_conducted'=>$showroom_visit_not_conducted,'test_drive_allocated'=>$test_drive_allocated,'test_drive_conducted'=>$test_drive_conducted,'test_drive_not_conducted'=>$test_drive_not_conducted,'evaluation_allocated'=>$evaluation_allocated,'evaluation_conducted'=>$evaluation_conducted,'evaluation_not_conducted'=>$evaluation_not_conducted);


}
		}else{
			$select_data=array();
		}
	return $select_data;
}
public function appointment_count($location,$from_date,$to_date,$appointmet_type,$status)
{
	$this->db->select('count(distinct enq_id) as leadCount');
	$this->db->from($this -> table_name);
	$this->db->join($this -> table_name1,'l.enq_id=f.leadid');
	/*$this->db->from('lead_master l');
	$this->db->join('lead_followup f','f.leadid= l.enq_id');*/
	//$this->db->join('lmsuser u','u.id= l.assign_to_cse');
	if($location==38){
			$this->db->join('tbl_manager_process m','m.user_id=l.assign_to_cse','left');
	}else{
			$this->db->join('tbl_manager_process m','m.user_id=l.assign_to_dse_tl','left');
	}

		if($this->process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $this->process_name);
		}
	$this->db->where('m.location_id',$location);
	$this->db->where('f.appointment_type',$appointmet_type);
	if($status!=''){
	$this->db->where('f.appointment_status',$status);	
	}
	$this->db->where('l.created_date>=',$from_date);
		$this->db->where('l.created_date<=',$to_date);
	$query = $this -> db -> get();
	//echo $this->db->last_query();
	$query=$query->result();
		$appointment_home_visit_count=$query[0]->leadCount;
		return $appointment_home_visit_count;
}
	}
?>