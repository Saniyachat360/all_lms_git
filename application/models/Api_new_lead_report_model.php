<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_new_lead_report_model extends CI_Model {
	public function __construct() {
		parent::__construct();
	}
	public function select_table($process_id)
	{
		$this->today=date('Y-m-d');
		if ($process_id == 6 || $process_id == 7) {
			
			$lead_master_table = 'lead_master';
			$lead_followup_table = 'lead_followup';
			$request_to_lead_transfer_table = 'request_to_lead_transfer';
				
		} else {
			
			$lead_master_table = 'lead_master_all';
			$lead_followup_table = 'lead_followup_all';
			$request_to_lead_transfer_table = 'request_to_lead_transfer_all';
				
		}
	
		return array( 'lead_master_table'=>$lead_master_table,'lead_followup_table'=>$lead_followup_table,'request_to_lead_transfer_table'=>$request_to_lead_transfer_table) ;
		
	}
	public function total_lead($process_name,$role,$user_id,$location_id, $fromdate, $todate,$process_id) {		
		/*if ($location_id == 38) {*/
			$total_leads = $this -> total_lead_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$total_unassigned_leads = $this -> total_unassigned_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$total_pending_new_leads = $this -> total_pending_new_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$total_pending_followup_leads = $this -> total_pending_followup_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			/*$days = '30';
			$total_booking_30 = $this -> booking_days_cse($location_id, $days, $fromdate, $todate);
			$days = '60';
			$total_booking_60 = $this -> booking_days_cse($location_id, $days, $fromdate, $todate);
			$days = '>60';
			$total_booking_greater_60 = $this -> booking_days_cse($location_id, $days, $fromdate, $todate);*/
		/*} else {
			$this -> db -> select('id');
			$this -> db -> from('lmsuser');
			$this -> db -> where('location', $location_id);
			$this -> db -> where('role', 5);
			$query = $this -> db -> get() -> result();
			foreach ($query as $row) {
				$dse_tl_id[] = $row -> id;
			}
			$total_leads = $this -> total_lead_count_dse($dse_tl_id, $fromdate, $todate);
			$total_unassigned_leads = $this -> total_unassigned_count_dse($dse_tl_id, $fromdate, $todate);
			$total_pending_new_leads = $this -> total_pending_new_count_dse1($dse_tl_id, $fromdate, $todate);
			$total_pending_followup_leads = $this -> total_pending_followup_count_dse1($dse_tl_id, $fromdate, $todate);
			$days = '30';
			$total_booking_30 = $this -> booking_days_dse($dse_tl_id, $days, $fromdate, $todate);
			$days = '60';
			$total_booking_60 = $this -> booking_days_dse($dse_tl_id, $days, $fromdate, $todate);
			$days = '>60';
			$total_booking_greater_60 = $this -> booking_days_dse($dse_tl_id, $days, $fromdate, $todate);
		}*/
		$select_leads[] = array('total_leads' => $total_leads, 'total_unassigned_leads' => $total_unassigned_leads, 'total_pending_new_leads' => $total_pending_new_leads, 'total_pending_followup_leads' => $total_pending_followup_leads);
		
		//$select_leads[] = array('total_leads' => $total_leads[0] -> total_leads, 'total_unassigned_leads' => $total_unassigned_leads[0] -> total_leads, 'total_pending_new_leads' => $total_pending_new_leads[0] -> total_leads, 'total_pending_followup_leads' => $total_pending_followup_leads[0] -> total_leads);
		return $select_leads;

	}
////////////////CSE Count //////////////////////
	public function total_lead_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id,$process_id) 
	{
			$table=$this->select_table($process_id);	
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as total_leads');
		$this -> db -> from($table['lead_master_table'].' ln');
		//$this -> db -> from($this->table_name.' ln');
		$this -> db -> where('ln.process', $process_name);
		// If user DSE TL
		if($role == '5')
		{
			$this -> db -> where('ln.assign_to_dse_tl',$user_id);
		
		}
		// If user DSE 
		elseif($role == '4')
		{
			$this -> db -> where('ln.assign_to_dse', $user_id);
		}
		// If user Excecutive
		elseif (in_array($role,$this->executive_array)) {
	
			$this -> db -> where('ln.assign_to_cse', $user_id);
		}
		//if user TL 
		elseif(in_array($role,$this->tl_array)){
			$this -> db -> where('ln.assign_by_cse_tl', $user_id);
		
			
		}
		$this -> db -> where('ln.created_date>=', $fromdate);
		$this -> db -> where('ln.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_leads = $query1[0] -> total_leads;
		return $total_leads;
	}
	////////////////CSE Count //////////////////////
	/*public function total_lead_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id) {
		
		$this -> db -> select("count(enq_id) as total_leads");
		$this -> db -> from("lead_master l");
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_cse');
		$this -> db -> where('u.location', $location_id);
		$this -> db -> where('l.assign_to_dse_tl', 0);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		return $query -> result();
	}*/
public function total_unassigned_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id,$process_id) {
		
		//echo $id;
		$table=$this->select_table($process_id);	
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as total_leads');
			$this -> db -> from($table['lead_master_table'].' ln');
		$this -> db -> where('ln.process', $process_name);
		$this -> db -> where('ln.nextAction!=', "Close");
		if($role == '5')
		{
			$this -> db -> where('ln.assign_to_dse_tl',$user_id);
			$this -> db -> where('ln.assign_to_dse', 0);
		}
		elseif($role == '4')
		{
			$this -> db -> where('ln.assign_to_dse_tl',0);
			$this -> db -> where('ln.assign_to_dse', $user_id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> where('assign_by_cse_tl', 0);
			$this -> db -> where('ln.assign_to_cse', $user_id);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> where('assign_by_cse_tl', 0);
		
			
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_unassigned = $query1[0] -> total_leads;
		return $total_unassigned;
	}
	/*public function total_unassigned_count_cse($location_id, $fromdate, $todate) {
		
		$this -> db -> select("count(enq_id) as total_leads");
		$this -> db -> from("lead_master l");

		$this -> db -> where('l.assign_to_cse', 0);
		$this -> db -> where('l.assign_to_dse_tl', 0);
		$this -> db -> where('l.nextAction !=', 'Close');
		
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();

		return $query -> result();
	}*/
public function total_pending_new_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id,$process_id) {
			
		$table=$this->select_table($process_id);
		$today=$todate;
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as total_leads');
			$this -> db -> from($table['lead_master_table'].' ln');
		$this -> db -> where('ln.process', $process_name);
		$this -> db -> where('ln.nextAction!=', "Close");
		
		if($role == '5')
		{
			$this -> db -> where('dse_followup_id', 0);
			$this -> db -> where('ln.assign_to_dse_tl',$user_id);
			$this -> db -> where('ln.assign_to_dse_date <', $today);
		}
		elseif($role == '4')
		{
			$this -> db -> where('ln.dse_followup_id',0);
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $user_id);
			$this -> db -> where('ln.assign_to_dse_date <', $today);
		}
		elseif (in_array($role,$this->executive_array)) {
			
			$this -> db -> where('cse_followup_id', 0);
			$this -> db -> where('ln.assign_to_cse', $user_id);
			$this -> db -> where('ln.assign_to_cse_date < ', $today);
		}
		elseif(in_array($role,$this->tl_array)) {
			$this -> db -> where('ln.assign_to_dse_tl', 0);
			$this -> db -> where('assign_by_cse_tl', $user_id);
			$this -> db -> where('ln.assign_to_cse_date < ', $today);
			$this -> db -> where('cse_followup_id', 0);
		}
		$this -> db -> where('ln.created_date>=', $fromdate);
		$this -> db -> where('ln.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_pending_new = $query1[0] -> total_leads;
		return $total_pending_new;

	}
	
/*	public function total_pending_new_count_cse($location_id, $fromdate, $todate) {
		
		$today = date('Y-m-d');
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$this -> db -> select('count(ln.enq_id) as total_leads');
		$this -> db -> from('lead_master ln');
		$this -> db -> join('lmsuser u', 'u.id=ln.assign_to_cse');
		$this -> db -> where('ln.assign_to_dse_tl', 0);
		$this -> db -> where('ln.cse_followup_id', '0');
		$this -> db -> where('ln.assign_to_cse_date <', $yesterday);
		$this -> db -> where('u.location', $location_id);
		$this -> db -> where('ln.created_date>=', $fromdate);
		$this -> db -> where('ln.created_date<=', $todate);

		$query = $this -> db -> get();
		return $query -> result();

	}*/
public function total_pending_followup_count_cse($location_id, $fromdate, $todate,$role,$process_name,$user_id,$process_id) {
				
		$table=$this->select_table($process_id);
		$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as total_leads');
		$this -> db -> from($table['lead_master_table'].' ln');
		if($role == '5')
		{	$this -> db -> join($table['lead_followup_table'].' f', 'f.id=ln.dse_followup_id');
				
			//$this -> db -> join($this->table_name1.' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl',$user_id);
		}
		elseif($role == '4')
		{
			$this -> db -> join($table['lead_followup_table'].' f', 'f.id=ln.dse_followup_id');	
			//$this -> db -> join($this->table_name1.' f','f.id=ln.dse_followup_id');
			$this -> db -> where('ln.assign_to_dse_tl!=',0);
			$this -> db -> where('ln.assign_to_dse', $user_id);
		}
		else {
			$this -> db -> join($table['lead_followup_table'].' f', 'f.id=ln.cse_followup_id');	
			//$this -> db -> join($this->table_name1.' f','f.id=ln.cse_followup_id');
		}
		if (in_array($role,$this->executive_array)) {
			
			$this -> db -> where('ln.assign_to_cse', $user_id);
			$this -> db -> where('ln.assign_to_dse_tl',0);
		}elseif(in_array($role,$this->tl_array)){
			//$this -> db -> join($this->table_name1.' f','f.id=ln.cse_followup_id');
			$this -> db -> where('assign_by_cse_tl', $user_id);
			$this -> db -> where('ln.assign_to_dse_tl',0);
		}
		$this -> db -> where('ln.process', $process_name);
		$this -> db -> where('f.nextfollowupdate <', $today);
		$this -> db -> where('f.nextfollowupdate!=', '0000-00-00');
		$this -> db -> where('ln.nextAction!=', "Close");	
		$this -> db -> where('ln.created_date>=', $fromdate);
		$this -> db -> where('ln.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_call_today = $query1[0] -> total_leads;
		return $total_call_today;

	}
	/*public function total_pending_followup_count_cse($location_id, $fromdate, $todate) {
		
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as total_leads');
		$this -> db -> from("lead_master l");
		$this -> db -> join('lead_followup lm', 'l.cse_followup_id=lm.id');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_cse');
		$this -> db -> where('l.assign_to_dse_tl', 0);
		$this -> db -> where('lm.nextfollowupdate<', $today);
		$this -> db -> where('lm.nextfollowupdate!=', '0000-00-00');
		$this -> db -> where('u.location', $location_id);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);

		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}*/

	public function booking_days_cse($location_id, $days, $fromdate, $todate) {
		
		$this -> db -> select("count(l.enq_id) as total_leads");
		$this -> db -> from('lead_master l');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_cse');
		$this -> db -> join('lead_followup lm', 'l.cse_followup_id=lm.id');
		$this -> db -> where('l.assign_to_dse_tl', 0);
		$this -> db -> where('lm.days60_booking', $days);
		$this -> db -> where('u.location', $location_id);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	////////////////DSE Count //////////////////////
	public function total_lead_count_dse($dse_tl_id, $fromdate, $todate) {
		
		$this -> db -> select("count(enq_id) as total_leads");
		$this -> db -> from("lead_master l");
		$this -> db -> where_in('l.assign_to_dse_tl', $dse_tl_id);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();

		return $query -> result();
	}

	public function total_unassigned_count_dse($dse_tl_id, $fromdate, $todate) {
		
		$this -> db -> select("count(enq_id) as total_leads");
		$this -> db -> from("lead_master l");
		$this -> db -> where('l.assign_to_dse', 0);
		//$this -> db -> where('l.assign_to_dse_tl!=', 0);
		$this -> db -> where_in('l.assign_to_dse_tl', $dse_tl_id);
		$this -> db -> where('l.nextAction!=', 'Close');
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();

		return $query -> result();
	}

	public function total_pending_new_count_dse1($dse_tl_id, $fromdate, $todate) {
		
		$today = date('Y-m-d');
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$this -> db -> select('count(l.enq_id) as total_leads');
		$this -> db -> from('lead_master l');
		$this -> db -> where('l.dse_followup_id', '0');
		$this -> db -> where_in('l.assign_to_dse_tl', $dse_tl_id);
		$this -> db -> where('l.assign_to_dse_tl_date <', $yesterday);
		$this -> db -> where('l.assign_to_dse_date <', $yesterday);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function total_pending_followup_count_dse1($dse_tl_id, $fromdate, $todate) {
		
		$today = date('Y-m-d');
		$this -> db -> select('count(lm.id) as total_leads');
		$this -> db -> from("lead_master l");
		$this -> db -> join('lead_followup lm', 'l.dse_followup_id=lm.id');
		$this -> db -> where('lm.nextfollowupdate<', $today);
		$this -> db -> where('lm.nextfollowupdate!=', '0000-00-00');
		$this -> db -> where_in('l.assign_to_dse_tl', $dse_tl_id);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function booking_days_dse($dse_tl_id, $days, $fromdate, $todate) {
		
		$this -> db -> select("count(l.enq_id) as total_leads");
		$this -> db -> from('lead_master l');
		$this -> db -> join('lead_followup lm', 'l.dse_followup_id=lm.id');
		$this -> db -> where('lm.days60_booking', $days);
		$this -> db -> where_in('l.assign_to_dse_tl', $dse_tl_id);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	public function total_feedback($process_name,$role,$user_id,$location_id, $fromdate, $todate,$process_id) {
		/*if ($location_id == 38) {
	
			$feedback2 = 'Not Interested';
			$total_count2 = $this -> total_feedback_count_cse($location_id, $feedback2, $fromdate, $todate);
			$feedback3 = 'Already Booked From Us';
			$total_count3 = $this -> total_feedback_count_cse($location_id, $feedback3, $fromdate, $todate);
			$feedback4 = 'Lost to Co-Dealer';
			$total_count4 = $this -> total_feedback_count_cse($location_id, $feedback4, $fromdate, $todate);
			$feedback5 = 'Colour And Model Availablity';
			$total_count5 = $this -> total_feedback_count_cse($location_id, $feedback5, $fromdate, $todate);
			$feedback6 = 'Budget Issue';
			$total_count6 = $this -> total_feedback_count_cse($location_id, $feedback6, $fromdate, $todate);
			$feedback7 = 'Nearest Dealership Available';
			$total_count7 = $this -> total_feedback_count_cse($location_id, $feedback7, $fromdate, $todate);
			$feedback8 = 'Outstation Purchase';
			$total_count8 = $this -> total_feedback_count_cse($location_id, $feedback8, $fromdate, $todate);
			$feedback9 = 'Plan Cancelled';
			$total_count9 = $this -> total_feedback_count_cse($location_id, $feedback9, $fromdate, $todate);
			$feedback10 = 'Undecided';
			$total_count10 = $this -> total_feedback_count_cse($location_id, $feedback10, $fromdate, $todate);
			$nextAction11 = 'Follow-up';
			$total_count11 = $this -> total_nextAction_count_cse($location_id, $nextAction11, $fromdate, $todate);
			$nextAction12 = 'Home Visit';
			$total_count12 = $this -> total_nextAction_count_cse($location_id, $nextAction12, $fromdate, $todate);
			$nextAction13 = 'Showroom Visit';
			$total_count13 = $this -> total_nextAction_count_cse($location_id, $nextAction13, $fromdate, $todate);
			$nextAction14 = 'Test Drive';
			$total_count14 = $this -> total_nextAction_count_cse($location_id, $nextAction14, $fromdate, $todate);
			$nextAction15 = 'Evaluation Allotted';
			$total_count15 = $this -> total_nextAction_count_cse($location_id, $nextAction15, $fromdate, $todate);
			$nextAction16 = 'Deal';
			$total_count16 = $this -> total_nextAction_count_cse($location_id, $nextAction16, $fromdate, $todate);
			$nextAction17 = 'Booked From Autovista';
			$total_count17 = $this -> total_nextAction_count_cse($location_id, $nextAction17, $fromdate, $todate);

		} else {
			$this -> db -> select('id');
			$this -> db -> from('lmsuser');
			$this -> db -> where('location', $location_id);
			$this -> db -> where('role', 5);
			$query = $this -> db -> get() -> result();
			foreach ($query as $row) {
				$dse_tl_id[] = $row -> id;
			}
			
			$feedback2 = 'Not Interested';
			$total_count2 = $this -> total_feedback_count_dse($dse_tl_id, $feedback2, $fromdate, $todate);
			$feedback3 = 'Already Booked From Us';
			$total_count3 = $this -> total_feedback_count_dse($dse_tl_id, $feedback3, $fromdate, $todate);
			$feedback4 = 'Lost to Co-Dealer';
			$total_count4 = $this -> total_feedback_count_dse($dse_tl_id, $feedback4, $fromdate, $todate);
			$feedback5 = 'Colour And Model Availablity';
			$total_count5 = $this -> total_feedback_count_dse($dse_tl_id, $feedback5, $fromdate, $todate);
			$feedback6 = 'Budget Issue';
			$total_count6 = $this -> total_feedback_count_dse($dse_tl_id, $feedback6, $fromdate, $todate);
			$feedback7 = 'Nearest Dealership Available';
			$total_count7 = $this -> total_feedback_count_dse($dse_tl_id, $feedback7, $fromdate, $todate);
			$feedback8 = 'Outstation Purchase';
			$total_count8 = $this -> total_feedback_count_dse($dse_tl_id, $feedback8, $fromdate, $todate);
			$feedback9 = 'Plan Cancelled';
			$total_count9 = $this -> total_feedback_count_dse($dse_tl_id, $feedback9, $fromdate, $todate);
			$feedback10 = 'Undecided';
			$total_count10 = $this -> total_feedback_count_dse($dse_tl_id, $feedback10, $fromdate, $todate);
			$nextAction11 = 'Follow-up';
			$total_count11 = $this -> total_nextAction_count_dse($dse_tl_id, $nextAction11, $fromdate, $todate);
			$nextAction12 = 'Home Visit';
			$total_count12 = $this -> total_nextAction_count_dse($dse_tl_id, $nextAction12, $fromdate, $todate);
			$nextAction13 = 'Showroom Visit';
			$total_count13 = $this -> total_nextAction_count_dse($dse_tl_id, $nextAction13, $fromdate, $todate);
			$nextAction14 = 'Test Drive';
			$total_count14 = $this -> total_nextAction_count_dse($dse_tl_id, $nextAction14, $fromdate, $todate);
			$nextAction15 = 'Evaluation Allotted';
			$total_count15 = $this -> total_nextAction_count_dse($dse_tl_id, $nextAction15, $fromdate, $todate);
			$nextAction16 = 'Deal';
			$total_count16 = $this -> total_nextAction_count_dse($dse_tl_id, $nextAction16, $fromdate, $todate);
			$nextAction17 = 'Booked From Autovista';
			$total_count17 = $this -> total_nextAction_count_dse($dse_tl_id, $nextAction17, $fromdate, $todate);
		}
		$select_leads[] = array('booked_from_autovista' => $total_count17[0] -> total_count,'follow_up' => $total_count11[0] -> total_count,
		 'home_visit' => $total_count12[0] -> total_count, 'showroom_visit' => $total_count13[0] -> total_count, 'test_drive' => $total_count14[0] -> total_count, 
		 'evaluation_allotted' => $total_count15[0] -> total_count, 'deal' => $total_count16[0] -> total_count, 'undecided' => $total_count10[0] -> total_count,
		  'not_interested' => $total_count2[0] -> total_count, 'already_booked_from_us' => $total_count3[0] -> total_count, 'lost_to_codealer' => $total_count4[0] -> total_count,
		   'color_model_availability' => $total_count5[0] -> total_count, 'budget_issue' => $total_count6[0] -> total_count, 'nearest_dealership' => $total_count7[0] -> total_count, 
		   'outstation_purchase' => $total_count8[0] -> total_count, 'plan_cancel' => $total_count9[0] -> total_count);*/
		   if($process_name=='Finance')
	{
		$feedback2 = 'Appointment taken';
			$total_count2 = $this -> total_feedback_count_cse($feedback2, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$feedback3 = 'Login';
			$total_count3 = $this -> total_feedback_count_cse($feedback3, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$feedback4 = 'Login and Reject';
			$total_count4 = $this -> total_feedback_count_cse($feedback4, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$feedback5 = 'Login and Cancel';
			$total_count5 = $this -> total_feedback_count_cse( $feedback5, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$nextAction11 = 'Lost';
			$total_count11 = $this -> total_nextAction_count_cse($nextAction11, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$nextAction12 = 'Disbursement';
			$total_count12 = $this -> total_nextAction_count_cse($nextAction12, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			
			$select_leads[] = array('lost' => $total_count11[0] -> total_count, 'disbursement' => $total_count12[0] -> total_count,  
			'appointment_taken' => $total_count2[0] -> total_count, 'login' => $total_count3[0] -> total_count, 'login_and_reject' => $total_count4[0] -> total_count, 
			'login_and_cancel' => $total_count5[0] -> total_count);
		
	}else if($process_name=='Accessories')
		{
			$feedback2 = 'Will Decide Later';
			$total_count2 = $this -> total_feedback_count_cse($feedback2, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$feedback3 = 'Purchase from Outside';
			$total_count3 = $this -> total_feedback_count_cse($feedback3, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$feedback7 = 'Dont want Maruti';
			$total_count7 = $this -> total_feedback_count_cse($feedback7, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$feedback4 = 'High Amount';
			$total_count4 = $this -> total_feedback_count_cse($feedback4, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$feedback5 = 'Booking Cancel';
			$total_count5 = $this -> total_feedback_count_cse($feedback5, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$feedback6 = 'Waiting for Vehicle';
			$total_count6 = $this -> total_feedback_count_cse($feedback6, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$nextAction11 = 'Lost';
			$total_count11 = $this -> total_nextAction_count_cse($nextAction11, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$nextAction12 = 'Home Visit';
			$total_count12 = $this -> total_nextAction_count_cse($nextAction12, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$nextAction13 = 'Showroom Visit';
			$total_count13 = $this -> total_nextAction_count_cse($nextAction13, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$select_leads[] = array($nextAction11 => $total_count11[0] -> total_count, $nextAction12 => $total_count12[0] -> total_count, $nextAction13 => $total_count13[0] -> total_count, $feedback2 => $total_count2[0] -> total_count, $feedback3 => $total_count3[0] -> total_count, $feedback4 => $total_count4[0] -> total_count, $feedback5 => $total_count5[0] -> total_count, $feedback6 => $total_count6[0] -> total_count, $feedback7 => $total_count7[0] -> total_count);
		
	
			
		}
	else
		{
				$feedback2 = 'Interested';
			$total_count2 = $this -> total_feedback_count_cse($feedback2, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$feedback3 = 'Busy';
			$total_count3 = $this -> total_feedback_count_cse($feedback3, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$feedback4 = 'Lost to Co-Dealer';
			$total_count4 = $this -> total_feedback_count_cse($feedback4, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			
			$nextAction11 = 'Follow-up';
			$total_count11 = $this -> total_nextAction_count_cse($nextAction11, $fromdate, $todate,$role,$process_name,$user_id,$process_id);
			$select_leads[] = array('follow_up' => $total_count11[0] -> total_count,  'interested' => $total_count2[0] -> total_count,
			 'busy' => $total_count3[0] -> total_count, 'lost_to_co_dealer' => $total_count4[0] -> total_count);
	
				}
		return $select_leads;
	}
	public function total_feedback_count_cse($feedback_stauts, $fromdate, $todate,$role,$process_name,$user_id,$process_id) {
		$table=$this->select_table($process_id);	
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as total_count,ln.feedbackStatus');
			$this -> db -> from($table['lead_master_table'].' ln');
		//$this -> db -> from($this->table_name.' ln');
		$this -> db -> where('ln.process', $process_name);
		
		$this -> db -> where('ln.created_date>=', $fromdate);
		$this -> db -> where('ln.created_date<=', $todate);
		if($role == '5')
		{
			$this -> db -> join($table['lead_followup_table'].' lm', 'ln.dse_followup_id=lm.id');
			//$this -> db -> join($this->table_name1.' lm', 'ln.dse_followup_id=lm.id');
			$this -> db -> where('ln.assign_to_dse_tl',$user_id);
			
		}
		elseif($role == '4')
		{
			$this -> db -> join($table['lead_followup_table'].' lm', 'ln.dse_followup_id=lm.id');	
			$this -> db -> where('ln.assign_to_dse', $user_id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> join($table['lead_followup_table'].' lm', 'ln.cse_followup_id=lm.id');
			//$this -> db -> join($this->table_name1.' lm', 'ln.cse_followup_id=lm.id');
			$this -> db -> where('ln.assign_to_cse', $user_id);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> join($table['lead_followup_table'].' lm', 'ln.cse_followup_id=lm.id');
			//$this -> db -> join($this->table_name1.' lm', 'ln.cse_followup_id=lm.id');
			$this -> db -> where('assign_by_cse_tl',  $user_id);
		
			
		}
		$this -> db -> where('ln.feedbackStatus', $feedback_stauts);
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		$query1 = $query -> result();
	
		return $query1;

	}
	/*public function total_feedback_count_cse($location_id, $feedback_stauts, $fromdate, $todate) {
		
		$this -> db -> select('count(enq_id) as total_count,l.feedbackStatus');
		$this -> db -> from('lead_master l');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_cse');
		$this -> db -> join('lead_followup lm', 'l.cse_followup_id=lm.id');
		$this -> db -> where('u.location', $location_id);
		$this -> db -> where('l.assign_to_dse_tl', 0);
		$this -> db -> where('lm.feedbackStatus', $feedback_stauts);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this -> db -> last_query();
		return $query -> result();

	}*/
public function total_nextAction_count_cse($nextAction, $fromdate, $todate,$role,$process_name,$user_id,$process_id) {
		$table=$this->select_table($process_id);	
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(enq_id) as total_count,ln.nextAction');
		$this -> db -> from($table['lead_master_table'].' ln');
		$this -> db -> where('ln.process', $process_name);
		
		$this -> db -> where('ln.created_date>=', $fromdate);
		$this -> db -> where('ln.created_date<=', $todate);
		if($role == '5')
		{
			//$this -> db -> join($this->table_name1.' lm', 'ln.dse_followup_id=lm.id');
			$this -> db -> join($table['lead_followup_table'].' lm', 'ln.dse_followup_id=lm.id');
			$this -> db -> where('ln.assign_to_dse_tl',$user_id);
			
		}
		elseif($role == '4')
		{
			$this -> db -> join($table['lead_followup_table'].' lm', 'ln.dse_followup_id=lm.id');
			//$this -> db -> join($this->table_name1.' lm', 'ln.dse_followup_id=lm.id');
			$this -> db -> where('ln.assign_to_dse', $user_id);
		}
		elseif (in_array($role,$this->executive_array)) {
			$this -> db -> join($table['lead_followup_table'].' lm', 'ln.cse_followup_id=lm.id');
			//$this -> db -> join($this->table_name1.' lm', 'ln.cse_followup_id=lm.id');
			$this -> db -> where('ln.assign_to_cse', $user_id);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> join($table['lead_followup_table'].' lm', 'ln.cse_followup_id=lm.id');
			//$this -> db -> join($this->table_name1.' lm', 'ln.cse_followup_id=lm.id');
			$this -> db -> where('assign_by_cse_tl',  $user_id);
		
			
		}
		$this -> db -> where('ln.nextAction', $nextAction);
		$query = $this -> db -> get();
	//	echo $this->db->last_query();
		$query1 = $query -> result();
	
		return $query1;
	}
	/*public function total_nextAction_count_cse($location_id, $nextAction, $fromdate, $todate) {
		
		$this -> db -> select('count(enq_id) as total_count,l.nextAction');
		$this -> db -> from('lead_master l');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_cse');
		$this -> db -> join('lead_followup lm', 'l.cse_followup_id=lm.id');
		$this -> db -> where('u.location', $location_id);
		$this -> db -> where('l.assign_to_dse_tl', 0);
		$this -> db -> where('lm.nextAction', $nextAction);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this -> db -> last_query();
		return $query -> result();

	}*/

	public function total_feedback_count_dse($dse_tl_id, $feedback_stauts, $fromdate, $todate) {
		
		$this -> db -> select('count(enq_id) as total_count,l.feedbackStatus');
		$this -> db -> from('lead_master l');
		$this -> db -> join('lead_followup lm', 'l.dse_followup_id=lm.id');
		$this -> db -> where_in('l.assign_to_dse_tl', $dse_tl_id);
		$this -> db -> where('lm.feedbackStatus', $feedback_stauts);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		//echo $this -> db -> last_query();
		return $query -> result();

	}

	public function total_nextAction_count_dse($dse_tl_id, $nextAction, $fromdate, $todate) {
		
		$this -> db -> select('count(enq_id) as total_count,l.nextAction');
		$this -> db -> from('lead_master l');
		$this -> db -> join('lead_followup lm', 'l.dse_followup_id=lm.id');
		$this -> db -> where_in('l.assign_to_dse_tl', $dse_tl_id);
		$this -> db -> where('lm.nextAction', $nextAction);
		$this -> db -> where('l.created_date>=', $fromdate);
		$this -> db -> where('l.created_date<=', $todate);
		$query = $this -> db -> get();
		return $query -> result();

	}
	public function get_dse_name($role,$user_id,$location,$fromdate,$todate,$process_id) {		
		$this -> db -> select('fname,lname,id');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> where('u.location_id', $location);
		$this->db->where('u.process_id',$process_id);
		$this -> db -> where('l.status!=', '-1');
		//$this -> db -> where('role!=', '5');
		if($role=='4'){
			
		//$user_id=$_SESSION['user_id'];
				
			$this -> db -> where('id', $user_id );
		}
		if($role=='5' || $role=='1' || $role=='2'){
			
		//$user_id=$_SESSION['user_id'];
				
			$this -> db -> where('role', '4' );
		}
		

	 $this -> db -> last_query();
		$query = $this -> db -> get() -> result();
		
		if (count($query) > 0) {
			foreach ($query as $fetch) {

				$dse_id = $fetch -> id;
				$total_pending_new_leads = $this -> total_pending_new_count_dse($dse_id, $fromdate, $todate);
				$total_pending_followup_leads = $this -> total_pending_followup_count_dse($dse_id, $fromdate, $todate);

				$con = 'lf.nextAction="Home Visit"';
				$home_visit_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				$con = 'lf.nextAction="Showroom Visit"';
				$showroom_visit_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				$con = 'lf.nextAction="Evaluation Allotted"';
				$evaluation_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				$con = 'lf.nextAction="Test Drive"';
				$test_drive_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				$con = 'lf.nextAction="Follow-up"';
				$follow_up_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				$con = 'lf.feedbackStatus="Undecided"';
				$undecided_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				$con = 'lf.nextAction="Deal"';
				$deal_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				$con = 'lf.feedbackStatus="Not interested"';
				$not_interested_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				$con = 'lf.feedbackStatus="Already Booked From Us"';
				$already_booked_with_autovista_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				$con = 'lf.feedbackStatus="Lost to Co-dealer"';
				$lost_to_co_dealer_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				$con = 'lf.feedbackStatus="Lost To Competitor Brand"';
				$lost_to_competition_brand_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				$con = 'lf.feedbackStatus="Color and Model Availability"'; 
				$color_model_availability_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				$con = 'lf.feedbackStatus="Budget Issue"';
				$low_budget_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				$con = 'lf.feedbackStatus="Plan cancelled"';
				$plan_cancelled_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				$con = 'lf.nextAction="Booked From Autovista"';
				$booked_count = $this -> check_count($con, $fetch -> id, $fromdate, $todate);

				//$evaluation_count = $this -> evaluation_count($fetch -> id);
				$id = $fetch -> id;
				//echo $id;
				//print_r($home_visit_count);
				$pending_new = $total_pending_new_leads[0] -> check_count;
				$pending_followup = $total_pending_followup_leads[0] -> check_count;
				$home_visit_count = $home_visit_count[0] -> check_count;
				$showroom_visit_count = $showroom_visit_count[0] -> check_count;
				$evaluation_count = $evaluation_count[0] -> check_count;
				$test_drive_count = $test_drive_count[0] -> check_count;
				$follow_up_count = $follow_up_count[0] -> check_count;
				$undecided_count = $undecided_count[0] -> check_count;
				$not_interested_count = $not_interested_count[0] -> check_count;
				$deal_count = $deal_count[0] -> check_count;
				$already_booked_with_autovista_count = $already_booked_with_autovista_count[0] -> check_count;
				$lost_to_co_dealer_count = $lost_to_co_dealer_count[0] -> check_count;
				$lost_to_competition_brand_count = $lost_to_competition_brand_count[0] -> check_count;
				$color_model_availability_count = $color_model_availability_count[0] -> check_count;
				$low_budget_count = $low_budget_count[0] -> check_count;
				$plan_cancelled_count = $plan_cancelled_count[0] -> check_count; 
				$booked_count = $booked_count[0] -> check_count;
				$lead[] = array('fname' => $fetch -> fname, 'dse_id' => $fetch -> id,'lname' => $fetch -> lname, 'pending_new' => $pending_new, 'pending_followup' => $pending_followup, 'home_visit_count' => $home_visit_count, 'showroom_visit_count' => $showroom_visit_count, 'evaluation_count' => $evaluation_count, 'test_drive_count' => $test_drive_count, 'follow_up_count' => $follow_up_count, 'undecided_count' => $undecided_count, 'not_interested_count' => $not_interested_count, 'deal_count' => $deal_count, 'already_booked_with_autovista_count' => $already_booked_with_autovista_count, 'lost_to_co_dealer_count' => $lost_to_co_dealer_count, 'lost_to_competition_brand_count' => $lost_to_competition_brand_count, 'color_model_availability_count' => $color_model_availability_count, 'low_budget_count' => $low_budget_count, 'plan_cancelled_count' => $plan_cancelled_count, 'booked_count' => $booked_count);
			}
		}
else {
	$lead = array();
} 
return $lead;		

		

	}

	public function total_pending_new_count_dse($dse_id, $fromdate, $todate) {
		$today = date('Y-m-d');
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		$this -> db -> select('count(ln.enq_id) as check_count');
		$this -> db -> from('lead_master ln');
		$this -> db -> where('ln.dse_followup_id', '0');
		$this -> db -> where('ln.assign_to_dse_date <', $yesterday);
		$this -> db -> where('ln.assign_to_dse', $dse_id);
		//$this -> db -> where('ln.assign_to_dse_tl_date <', $yesterday);
		$this -> db -> where('ln.created_date>=', $fromdate);
		$this -> db -> where('ln.created_date<=', $todate);

		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function total_pending_followup_count_dse($dse_id, $fromdate, $todate) {
		$today = date('Y-m-d');
		$this -> db -> select('count(l.enq_id) as check_count');
		$this -> db -> from("lead_master l");
		$this -> db -> join('lead_followup lf', 'l.dse_followup_id=lf.id');
		$this -> db -> where('lf.nextfollowupdate<', $today);
		$this -> db -> where('lf.nextfollowupdate!=', '0000-00-00');
		$this -> db -> where('l.assign_to_dse', $dse_id);
		
		$this -> db -> where('l.created_date>=', $fromdate);
		
		$this -> db -> where('l.created_date<=', $todate);

		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function check_count($con, $dse_id, $fromdate, $todate) {

		$this -> db -> select('count(l.enq_id) as check_count');
		$this -> db -> from("lead_master l");
		$this -> db -> join('lead_followup lf', 'l.dse_followup_id=lf.id');
		$this -> db -> where($con);
		$this -> db -> where('assign_to_dse', $dse_id);

		$this -> db -> where('l.created_date>=', $fromdate);
		
		$this -> db -> where('l.created_date<=', $todate);

		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	
	
}?>