<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class lead_report_tracker_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> process_id = $_SESSION['process_id'];
			$this -> process_name = $_SESSION['process_name'];
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master l ';
			$this -> table_name1 = 'lead_followup ';
				$this->selectElement='`tloc`.`location` as `showroom_location`, `l`.`assign_to_dse_tl`, `l`.`assign_to_dse`,
				`udse`.`fname` as `dse_fname`, `udse`.`lname` as `dse_lname`, `udse`.`role` as `dse_role`,  `udsetl`.`fname` as `dsetl_fname`, `udsetl`.`lname` as `dsetl_lname`, `udsetl`.`role` as `dsetl_role`,
				`dsef`.`date` as `dse_date`, `dsef`.`nextfollowupdate` as `dse_nfd`,`dsef`.`nextfollowuptime` as `dse_nftime`, `dsef`.`comment` as `dse_comment`, `dsef`.`td_hv_date`, `dsef`.`nextAction` as `dsenextAction`, `dsef`.`feedbackStatus` as `dsefeedback`
				, `m1`.`model_name` as `old_model_name`, `m2`.`make_name`';
			
		} else {
			$this -> table_name = 'lead_master_all l ';
			$this -> table_name1 = 'lead_followup_all ';
			$this->selectElement='csef.file_login_date,csef.login_status_name,csef.approved_date,csef.disburse_date,csef.disburse_amount,csef.process_fee,csef.emi,csef.eagerness,l.bank_name,l.loan_type,l.los_no,l.roi,l.tenure,l.loanamount,l.dealer,l.executive_name';

		}
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
	}

	public function select_location() {
		$this -> db -> select("*");
		$this -> db -> from("tbl_location");
		$query = $this -> db -> get();

		return $query -> result();
	}

	public function total_all_leads($fromdate,$todate) {
		ini_set('memory_limit', '-1');
		

			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate . "' and l.created_date<='" . $todate . "'";
			}

		//User

		if ($this->role == 5 ) {

			
			$username = "assign_to_dse_tl ='" . $this->user_id . "'";

		}
		elseif ($this->role == 4 ) {

			
			$username = "assign_to_dse ='" . $this->user_id . "'";

		}
		elseif (in_array($this->role,$this->executive_array)) {
			$username = "assign_to_cse ='" . $this->user_id . "'";
		}
		elseif (in_array($this->role,$this->tl_array)) {

			$username = "assign_by_cse_tl ='" . $this->user_id . "'";

		}

		

		$query = "SELECT 
		GROUP_CONCAT( DISTINCT  a.accessories_name ) as accessoires_list,
		sum(price) as assessories_price,
		m.model_name,
		l.alternate_contact_no,l.service_center,l.service_type,l.pickup_required,l.pick_up_date, `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.address,l.email,l.created_date as lead_date,l.feedbackStatus,l.nextAction,
		 l.ownership,l.budget_from,l.budget_to,l.accidental_claim,`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.reg_no, min(l.created_date) as min_date, max(l.created_date) as max_date ,l.km,`l`.`buyer_type`,  `l`.`manf_year`,
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,`ucsetl`.`fname` as `csetl_fname`, `ucsetl`.`lname` as `csetl_lname`, `ucsetl`.`role` as `csetl_role`,
		". $this->selectElement .",
		`v`.`variant_name`,`m`.`model_name` as `new_model_name`,
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, `csef`.`td_hv_date`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,
		ua.fname as auditfname,ua.lname as auditlname,
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date
		FROM " .$this->table_name. " 
		LEFT JOIN " .$this->table_name1. " `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN ".$this->table_name1. "  `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ucsetl` ON `ucsetl`.`id`=`l`.`assign_by_cse_tl`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` 
		LEFT JOIN `model_variant` `v` ON `v`.`variant_id`=`l`.`variant_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` 
		LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `udsetl`.`location`
		LEFT JOIN `make_models` `m1` ON `m1`.`model_id`=`l`.`old_model` 
		LEFT JOIN `makes` `m2` ON `m2`.`make_id`=`l`.`old_make`
		LEFT JOIN `accessories_order_list` `a` ON `a`.`enq_id`=`l`.`enq_id`";
		if (isset($alldate)) {

			$query = $query . ' where ' . $alldate;
		}
		
		
		if (isset($username)) {
			$query = $query . ' And ' . $username;
		}
		$query = $query . 'And l.process="' . $this->process_name . '"';

		$query = $query . " group by l.enq_id";

	

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();

		return $query;

	}

	public function total_unassigned_leads($fromdate,$todate) {
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);
		if ($this->role == 4 || $this->role == 6  || $this->role == 8 || $this->role == 10) {	
			$username = "assign_to_cse ='" . $this->user_id . "'";

		}
		
			$query = "SELECT 
		GROUP_CONCAT( DISTINCT  a.accessories_name ) as accessoires_list,
		sum(price) as assessories_price,
		m.model_name,
		l.alternate_contact_no,l.service_center,l.service_type,l.pickup_required,l.pick_up_date, `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.address,l.email,l.created_date as lead_date,l.feedbackStatus,l.nextAction,
		 l.ownership,l.budget_from,l.budget_to,l.accidental_claim,`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.reg_no, min(l.created_date) as min_date, max(l.created_date) as max_date ,l.km,`l`.`buyer_type`,  `l`.`manf_year`,
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,`ucsetl`.`fname` as `csetl_fname`, `ucsetl`.`lname` as `csetl_lname`, `ucsetl`.`role` as `csetl_role`,
		". $this->selectElement .",
		`v`.`variant_name`,`m`.`model_name` as `new_model_name`,
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, `csef`.`td_hv_date`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,
		ua.fname as auditfname,ua.lname as auditlname,
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date
		FROM " .$this->table_name. " 
		LEFT JOIN " .$this->table_name1. " `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN ".$this->table_name1. "  `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ucsetl` ON `ucsetl`.`id`=`l`.`assign_by_cse_tl`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` 
		LEFT JOIN `model_variant` `v` ON `v`.`variant_id`=`l`.`variant_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` 
		LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `udsetl`.`location`
		LEFT JOIN `make_models` `m1` ON `m1`.`model_id`=`l`.`old_model` 
		LEFT JOIN `makes` `m2` ON `m2`.`make_id`=`l`.`old_make`
		LEFT JOIN `accessories_order_list` `a` ON `a`.`enq_id`=`l`.`enq_id`";
		
		$query = $query . 'where l.process="' . $this->process_name . '"';
		$query = $query . 'And l.assign_by_cse_tl="0"';
		$query = $query . 'And l.assign_to_dse_tl="0"';
		$query = $query . 'And l.nextAction!="Close"';
		$query = $query . 'And l.created_date >="'.$fromdate .'"';
		$query = $query . 'And l.created_date <="'.$todate .'"';
		
		if (isset($username)) {
			$query = $query . ' And ' . $username;
		}
		$query = $query . " group by l.enq_id";
		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();
		return $query;

				}

	public function total_pending_new_leads($fromdate,$todate) {
		$today = date('Y-m-d');
		$yesterday = date("Y-m-d", strtotime('-1 days'));
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);
	
		$query = "SELECT 
		GROUP_CONCAT( DISTINCT  a.accessories_name ) as accessoires_list,
		sum(price) as assessories_price,
		m.model_name,
		l.alternate_contact_no,l.service_center,l.service_type,l.pickup_required,l.pick_up_date, `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.address,l.email,l.created_date as lead_date,l.feedbackStatus,l.nextAction,
		 l.ownership,l.budget_from,l.budget_to,l.accidental_claim,`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.reg_no, min(l.created_date) as min_date, max(l.created_date) as max_date ,l.km,`l`.`buyer_type`,  `l`.`manf_year`,
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,`ucsetl`.`fname` as `csetl_fname`, `ucsetl`.`lname` as `csetl_lname`, `ucsetl`.`role` as `csetl_role`,
		". $this->selectElement .",
		`v`.`variant_name`,`m`.`model_name` as `new_model_name`,
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, `csef`.`td_hv_date`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,
		ua.fname as auditfname,ua.lname as auditlname,
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date
		
		 FROM " .$this->table_name. " 
		LEFT JOIN " .$this->table_name1. " `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN ".$this->table_name1. "  `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ucsetl` ON `ucsetl`.`id`=`l`.`assign_by_cse_tl`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` 
		LEFT JOIN `model_variant` `v` ON `v`.`variant_id`=`l`.`variant_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` 
		
		LEFT JOIN `make_models` `m1` ON `m1`.`model_id`=`l`.`old_model` 
		LEFT JOIN `makes` `m2` ON `m2`.`make_id`=`l`.`old_make`
		 LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `udsetl`.`location`
		
		  
		  LEFT JOIN `accessories_order_list` `a` ON `a`.`enq_id`=`l`.`enq_id`
		
		
		";
		
		$query = $query . 'where l.process="' . $this->process_name . '"';
		if($this->role == '5')
		{
				$query = $query . ' And l.dse_followup_id="0"';
			$query = $query . ' And l.assign_to_dse_tl='.$this->user_id;
			$query = $query . ' And l.assign_to_dse_date <"'.$today.'"';
			
		}
		elseif($this->role == '4')
		{
			$query = $query . ' And l.dse_followup_id="0"';
			$query = $query . ' And l.assign_to_dse_tl!="0"';
			$query = $query . ' And l.assign_to_dse='.$this->user_id;
			$query = $query . ' And l.assign_to_dse_date < "'.$today.'"';
			
		}
		elseif (in_array($this->role,$this->executive_array)) {
			
			$query = $query . ' And l.cse_followup_id="0"';
			$query = $query . ' And l.assign_to_cse='.$this->user_id;
			$query = $query . ' And l.assign_to_cse_date < "'.$today.'"';
		
		}
		elseif(in_array($this->role,$this->tl_array)) {
			$query = $query . ' And l.assign_to_dse_tl=0';
			$query = $query . ' And l.assign_by_cse_tl='.$this->user_id;
			$query = $query . ' And l.assign_to_cse_date < "'.$today.'"';
			$query = $query . ' And l.cse_followup_id = 0';
		
		}
		else {
	$query = $query . ' And l.assign_to_dse_tl=0';
	$query = $query . ' And l.assign_by_cse_tl !=0';
	$query = $query . ' And l.assign_to_cse_date < "'.$today.'"';
		$query = $query . ' And l.cse_followup_id = 0';
	
}
		
		$query = $query . ' And l.created_date >="'.$fromdate .'"';
		$query = $query . ' And l.created_date <="'.$todate .'"';
		$query = $query . 'And l.nextAction!="Close"';
		$query = $query . " group by l.enq_id";
		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();
		return $query;
	}

	public function total_pending_followup_leads($fromdate,$todate) {
		$today = date('Y-m-d');

		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);
		
		$query = "SELECT 
		GROUP_CONCAT( DISTINCT  a.accessories_name ) as accessoires_list,
		sum(price) as assessories_price,
		m.model_name,
		l.alternate_contact_no,l.service_center,l.service_type,l.pickup_required,l.pick_up_date, `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.address,l.email,l.created_date as lead_date,l.feedbackStatus,l.nextAction,
		 l.ownership,l.budget_from,l.budget_to,l.accidental_claim,`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.reg_no, min(l.created_date) as min_date, max(l.created_date) as max_date ,l.km,`l`.`buyer_type`,  `l`.`manf_year`,
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,`ucsetl`.`fname` as `csetl_fname`, `ucsetl`.`lname` as `csetl_lname`, `ucsetl`.`role` as `csetl_role`,
		". $this->selectElement .",
		`v`.`variant_name`,`m`.`model_name` as `new_model_name`,
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, `csef`.`td_hv_date`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,
		ua.fname as auditfname,ua.lname as auditlname,
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date
		FROM " .$this->table_name. " 
		LEFT JOIN " .$this->table_name1. " `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN ".$this->table_name1. "  `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ucsetl` ON `ucsetl`.`id`=`l`.`assign_by_cse_tl`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` 
		LEFT JOIN `model_variant` `v` ON `v`.`variant_id`=`l`.`variant_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` 
		LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `udsetl`.`location`
		LEFT JOIN `make_models` `m1` ON `m1`.`model_id`=`l`.`old_model` 
		LEFT JOIN `makes` `m2` ON `m2`.`make_id`=`l`.`old_make`
		LEFT JOIN `accessories_order_list` `a` ON `a`.`enq_id`=`l`.`enq_id`";
		$query = $query . 'where l.process="' . $this->process_name . '"';
		
	if($this->role == '5')
		{
			$query = $query . ' And l.assign_to_dse_tl='.$this->user_id;
			$query = $query . ' And dsef.nextfollowupdate !="0000-00-00"';
			$query = $query . ' And dsef.nextfollowupdate <"'.$today.'"';
			
		}
		elseif($this->role == '4')
		{
			$query = $query . ' And l.assign_to_dse='.$this->user_id;
			$query = $query . ' And dsef.nextfollowupdate !="0000-00-00"';
			$query = $query . ' And dsef.nextfollowupdate <"'.$today.'"';
			
		}
		elseif (in_array($this->role,$this->executive_array)) {
			
			$query = $query . ' And l.assign_to_dse_tl=0';
			$query = $query . ' And l.assign_to_cse='.$this->user_id;
			$query = $query . ' And csef.nextfollowupdate !="0000-00-00"';
			$query = $query . ' And csef.nextfollowupdate <"'.$today.'"';
		
		}
		elseif(in_array($this->role,$this->tl_array)) {
			$query = $query . ' And l.assign_to_dse_tl=0';
			$query = $query . ' And l.assign_by_cse_tl='.$this->user_id;
			$query = $query . ' And csef.nextfollowupdate !="0000-00-00"';
			$query = $query . ' And csef.nextfollowupdate <"'.$today.'"';
		
		}
		$query = $query . 'And l.created_date >="'.$fromdate .'"';
		$query = $query . 'And l.created_date <="'.$todate .'"';
		$query = $query . 'And l.nextAction!="Close"';
		
		$query = $query . " group by l.enq_id";
		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();
		return $query;
	}



	public function total_location_issue_leads($location_id,$fromdate,$todate) {
		$feedback_stauts='Location Issue';
		$total=$this->total_feedback_count($location_id, $feedback_stauts,$fromdate,$todate);
		return $total;
	}

	public function total_not_interested_leads($location_id,$fromdate,$todate) {
			$feedback_stauts='Not Interested';
		$total=$this->total_feedback_count($location_id, $feedback_stauts,$fromdate,$todate);
		return $total;
	}

	public function total_already_booked_from_us_leads($location_id,$fromdate,$todate) {
		$feedback_stauts='Already Booked From Us';
		$total=$this->total_feedback_count($location_id, $feedback_stauts,$fromdate,$todate);
		return $total;
	}

	public function total_lost_to_co_dealer_leads($fromdate,$todate) {
		$feedback_stauts='Lost to Co-Dealer';
		$total=$this->total_feedback_count($feedback_stauts,$fromdate,$todate);
		return $total;
	}

	public function total_colour_and_model_availablity_leads($location_id,$fromdate,$todate) {
		$feedback_stauts='Colour And Model Availablity';
		$total=$this->total_feedback_count($location_id, $feedback_stauts,$fromdate,$todate);
		return $total;
	}

	public function total_budget_issue_leads($location_id,$fromdate,$todate) {
		$feedback_stauts='Budget Issue';
		$total=$this->total_feedback_count($location_id, $feedback_stauts,$fromdate,$todate);
		return $total;
	}

	public function total_nearest_dealership_available_leads($location_id,$fromdate,$todate) {
		$feedback_stauts='Nearest Dealership Available';
		$total=$this->total_feedback_count($location_id, $feedback_stauts,$fromdate,$todate);
		return $total;
	}

	public function total_outstation_purchase_leads($location_id,$fromdate,$todate) {
		$feedback_stauts='Outstation Purchase';
		$total=$this->total_feedback_count($location_id, $feedback_stauts,$fromdate,$todate);
		return $total;
	}

	public function total_plan_cancelled_leads($location_id,$fromdate,$todate) {
		$feedback_stauts='Plan Cancelled';
		$total=$this->total_feedback_count($location_id, $feedback_stauts,$fromdate,$todate);
		return $total;
	}
	public function total_appointment_taken_leads($fromdate,$todate) {
		$feedback_status='Appointment taken';
		$total=$this->total_feedback_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_login_leads($fromdate,$todate) {
		$feedback_status='Login';
		$total=$this->total_feedback_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_will_decide_later_leads($fromdate,$todate) {
		$feedback_status='Will Decide Later';
		$total=$this->total_feedback_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_purchase_from_outside_leads($fromdate,$todate) {
		$feedback_status='Purchase from Outside';
		$total=$this->total_feedback_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_high_amount_leads($fromdate,$todate) {
		$feedback_status='High Amount';
		$total=$this->total_feedback_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_booking_cancel_leads($fromdate,$todate) {
		$feedback_status='Booking Cancel';
		$total=$this->total_feedback_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_waiting_for_vehicle_leads($fromdate,$todate) {
		$feedback_status='Waiting for Vehicle';
		$total=$this->total_feedback_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_dont_want_maruti_leads($fromdate,$todate) {
		$feedback_status='Dont want Maruti';
		$total=$this->total_feedback_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_interested_leads($fromdate,$todate) {
		$feedback_status='Interested';
		$total=$this->total_feedback_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_busy_leads($fromdate,$todate) {
		$feedback_status='Busy';
		$total=$this->total_feedback_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_login_and_reject_leads($fromdate,$todate) {
		$feedback_status=' Login and Reject';
		$total=$this->total_feedback_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_login_and_cancel_leads($fromdate,$todate) {
		$feedback_status=' Login and Cancel';
		$total=$this->total_feedback_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_undecided_leads($location_id,$fromdate,$todate) {
		$feedback_stauts='Undecided';
		$total=$this->total_feedback_count($location_id, $feedback_stauts,$fromdate,$todate);
		return $total;
	}
	public function total_follow_up_leads($fromdate,$todate) {
		$feedback_status='Follow-up';
		$total=$this->total_nextAction_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_booked_from_autovista_leads($location_id,$fromdate,$todate) {
		$feedback_stauts='Booked From Autovista';
		$total=$this->total_nextAction_count($location_id, $feedback_stauts,$fromdate,$todate);
		return $total;
	}
	public function total_home_visit_leads($fromdate,$todate) {
		$feedback_status='Home Visit';
		$total=$this->total_nextAction_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_showroom_visit_leads($fromdate,$todate) {
		$feedback_status='Showroom Visit';
		$total=$this->total_nextAction_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_test_drive_leads($location_id,$fromdate,$todate) {
		$feedback_stauts='Test Drive';
		$total=$this->total_nextAction_count($location_id, $feedback_stauts,$fromdate,$todate);
		return $total;
	}
	public function total_evaluation_allotted_leads($location_id,$fromdate,$todate) {
		$feedback_stauts='Evaluation Allotted';
		$total=$this->total_nextAction_count($location_id, $feedback_stauts,$fromdate,$todate);
		return $total;
	}
	public function total_disbursement_leads($fromdate,$todate) {
		$feedback_status='Disbursement';
		$total=$this->total_nextAction_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	public function total_lost_leads($fromdate,$todate) {
		$feedback_status='Lost';
		$total=$this->total_nextAction_count($feedback_status,$fromdate,$todate);
		return $total;
	}
	

	public function total_feedback_count($feedback_status,$fromdate,$todate) {
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);
		/*if ($role == 4 || $role == 6  || $role == 8 || $role == 10) {	
			$username = "assign_to_cse ='" . $user_id . "'";

		}*/
		$query = "SELECT 
		GROUP_CONCAT( DISTINCT  a.accessories_name ) as accessoires_list,
		sum(price) as assessories_price,
		m.model_name,
		l.alternate_contact_no,l.service_center,l.service_type,l.pickup_required,l.pick_up_date, `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.address,l.email,l.created_date as lead_date,l.feedbackStatus,l.nextAction,
		 l.ownership,l.budget_from,l.budget_to,l.accidental_claim,`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.reg_no, min(l.created_date) as min_date, max(l.created_date) as max_date ,l.km,`l`.`buyer_type`,  `l`.`manf_year`,
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,`ucsetl`.`fname` as `csetl_fname`, `ucsetl`.`lname` as `csetl_lname`, `ucsetl`.`role` as `csetl_role`,
		". $this->selectElement .",
		`v`.`variant_name`,`m`.`model_name` as `new_model_name`,
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, `csef`.`td_hv_date`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,
		ua.fname as auditfname,ua.lname as auditlname,
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date
		FROM " .$this->table_name. " 
		LEFT JOIN " .$this->table_name1. " `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN ".$this->table_name1. "  `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ucsetl` ON `ucsetl`.`id`=`l`.`assign_by_cse_tl`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` 
		LEFT JOIN `model_variant` `v` ON `v`.`variant_id`=`l`.`variant_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` 
		LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `udsetl`.`location`
		LEFT JOIN `make_models` `m1` ON `m1`.`model_id`=`l`.`old_model` 
		LEFT JOIN `makes` `m2` ON `m2`.`make_id`=`l`.`old_make`
		LEFT JOIN `accessories_order_list` `a` ON `a`.`enq_id`=`l`.`enq_id`";
		
		$query = $query . 'where l.process="' . $this->process_name . '"';
		
		if($this->role == '5')
		{
			$query = $query . ' And l.assign_to_dse_tl='.$this->user_id;
			$query = $query . ' And l.feedbackStatus ="'.$feedback_status .'"';
			
		}
		elseif($this->role == '4')
		{
			$query = $query . ' And l.assign_to_dse='.$this->user_id;
			$query = $query . ' And l.feedbackStatus ="'.$feedback_status .'"';
			
		}
		elseif (in_array($this->role,$this->executive_array)) {
			
			$query = $query . ' And l.assign_to_dse_tl=0';
			$query = $query . ' And l.assign_to_cse='.$this->user_id;
			$query = $query . ' And l.feedbackStatus ="'.$feedback_status .'"';
		
		}
		elseif(in_array($this->role,$this->tl_array)) {
			$query = $query . ' And l.assign_to_dse_tl=0';
			$query = $query . ' And l.assign_by_cse_tl='.$this->user_id;
			$query = $query . ' And l.feedbackStatus ="'.$feedback_status .'"';
		
		}
		/*$query = $query . 'And l.assign_to_dse_tl="0"';
		$query = $query . 'And f.feedbackStatus ="'.$feedback_status .'"';*/
		$query = $query . 'And l.created_date >="'.$fromdate .'"';
		$query = $query . 'And l.created_date <="'.$todate .'"';
		/*if (isset($username)) {
			$query = $query . ' And ' . $username;
		}*/
		$query = $query . " group by l.enq_id";
		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();
		return $query;
	}

	public function total_nextAction_count($nextAction,$fromdate,$todate) {
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);
		
		$query = "SELECT 
		GROUP_CONCAT( DISTINCT  a.accessories_name ) as accessoires_list,
		sum(price) as assessories_price,
		m.model_name,
		l.alternate_contact_no,l.service_center,l.service_type,l.pickup_required,l.pick_up_date, `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.address,l.email,l.created_date as lead_date,l.feedbackStatus,l.nextAction,
		 l.ownership,l.budget_from,l.budget_to,l.accidental_claim,`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.reg_no, min(l.created_date) as min_date, max(l.created_date) as max_date ,l.km,`l`.`buyer_type`,  `l`.`manf_year`,
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,`ucsetl`.`fname` as `csetl_fname`, `ucsetl`.`lname` as `csetl_lname`, `ucsetl`.`role` as `csetl_role`,
		". $this->selectElement .",
		`v`.`variant_name`,`m`.`model_name` as `new_model_name`,
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, `csef`.`td_hv_date`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,
		ua.fname as auditfname,ua.lname as auditlname,
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date
		FROM " .$this->table_name. " 
		LEFT JOIN " .$this->table_name1. " `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN ".$this->table_name1. "  `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ucsetl` ON `ucsetl`.`id`=`l`.`assign_by_cse_tl`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` 
		LEFT JOIN `model_variant` `v` ON `v`.`variant_id`=`l`.`variant_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` 
		LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `udsetl`.`location`
		LEFT JOIN `make_models` `m1` ON `m1`.`model_id`=`l`.`old_model` 
		LEFT JOIN `makes` `m2` ON `m2`.`make_id`=`l`.`old_make`
		LEFT JOIN `accessories_order_list` `a` ON `a`.`enq_id`=`l`.`enq_id`";
		
		$query = $query . 'where l.process="' . $this->process_name . '"';
		
		if($this->role == '5')
		{
			$query = $query . ' And l.assign_to_dse_tl='.$this->user_id;
			$query = $query . ' And l.nextAction ="'.$nextAction .'"';
			
		}
		elseif($this->role == '4')
		{
			$query = $query . ' And l.assign_to_dse='.$this->user_id;
			$query = $query . ' And l.nextAction ="'.$nextAction .'"';
			
		}
		elseif (in_array($this->role,$this->executive_array)) {
			
			$query = $query . ' And l.assign_to_dse_tl=0';
			$query = $query . ' And l.assign_to_cse='.$this->user_id;
			$query = $query . ' And l.nextAction ="'.$nextAction .'"';
		
		}
		elseif(in_array($this->role,$this->tl_array)) {
			$query = $query . ' And l.assign_to_dse_tl=0';
			$query = $query . ' And l.assign_by_cse_tl='.$this->user_id;
			$query = $query . ' And l.nextAction ="'.$nextAction .'"';
		
		}
		/*$query = $query . 'And l.assign_to_dse_tl="0"';
		$query = $query . 'And f.feedbackStatus ="'.$feedback_status .'"';*/
		$query = $query . 'And l.created_date >="'.$fromdate .'"';
		$query = $query . 'And l.created_date <="'.$todate .'"';
		
		$query = $query . " group by l.enq_id";
		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();
		return $query;
	}

}
?>