<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dsewise_dashboard_download_tracker_model extends CI_Model {
	public function __construct() {
		parent::__construct();
		$this->today=date('Y-m-d');
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
			$this->selectElement='`tloc`.`location` as `showroom_location`, csef.file_login_date,csef.login_status_name,csef.approved_date,csef.disburse_date,csef.disburse_amount,csef.process_fee,csef.emi,csef.eagerness,l.bank_name,l.loan_type,l.los_no,l.roi,l.tenure,l.loanamount,l.dealer,l.executive_name';

		}
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
	}

	 

	public function pending_new($dse_id, $fromdate, $todate) {
		
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
		$query = $query . ' And l.dse_followup_id="0"';
		$query = $query . ' And l.assign_to_dse='.$dse_id;
		$query = $query . ' And l.assign_to_dse_date < "'.$this->today.'"';
		$query = $query . ' And l.created_date >="'.$fromdate .'"';
		$query = $query . ' And l.created_date <="'.$todate .'"';
		$query = $query . 'And l.nextAction!="Close"';
		$query = $query . " group by l.enq_id";
		$query = $this -> db -> query($query);
		$query = $query -> result();
		return $query;

	}

	public function pending_followup($dse_id, $fromdate, $todate) {
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
		$query = $query . ' And dsef.nextfollowupdate !="0000-00-00"';
		$query = $query . ' And dsef.nextfollowupdate <"'.$this->today.'"';
		$query = $query . ' And l.assign_to_dse='.$dse_id;		
		$query = $query . ' And l.created_date >="'.$fromdate .'"';
		$query = $query . ' And l.created_date <="'.$todate .'"';
		$query = $query . 'And l.nextAction!="Close"';
		$query = $query . " group by l.enq_id";
		$query = $this -> db -> query($query);
		$query = $query -> result();
		return $query;

	}
	public function check_downloaded_traker($dse_id, $fromdate, $todate,$con) {

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
			
		$query = $query . $con;	
		//$this -> db -> where($con);
		$query = $query . ' And l.assign_to_dse='.$dse_id;		
		$query = $query . ' And l.created_date >="'.$fromdate .'"';
		$query = $query . ' And l.created_date <="'.$todate .'"';
		$query = $query . " group by l.enq_id";
		$query = $this -> db -> query($query);
		
		$query = $query -> result();
		return $query;
	}
	public function follow_up_count($dse_id, $fromdate, $todate) {

				$con = ' And dsef.nextAction="Follow-up"';
				$follow_up_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
				return $follow_up_count;
	}
	
	public function home_visit_count($dse_id, $fromdate, $todate) {
		
		$con = ' And dsef.nextAction="Home Visit"';
		$home_visit_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
		return $home_visit_count;
		
	}

	public function showroom_visit_count($dse_id, $fromdate, $todate) {
		$con = ' And dsef.nextAction="Showroom Visit"';
		$showroom_visit_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
		return $showroom_visit_count;
	}

	
	public function evaluation_count($dse_id, $fromdate, $todate) {
		$con = ' And dsef.nextAction="Evaluation Allotted"';
		$evaluation_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
		return $evaluation_count;
		
	}
	
	public function test_drive_count($dse_id, $fromdate, $todate) {
		$con = ' And dsef.nextAction="Test Drive"';
		$test_drive_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
		return $test_drive_count;
		
	}
	
	

	public function undecided_count($dse_id, $fromdate, $todate) {

		$con = ' And dsef.feedbackStatus="Undecided"';
		$undecided_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
		return $undecided_count;
	}
	
	public function deal_count($dse_id, $fromdate, $todate) {
		
		$con = ' And dsef.nextAction="Deal"';
		$deal_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
		return $deal_count;
		
	}

	public function not_interested_count($dse_id, $fromdate, $todate) {

		$con = ' And dsef.feedbackStatus="Not interested"';
		$not_interested_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
		return $not_interested_count;
	}

	public function already_booked_with_autovista_count($dse_id, $fromdate, $todate) {
		
		$con = ' And dsef.feedbackStatus="Already Booked From Us"';
		$already_booked_with_autovista_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
		
	}
	
	public function lost_to_co_dealer_count($dse_id, $fromdate, $todate) {

		$con = ' And dsef.feedbackStatus="Lost to Co-dealer"';
		$lost_to_co_dealer_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
		return $lost_to_co_dealer_count;
	}


	public function lost_to_competition_brand_count($dse_id, $fromdate, $todate) {

			$con = ' And dsef.feedbackStatus="Lost To Competitor Brand"';
			$lost_to_competition_brand_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
			return $lost_to_competition_brand_count;
	}
	
	public function color_model_availability_count($dse_id, $fromdate, $todate) {
		$con = ' And dsef.feedbackStatus="Color and Model Availability"';
		$color_model_availability_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
		return $color_model_availability_count;
	}

	public function low_budget_count($dse_id, $fromdate, $todate) {

	//	$con = 'dsef.feedbackStatus="Low Budget"';
		$con = ' And dsef.feedbackStatus="Budget Issue"';
		$low_budget_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
		return $low_budget_count;
	}

	public function plan_cancelled_count($dse_id, $fromdate, $todate) {

		$con = ' And dsef.feedbackStatus="Plan cancelled"';
		$plan_cancelled_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
		return $plan_cancelled_count;
	}

	public function booked_count($dse_id, $fromdate, $todate) {
		
		$con = ' And dsef.nextAction="Booked From Autovista"';
		$booked_count = $this -> check_downloaded_traker($dse_id, $fromdate, $todate,$con);
		return $booked_count;
	}
}
