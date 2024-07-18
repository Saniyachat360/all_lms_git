<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_new_reports_model extends CI_model {
	function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this -> today = date('Y-m-d');
		$this -> time = date("h:i:s A");
	}
		public function select_table($process_id)
	{
		
		if ($process_id == 6 || $process_id == 7) {
			
			$lead_master_table = 'lead_master l';
			$lead_followup_table = 'lead_followup';
			$request_to_lead_transfer_table = 'request_to_lead_transfer';
		} 
		elseif ($process_id == 8) {
			$lead_master_table = 'lead_master l';
			$lead_followup_table = 'lead_followup';
			$request_to_lead_transfer_table = 'request_to_lead_transfer';
		}
		else {
			
			$lead_master_table = 'lead_master_all l';
			$lead_followup_table = 'lead_followup_all';
			$request_to_lead_transfer_table = 'request_to_lead_transfer_all';
		}
	
		return array( 'lead_master_table'=>$lead_master_table,'lead_followup_table'=>$lead_followup_table,'request_to_lead_transfer_table'=>$request_to_lead_transfer_table) ;
		
	}
	//Spiner
		public function select_lead_sourcewise_count($campaign_name,$fromdate,$todate,$role,$user_id,$process_id,$process_name) {
		// Date
		$table=$this->select_table($process_id);
		if ($fromdate == '') {
			$fromdate = $this -> today;
		}
		if ($todate == '') {
			//echo "3";
			$todate = $this -> today;
		}
		$from_date = "l.created_date>='$fromdate'";
		$to_date = "l.created_date<='$todate'";

		$this -> db -> select('lead_source,count(enq_id) as leads_generated');
		
		$this -> db -> from($table['lead_master_table']);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}

		if ($campaign_name != '') {
			if ($campaign_name == 'Web') {
				$this -> db -> where('l.lead_source', '');
			}
			elseif ($campaign_name == 'All') {
				
			}
			 else {
				$this -> db -> where('l.lead_source', $campaign_name);
			}
		}
		$this -> db -> where($from_date);
		$this -> db -> where($to_date);
		$this -> db -> group_by('lead_source', 'asc');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query = $query -> result();
	//	print_r($query);
		if (count($query) > 0) {
			foreach ($query as $row) {

				$live_leads = $this -> live_leads($row -> lead_source, $from_date, $to_date,$process_id,$process_name);
				$close_leads = $this -> close_leads($row -> lead_source, $from_date, $to_date,$process_id,$process_name);
				$lost_to_co_dealer_leads = $this -> lost_to_co_dealer_leads($row -> lead_source, $from_date, $to_date,$process_id,$process_name);
				$lost_to_other_leads = $this -> lost_to_other_leads($row -> lead_source, $from_date, $to_date,$process_id,$process_name);
				$booked_leads = $this -> booked_leads($row -> lead_source, $from_date, $to_date,$process_id,$process_name);


				$select_leads[] = array('lead_source' => $row -> lead_source, 'leads_generated' => $row -> leads_generated, 'live_leads' => $live_leads, 'close_leads' => $close_leads, 'lost_to_co_dealer_leads' => $lost_to_co_dealer_leads, 'lost_to_other_leads' => $lost_to_other_leads, 'booked_leads' => $booked_leads);

			}
		} else {
			//$select_leads[] = array('id'=>'','role'=>'', 'location_name'=>'','fname' => '', 'lname' => '', 'unassigned_leads' => '',  'new_leads' => '','call_today' => '', 'pending_new_leads' => '', 'pending_followup' => '');
			$select_leads = array();

		}
		return $select_leads;
	}
	public function live_leads($lead_source, $from_date, $to_date,$process_id,$process_name) {
		$table=$this->select_table($process_id);
		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
		
		$this -> db -> where('l.lead_source', $lead_source);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
		$this -> db -> where('l.nextAction !=', 'Booked From Autovista');
		$this -> db -> where('l.nextAction !=', 'Close');
		$t="(cse_followup_id !='0' || dse_followup_id !='0')";
		$this -> db -> where($t);
		$this -> db -> where($from_date);
		$this -> db -> where($to_date);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
	public function close_leads($lead_source, $from_date, $to_date,$process_id,$process_name) {
		$table=$this->select_table($process_id);
		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
		$this -> db -> where('l.lead_source', $lead_source);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
		$this -> db -> where('l.nextAction', 'Close');
		$this -> db -> where($from_date);
		$this -> db -> where($to_date);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
		

	public function lost_to_co_dealer_leads($lead_source, $from_date, $to_date,$process_id,$process_name) {
		$table=$this->select_table($process_id);
		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
		$this -> db -> where('l.lead_source', $lead_source);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
		$this -> db -> where('l.feedbackStatus', 'Lost to Co-Dealer');
		$this -> db -> where($from_date);
		$this -> db -> where($to_date);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}

	public function lost_to_other_leads($lead_source, $from_date, $to_date,$process_id,$process_name) {
		$table=$this->select_table($process_id);
		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
		$this -> db -> where('l.lead_source', $lead_source);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
		$this -> db -> where('l.feedbackStatus', 'Lost To Competitor Brand');
		$this -> db -> where($from_date);
		$this -> db -> where($to_date);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}

	public function booked_leads($lead_source, $from_date, $to_date,$process_id,$process_name) {
		$table=$this->select_table($process_id);
		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
		$this -> db -> where('l.lead_source', $lead_source);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
		$this -> db -> where('l.nextAction', 'Booked From Autovista');
		$this -> db -> where($from_date);
		$this -> db -> where($to_date);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
public function search_performance($cse_id,$fromdate,$todate,$role,$user_id,$process_id,$process_name) {

		
		if ($fromdate == '') {
			$fromdate = $this -> today;
		}
		if ($todate == '') {
			//echo "3";
			$todate = $this -> today;
		}
		
		$this -> db -> select('u.fname,u.lname,u.id');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id');
		$this -> db -> where('m.process_id', $process_id);
		$this -> db -> where('m.location_id', 38);
		$this -> db -> where('u.role', 3);
		if ($cse_id != '') {

			$this -> db -> where('u.id', $cse_id);
		}
		$this -> db -> where('u.status', 1);

		$this -> db -> group_by('u.id');

		$query = $this -> db -> get() -> result();

		if (count($query) > 0) {

			foreach ($query as $row) {

				$assign_leads = $this -> cse_assigned_leads($row -> id, $fromdate, $todate,$process_id,$process_name);

				$pending_new_leads = $this -> cse_pending_new_leads($row -> id, $fromdate, $todate,$process_id,$process_name);

				$pending_followup_leads = $this -> cse_pending_followup_leads($row -> id, $fromdate, $todate,$process_id,$process_name);

				$live_leads = $this -> cse_live_leads($row -> id, $fromdate, $todate,$process_id,$process_name);
				$close_leads = $this -> cse_close_leads($row -> id, $fromdate, $todate,$process_id,$process_name);
				$booked_leads = $this -> cse_booked_leads($row -> id, $fromdate, $todate,$process_id,$process_name);
				// 'pending_new_leads' => $pending_new_leads,

				$select_data[] = array('cse_fname' => $row -> fname, 'cse_lname' => $row -> lname, 'assign_lead' => $assign_leads,'pending_new_leads' => $pending_new_leads,
				 'pending_followup_leads' => $pending_followup_leads, 'live_leads' => $live_leads
				,'close_leads' => $close_leads, 'booked_leads' => $booked_leads);

			}

		} else {

			$select_data = array();

		}

		return $select_data;

	}
	public function cse_assigned_leads($id, $fromdate, $todate,$process_id,$process_name) {
		$table=$this->select_table($process_id);
		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
	
		$this -> db -> where('l.assign_to_cse', $id);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}		
		$this -> db -> where('l.assign_to_cse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_cse_date<=',$todate);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
	public function cse_pending_new_leads($id, $fromdate, $todate,$process_id,$process_name) {
		$table=$this->select_table($process_id);

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
	
		$this -> db -> where('l.assign_to_cse', $id);
		$this -> db -> where('l.cse_followup_id', 0);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}		
		$this -> db -> where('l.assign_to_cse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_cse_date<=',$todate);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
public function cse_pending_followup_leads($id, $fromdate, $todate,$process_id,$process_name) {
		$table=$this->select_table($process_id);

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
		$this -> db -> join($table['lead_followup_table'].' f', 'f.id=l.cse_followup_id', 'left');
		
		$this -> db -> where('l.assign_to_cse', $id);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}		
		$this -> db -> where('l.assign_to_cse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_cse_date<=',$todate);
		$this -> db -> where("f.nextfollowupdate!=", '0000-00-00');
		$this -> db -> where("f.nextfollowupdate <", $this -> today);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
	public function cse_live_leads($id, $fromdate, $todate,$process_id,$process_name) {
		$table=$this->select_table($process_id);

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
		//$this -> db -> join($this -> table_name1,'l.cse_followup_id=f.id','left');
		$this -> db -> where('l.assign_to_cse', $id);
		$this -> db -> where('l.cse_followup_id !=', '0');
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
		$this -> db -> where('l.nextAction !=', 'Booked From Autovista');
		$this -> db -> where('l.nextAction !=', 'Close');		
		$this -> db -> where('l.assign_to_cse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_cse_date<=',$todate);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
	public function cse_close_leads($id, $fromdate, $todate,$process_id,$process_name) {
		$table=$this->select_table($process_id);

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
		//$this -> db -> join($this -> table_name1,'l.cse_followup_id=f.id','left');
		$this -> db -> where('l.assign_to_cse', $id);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
		$this -> db -> where('l.nextAction', 'Close');
		$this -> db -> where('l.assign_to_cse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_cse_date<=',$todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
	public function cse_booked_leads($id, $fromdate, $todate,$process_id,$process_name) {
		$table=$this->select_table($process_id);

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
		$this -> db -> where('l.assign_to_cse', $id);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
		$this -> db -> where('l.nextAction', 'Booked From Autovista');
		$this -> db -> where('l.assign_to_cse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_cse_date<=',$todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
	public function cse_productivity($cse_id,$from_date,$to_date,$role,$user_id,$process_id,$process_name)
{
	if ($from_date == '') {
			$from_date = $this -> today;
		}
		if ($to_date == '') {
			//echo "3";
			$to_date = $this -> today;
		}
	$this -> db -> select('u.fname,u.lname,u.id');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
		$this -> db -> where('m.process_id', $process_id);
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
	$total_call=$this->total_call($row->id,$from_date,$to_date,$process_id,$process_name);
	$total_connected=$this->total_connected($row->id,$from_date,$to_date,'Connected',$process_id,$process_name);
	$total_not_connected=$this->total_connected($row->id,$from_date,$to_date,'Not Connected',$process_id,$process_name);
	/*$total_call_delay_15=$this->total_call_delay($row->id,$from_date,$to_date,'15');
	$total_call_delay_30=$this->total_call_delay($row->id,$from_date,$to_date,'30');*/
	$lead_assigned=$this->lead_assigned($row->id,$from_date,$to_date,$process_id,$process_name,'CSE');
	$evaluation_allotted=$this->appointment_type($row->id,$from_date,$to_date,'Evaluation Allotted',$process_id,$process_name);
	$test_drive=$this->appointment_type($row->id,$from_date,$to_date,'Test Drive',$process_id,$process_name);
	$home_visit=$this->appointment_type($row->id,$from_date,$to_date,'Home Visit',$process_id,$process_name);
	$showroom_visit=$this->appointment_type($row->id,$from_date,$to_date,'Showroom Visit',$process_id,$process_name);
		
	$select_data[]=array('cse_fname'=>$row->fname,'cse_lname'=>$row->lname,'total_call'=>$total_call,'total_connected'=>$total_connected,'total_not_connected'=>$total_not_connected,'lead_assigned'=>$lead_assigned,'evaluation_allotted'=>$evaluation_allotted,'test_drive'=>$test_drive,'home_visit'=>$home_visit,'showroom_visit'=>$showroom_visit);
}
		}else{
			$select_data=array();
		}
	return $select_data;
}
public function total_call($id,$from_date,$to_date,$process_id,$process_name) {
		$table=$this->select_table($process_id);
	$this->db->select('count( l.enq_id) as leadCount');
		$this -> db -> from($table['lead_master_table']);
		$this -> db -> join($table['lead_followup_table'].' f', 'f.leadid=l.enq_id', 'left');
	
	if($process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $process_name);
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
public function total_connected($id,$from_date,$to_date,$contactibility,$process_id,$process_name) {
	$table=$this->select_table($process_id);
	$this->db->select('count( l.enq_id) as leadCount');
	$this -> db -> from($table['lead_master_table']);
	$this -> db -> join($table['lead_followup_table'].' f', 'f.leadid=l.enq_id', 'left');
	if($process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $process_name);
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
public function lead_assigned($id,$from_date,$to_date,$process_id,$process_name,$type)
{
	$table=$this->select_table($process_id);	
	$this->db->select('count(distinct l.enq_id) as leadCount');
	$this -> db -> from($table['lead_master_table']);
	if($process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $process_name);
		}
	if($type=='DSE')
	{
		$this->db->where('l.assign_to_dse',$id);
	
	$this->db->where('l.assign_to_dse_date>=',$from_date);
	$this->db->where('l.assign_to_dse_date<=',$to_date);
	}
	else {
		$this->db->where('l.assign_to_cse',$id);	
	$this->db->where('l.assign_to_cse_date>=',$from_date);
	$this->db->where('l.assign_to_cse_date<=',$to_date);
	}
	
	
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$total_connected_count=$query[0]->leadCount;
	return $total_connected_count;
}
public function appointment_type($id,$from_date,$to_date,$appointment_type,$process_id,$process_name)
{
	$table=$this->select_table($process_id);
	$this->db->select('count(distinct l.enq_id) as leadCount');
	$this -> db -> from($table['lead_master_table']);
	$this -> db -> join($table['lead_followup_table'].' f', 'f.leadid=l.enq_id', 'left');
	if($process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $process_name);
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
public function appointment_report($location_id,$from_date,$to_date,$role,$user_id,$process_id,$process_name)
{
	if ($from_date == '') {
			$from_date = $this -> today;
		}
		if ($to_date == '') {
			//echo "3";
			$to_date = $this -> today;
		}
	$this->db->select('l.location_id,l.location');
	$this -> db -> from('tbl_map_process p');		
	$this->db->join('tbl_location l','l.location_id=p.location_id');		
	$this -> db -> where('p.process_id', $process_id);
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
	$home_visit_allocated=$this->appointment_count($row->location_id,$from_date,$to_date,$process_id,$process_name,'Home Visit','');
	$home_visit_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,$process_id,$process_name,'Home Visit','Conducted');
	$home_visit_not_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,$process_id,$process_name,'Home Visit','Not Conducted');
	$showroom_visit_allocated=$this->appointment_count($row->location_id,$from_date,$to_date,$process_id,$process_name,'Showroom Visit','');
	$showroom_visit_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,$process_id,$process_name,'Showroom Visit','Conducted');
	$showroom_visit_not_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,$process_id,$process_name,'Showroom Visit','Not Conducted');
	$test_drive_allocated=$this->appointment_count($row->location_id,$from_date,$to_date,$process_id,$process_name,'Test Drive','');
	$test_drive_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,$process_id,$process_name,'Test Drive','Conducted');
	$test_drive_not_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,$process_id,$process_name,'Test Drive','Not Conducted');
	$evaluation_allocated=$this->appointment_count($row->location_id,$from_date,$to_date,$process_id,$process_name,'Evaluation Allotted','');
	$evaluation_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,$process_id,$process_name,'Evaluation Allotted','Conducted');
	$evaluation_not_conducted=$this->appointment_count($row->location_id,$from_date,$to_date,$process_id,$process_name,'Evaluation Allotted','Not Conducted');
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
public function appointment_count($location,$from_date,$to_date,$process_id,$process_name,$appointmet_type,$status)
{
	if ($from_date == '') {
			$from_date = $this -> today;
		}
		if ($to_date == '') {
			//echo "3";
			$to_date = $this -> today;
		}
	$this->db->select('count(distinct enq_id) as leadCount');
	$this->db->from('lead_master l');
	$this->db->join('lead_followup f','f.leadid= l.enq_id');
	//$this->db->join('lmsuser u','u.id= l.assign_to_cse');
	if($location==38){
			$this->db->join('tbl_manager_process m','m.user_id=l.assign_to_cse','left');
	}else{
			$this->db->join('tbl_manager_process m','m.user_id=l.assign_to_dse_tl','left');
	}

		if($process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $process_name);
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
public function locationwise_report($location_id,$from_date,$to_date,$role,$user_id,$process_id,$process_name)
{
	if ($from_date == '') {
			$from_date = $this -> today;
		}
		if ($to_date == '') {
			//echo "3";
			$to_date = $this -> today;
		}
	$this -> db -> select('l.location_id,l.location');
	$this->db->from('tbl_location l');
	$this->db->join('tbl_map_process p','p.location_id=l.location_id');
	$this->db->where('p.status !=','-1');
	$this->db->where('l.location_id !=','38');
	$this->db->where('l.location_status !=','Deactive');
	$this->db->where('p.process_id',$process_id);

	if($location_id!=''){
		$this->db->where('l.location_id',$location_id);
	}
		
		$this -> db -> group_by('l.location_id');
		$this->db->order_by('l.location','asc');
		$query = $this -> db -> get()->result();
	
		if(count($query)>0){
	foreach ($query as $row) {
		$location_id=$row->location_id;
		$query_id=$this->db->query('select l.id from lmsuser l join tbl_manager_process m on l.id=m.user_id where m.location_id='.$location_id.' and l.role=5 and l.status=1 and m.process_id='.$process_id)->result();
	$ids = array();
foreach ($query_id as $id)
    {
        $ids[] = $id->id;
    }
	if(count($ids)>0){

	$total_lead=$this->total_lead($ids,$from_date,$to_date,$process_id,$process_name);
	$total_avg_month=$this->total_avg_month($ids,$process_id,$process_name);
	$total_lead_assigned_month=$this->total_lead_assigned_month($ids,$process_id,$process_name);
	
	$total_live_leads=$this->total_live_leads($ids,$from_date,$to_date,$process_id,$process_name);
	$total_lost_leads=$this->total_lost_leads($ids,$from_date,$to_date,$process_id,$process_name);
	$total_booking=$this->total_booking	($ids,$from_date,$to_date,$process_id,$process_name);	
	$total_lost_to_co_dealer=$this->total_lost_to_co_dealer($ids,$from_date,$to_date,$process_id,$process_name);	
	$esculation_level_1=$this->esculation_level($ids,$from_date,$to_date,'esc_level1',$process_id,$process_name);	
	$esculation_level_2=$this->esculation_level($ids,$from_date,$to_date,'esc_level2',$process_id,$process_name);	
	$esculation_level_3=$this->esculation_level($ids,$from_date,$to_date,'esc_level3',$process_id,$process_name);	
	}
	$select_data[]=array('location'=>$row->location,'total_lead_assigned'=>$total_lead,'total_avg_month'=>$total_avg_month,'total_lead_assigned_month'=>$total_lead_assigned_month,'total_live_leads'=>$total_live_leads,'total_lost_leads'=>$total_lost_leads,'total_booking'=>$total_booking,'total_lost_to_co_dealer'=>$total_lost_to_co_dealer,'esculation_level_1'=>$esculation_level_1,'esculation_level_2'=>$esculation_level_2,'esculation_level_3'=>$esculation_level_3);
	}
}else{
			$select_data=array();
		}

	return $select_data;
	
}
public function total_lead($ids,$from_date,$to_date,$process_id,$process_name)
{
	$this->db->select('count(distinct enq_id) as leadcount');
	$this->db->from('lead_master l');
	if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
	$this->db->where_in('assign_to_dse_tl',$ids);
	$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
	$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
	$query=$this->db->get()->result();
	$total_leads=$query[0]->leadcount;
	return $total_leads;
}
public function total_live_leads($ids,$from_date,$to_date,$process_id,$process_name)
{
	$this->db->select('count(distinct enq_id) as leadcount');
	$this->db->from('lead_master l');
	if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
	$this->db->where_in('assign_to_dse_tl',$ids);
	$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
	$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
	$this -> db -> where('l.nextAction !=', 'Booked From Autovista');
	$this -> db -> where('l.nextAction !=', 'Close');
	$query=$this->db->get()->result();
	$total_leads=$query[0]->leadcount;
	return $total_leads;
	
}
public function total_lost_leads($ids,$from_date,$to_date,$process_id,$process_name)
{
	$this->db->select('count(distinct enq_id) as leadcount');
	$this->db->from('lead_master l');
	if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
	$this->db->where_in('assign_to_dse_tl',$ids);
	$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
	$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
	
		$this -> db -> where('l.nextAction', 'Close');
	$query=$this->db->get()->result();
	$total_leads=$query[0]->leadcount;
	return $total_leads;
	
}
public function total_booking($ids,$from_date,$to_date,$process_id,$process_name)
{
	$this->db->select('count(distinct enq_id) as leadcount');
	$this->db->from('lead_master l');
	if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
	$this->db->where_in('assign_to_dse_tl',$ids);
	$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
	$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
	$this -> db -> where('l.nextAction', 'Booked From Autovista');
	$query=$this->db->get()->result();
	$total_leads=$query[0]->leadcount;
	return $total_leads;
	
}
public function total_lost_to_co_dealer($ids,$from_date,$to_date,$process_id,$process_name)
{
	$this->db->select('count(distinct enq_id) as leadcount');
	$this->db->from('lead_master l');
	if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
	$this->db->where_in('assign_to_dse_tl',$ids);
	$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
	$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
	$this -> db -> where('l.feedbackStatus ', 'Lost to Co-Dealer');
		$this -> db -> where('l.nextAction', 'Close');
	$query=$this->db->get()->result();
	$total_leads=$query[0]->leadcount;
	return $total_leads;
	
}
public function esculation_level($ids,$from_date,$to_date,$level_field,$process_id,$process_name)
{
	$this->db->select('count(distinct enq_id) as leadcount');
	$this->db->from('lead_master l');
	if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
	$this->db->where_in('assign_to_dse_tl',$ids);
	$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
	$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
	$this -> db -> where($level_field, 'Yes');
	
	$query=$this->db->get()->result();
	$total_leads=$query[0]->leadcount;
	return $total_leads;
	
}
public function total_avg_month($ids,$process_id,$process_name)
{
	$from_date=date('Y-01-01');
	$to_date=date('Y-m-d');
	$this->db->select('count(distinct enq_id) as leadcount');
	$this->db->from('lead_master l');
	if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
	$this->db->where_in('assign_to_dse_tl',$ids);
	$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
	$this->db->where('l.assign_to_dse_tl_date<=',$to_date);

	$query=$this->db->get()->result();
	$total_leads=$query[0]->leadcount;
	$current_month=date('m');
	if($total_leads>0){
		$total_avg_month=$total_leads/$current_month;
	}else{
		$total_avg_month=0;
	}

	return $total_avg_month;
	
}

public function total_lead_assigned_month($ids,$process_id,$process_name)
{
	$from_date=date('Y-m-01');
	$to_date=date('Y-m-d');
	$this->db->select('count(distinct enq_id) as leadcount');
	$this->db->from('lead_master l');
	if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
	$this->db->where_in('assign_to_dse_tl',$ids);
	$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
	$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
	
	$query=$this->db->get();

	$query=$query->result();
	$total_leads=$query[0]->leadcount;
	return $total_leads;
	
}
/*********************************   DSE Productivity Report  ****************************************************/
public function dse_productivity($location,$dse_name,$from_date,$to_date,$role,$user_id,$process_id,$process_name)
{
	if ($from_date == '') {
			$from_date = $this -> today;
		}
		if ($to_date == '') {
			//echo "3";
			$to_date = $this -> today;
		}
	$this->db->select("u.fname,u.lname,u.id");
	$this -> db -> from('lmsuser u');
	$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
	$this->db->where('m.process_id',$process_id);
	if($location!=''){
		$this -> db -> where('m.location_id', $location);
	}
	if($dse_name!=''){
		$this -> db -> where('u.id', $dse_name);
	}
	$this -> db -> where('u.id!=', 1);
			$this -> db -> where('u.role', 4);
	$this->db->order_by('u.fname','asc');
	$query=$this->db->get();
	
	$query=$query->result();
	//print_r($query);
	foreach ($query as $row) {
	$total_call=$this->total_call($row->id,$from_date,$to_date,$process_id,$process_name);
	$total_connected=$this->total_connected($row->id,$from_date,$to_date,'Connected',$process_id,$process_name);
	$total_not_connected=$this->total_connected($row->id,$from_date,$to_date,'Not Connected',$process_id,$process_name);	
	$lead_assigned=$this->lead_assigned($row->id,$from_date,$to_date,$process_id,$process_name,'DSE');
	$evaluation_allotted=$this->appointment_type($row->id,$from_date,$to_date,'Evaluation Allotted',$process_id,$process_name);
	$test_drive=$this->appointment_type($row->id,$from_date,$to_date,'Test Drive',$process_id,$process_name);
	$home_visit=$this->appointment_type($row->id,$from_date,$to_date,'Home Visit',$process_id,$process_name);
	$showroom_visit=$this->appointment_type($row->id,$from_date,$to_date,'Showroom Visit',$process_id,$process_name);
	$booked=$this->total_booked($row->id,$from_date,$to_date,$process_id,$process_name);
	$select_data[]=array('dse_fname'=>$row->fname,'dse_lname'=>$row->lname,'total_call'=>$total_call,'total_connected'=>$total_connected,'total_not_connected'=>$total_not_connected,'lead_assigned'=>$lead_assigned,'evaluation_allotted'=>$evaluation_allotted,'test_drive'=>$test_drive,'home_visit'=>$home_visit,'showroom_visit'=>$showroom_visit,'booked'=>$booked);
	
//	$select_data[]=array('dse_fname'=>$row->fname,'dse_lname'=>$row->lname,'total_call'=>$total_call,'total_connected'=>$total_connected,'total_not_connected'=>$total_not_connected,'total_call_delay_15'=>$total_call_delay_15,'total_call_delay_30'=>$total_call_delay_30,'lead_assigned'=>$lead_assigned,'evaluation_allotted'=>$evaluation_allotted,'test_drive'=>$test_drive,'home_visit'=>$home_visit,'showroom_visit'=>$showroom_visit);
	
	}
	return $select_data;
}
public function total_booked($id,$from_date,$to_date,$process_id,$process_name)
{
	$this->db->select('count( l.enq_id) as leadCount');
	$this->db->from('lead_master l');
	$this -> db -> where('l.assign_to_dse', $id);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
		$this -> db -> where('l.nextAction', 'Booked From Autovista');

	$this->db->where('l.assign_to_dse_date>=',$from_date);
	$this->db->where('l.assign_to_dse_date<=',$to_date);
	
	$query=$this->db->get();
	//echo $this->db->last_query();
	$query=$query->result();
	$total_connected_count=$query[0]->leadCount;
	return $total_connected_count;
}
	/******************************************************* DSE Performance Reprot *****************************************/
public function dse_performance($location,$dse_name,$from_date,$to_date,$role,$user_id,$process_id,$process_name)
{
	if ($from_date == '') {
			$from_date = $this -> today;
		}
		if ($to_date == '') {
			//echo "3";
			$to_date = $this -> today;
		}
	$this->db->select("u.fname,u.lname,u.id");
	$this -> db -> from('lmsuser u');
	$this -> db -> join('tbl_manager_process m','m.user_id=u.id');
	$this->db->where('m.process_id',$process_id);
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
	foreach ($query as $row) {
	$assign_leads=$this->dse_assigned_leads($row->id,$from_date,$to_date,$process_id,$process_name);
	$pending_new_leads=$this->dse_pending_new_leads($row->id,$from_date,$to_date,$process_id,$process_name);
	$pending_followup_leads=$this->dse_pending_followup_leads($row->id,$from_date,$to_date,$process_id,$process_name);
	$live_leads=$this->dse_live_leads($row->id,$from_date,$to_date,$process_id,$process_name);	
	$total_lost_leads=$this->dse_close_leads($row->id,$from_date,$to_date,$process_id,$process_name);
	$co_dealer_lost_leads=$this->co_dealer_lost_leads($row->id,$from_date,$to_date,$process_id,$process_name);
	$other_lost_leads=$this->other_lost_leads($row->id,$from_date,$to_date,$process_id,$process_name);
	$booked_leads=$this->dse_booked_leads($row->id,$from_date,$to_date,$process_id,$process_name);
	$select_data[]=array('dse_fname'=>$row->fname,'dse_lname'=>$row->lname,'assign_lead'=>$assign_leads,'pending_new_leads'=>$pending_new_leads,'pending_followup_leads'=>$pending_followup_leads,'live_leads'=>$live_leads,'total_lost_leads'=>$total_lost_leads,'co_dealer_lost_leads'=>$co_dealer_lost_leads,'other_lost_leads'=>$other_lost_leads,'booked_leads'=>$booked_leads);
	}
	return $select_data;
}
public function dse_assigned_leads($id, $fromdate, $todate,$process_id,$process_name) {
		$table=$this->select_table($process_id);
		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
	
		$this->db->where('l.assign_to_dse',$id);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}		
		$this -> db -> where('l.assign_to_dse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_dse_date<=',$todate);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
	public function dse_pending_new_leads($id, $fromdate, $todate,$process_id,$process_name) {
		$table=$this->select_table($process_id);

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
	
		$this->db->where('l.assign_to_dse',$id);
		$this -> db -> where('l.dse_followup_id', 0);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}		
		$this -> db -> where('l.assign_to_dse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_dse_date<=',$todate);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
public function dse_pending_followup_leads($id, $fromdate, $todate,$process_id,$process_name) {
		$table=$this->select_table($process_id);

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
		$this -> db -> join($table['lead_followup_table'].' f', 'f.id=l.cse_followup_id', 'left');
		
		$this -> db -> where('l.assign_to_dse', $id);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}		
		$this -> db -> where('l.assign_to_dse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_dse_date<=',$todate);
		$this -> db -> where("f.nextfollowupdate!=", '0000-00-00');
		$this -> db -> where("f.nextfollowupdate <", $this -> today);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
	public function dse_live_leads($id, $fromdate, $todate,$process_id,$process_name) {
		$table=$this->select_table($process_id);

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
		//$this -> db -> join($this -> table_name1,'l.cse_followup_id=f.id','left');
		$this -> db -> where('l.assign_to_dse', $id);
		$this -> db -> where('l.dse_followup_id !=', '0');
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
		$this -> db -> where('l.nextAction !=', 'Booked From Autovista');
		$this -> db -> where('l.nextAction !=', 'Close');		
		$this -> db -> where('l.assign_to_dse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_dse_date<=',$todate);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
	public function dse_close_leads($id, $fromdate, $todate,$process_id,$process_name) {
		$table=$this->select_table($process_id);

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
		//$this -> db -> join($this -> table_name1,'l.cse_followup_id=f.id','left');
		$this -> db -> where('l.assign_to_dse', $id);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
		$this -> db -> where('l.nextAction', 'Close');
		$this -> db -> where('l.assign_to_dse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_dse_date<=',$todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
	public function co_dealer_lost_leads($id,$from_date,$to_date,$process_id,$process_name)
{
	$table=$this->select_table($process_id);
	$this->db->select('count(distinct l.enq_id) as leadCount');
	$this -> db -> from($table['lead_master_table']);	
	$this->db->where('l.assign_to_dse',$id);
	if($process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $process_name);
		}
	$this -> db -> where('l.assign_to_dse_date>=',$from_date);
	$this -> db -> where('l.assign_to_dse_date<=',$to_date);
	$this -> db -> where('l.feedbackStatus ', 'Lost to Co-Dealer');
	$this -> db -> where('l.nextAction', 'Close');
	$query=$this->db->get();
	$query=$query->result();
	$pending_new_lead_count=$query[0]->leadCount;
	return $pending_new_lead_count;
}
public function other_lost_leads($id,$from_date,$to_date,$process_id,$process_name)
{
	$table=$this->select_table($process_id);
	$this->db->select('count(distinct l.enq_id) as leadCount');
	
	$this -> db -> from($table['lead_master_table']);
	
	$this->db->where('l.assign_to_dse',$id);
	if($process_id==8){
		$this -> db -> where('l.evaluation', 'Yes');
		}else
		{
			$this -> db -> where('l.process', $process_name);
		}
	$this -> db -> where('l.assign_to_dse_date>=',$from_date);
	$this -> db -> where('l.assign_to_dse_date<=',$to_date);
	$this -> db -> where('l.feedbackStatus ', 'Others');
	$this -> db -> where('l.nextAction', 'Close');
	$query=$this->db->get();
	$query=$query->result();
	$pending_new_lead_count=$query[0]->leadCount;
	return $pending_new_lead_count;
}
	public function dse_booked_leads($id, $fromdate, $todate,$process_id,$process_name) {
		$table=$this->select_table($process_id);

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($table['lead_master_table']);
		$this -> db -> where('l.assign_to_dse', $id);
		if ($process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $process_name);
		}
		$this -> db -> where('l.nextAction', 'Booked From Autovista');
		$this -> db -> where('l.assign_to_dse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_dse_date<=',$todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
}