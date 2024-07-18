<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dsewise_dashboard_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> process_id = $_SESSION['process_id'];
			$this -> process_name = $_SESSION['process_name'];
			$this -> user_id = $this -> session -> userdata('user_id');
	}

	public function select_location() {
		/*$role=$_SESSION['role'];
		$location=$_SESSION['location'];
		$this -> db -> select('location,location_id');
		$this -> db -> from('tbl_location');
		if($role== 5 || $role== 4)
		{
			$this -> db -> where('location_id',$location);
		}
			
		$this -> db -> where('location_id!=', 38);*/
		$this -> db -> select('l.*');
		$this -> db -> from('tbl_location l');
		$this->db->join('tbl_manager_process p','p.location_id=l.location_id');
		$this->db->where('process_id',$this->process_id);
		$this->db->where('user_id',$this->user_id);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function get_dse_name($location,$fromdate,$todate) {
		//$location = $this -> input -> post('location');
		//$fromdate = $this -> input -> post('fromdate');
		//$todate = $this -> input -> post('todate');
		$fromdate;
		$todate;
		//$roles=array(4);
		$this -> db -> select('fname,lname,id');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> where('u.location_id', $location);
		$this -> db -> where('l.status!=', '-1');
		$this->db->where('u.process_id',$this->process_id);
		//$this -> db -> where('role!=', '5');
		if($_SESSION['role']=='4'){
			
		$user_id=$_SESSION['user_id'];
				
			$this -> db -> where('id', $user_id );
		}
		if($_SESSION['role']=='5' || $_SESSION['role']=='1' || $_SESSION['role']=='2'){
			
		//$user_id=$_SESSION['user_id'];
				
			$this -> db -> where('role', '4' );
		}
		

		//echo $this -> db -> last_query();
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
return $lead;
		} 
		

		

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
		$this->db->where('process',$this->process_name);
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
		$this->db->where('process',$this->process_name);
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
		$this->db->where('process',$this->process_name);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

}
