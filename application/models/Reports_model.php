<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports_model extends CI_model {
	function __construct() {
		parent::__construct();
		$this -> today = date('Y-m-d');
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> process_id = $_SESSION['process_id'];
		$this -> process_name = $_SESSION['process_name'];
		//Select Table
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master l';
			$this -> table_name1 = 'lead_followup f';

		} elseif ($this -> process_id == 8) {
			$this -> table_name = 'lead_master_evaluation l';
			$this -> table_name1 = 'lead_followup_evaluation f';

		} else {
			$this -> table_name = 'lead_master_all l';
			$this -> table_name1 = 'lead_followup_all f';
		}

	}

	function select_lead_source() {

		$this -> db -> select('*');
		$this -> db -> from('lead_source');
		$this -> db -> where('process_id', $this -> process_id);
		$this -> db -> order_by('lead_source_name', 'ASC');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	public function select_lead_sourcewise_count($campaign_name, $fromdate, $todate) {
		// Date

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
		$this -> db -> from($this -> table_name);
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $this -> process_name);
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
		//print_r($query);
		if (count($query) > 0) {
			foreach ($query as $row) {
				//	echo $row->id. 'role '.$row->role;
				$live_leads = $this -> live_leads($row -> lead_source, $from_date, $to_date);
				$close_leads = $this -> close_leads($row -> lead_source, $from_date, $to_date);
				$lost_to_co_dealer_leads = $this -> lost_to_co_dealer_leads($row -> lead_source, $from_date, $to_date);
				$lost_to_other_leads = $this -> lost_to_other_leads($row -> lead_source, $from_date, $to_date);
				$booked_leads = $this -> booked_leads($row -> lead_source, $from_date, $to_date);

				/*$new_leads=$this -> new_leads($row -> id,$row->role);
				 $call_today=$this -> call_today($row -> id,$row->role);
				 $pending_new_leads=$this -> pending_new($row -> id,$row->role);
				 $pending_followup=$this -> pending_followup($row -> id,$row->role);*/

				$select_leads[] = array('lead_source' => $row -> lead_source, 'leads_generated' => $row -> leads_generated, 'live_leads' => $live_leads, 'close_leads' => $close_leads, 'lost_to_co_dealer_leads' => $lost_to_co_dealer_leads, 'lost_to_other_leads' => $lost_to_other_leads, 'booked_leads' => $booked_leads);

			}
		} else {
			//$select_leads[] = array('id'=>'','role'=>'', 'location_name'=>'','fname' => '', 'lname' => '', 'unassigned_leads' => '',  'new_leads' => '','call_today' => '', 'pending_new_leads' => '', 'pending_followup' => '');
			$select_leads = array();

		}
		return $select_leads;
	}

	public function close_leads($lead_source, $from_date, $to_date) {

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
		$this -> db -> where('l.lead_source', $lead_source);
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $this -> process_name);
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

	public function lost_to_co_dealer_leads($lead_source, $from_date, $to_date) {

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
		$this -> db -> where('l.lead_source', $lead_source);
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $this -> process_name);
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

	public function lost_to_other_leads($lead_source, $from_date, $to_date) {

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
		$this -> db -> where('l.lead_source', $lead_source);
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $this -> process_name);
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

	public function booked_leads($lead_source, $from_date, $to_date) {

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
		$this -> db -> where('l.lead_source', $lead_source);
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $this -> process_name);
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

	public function live_leads($lead_source, $from_date, $to_date) {

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
		
		$this -> db -> where('l.lead_source', $lead_source);
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$t="(cse_followup_id !='0' || exe_followup_id !='0')";
			$this -> db -> where($t);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$t="(cse_followup_id !='0' || dse_followup_id !='0')";
			$this -> db -> where($t);
		}
		$this -> db -> where('l.nextAction !=', 'Booked From Autovista');
		$this -> db -> where('l.nextAction !=', 'Close');
		
		
		$this -> db -> where($from_date);
		$this -> db -> where($to_date);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}

	function select_cse() {

		$this -> db -> select('concat(u.fname," ",u.lname) as cse_name,u.id');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id');
		$this -> db -> where('m.process_id', $this -> process_id);
		$this -> db -> where('m.location_id', 38);
		$this -> db -> where('u.role', 3);
		$this -> db -> where('u.status', 1);
		$this -> db -> group_by('u.id');
		$query = $this -> db -> get();

		//		echo $this->db->last_query();

		return $query -> result();

	}

	/*public function search_performance($cse_id,$fromdate,$todate) {

		
		
		
		$this -> db -> select('u.fname,u.lname,u.id');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id');
		$this -> db -> where('m.process_id', $this -> process_id);
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

				$assign_leads = $this -> cse_assigned_leads($row -> id, $fromdate, $todate);
			$new_leads = $this -> cse_new_leads($row -> id, $fromdate, $todate);
				$pending_new_leads = $this -> cse_pending_new_leads($row -> id, $fromdate, $todate);

				$pending_followup_leads = $this -> cse_pending_followup_leads($row -> id, $fromdate, $todate);
				
				$sent_to_showroom_leads= $this -> cse_sent_to_showroom_leads($row -> id, $fromdate, $todate);

				$live_leads = $this -> cse_live_leads($row -> id, $fromdate, $todate);
				$close_leads = $this -> cse_close_leads($row -> id, $fromdate, $todate);
				$booked_leads = $this -> cse_booked_leads($row -> id, $fromdate, $todate);
				// 'pending_new_leads' => $pending_new_leads,

				$select_data[] = array('cse_id' => $row -> id,'cse_fname' => $row -> fname, 'cse_lname' => $row -> lname, 'assign_lead' => $assign_leads,'pending_new_leads' => $pending_new_leads,
				 'pending_followup_leads' => $pending_followup_leads, 'live_leads' => $live_leads
				,'close_leads' => $close_leads, 'booked_leads' => $booked_leads,'new_leads' => $new_leads,'sent_to_showroom_leads' => $sent_to_showroom_leads);

			}

		} else {

			$select_data = array();

		}

		return $select_data;

	}*/
public function cse_performance($cse_id,$fromdate,$todate) {
		$this -> db -> select('u.fname,u.lname,u.id');
		$this -> db -> from('lmsuser u');
		$this -> db -> join('tbl_manager_process m', 'm.user_id=u.id');
		$this -> db -> where('m.process_id', $this -> process_id);
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

				$assign_leads = $this -> cse_assigned_leads($row -> id, $fromdate, $todate);
			$new_leads = $this -> cse_new_leads($row -> id, $fromdate, $todate);
				$pending_new_leads = $this -> cse_pending_new_leads($row -> id, $fromdate, $todate);

				$pending_followup_leads = $this -> cse_pending_followup_leads($row -> id, $fromdate, $todate);
				
				$sent_to_showroom_leads= $this -> cse_sent_to_showroom_leads($row -> id, $fromdate, $todate);

				$live_leads = $this -> cse_live_leads($row -> id, $fromdate, $todate);
				$close_leads = $this -> cse_close_leads($row -> id, $fromdate, $todate);
				$booked_leads = $this -> cse_booked_leads($row -> id, $fromdate, $todate);
				// 'pending_new_leads' => $pending_new_leads,

				$select_data[] = array('cse_id' => $row -> id,'cse_fname' => $row -> fname, 'cse_lname' => $row -> lname, 'assign_lead' => $assign_leads,'pending_new_leads' => $pending_new_leads,
				 'pending_followup_leads' => $pending_followup_leads, 'live_leads' => $live_leads
				,'close_leads' => $close_leads, 'booked_leads' => $booked_leads,'new_leads' => $new_leads,'sent_to_showroom_leads' => $sent_to_showroom_leads);

			}

		} else {

			$select_data = array();

		}

		return $select_data;

	}
	public function cse_assigned_leads($id, $fromdate, $todate) {

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
	
		$this -> db -> where('l.assign_to_cse', $id);
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $this -> process_name);
		}		
		$this -> db -> where('l.assign_to_cse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_cse_date<=',$todate);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
	
	
	
	
	public function cse_sent_to_showroom_leads($id, $fromdate, $todate) {

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
	
		$this -> db -> where('l.assign_to_cse', $id);
		

		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('l.assign_to_e_tl!=', 0);
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
	
	
	
	
public function cse_pending_new_leads($id, $fromdate, $todate) {
		$today=date('Y-m-d');
		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
	
		$this -> db -> where('l.assign_to_cse', $id);
		$this -> db -> where('l.cse_followup_id', 0);
		
		$this->db->where('assign_to_cse_date<',$today);
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('l.assign_to_e_tl ', 0);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('l.assign_to_dse_tl', 0);
		}		
		$this -> db -> where('l.assign_to_cse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_cse_date<=',$todate);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
public function cse_new_leads($id, $fromdate, $todate) {
		$today=date('Y-m-d');
		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
	
		$this -> db -> where('l.assign_to_cse', $id);
		$this -> db -> where('l.cse_followup_id', 0);
		$this->db->where('assign_to_cse_date',$today);
		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $this -> process_name);
		}		
		$this -> db -> where('l.assign_to_cse_date>=',$fromdate);
		$this -> db -> where('l.assign_to_cse_date<=',$todate);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$close_leads = $query1[0] -> close;
		return $close_leads;
	}
public function cse_pending_followup_leads($id, $fromdate, $todate) {

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
		$this -> db -> join($this -> table_name1,'l.cse_followup_id=f.id','left');
		$this -> db -> where('l.assign_to_cse', $id);
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $this -> process_name);
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
	public function cse_live_leads($id, $fromdate, $todate) {

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
		//$this -> db -> join($this -> table_name1,'l.cse_followup_id=f.id','left');
		$this -> db -> where('l.assign_to_cse', $id);
		$this -> db -> where('l.cse_followup_id !=', '0');
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $this -> process_name);
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
	public function cse_close_leads($id, $fromdate, $todate) {

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
		//$this -> db -> join($this -> table_name1,'l.cse_followup_id=f.id','left');
		$this -> db -> where('l.assign_to_cse', $id);
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $this -> process_name);
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
	public function cse_booked_leads($id, $fromdate, $todate) {

		$this -> db -> select('count(enq_id) as close');
		$this -> db -> from($this -> table_name);
		$this -> db -> where('l.assign_to_cse', $id);
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
		} else {
			$this -> db -> where('l.process', $this -> process_name);
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
	
/**************************************************************************************************************************/
public function select_location()
{
	$this -> db -> select('l.location_id,l.location');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_map_process p','p.location_id=l.location_id');
		$this->db->where('p.status !=','-1');
		$this->db->where('l.location_status !=','Deactive');
		$this->db->where('l.location_id !=','38');
		$this->db->where('p.process_id',$this->process_id);
		$this->db->order_by('l.location','asc');
	
	$query=$this->db->get();
	//echo $this->db->last_query();
	return $query->result();
}
public function search_locationwise_report()
{
	$location_id=$this->input->post('location_id');
	$from_date=$this->input->post('from_date');
	$to_date=$this->input->post('to_date');
	$this -> db -> select('l.location_id,l.location');
	$this->db->from('tbl_location l');
	$this->db->join('tbl_map_process p','p.location_id=l.location_id');
	$this->db->where('p.status !=','-1');
	$this->db->where('l.location_id !=','38');
	$this->db->where('l.location_status !=','Deactive');
	$this->db->where('p.process_id',$this->process_id);

	if($location_id!=''){
		$this->db->where('l.location_id',$location_id);
	}
		
		$this -> db -> group_by('l.location_id');
		$this->db->order_by('l.location','asc');
		$query = $this -> db -> get()->result();
	
		if(count($query)>0){
	foreach ($query as $row) {
		$location_id=$row->location_id;
		if($_SESSION['process_id']==8){
			$role='15';
		}else{
			$role='5';
		}
		$query_id=$this->db->query('select l.id from lmsuser l join tbl_manager_process m on l.id=m.user_id where m.location_id='.$location_id.' and l.role='.$role.' and l.status=1 and m.process_id='.$this->process_id)->result();
//	echo $this->db->last_query();
	$ids = array();
foreach ($query_id as $id)
    {
        $ids[] = $id->id;
    }
	if(count($ids)>0){

	$total_lead=$this->total_lead($ids,$from_date,$to_date);
	$total_avg_month=$this->total_avg_month($ids);
	$total_lead_assigned_month=$this->total_lead_assigned_month($ids);
	
	$total_live_leads=$this->total_live_leads($ids,$from_date,$to_date);
	$total_lost_leads=$this->total_lost_leads($ids,$from_date,$to_date);
	$total_booking=$this->total_booking	($ids,$from_date,$to_date);	
	$total_lost_to_co_dealer=$this->total_lost_to_co_dealer($ids,$from_date,$to_date);	
	$esculation_level_1=$this->esculation_level($ids,$from_date,$to_date,'esc_level1');	
	$esculation_level_2=$this->esculation_level($ids,$from_date,$to_date,'esc_level2');	
	$esculation_level_3=$this->esculation_level($ids,$from_date,$to_date,'esc_level3');	
	}else{
		$total_lead="";
	$total_avg_month="";
	$total_lead_assigned_month="";
	
	$total_live_leads="";
	$total_lost_leads="";
	$total_booking="";	
	$total_lost_to_co_dealer="";	
	$esculation_level_1="";	
	$esculation_level_2="";	
	$esculation_level_3="";	
	}
	$select_data[]=array('location'=>$row->location,'total_lead_assigned'=>$total_lead,'total_avg_month'=>$total_avg_month,'total_lead_assigned_month'=>$total_lead_assigned_month,'total_live_leads'=>$total_live_leads,'total_lost_leads'=>$total_lost_leads,'total_booking'=>$total_booking,'total_lost_to_co_dealer'=>$total_lost_to_co_dealer,'esculation_level_1'=>$esculation_level_1,'esculation_level_2'=>$esculation_level_2,'esculation_level_3'=>$esculation_level_3);
	}
}else{
			$select_data=array();
		}

	return $select_data;
	
}
public function total_lead($ids,$from_date,$to_date)
{
	$this->db->select('count(distinct enq_id) as leadcount');
	if($_SESSION['process_id']==8){
			$this->db->from('lead_master_evaluation l');
			$this->db->where_in('assign_to_e_tl',$ids);
			$this->db->where('l.assign_to_e_tl_date>=',$from_date);
			$this->db->where('l.assign_to_e_tl_date<=',$to_date);
	}else{
			$this->db->from('lead_master l');
			$this->db->where_in('assign_to_dse_tl',$ids);
			$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
			$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
	}

	
	$query=$this->db->get()->result();
	$total_leads=$query[0]->leadcount;
	return $total_leads;
}
public function total_live_leads($ids,$from_date,$to_date)
{
	$this->db->select('count(distinct enq_id) as leadcount');

	if ($this -> process_id == 8) {
			$this->db->from('lead_master_evaluation l');
			$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where_in('assign_to_e_tl',$ids);
			$this->db->where('l.assign_to_e_tl_date>=',$from_date);
			$this->db->where('l.assign_to_e_tl_date<=',$to_date);
		} else {
				$this->db->from('lead_master l');
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where_in('assign_to_dse_tl',$ids);
			$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
			$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
		}
	
	
	$this -> db -> where('l.nextAction !=', 'Booked From Autovista');
	$this -> db -> where('l.nextAction !=', 'Close');
	$query=$this->db->get()->result();
	$total_leads=$query[0]->leadcount;
	return $total_leads;
	
}
public function total_lost_leads($ids,$from_date,$to_date)
{
	$this->db->select('count(distinct enq_id) as leadcount');
	
	if ($this -> process_id == 8) {
		$this->db->from('lead_master_evaluation l');
			$this -> db -> where('l.evaluation', 'Yes');
				$this->db->where_in('assign_to_e_tl',$ids);
			$this->db->where('l.assign_to_e_tl_date>=',$from_date);
			$this->db->where('l.assign_to_e_tl_date<=',$to_date);
		} else {
			$this->db->from('lead_master l');
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where_in('assign_to_dse_tl',$ids);
			$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
			$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
		}

	
		$this -> db -> where('l.nextAction', 'Close');
	$query=$this->db->get()->result();
	$total_leads=$query[0]->leadcount;
	return $total_leads;
	
}
public function total_booking($ids,$from_date,$to_date)
{
	$this->db->select('count(distinct enq_id) as leadcount');
	
	if ($this -> process_id == 8) {
		$this->db->from('lead_master_evaluation l');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where_in('assign_to_e_tl',$ids);
		$this->db->where('l.assign_to_e_tl_date>=',$from_date);
		$this->db->where('l.assign_to_e_tl_date<=',$to_date);
		} else {
			$this->db->from('lead_master l');
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where_in('assign_to_dse_tl',$ids);
	$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
	$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
		}
	
	$this -> db -> where('l.nextAction', 'Booked From Autovista');
	$query=$this->db->get()->result();
	$total_leads=$query[0]->leadcount;
	return $total_leads;
	
}
public function total_lost_to_co_dealer($ids,$from_date,$to_date)
{
	$this->db->select('count(distinct enq_id) as leadcount');
	
	if ($this -> process_id == 8) {
		$this->db->from('lead_master_evaluation l');
			$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where_in('assign_to_e_tl',$ids);
			$this->db->where('l.assign_to_e_tl_date>=',$from_date);
			$this->db->where('l.assign_to_e_tl_date<=',$to_date);
			
		} else {
			$this->db->from('lead_master l');
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where_in('assign_to_dse_tl',$ids);
			$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
			$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
		}
	$this -> db -> where('l.feedbackStatus ', 'Lost to Co-Dealer');
		$this -> db -> where('l.nextAction', 'Close');
	$query=$this->db->get()->result();
	$total_leads=$query[0]->leadcount;
	return $total_leads;
	
}
public function esculation_level($ids,$from_date,$to_date,$level_field)
{
	$this->db->select('count(distinct enq_id) as leadcount');
	
	if ($this -> process_id == 8) {
		$this->db->from('lead_master_evaluation l');
			$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where_in('assign_to_e_tl',$ids);
	$this->db->where('l.assign_to_e_tl_date>=',$from_date);
	$this->db->where('l.assign_to_e_tl_date<=',$to_date);
		} else {
			$this->db->from('lead_master l');
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where_in('assign_to_dse_tl',$ids);
	$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
	$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
		}

	$this -> db -> where($level_field, 'Yes');
	
	$query=$this->db->get()->result();
	//echo $this->db->last_query();
	$total_leads=$query[0]->leadcount;
	return $total_leads;
	
}
public function total_avg_month($ids)
{
	$from_date=date('Y-01-01');
	$to_date=date('Y-m-d');
	$this->db->select('count(distinct enq_id) as leadcount');
	
	if ($this -> process_id == 8) {
		$this->db->from('lead_master_evaluation l');
		$this -> db -> where('l.evaluation', 'Yes');
		$this->db->where_in('assign_to_e_tl',$ids);
		$this->db->where('l.assign_to_e_tl_date>=',$from_date);
		$this->db->where('l.assign_to_e_tl_date<=',$to_date);
		} else {
			$this->db->from('lead_master l');
		$this -> db -> where('l.process', $this -> process_name);
		$this->db->where_in('assign_to_dse_tl',$ids);
		$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
		$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
		}


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

public function total_lead_assigned_month($ids)
{
	$from_date=date('Y-m-01');
	$to_date=date('Y-m-d');
	$this->db->select('count(distinct enq_id) as leadcount');
	
	if ($this -> process_id == 8) {
		$this->db->from('lead_master_evaluation l');
			$this -> db -> where('l.evaluation', 'Yes');
			$this->db->where_in('assign_to_e_tl',$ids);
			$this->db->where('l.assign_to_e_tl_date>=',$from_date);
			$this->db->where('l.assign_to_e_tl_date<=',$to_date);
		} else {
			$this->db->from('lead_master l');
			$this -> db -> where('l.process', $this -> process_name);
			$this->db->where_in('assign_to_dse_tl',$ids);
			$this->db->where('l.assign_to_dse_tl_date>=',$from_date);
			$this->db->where('l.assign_to_dse_tl_date<=',$to_date);
		}
	
	
	$query=$this->db->get();

	$query=$query->result();
	$total_leads=$query[0]->leadcount;
	return $total_leads;
	
}

}
?>