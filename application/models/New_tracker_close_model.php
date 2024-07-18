<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class new_tracker_close_model extends CI_model {
	function __construct() {
		parent::__construct();
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> process_id = $_SESSION['process_id'];
			$this -> process_name = $_SESSION['process_name'];
		//Select Table
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master_c l';
			$this -> table_name1 = 'lead_followup_c';
			$this->selectElement='`tloc`.`location` as `showroom_location`, `l`.`assign_to_dse_tl`, `l`.`assign_to_dse`,l.assign_to_dse_date,l.assign_to_dse_time,l.assign_to_dse_tl_date,l.assign_to_dse_tl_time,
				`udse`.`fname` as `dse_fname`, `udse`.`lname` as `dse_lname`, `udse`.`role` as `dse_role`,  `udsetl`.`fname` as `dsetl_fname`, `udsetl`.`lname` as `dsetl_lname`, `udsetl`.`role` as `dsetl_role`,
				`dsef`.`date` as `dse_date`, `dsef`.`nextfollowupdate` as `dse_nfd`,`dsef`.`nextfollowuptime` as `dse_nftime`, `dsef`.`comment` as `dse_comment`, `dsef`.`td_hv_date`, `dsef`.`nextAction` as `dsenextAction`, `dsef`.`feedbackStatus` as `dsefeedback`,`dsef`.`contactibility` as `dsecontactibility`,`dsef`.`created_time` as `dse_time`
				, `m1`.`model_name` as `old_model_name`, `m2`.`make_name`,l.quotated_price,l.expected_price,l.edms_booking_id,
				csef.appointment_type as cappointment_type,csef.appointment_date as cappointment_date,csef.appointment_time as cappointment_time,csef.appointment_status as cappointment_status,
				dsef.appointment_type as dappointment_type,dsef.appointment_date as dappointment_date,dsef.appointment_time as dappointment_time,dsef.appointment_status as dappointment_status
				';
		}
		elseif ($this -> process_id == 8) {
			$this -> table_name = 'lead_master_evaluation l';
			$this -> table_name1 = 'lead_followup_evaluation';
			//$this->selectElement='l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id';
			$this->selectElement='`tloc`.`location` as `showroom_location`,l.assign_to_e_tl as assign_to_dse_tl, `l`.`assign_to_e_exe` as assign_to_dse,l.assign_to_e_exe_date as assign_to_dse_date,l.assign_to_e_exe_time as assign_to_dse_time,l.assign_to_e_tl_date as assign_to_dse_tl_date,l.assign_to_e_tl_time as assign_to_dse_tl_time,`l`.`exe_followup_id` as `dse_followup_id`,
				`udse`.`fname` as `dse_fname`, `udse`.`lname` as `dse_lname`, `udse`.`role` as `dse_role`,  `udsetl`.`fname` as `dsetl_fname`, `udsetl`.`lname` as `dsetl_lname`, `udsetl`.`role` as `dsetl_role`,
				`dsef`.`date` as `dse_date`, `dsef`.`nextfollowupdate` as `dse_nfd`,`dsef`.`nextfollowuptime` as `dse_nftime`, `dsef`.`comment` as `dse_comment`, `dsef`.`nextAction` as `dsenextAction`, `dsef`.`feedbackStatus` as `dsefeedback`,`dsef`.`contactibility` as `dsecontactibility`,`dsef`.`created_time` as `dse_time`
				, `m1`.`model_name` as `old_model_name`, `m2`.`make_name`,l.quotated_price,l.expected_price
				,l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_status
				
				';
	
	
		} else {
			$this -> table_name = 'lead_master_all l';
			$this -> table_name1 = 'lead_followup_all';
		$this->selectElement='`tloc`.`location` as `showroom_location`, csef.file_login_date,csef.pick_up_date,csef.login_status_name,csef.approved_date,csef.disburse_date,csef.disburse_amount,csef.process_fee,csef.emi,csef.eagerness,l.bank_name,l.loan_type,l.los_no,l.roi,l.tenure,l.loanamount,l.dealer,l.executive_name
		,l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_status';

		}
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		
	}
//Select feedback
	function select_feedback() {
		$this -> db -> select('*');
		$this -> db -> from('tbl_feedback_status');
		$this -> db -> where('fstatus!=', 'Deactive');
		$this -> db -> where('process_id', $this->process_id);
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();

	}

	//Select Next Action

	function select_next_action() {
		//$process_id = $_SESSION['process_id'];
		$feedback=$this->input->post('feedback');
		$this->db->select('feedbackStatusName,nextActionName');
		$this->db->from('tbl_mapNextAction');
		$this->db->where('feedbackStatusName',$feedback);
		$this->db->where('map_next_to_feed_status!=','Deactive');
		$this->db->where('process_id',$this->process_id);
		$query=$this->db->get();
		//echo $this->db->last_query();
		return $query->result();

	}
	function select_lead_source() {

		$this -> db -> select('*');
		$this -> db -> from('lead_source');
		$this -> db -> where('process_id', $this ->process_id);
		$this -> db -> where("leadsourceStatus !=", "Deactive");		
		$this -> db -> order_by('lead_source_name','ASC');
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	function select_campaign() {
		/*---check count as per group & user--*/
		if ($_SESSION['role'] != 1) {

			$user_id = $_SESSION['user_id'];

			$this -> db -> select('campaign_name');
			$this -> db -> from('tbl_campaign');
			$query1 = $this -> db -> get() -> result();

			$c = count($query1);
			if (count($query1) > 0) {
				$t = ' ( ';
				for ($i = 0; $i < $c; $i++) {
					if ($i == 0) {
						if ($query1[$i] -> campaign_name == 'New Car') {
							$t = $t . "enquiry_for != 'Used Car'";
						} else {
							$t = $t . "enquiry_for = '" . $query1[$i] -> campaign_name . "'";
						}
					} else {
						$t = $t . " or enquiry_for ='" . $query1[$i] -> campaign_name . "'";
					}
				}
				$st = $t . ')';

			}
			$st;
		}

		$this -> db -> select('enquiry_for');
		$this -> db -> from('lead_master u');
		$this -> db -> join('tbl_campaign c', 'c.campaign_name=u.enquiry_for');
		$this -> db -> where('lead_source', 'Facebook');
		if ($_SESSION['role'] != 1) {
			$this -> db -> where($st);
		}
		$this -> db -> group_by('u.enquiry_for');
		$query = $this -> db -> get();
		return $query -> result();

	}


	

	public function select_leads() {
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}

		//Filter Condition
		$today = date('Y-m-d');
		//Campaign
		$campaign_name = $this -> input -> get('campaign_name');
		if ($campaign_name != '' && $campaign_name != 'All') {
			if ($campaign_name == 'Website') {
				$lead_info = "lead_source=''";
			} else {
				$name = explode('%23', $campaign_name);
				if (isset($name[1])) {
					if ($name[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name[1] . "'";
					}
				}
				$name1 = explode('#', $campaign_name);
				if (isset($name1[1])) {
					if ($name1[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name1[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name1[1] . "'";
					}
				}

			}
		}
		//Feddback
		if ($this -> input -> get('feedback') != '') {
			$feedback = "l.feedbackStatus='" . $this -> input -> get('feedback') . "'";
		}
		// Next Action
		if ($this -> input -> get('nextaction') != '') {
			$nextaction = "l.nextaction='" . $this -> input -> get('nextaction') . "'";
		}

		// Date
		$date_type = $this -> input -> get('date_type');
		if ($this -> input -> get('fromdate') == '' && $this -> input -> get('todate') != '') {
			$fromdate = $today;
		} else {
			//echo "2";
			$fromdate = $this -> input -> get('fromdate');
		}
		if ($this -> input -> get('todate') == '' && $this -> input -> get('fromdate') != '') {
			//echo "3";
			$todate = $today;
		} else {
			//echo "4";
			$todate = $this -> input -> get('todate');
		}
		
		

		if ($date_type == 'Lead') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate . "' and l.created_date<='" . $todate . "'";
			}
		}
		if ($date_type == 'CSE') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "csef.date>= '" . $fromdate . "' and csef.date<= '" . $todate . "' and csef.date!='0000-00-00'";

			}
		}
		if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate ."' and dsef.date<= '".$todate."' and dsef.date!='0000-00-00'";
			
		}
		}
			if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_date>= '". $fromdate ."' and l.assign_to_dse_date<= '".$todate."' and l.assign_to_dse_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_tl_date>= '". $fromdate ."' and l.assign_to_dse_tl_date<= '".$todate."' and l.assign_to_dse_tl_date!='0000-00-00'";
			
		}
		}
		if($_SESSION['process_id']==8){
				if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate ."' and dsef.date<= '".$todate."' and dsef.date!='0000-00-00'";
			
		}
		}
			if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_e_exe_date>= '". $fromdate ."' and l.assign_to_e_exe_date<= '".$todate."' and l.assign_to_e_exe_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_e_tl_date >= '". $fromdate ."' and l.assign_to_e_tl_date <= '".$todate."' and l.assign_to_e_tl_date !='0000-00-00'";
			
		}
		}
		}
		//User

		if ($this->role == 5 ) {

			
			$username = "assign_to_dse_tl ='" . $this->user_id . "'";

		}
		elseif ($this->role == 4 ) {

			
			$username = "assign_to_dse ='" . $this->user_id . "'";

		}
		elseif ($this->role == 15 ) {

			
			$username = "assign_to_e_tl  ='" . $this->user_id . "'";

		}
		elseif ($this->role == 16 ) {

			
			$username = " 	assign_to_e_exe  ='" . $this->user_id . "'";

		}
		elseif (in_array($this->role,$this->executive_array)) {
			$username = "assign_to_cse ='" . $this->user_id . "'";
		}
		/*elseif (in_array($this->role,$this->tl_array)) {
			if($_SESSION['role_name']!='Manager' && $_SESSION['role_name']!='Auditor'){
			$username = "assign_by_cse_tl ='" . $this->user_id . "'";
			}
		}

		 */

		

		$query = "SELECT 
		
		m.model_name,
		 `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.alternate_contact_no,l.address,l.email,l.created_date as lead_date,l.created_time as lead_time,l.feedbackStatus,l.nextAction,
		 l.ownership,l.budget_from,l.budget_to,l.accidental_claim,`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.reg_no, min(l.created_date) as min_date, max(l.created_date) as max_date ,l.km,`l`.`buyer_type`,  `l`.`manf_year`,l.assign_to_cse_date,l.assign_to_cse_time,
		l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_status,
		l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,l.evaluation_within_days,l.fuel_type,l.color,
		
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,`ucsetl`.`fname` as `csetl_fname`, `ucsetl`.`lname` as `csetl_lname`, `ucsetl`.`role` as `csetl_role`,
		". $this->selectElement .",
		
		`v`.`variant_name`,`m`.`model_name` as `new_model_name`,
		
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,`csef`.`contactibility` as `csecontactibility`,`csef`.`created_time` as `cse_time`,
		
		ua.fname as auditfname,ua.lname as auditlname,
		bm2.make_name as buy_make_name,bm1.model_name as buy_model_name,
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date,mr.created_time as auditor_time,mr.call_status as auditor_call_status
		
		FROM " .$this->table_name. " 
		LEFT JOIN " .$this->table_name1. " `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ucsetl` ON `ucsetl`.`id`=`l`.`assign_by_cse_tl`
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` 
		LEFT JOIN `model_variant` `v` ON `v`.`variant_id`=`l`.`variant_id` 
		
		LEFT JOIN `make_models` `m1` ON `m1`.`model_id`=`l`.`old_model` 
		LEFT JOIN `makes` `m2` ON `m2`.`make_id`=`l`.`old_make`

		LEFT JOIN `make_models` `bm1` ON `bm1`.`model_id`=`l`.`buy_model` 
		LEFT JOIN `makes` `bm2` ON `bm2`.`make_id`=`l`.`buy_make`
		
		";
		
		if($_SESSION['process_id']==8){
		
		$query=$query." LEFT JOIN " .$this->table_name1. "  dsef ON dsef.id=l.exe_followup_id
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_e_exe` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_e_tl` ";
		
		}else{
		$query=$query." LEFT JOIN " .$this->table_name1. "  `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` ";
		}
		$query=$query."LEFT JOIN `tbl_manager_process` `mp` on `mp`.`user_id` =`udsetl`.`id`
		LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `mp`.`location_id`";

		if (isset($alldate)) {

			$query = $query . ' where ' . $alldate;
		}
		if (isset($feedback)) {
			$query = $query . ' And ' . $feedback;
		}
		if (isset($nextaction)) {
			$query = $query . ' And ' . $nextaction;
		}
		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		if (isset($username)) {
			$query = $query . ' And ' . $username;
		}
		if($_SESSION['role_name']=='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$this->user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
{
	
					$query=$query.'And mp.location_id in ('.$location_id.')';
					}
				}
		}
		if($_SESSION['process_id']==8){
			$query = $query . ' And l.evaluation="Yes"';
		}else{
		$query = $query . ' And l.process="' . $this->process_name . '"';
		}
		$query = $query . " group by l.enq_id limit ".$offset.' , '. $rec_limit;

	

		$query = $this -> db -> query($query);
		if($_SESSION['user_id']==1){
		//	echo $this->db->last_query();	
		}
	
		$query = $query -> result();

		return $query;

	}

	public function select_leads_count() {
	ini_set('memory_limit', '-1');
		

		//Filter Condition
		$today = date('Y-m-d');
		//Campaign
		$campaign_name = $this -> input -> get('campaign_name');
		if ($campaign_name != '' && $campaign_name != 'All') {
			if ($campaign_name == 'Website') {
				$lead_info = "lead_source=''";
			} else {
				$name = explode('%23', $campaign_name);
				if (isset($name[1])) {
					if ($name[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name[1] . "'";
					}
				}
				$name1 = explode('#', $campaign_name);
				if (isset($name1[1])) {
					if ($name1[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name1[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name1[1] . "'";
					}
				}

			}
		}
		//Feddback
		if ($this -> input -> get('feedback') != '') {
			$feedback = "l.feedbackStatus='" . $this -> input -> get('feedback') . "'";
		}
		// Next Action
		if ($this -> input -> get('nextaction') != '') {
			$nextaction = "l.nextaction='" . $this -> input -> get('nextaction') . "'";
		}

		// Date
		$date_type = $this -> input -> get('date_type');
		if ($this -> input -> get('fromdate') == '' && $this -> input -> get('todate') != '') {
			$fromdate = $today;
		} else {
			//echo "2";
			$fromdate = $this -> input -> get('fromdate');
		}
		if ($this -> input -> get('todate') == '' && $this -> input -> get('fromdate') != '') {
			//echo "3";
			$todate = $today;
		} else {
			//echo "4";
			$todate = $this -> input -> get('todate');
		}
		
		

		if ($date_type == 'Lead') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate . "' and l.created_date<='" . $todate . "'";
			}
		}
		if ($date_type == 'CSE') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "csef.date>= '" . $fromdate . "' and csef.date<= '" . $todate . "' and csef.date!='0000-00-00'";

			}
		}
		if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate ."' and dsef.date<= '".$todate."' and dsef.date!='0000-00-00'";
			
		}
		}
			if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_date>= '". $fromdate ."' and l.assign_to_dse_date<= '".$todate."' and l.assign_to_dse_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_tl_date>= '". $fromdate ."' and l.assign_to_dse_tl_date<= '".$todate."' and l.assign_to_dse_tl_date!='0000-00-00'";
			
		}
		}
		if($_SESSION['process_id']==8){
				if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate ."' and dsef.date<= '".$todate."' and dsef.date!='0000-00-00'";
			
		}
		}
			if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_e_exe_date>= '". $fromdate ."' and l.assign_to_e_exe_date<= '".$todate."' and l.assign_to_e_exe_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_e_tl_date >= '". $fromdate ."' and l.assign_to_e_tl_date <= '".$todate."' and l.assign_to_e_tl_date !='0000-00-00'";
			
		}
		}
		}
		//User

		if ($this->role == 5 ) {

			
			$username = "assign_to_dse_tl ='" . $this->user_id . "'";

		}
		elseif ($this->role == 4 ) {

			
			$username = "assign_to_dse ='" . $this->user_id . "'";

		}
		elseif ($this->role == 15 ) {

			
			$username = "assign_to_e_tl  ='" . $this->user_id . "'";

		}
		elseif ($this->role == 16 ) {

			
			$username = " 	assign_to_e_exe  ='" . $this->user_id . "'";

		}
		elseif (in_array($this->role,$this->executive_array)) {
			$username = "assign_to_cse ='" . $this->user_id . "'";
		}
		/*elseif (in_array($this->role,$this->tl_array)) {
				if($_SESSION['role_name']!='Manager' && $_SESSION['role_name']!='Auditor'){
			$username = "assign_by_cse_tl ='" . $this->user_id . "'";
				}

		}*/

		

		$query = "Select count(distinct enq_id) as lead_count FROM " .$this->table_name. " 
		LEFT JOIN " .$this->table_name1. " `csef` ON `csef`.`id`=`l`.`cse_followup_id` ";
		
		if($_SESSION['process_id']==8){
		
		$query=$query." LEFT JOIN " .$this->table_name1. "  dsef ON dsef.id=l.exe_followup_id
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_e_exe` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_e_tl` ";
		
		}else{
		$query=$query." LEFT JOIN " .$this->table_name1. "  `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` ";
		}
		$query=$query."LEFT JOIN `tbl_manager_process` `mp` on `mp`.`user_id` =`udsetl`.`id`
		LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `mp`.`location_id`";

		if (isset($alldate)) {

			$query = $query . ' where ' . $alldate;
		}
		if (isset($feedback)) {
			$query = $query . ' And ' . $feedback;
		}
		if (isset($nextaction)) {
			$query = $query . ' And ' . $nextaction;
		}
		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		if (isset($username)) {
			$query = $query . ' And ' . $username;
		}
		if($_SESSION['role_name']=='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$this->user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
{
	
					$query=$query.'And mp.location_id in ('.$location_id.')';
					}
				}
		}
		if($_SESSION['process_id']==8){
			$query = $query . ' And l.evaluation="Yes"';
		}else{
		$query = $query . ' And l.process="' . $this->process_name . '"';
		}
		//$query = $query . " group by l.enq_id";

	

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();

		return $query;

	}

	public function select_lead_download() {
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 500); //120 seconds
		
		//Filter Condition
		$today = date('Y-m-d');
		//Campaign
		$campaign_name = $this -> input -> get('campaign_name');
		if ($campaign_name != '' && $campaign_name != 'All') {
			if ($campaign_name == 'Website') {
				$lead_info = "lead_source=''";
			} else {
				$name = explode('%23', $campaign_name);
				if (isset($name[1])) {
					if ($name[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name[1] . "'";
					}
				}
				$name1 = explode('#', $campaign_name);
				if (isset($name1[1])) {
					if ($name1[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name1[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name1[1] . "'";
					}
				}

			}
		}
		//Feddback
		if ($this -> input -> get('feedback') != '') {
			$feedback = "l.feedbackStatus='" . $this -> input -> get('feedback') . "'";
		}
		// Next Action
		if ($this -> input -> get('nextaction') != '') {
			$nextaction = "l.nextaction='" . $this -> input -> get('nextaction') . "'";
		}

		// Date
		$date_type = $this -> input -> get('date_type');
		if ($this -> input -> get('fromdate') == '' && $this -> input -> get('todate') != '') {
			$fromdate = $today;
		} else {
			//echo "2";
			$fromdate = $this -> input -> get('fromdate');
		}
		if ($this -> input -> get('todate') == '' && $this -> input -> get('fromdate') != '') {
			//echo "3";
			$todate = $today;
		} else {
			//echo "4";
			$todate = $this -> input -> get('todate');
		}
		
		

		if ($date_type == 'Lead') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate . "' and l.created_date<='" . $todate . "'";
			}
		}
		if ($date_type == 'CSE') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "csef.date>= '" . $fromdate . "' and csef.date<= '" . $todate . "' and csef.date!='0000-00-00'";

			}
		}
		if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate ."' and dsef.date<= '".$todate."' and dsef.date!='0000-00-00'";
			
		}
		}
			if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_date>= '". $fromdate ."' and l.assign_to_dse_date<= '".$todate."' and l.assign_to_dse_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_tl_date>= '". $fromdate ."' and l.assign_to_dse_tl_date<= '".$todate."' and l.assign_to_dse_tl_date!='0000-00-00'";
			
		}
		}
		if($_SESSION['process_id']==8){
				if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate ."' and dsef.date<= '".$todate."' and dsef.date!='0000-00-00'";
			
		}
		}
			if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_e_exe_date>= '". $fromdate ."' and l.assign_to_e_exe_date<= '".$todate."' and l.assign_to_e_exe_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_e_tl_date >= '". $fromdate ."' and l.assign_to_e_tl_date <= '".$todate."' and l.assign_to_e_tl_date !='0000-00-00'";
			
		}
		}
		}
		//User

		if ($this->role == 5 ) {

			
			$username = "assign_to_dse_tl ='" . $this->user_id . "'";

		}
		elseif ($this->role == 4 ) {

			
			$username = "assign_to_dse ='" . $this->user_id . "'";

		}
		elseif ($this->role == 15 ) {

			
			$username = "assign_to_e_tl  ='" . $this->user_id . "'";

		}
		elseif ($this->role == 16 ) {

			
			$username = " 	assign_to_e_exe  ='" . $this->user_id . "'";

		}
		elseif (in_array($this->role,$this->executive_array)) {
			$username = "assign_to_cse ='" . $this->user_id . "'";
		}
		/*elseif (in_array($this->role,$this->tl_array)) {
			if($_SESSION['role_name']!='Manager' && $_SESSION['role_name']!='Auditor'){
			$username = "assign_by_cse_tl ='" . $this->user_id . "'";
			}
		}

		 */

		

		$query = "SELECT  l.created_time,
		
		m.model_name,
		 `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.alternate_contact_no,l.address,l.email,l.created_date as lead_date,l.created_time as lead_time,l.feedbackStatus,l.nextAction,
		 l.ownership,l.budget_from,l.budget_to,l.accidental_claim,`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.reg_no, min(l.created_date) as min_date, max(l.created_date) as max_date ,l.km,`l`.`buyer_type`,  `l`.`manf_year`,l.assign_to_cse_date,l.assign_to_cse_time,
		
		l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,l.evaluation_within_days,l.fuel_type,l.color,
		
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,`ucsetl`.`fname` as `csetl_fname`, `ucsetl`.`lname` as `csetl_lname`, `ucsetl`.`role` as `csetl_role`,
		". $this->selectElement .",
		
		`v`.`variant_name`,`m`.`model_name` as `new_model_name`,
		
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,`csef`.`contactibility` as `csecontactibility`,`csef`.`created_time` as `cse_time`,
		
		ua.fname as auditfname,ua.lname as auditlname,
		m2.make_name as old_make,m1.model_name as old_model,
		bm2.make_name as buy_make_name,bm1.model_name as buy_model_name,
		
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date,mr.created_time as auditor_time,mr.call_status as auditor_call_status
		
		FROM " .$this->table_name. " 
		LEFT JOIN " .$this->table_name1. " `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ucsetl` ON `ucsetl`.`id`=`l`.`assign_by_cse_tl`
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` 
		LEFT JOIN `model_variant` `v` ON `v`.`variant_id`=`l`.`variant_id` 
		
		LEFT JOIN `make_models` `m1` ON `m1`.`model_id`=`l`.`old_model` 
		LEFT JOIN `makes` `m2` ON `m2`.`make_id`=`l`.`old_make`

			LEFT JOIN `make_models` `bm1` ON `bm1`.`model_id`=`l`.`buy_model` 
		LEFT JOIN `makes` `bm2` ON `bm2`.`make_id`=`l`.`buy_make`

		";
		
		if($_SESSION['process_id']==8){
		
		$query=$query." LEFT JOIN " .$this->table_name1. "  dsef ON dsef.id=l.exe_followup_id
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_e_exe` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_e_tl` ";
		
		}else{
		$query=$query." LEFT JOIN " .$this->table_name1. "  `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` ";
		}
		$query=$query."LEFT JOIN `tbl_manager_process` `mp` on `mp`.`user_id` =`udsetl`.`id`
		LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `mp`.`location_id`";

		if (isset($alldate)) {

			$query = $query . ' where ' . $alldate;
		}
		if (isset($feedback)) {
			$query = $query . ' And ' . $feedback;
		}
		if (isset($nextaction)) {
			$query = $query . ' And ' . $nextaction;
		}
		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		if (isset($username)) {
			$query = $query . ' And ' . $username;
		}
		if($_SESSION['role_name']=='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$this->user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
{
	
					$query=$query.'And mp.location_id in ('.$location_id.')';
					}
				}
		}
		if($_SESSION['process_id']==8){
			$query = $query . ' And l.evaluation="Yes"';
		}else{
		$query = $query . ' And l.process="' . $this->process_name . '"';
		}
		$query = $query . " group by l.enq_id  ";

	

		$query = $this -> db -> query($query);
		if($_SESSION['user_id']==1){
		//	echo $this->db->last_query();	
		}
	
		$query = $query -> result();

		return $query;
	}
	
public function select_lead_download_all() {
		ini_set('memory_limit', '-1');
				ini_set('max_execution_time', 300); //120 seconds

		//Filter Condition
		$today = date('Y-m-d');
		//Campaign
		$campaign_name = $this -> input -> get('campaign_name');
		if ($campaign_name != '' && $campaign_name != 'All') {
			if ($campaign_name == 'Website') {
				$lead_info = "lead_source=''";
			} else {
				$name = explode('%23', $campaign_name);
				if (isset($name[1])) {
					if ($name[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name[1] . "'";
					}
				}
				$name1 = explode('#', $campaign_name);
				if (isset($name1[1])) {
					if ($name1[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name1[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name1[1] . "'";
					}
				}

			}
		}
		//Feddback
		if ($this -> input -> get('feedback') != '') {
			$feedback = "l.feedbackStatus='" . $this -> input -> get('feedback') . "'";
		}
		// Next Action
		if ($this -> input -> get('nextaction') != '') {
			$nextaction = "l.nextaction='" . $this -> input -> get('nextaction') . "'";
		}

		// Date
		$date_type = $this -> input -> get('date_type');
		if ($this -> input -> get('fromdate') == '' && $this -> input -> get('todate') != '') {
			$fromdate = $today;
		} else {
			//echo "2";
			$fromdate = $this -> input -> get('fromdate');
		}
		if ($this -> input -> get('todate') == '' && $this -> input -> get('fromdate') != '') {
			//echo "3";
			$todate = $today;
		} else {
			//echo "4";
			$todate = $this -> input -> get('todate');
		}
		
		

		if ($date_type == 'Lead') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate . "' and l.created_date<='" . $todate . "'";
			}
		}
		if ($date_type == 'CSE') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "csef.date>= '" . $fromdate . "' and csef.date<= '" . $todate . "' and csef.date!='0000-00-00'";

			}
		}
		if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate ."' and dsef.date<= '".$todate."' and dsef.date!='0000-00-00'";
			
		}
		}

		//User

		if ($this->role == 5 ) {

			
			$username = "assign_to_dse_tl ='" . $this->user_id . "'";

		}
		elseif ($this->role == 4 ) {

			
			$username = "assign_to_dse ='" . $this->user_id . "'";

		}
		elseif ($this->role == 15 ) {

			
			$username = "assign_to_e_tl  ='" . $this->user_id . "'";

		}
		elseif ($this->role == 16 ) {

			
			$username = " 	assign_to_e_exe  ='" . $this->user_id . "'";

		}
		elseif (in_array($this->role,$this->executive_array)) {
			$username = "assign_to_cse ='" . $this->user_id . "'";
		}
		elseif (in_array($this->role,$this->tl_array)) {
				if($_SESSION['role_name']!='Manager' && $_SESSION['role_name']!='Auditor'){

			$username = "assign_by_cse_tl ='" . $this->user_id . "'";
				}

		}

		

		$query = "SELECT 
		GROUP_CONCAT( DISTINCT  a.accessories_name ) as accessoires_list,
		sum(price) as assessories_price,
		m.model_name,
		l.service_center,l.service_type,l.pickup_required,l.pick_up_date, `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.alternate_contact_no,l.address,l.email,l.created_date as lead_date,l.created_time as lead_time,l.feedbackStatus,l.nextAction,
		 l.ownership,l.budget_from,l.budget_to,l.accidental_claim,`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.reg_no, min(l.created_date) as min_date, max(l.created_date) as max_date ,l.km,`l`.`buyer_type`,  `l`.`manf_year`,l.assign_to_cse_date,l.assign_to_cse_time,l.assign_to_dse_date,l.assign_to_dse_time,l.assign_to_dse_tl_date,l.assign_to_dse_tl_time,
		l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_status,l.appointment_feedback,
		l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,l.created_time,
		
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,`ucsetl`.`fname` as `csetl_fname`, `ucsetl`.`lname` as `csetl_lname`, `ucsetl`.`role` as `csetl_role`,
		". $this->selectElement .",
		
		`v`.`variant_name`,`m`.`model_name` as `new_model_name`,
		
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, `csef`.`td_hv_date`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,`csef`.`contactibility` as `csecontactibility`,`csef`.`created_time` as `cse_time`,
		
		ua.fname as auditfname,ua.lname as auditlname,
		
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date,mr.created_time as auditor_time,mr.call_status as auditor_call_status
		
		FROM " .$this->table_name. " 
		LEFT JOIN " .$this->table_name1. " `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ucsetl` ON `ucsetl`.`id`=`l`.`assign_by_cse_tl`
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` 
		LEFT JOIN `model_variant` `v` ON `v`.`variant_id`=`l`.`variant_id` 
		
		LEFT JOIN `make_models` `m1` ON `m1`.`model_id`=`l`.`old_model` 
		LEFT JOIN `makes` `m2` ON `m2`.`make_id`=`l`.`old_make`
		LEFT JOIN `accessories_order_list` `a` ON `a`.`enq_id`=`l`.`enq_id`";
		
		if($_SESSION['process_id']==8){
		
		$query=$query." LEFT JOIN " .$this->table_name1. "  dsef ON dsef.id=l.exe_followup_id
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_e_exe` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_e_tl` ";
		
		}else{
		$query=$query." LEFT JOIN " .$this->table_name1. "  `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` ";
		}
		$query=$query."LEFT JOIN `tbl_manager_process` `mp` on `mp`.`user_id` =`udsetl`.`id`
		LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `mp`.`location_id`";

		if (isset($alldate)) {

			$query = $query . ' where ' . $alldate;
		}
		if (isset($feedback)) {
			$query = $query . ' And ' . $feedback;
		}
		if (isset($nextaction)) {
			$query = $query . ' And ' . $nextaction;
		}
		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		if (isset($username)) {
			$query = $query . ' And ' . $username;
		}
		if($_SESSION['process_id']==8){
			$query = $query . ' And l.evaluation="Yes"';
		}else{
		$query = $query . ' And l.process="' . $this->process_name . '"';
		}
		$query = $query . " group by l.enq_id";

	

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();

		return $query;
	}
		public function select_leads_complaint() {
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}

		//Filter Condition
		$today = date('Y-m-d');
		//Campaign
		$campaign_name = $this -> input -> get('campaign_name');
		if ($campaign_name != '' && $campaign_name != 'All') {
			if ($campaign_name == 'Website') {
				$lead_info = "lead_source=''";
			} else {
				$name = explode('%23', $campaign_name);
				if (isset($name[1])) {
					if ($name[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name[1] . "'";
					}
				}
				$name1 = explode('#', $campaign_name);
				if (isset($name1[1])) {
					if ($name1[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name1[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name1[1] . "'";
					}
				}

			}
		}
		//Feddback
		if ($this -> input -> get('feedback') != '') {
			$feedback = "l.feedbackStatus='" . $this -> input -> get('feedback') . "'";
		}
		// Next Action
		if ($this -> input -> get('nextaction') != '') {
			$nextaction = "l.nextaction='" . $this -> input -> get('nextaction') . "'";
		}

		// Date
		$date_type = $this -> input -> get('date_type');
		if ($this -> input -> get('fromdate') == '' && $this -> input -> get('todate') != '') {
			$fromdate = $today;
		} else {
			//echo "2";
			$fromdate = $this -> input -> get('fromdate');
		}
		if ($this -> input -> get('todate') == '' && $this -> input -> get('fromdate') != '') {
			//echo "3";
			$todate = $today;
		} else {
			//echo "4";
			$todate = $this -> input -> get('todate');
		}
		
		

		if ($date_type == 'Lead') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate . "' and l.created_date<='" . $todate . "'";
			}
		}
		if ($date_type == 'CSE') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "csef.date>= '" . $fromdate . "' and csef.date<= '" . $todate . "' and csef.date!='0000-00-00'";

			}
		}
		
	
		//User

		elseif (in_array($this->role,$this->executive_array)) {
			$username = "assign_to_cse ='" . $this->user_id . "'";
		}
		elseif (in_array($this->role,$this->tl_array)) {
			if($_SESSION['role_name']!='Manager' && $_SESSION['role_name']!='Auditor'){
			$username = "assign_by_cse_tl ='" . $this->user_id . "'";
			}
		}

		

		$query = "SELECT 
		
		l.service_center,l.comment,l.business_area,
		l.complaint_id,l.lead_source,l.name,l.contact_no,l.alternate_contact_no,l.address,l.email,l.created_date as lead_date,l.created_time as lead_time,l.feedbackStatus,l.nextAction,
		`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.assign_to_cse_date,l.assign_to_cse_time,l.reg_no,l.location,
		
		
		
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,
	
		
		
		
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,`csef`.`contactibility` as `csecontactibility`,`csef`.`created_time` as `cse_time`,
		
		ua.fname as auditfname,ua.lname as auditlname,
		
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date,mr.created_time as auditor_time,mr.call_status as auditor_call_status
		
		FROM lead_master_complaint l
		LEFT JOIN lead_followup_complaint `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		";
		

		if (isset($alldate)) {

			$query = $query . ' where ' . $alldate;
		}
		if (isset($feedback)) {
			$query = $query . ' And ' . $feedback;
		}
		if (isset($nextaction)) {
			$query = $query . ' And ' . $nextaction;
		}
		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		if (isset($username)) {
			$query = $query . ' And ' . $username;
		}
		if($_SESSION['role_name']=='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$this->user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
{
	
					$query=$query.'And mp.location_id in ('.$location_id.')';
					}
				}
		}
		
	
	
		$query = $query . " group by l.complaint_id limit ".$offset.' , '. $rec_limit;

	

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();

		return $query;

	}
	
public function select_leads_count_complaint() {
	ini_set('memory_limit', '-1');
		

		//Filter Condition
		$today = date('Y-m-d');
		//Campaign
		$campaign_name = $this -> input -> get('campaign_name');
		if ($campaign_name != '' && $campaign_name != 'All') {
			if ($campaign_name == 'Website') {
				$lead_info = "lead_source=''";
			} else {
				$name = explode('%23', $campaign_name);
				if (isset($name[1])) {
					if ($name[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name[1] . "'";
					}
				}
				$name1 = explode('#', $campaign_name);
				if (isset($name1[1])) {
					if ($name1[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name1[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name1[1] . "'";
					}
				}

			}
		}
		//Feddback
		if ($this -> input -> get('feedback') != '') {
			$feedback = "l.feedbackStatus='" . $this -> input -> get('feedback') . "'";
		}
		// Next Action
		if ($this -> input -> get('nextaction') != '') {
			$nextaction = "l.nextaction='" . $this -> input -> get('nextaction') . "'";
		}

		// Date
		$date_type = $this -> input -> get('date_type');
		if ($this -> input -> get('fromdate') == '' && $this -> input -> get('todate') != '') {
			$fromdate = $today;
		} else {
			//echo "2";
			$fromdate = $this -> input -> get('fromdate');
		}
		if ($this -> input -> get('todate') == '' && $this -> input -> get('fromdate') != '') {
			//echo "3";
			$todate = $today;
		} else {
			//echo "4";
			$todate = $this -> input -> get('todate');
		}
		
		

		if ($date_type == 'Lead') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate . "' and l.created_date<='" . $todate . "'";
			}
		}
		if ($date_type == 'CSE') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "csef.date>= '" . $fromdate . "' and csef.date<= '" . $todate . "' and csef.date!='0000-00-00'";

			}
		}
		
	
		//User

		
		elseif (in_array($this->role,$this->executive_array)) {
			$username = "assign_to_cse ='" . $this->user_id . "'";
		}
		elseif (in_array($this->role,$this->tl_array)) {
				if($_SESSION['role_name']!='Manager' && $_SESSION['role_name']!='Auditor'){
			$username = "assign_by_cse_tl ='" . $this->user_id . "'";
				}

		}

		

		$query = "Select count(distinct l.complaint_id) as lead_count FROM lead_master_complaint l
		LEFT JOIN lead_followup_complaint `csef` ON `csef`.`id`=`l`.`cse_followup_id` ";
		
		
	
		if (isset($alldate)) {

			$query = $query . ' where ' . $alldate;
		}
		if (isset($feedback)) {
			$query = $query . ' And ' . $feedback;
		}
		if (isset($nextaction)) {
			$query = $query . ' And ' . $nextaction;
		}
		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		if (isset($username)) {
			$query = $query . ' And ' . $username;
		}
		if($_SESSION['role_name']=='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$this->user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
{
	
					$query=$query.'And mp.location_id in ('.$location_id.')';
					}
				}
		}
		
		//$query = $query . " group by l.enq_id";

	

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();

		return $query;

	}
	public function select_lead_download_complaint() {
		
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300); //120 seconds
		$campaign_name = $this -> input -> get('campaign_name');
		if ($campaign_name != '' && $campaign_name != 'All') {
			if ($campaign_name == 'Website') {
				$lead_info = "lead_source=''";
			} else {
				$name = explode('%23', $campaign_name);
				if (isset($name[1])) {
					if ($name[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name[1] . "'";
					}
				}
				$name1 = explode('#', $campaign_name);
				if (isset($name1[1])) {
					if ($name1[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name1[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name1[1] . "'";
					}
				}

			}
		}
		//Feddback
		if ($this -> input -> get('feedback') != '') {
			$feedback = "l.feedbackStatus='" . $this -> input -> get('feedback') . "'";
		}
		// Next Action
		if ($this -> input -> get('nextaction') != '') {
			$nextaction = "l.nextaction='" . $this -> input -> get('nextaction') . "'";
		}

		// Date
		$date_type = $this -> input -> get('date_type');
		if ($this -> input -> get('fromdate') == '' && $this -> input -> get('todate') != '') {
			$fromdate = $today;
		} else {
			//echo "2";
			$fromdate = $this -> input -> get('fromdate');
		}
		if ($this -> input -> get('todate') == '' && $this -> input -> get('fromdate') != '') {
			//echo "3";
			$todate = $today;
		} else {
			//echo "4";
			$todate = $this -> input -> get('todate');
		}
		
		

		if ($date_type == 'Lead') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate . "' and l.created_date<='" . $todate . "'";
			}
		}
		if ($date_type == 'CSE') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "csef.date>= '" . $fromdate . "' and csef.date<= '" . $todate . "' and csef.date!='0000-00-00'";

			}
		}
		
	
		//User

		elseif (in_array($this->role,$this->executive_array)) {
			$username = "assign_to_cse ='" . $this->user_id . "'";
		}
		elseif (in_array($this->role,$this->tl_array)) {
			if($_SESSION['role_name']!='Manager' && $_SESSION['role_name']!='Auditor'){
			$username = "assign_by_cse_tl ='" . $this->user_id . "'";
			}
		}

		

		$query = "SELECT 
		
		l.service_center,l.comment,l.business_area,
		l.complaint_id,l.lead_source,l.name,l.contact_no,l.alternate_contact_no,l.address,l.email,l.created_date as lead_date,l.created_time as lead_time,l.feedbackStatus,l.nextAction,
		`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.assign_to_cse_date,l.assign_to_cse_time,l.reg_no,l.location,
		
		
		
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,
	
		
		
		
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,`csef`.`contactibility` as `csecontactibility`,`csef`.`created_time` as `cse_time`,
		
		ua.fname as auditfname,ua.lname as auditlname,
		
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date,mr.created_time as auditor_time,mr.call_status as auditor_call_status
		
		FROM lead_master_complaint l
		LEFT JOIN lead_followup_complaint `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		";
		

		if (isset($alldate)) {

			$query = $query . ' where ' . $alldate;
		}
		if (isset($feedback)) {
			$query = $query . ' And ' . $feedback;
		}
		if (isset($nextaction)) {
			$query = $query . ' And ' . $nextaction;
		}
		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		if (isset($username)) {
			$query = $query . ' And ' . $username;
		}
		if($_SESSION['role_name']=='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$this->user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
{
	
					$query=$query.'And mp.location_id in ('.$location_id.')';
					}
				}
		}
		
		$query = $query . " group by l.complaint_id ";
	

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();

		return $query;

	}
		public function select_poc_lead_download() {
	
	

		//Filter Condition
		$today = date('Y-m-d');
		//Campaign
		$campaign_name = $this -> input -> get('campaign_name');
		if ($campaign_name != '' && $campaign_name != 'All') {
			if ($campaign_name == 'Website') {
				$lead_info = "lead_source=''";
			} else {
				$name = explode('%23', $campaign_name);
				if (isset($name[1])) {
					if ($name[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name[1] . "'";
					}
				}
				$name1 = explode('#', $campaign_name);
				if (isset($name1[1])) {
					if ($name1[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name1[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name1[1] . "'";
					}
				}

			}
		}
		//Feddback
		if ($this -> input -> get('feedback') != '') {
			$feedback = "l.feedbackStatus='" . $this -> input -> get('feedback') . "'";
		}
		// Next Action
		if ($this -> input -> get('nextaction') != '') {
			$nextaction = "l.nextaction='" . $this -> input -> get('nextaction') . "'";
		}

		// Date
		$date_type = $this -> input -> get('date_type');
		if ($this -> input -> get('fromdate') == '' && $this -> input -> get('todate') != '') {
			$fromdate = $today;
		} else {
			//echo "2";
			$fromdate = $this -> input -> get('fromdate');
		}
		if ($this -> input -> get('todate') == '' && $this -> input -> get('fromdate') != '') {
			//echo "3";
			$todate = $today;
		} else {
			//echo "4";
			$todate = $this -> input -> get('todate');
		}
		
		

		if ($date_type == 'Lead') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate . "' and l.created_date<='" . $todate . "'";
			}
		}
		if ($date_type == 'CSE') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "csef.date>= '" . $fromdate . "' and csef.date<= '" . $todate . "' and csef.date!='0000-00-00'";

			}
		}
		if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate ."' and dsef.date<= '".$todate."' and dsef.date!='0000-00-00'";
			
		}
		}
			if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_date>= '". $fromdate ."' and l.assign_to_dse_date<= '".$todate."' and l.assign_to_dse_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_tl_date>= '". $fromdate ."' and l.assign_to_dse_tl_date<= '".$todate."' and l.assign_to_dse_tl_date!='0000-00-00'";
			
		}
		}
		if($_SESSION['process_id']==8){
				if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate ."' and dsef.date<= '".$todate."' and dsef.date!='0000-00-00'";
			
		}
		}
			if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_e_exe_date>= '". $fromdate ."' and l.assign_to_e_exe_date<= '".$todate."' and l.assign_to_e_exe_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_e_tl_date >= '". $fromdate ."' and l.assign_to_e_tl_date <= '".$todate."' and l.assign_to_e_tl_date !='0000-00-00'";
			
		}
		}
		}
		//User

		if ($this->role == 5 ) {

			
			$username = "assign_to_dse_tl ='" . $this->user_id . "'";

		}
		elseif ($this->role == 4 ) {

			
			$username = "assign_to_dse ='" . $this->user_id . "'";

		}
		elseif ($this->role == 15 ) {

			
			$username = "assign_to_e_tl  ='" . $this->user_id . "'";

		}
		elseif ($this->role == 16 ) {

			
			$username = " 	assign_to_e_exe  ='" . $this->user_id . "'";

		}
		elseif (in_array($this->role,$this->executive_array)) {
			$username = "assign_to_cse ='" . $this->user_id . "'";
		}
		

		

		$query = "select l.enq_id , l.name , l.address , l.contact_no , l.hp , l.financier_name , 
						 l.photo_uploaded , l.type_of_vehicle , l.accidental_details , l.manf_year , l.reg_year , l.insurance_type ,
						 l.insurance_validity_date , l.tyre_conditon , l.engine_work , l.body_work , l.vechicle_sale_category, 
						 l.refurbish_cost_bodyshop , l.total_rf , l.price_with_rf_and_commission , l.selling_price ,l.bought_at , 
						 l.bought_date , l.payment_date , l.payment_mode , l.payment_made_to , l.fuel_type , l.insurance_company ,
						 l.ownership , l.km , l.reg_no , l.outright , l.old_car_owner_name , l.accidental_details , l.refurbish_cost_tyre ,
						 l.refurbish_other , l.refurbish_cost_mecahanical , l.quotated_price , l.expected_price , l.enq_id , 
						 l.alternate_contact_no , l.location , l.lead_source , l.email , l.customer_location , l.appointment_type , 
						 l.appointment_date , l.appointment_time , l.appointment_status , l.created_date as lead_date , 
						 l.created_time as lead_time , l.days60_booking , l.assign_to_cse_date , l.assign_to_cse_time , l.enquiry_for ,
						 l.color , l.assign_to_e_exe_date , l.assign_to_e_exe_time , l.assign_to_cse , l.refurbish_cost_battery ,
						 l.agent_commision_payable , l.expected_date_of_sale ,
						 
						 csef.date as cse_date , csef.created_time as cse_time , csef.contactibility as csecontactibility , 
						 csef.feedbackStatus as csefeedback , csef.nextAction as csenextAction , csef.comment as cse_comment , 
						 csef.nextfollowuptime as cse_nftime , csef.nextfollowupdate as cse_nfd ,
						 
						 dsef.date as evaluator_date , dsef.created_time as evaluator_time , dsef.contactibility as evaluatorcontactibility , 
						 dsef.feedbackStatus as evaluatorfeedback , dsef.nextAction as evaluatornextAction , dsef.comment as evaluator_comment , 
						 dsef.nextfollowuptime as evaluator_nftime , dsef.nextfollowupdate as evaluator_nfd ,
						 
						 mk.model_name ,
						 
						 m.make_name ,
						 
						 mv.variant_name ,
						 
						 dse.fname , dse.lname ,
						 
						 dsetl.fname as tlfname , dsetl.lname as tllname ,
						 
						 tloc.location as showroom_location ,
						 
						 ucsetl.lname as csetl_lname , ucsetl.fname as csetl_fname ,
						 
						 ucse.lname as cse_lname , ucse.fname as cse_fname
						 
						 
		
		FROM lead_master_evaluation l
		LEFT JOIN lead_followup_evaluation `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN makes m ON m.make_id = l.old_make
		LEFT JOIN make_models mk ON mk.model_id = l.old_model
		LEFT JOIN model_variant mv ON mv.variant_id = l.old_variant
		
		LEFT JOIN lmsuser ucsetl ON ucsetl.id=l.assign_by_cse_tl
		LEFT JOIN lmsuser ucse ON ucse.id=l.assign_to_cse
		
		LEFT JOIN lmsuser dsetl ON dsetl.id = l.assign_to_e_tl
		LEFT JOIN lmsuser dse ON dse.id = l.assign_to_e_exe
		
	
		
		
		LEFT JOIN tbl_manager_process mp on mp.user_id =dsetl.id
		LEFT JOIN tbl_location tloc ON tloc.location_id= mp.location_id";
		
			
		
		if($_SESSION['sub_poc_purchase']==2){
				
			$query = $query . ' LEFT JOIN lead_followup_evaluation dsef ON dsef.id=l.tracking_followup_id  ' ;
			$query = $query . ' Where l.evaluation="Yes"';
		$query = $query . ' And l.process="' . $this->process_name . '"';
				$query = $query . ' And l.nextAction_for_tracking="Evaluation Done"';
		}else{
			
		$query = $query . ' LEFT JOIN lead_followup_evaluation dsef ON dsef.id=l.evaluation_followup_id  ';	
		$query = $query . ' And l.evaluation="Yes"';
		$query = $query . ' And l.process="' . $this->process_name . '"';
		}
			
	
		// If Login User Role Manager 
		if($_SESSION['role_name']=='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$this->user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
{
	
					$query=$query.'And mp.location_id in ('.$location_id.')';
					}
				}
		}
	
	
	
		// If Filter For Date From and To
		if (isset($alldate)) {

			$query = $query . ' And ' . $alldate;
		}
		
		//Filter For Feedback Status
		if (isset($feedback)) {
			$query = $query . ' And ' . $feedback;
		}

		//Filter For Next Action
		if (isset($nextaction)) {
			$query = $query . ' And ' . $nextaction;
		}

		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		
		if (isset($username)) {
			$query = $query . ' And ' . $username;
		}
	
		



		$query = $this -> db -> query($query);
	//echo $this->db->last_query();
		$query = $query -> result();

		return $query;


	}
	
	
	public function select_lead_evaluation() {
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}

		//Filter Condition
		$today = date('Y-m-d');
		//Campaign
		$campaign_name = $this -> input -> get('campaign_name');
		if ($campaign_name != '' && $campaign_name != 'All') {
			if ($campaign_name == 'Website') {
				$lead_info = "lead_source=''";
			} else {
				$name = explode('%23', $campaign_name);
				if (isset($name[1])) {
					if ($name[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name[1] . "'";
					}
				}
				$name1 = explode('#', $campaign_name);
				if (isset($name1[1])) {
					if ($name1[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name1[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name1[1] . "'";
					}
				}

			}
		}
		//Feddback
		if ($this -> input -> get('feedback') != '') {
			$feedback = "l.feedbackStatus='" . $this -> input -> get('feedback') . "'";
		}
		// Next Action
		if ($this -> input -> get('nextaction') != '') {
			$nextaction = "l.nextaction='" . $this -> input -> get('nextaction') . "'";
		}

		// Date
		$date_type = $this -> input -> get('date_type');
		if ($this -> input -> get('fromdate') == '' && $this -> input -> get('todate') != '') {
			$fromdate = $today;
		} else {
			//echo "2";
			$fromdate = $this -> input -> get('fromdate');
		}
		if ($this -> input -> get('todate') == '' && $this -> input -> get('fromdate') != '') {
			//echo "3";
			$todate = $today;
		} else {
			//echo "4";
			$todate = $this -> input -> get('todate');
		}
		
		

		if ($date_type == 'Lead') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate . "' and l.created_date<='" . $todate . "'";
			}
		}
		if ($date_type == 'CSE') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "csef.date>= '" . $fromdate . "' and csef.date<= '" . $todate . "' and csef.date!='0000-00-00'";

			}
		}
		if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate ."' and dsef.date<= '".$todate."' and dsef.date!='0000-00-00'";
			
		}
		}
			if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_date>= '". $fromdate ."' and l.assign_to_dse_date<= '".$todate."' and l.assign_to_dse_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_tl_date>= '". $fromdate ."' and l.assign_to_dse_tl_date<= '".$todate."' and l.assign_to_dse_tl_date!='0000-00-00'";
			
		}
		}
		if($_SESSION['process_id']==8){
				if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate ."' and dsef.date<= '".$todate."' and dsef.date!='0000-00-00'";
			
		}
		}
			if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_e_exe_date>= '". $fromdate ."' and l.assign_to_e_exe_date<= '".$todate."' and l.assign_to_e_exe_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_e_tl_date >= '". $fromdate ."' and l.assign_to_e_tl_date <= '".$todate."' and l.assign_to_e_tl_date !='0000-00-00'";
			
		}
		}
		}
		//User

		if ($this->role == 5 ) {

			
			$username = "assign_to_dse_tl ='" . $this->user_id . "'";

		}
		elseif ($this->role == 4 ) {

			
			$username = "assign_to_dse ='" . $this->user_id . "'";

		}
		elseif ($this->role == 15 ) {

			
			$username = "assign_to_e_tl  ='" . $this->user_id . "'";

		}
		elseif ($this->role == 16 ) {

			
			$username = " 	assign_to_e_exe  ='" . $this->user_id . "'";

		}
		elseif (in_array($this->role,$this->executive_array)) {
			$username = "assign_to_cse ='" . $this->user_id . "'";
		}
		

		

		$query = "select l.enq_id , l.name , l.address , l.contact_no , l.hp , l.financier_name , 
						 l.photo_uploaded , l.type_of_vehicle , l.accidental_details , l.manf_year , l.reg_year , l.insurance_type ,
						 l.insurance_validity_date , l.tyre_conditon , l.engine_work , l.body_work , l.vechicle_sale_category, 
						 l.refurbish_cost_bodyshop , l.total_rf , l.price_with_rf_and_commission , l.selling_price ,l.bought_at , 
						 l.bought_date , l.payment_date , l.payment_mode , l.payment_made_to , l.fuel_type , l.insurance_company ,
						 l.ownership , l.km , l.reg_no , l.outright , l.old_car_owner_name , l.accidental_details , l.refurbish_cost_tyre ,
						 l.refurbish_other , l.refurbish_cost_mecahanical , l.quotated_price , l.expected_price , l.enq_id , 
						 l.alternate_contact_no , l.location , l.lead_source , l.email , l.customer_location , l.appointment_type , 
						 l.appointment_date , l.appointment_time , l.appointment_status , l.created_date as lead_date , 
						 l.created_time as lead_time , l.days60_booking , l.assign_to_cse_date , l.assign_to_cse_time , l.enquiry_for ,
						 l.color , l.assign_to_e_exe_date , l.assign_to_e_exe_time , l.assign_to_cse , l.refurbish_cost_battery ,
						 l.agent_commision_payable , l.expected_date_of_sale ,
						 
						 csef.date as cse_date , csef.created_time as cse_time , csef.contactibility as csecontactibility , 
						 csef.feedbackStatus as csefeedback , csef.nextAction as csenextAction , csef.comment as cse_comment , 
						 csef.nextfollowuptime as cse_nftime , csef.nextfollowupdate as cse_nfd ,
						 
						 dsef.date as evaluator_date , dsef.created_time as evaluator_time , dsef.contactibility as evaluatorcontactibility , 
						 dsef.feedbackStatus as evaluatorfeedback , dsef.nextAction as evaluatornextAction , dsef.comment as evaluator_comment , 
						 dsef.nextfollowuptime as evaluator_nftime , dsef.nextfollowupdate as evaluator_nfd ,
						 
						 mk.model_name ,
						 
						 m.make_name ,
						 
						 mv.variant_name ,
						 
						 dse.fname , dse.lname ,
						 
						 dsetl.fname as tlfname , dsetl.lname as tllname ,
						 
						 tloc.location as showroom_location ,
						 
						 ucsetl.lname as csetl_lname , ucsetl.fname as csetl_fname ,
						 
						 ucse.lname as cse_lname , ucse.fname as cse_fname
						 
						 
		
		FROM lead_master_evaluation l
		LEFT JOIN lead_followup_evaluation `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		LEFT JOIN makes m ON m.make_id = l.old_make
		LEFT JOIN make_models mk ON mk.model_id = l.old_model
		LEFT JOIN model_variant mv ON mv.variant_id = l.old_variant
		
		LEFT JOIN lmsuser ucsetl ON ucsetl.id=l.assign_by_cse_tl
		LEFT JOIN lmsuser ucse ON ucse.id=l.assign_to_cse
		
		LEFT JOIN lmsuser dsetl ON dsetl.id = l.assign_to_e_tl
		LEFT JOIN lmsuser dse ON dse.id = l.assign_to_e_exe
		
	
		
		
		LEFT JOIN tbl_manager_process mp on mp.user_id =dsetl.id
		LEFT JOIN tbl_location tloc ON tloc.location_id= mp.location_id";
		
			
		
		if($_SESSION['sub_poc_purchase']==2){
				
			$query = $query . ' LEFT JOIN lead_followup_evaluation dsef ON dsef.id=l.tracking_followup_id  ' ;
			$query = $query . ' Where l.evaluation="Yes"';
		$query = $query . ' And l.process="' . $this->process_name . '"';
				$query = $query . ' And l.nextAction_for_tracking="Evaluation Done"';
		}else{
			
		$query = $query . ' LEFT JOIN lead_followup_evaluation dsef ON dsef.id=l.evaluation_followup_id  ';	
		$query = $query . ' And l.evaluation="Yes"';
		$query = $query . ' And l.process="' . $this->process_name . '"';
		}
			
		
	
		// If Login User Role Manager 
		if($_SESSION['role_name']=='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$this->user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
{
	
					$query=$query.'And mp.location_id in ('.$location_id.')';
					}
				}
		}
	
	
	
		// If Filter For Date From and To
		if (isset($alldate)) {

			$query = $query . ' And ' . $alldate;
		}
		
		//Filter For Feedback Status
		if (isset($feedback)) {
			$query = $query . ' And ' . $feedback;
		}

		//Filter For Next Action
		if (isset($nextaction)) {
			$query = $query . ' And ' . $nextaction;
		}

		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		
		if (isset($username)) {
			$query = $query . ' And ' . $username;
		}
	
		$query = $query . " group by l.enq_id limit ".$offset.' , '. $rec_limit;

	

		$query = $this -> db -> query($query);
	//echo $this->db->last_query();
		$query = $query -> result();

		return $query;

	}
	
	
	
	
	
	
	
		public function select_lead_evaluation_count() {
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}

		//Filter Condition
		$today = date('Y-m-d');
		//Campaign
		$campaign_name = $this -> input -> get('campaign_name');
		if ($campaign_name != '' && $campaign_name != 'All') {
			if ($campaign_name == 'Website') {
				$lead_info = "lead_source=''";
			} else {
				$name = explode('%23', $campaign_name);
				if (isset($name[1])) {
					if ($name[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name[1] . "'";
					}
				}
				$name1 = explode('#', $campaign_name);
				if (isset($name1[1])) {
					if ($name1[0] == 'Facebook') {
						$lead_info = "enquiry_for ='" . $name1[1] . "'";
						$lead_info = "lead_source = 'Facebook'";
					} else {
						$lead_info = "lead_source = '" . $name1[1] . "'";
					}
				}

			}
		}
		//Feddback
		if ($this -> input -> get('feedback') != '') {
			$feedback = "l.feedbackStatus='" . $this -> input -> get('feedback') . "'";
		}
		// Next Action
		if ($this -> input -> get('nextaction') != '') {
			$nextaction = "l.nextaction='" . $this -> input -> get('nextaction') . "'";
		}

		// Date
		$date_type = $this -> input -> get('date_type');
		if ($this -> input -> get('fromdate') == '' && $this -> input -> get('todate') != '') {
			$fromdate = $today;
		} else {
			//echo "2";
			$fromdate = $this -> input -> get('fromdate');
		}
		if ($this -> input -> get('todate') == '' && $this -> input -> get('fromdate') != '') {
			//echo "3";
			$todate = $today;
		} else {
			//echo "4";
			$todate = $this -> input -> get('todate');
		}
		
		

		if ($date_type == 'Lead') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate . "' and l.created_date<='" . $todate . "'";
			}
		}
		if ($date_type == 'CSE') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "csef.date>= '" . $fromdate . "' and csef.date<= '" . $todate . "' and csef.date!='0000-00-00'";

			}
		}
		if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate ."' and dsef.date<= '".$todate."' and dsef.date!='0000-00-00'";
			
		}
		}
			if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_date>= '". $fromdate ."' and l.assign_to_dse_date<= '".$todate."' and l.assign_to_dse_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_dse_tl_date>= '". $fromdate ."' and l.assign_to_dse_tl_date<= '".$todate."' and l.assign_to_dse_tl_date!='0000-00-00'";
			
		}
		}
		if($_SESSION['process_id']==8){
				if($date_type=='DSE'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "dsef.date>= '". $fromdate ."' and dsef.date<= '".$todate."' and dsef.date!='0000-00-00'";
			
		}
		}
			if($date_type=='DSEAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_e_exe_date>= '". $fromdate ."' and l.assign_to_e_exe_date<= '".$todate."' and l.assign_to_e_exe_date!='0000-00-00'";
			
		}
		}
		if($date_type=='DSETLAssign'){
		if ($fromdate != '' && $todate != '') {
			$alldate= "l.assign_to_e_tl_date >= '". $fromdate ."' and l.assign_to_e_tl_date <= '".$todate."' and l.assign_to_e_tl_date !='0000-00-00'";
			
		}
		}
		}
		//User

		if ($this->role == 5 ) {

			
			$username = "assign_to_dse_tl ='" . $this->user_id . "'";

		}
		elseif ($this->role == 4 ) {

			
			$username = "assign_to_dse ='" . $this->user_id . "'";

		}
		elseif ($this->role == 15 ) {

			
			$username = "assign_to_e_tl  ='" . $this->user_id . "'";

		}
		elseif ($this->role == 16 ) {

			
			$username = " 	assign_to_e_exe  ='" . $this->user_id . "'";

		}
		elseif (in_array($this->role,$this->executive_array)) {
			$username = "assign_to_cse ='" . $this->user_id . "'";
		}
		

		

		$query = "select count( distinct l.enq_id) as lead_count
		FROM lead_master_evaluation l
		LEFT JOIN lead_followup_evaluation `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		
		LEFT JOIN lmsuser dsetl ON dsetl.id = l.assign_to_e_tl
		
	
		
		
		LEFT JOIN tbl_manager_process mp on mp.user_id =dsetl.id";
		
			
		
			
		if($_SESSION['sub_poc_purchase']==2){
				
			$query = $query . ' LEFT JOIN lead_followup_evaluation dsef ON dsef.id=l.tracking_followup_id  ' ;
			$query = $query . ' Where l.evaluation="Yes"';
		$query = $query . ' And l.process="' . $this->process_name . '"';
				$query = $query . ' And l.nextAction_for_tracking="Evaluation Done"';
		}else{
			
		$query = $query . ' LEFT JOIN lead_followup_evaluation dsef ON dsef.id=l.evaluation_followup_id  ';	
		$query = $query . ' And l.evaluation="Yes"';
		$query = $query . ' And l.process="' . $this->process_name . '"';
		}
		
	
		// If Login User Role Manager 
		if($_SESSION['role_name']=='Manager'){
			$get_location=$this->db->query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$this->user_id'")->result();
			$location=array();
			if(count($get_location)>0 ){
		
				foreach ($get_location as $row) {
						$location[]=$row->location_id;
					}
				 $location_id = implode(",",$location);
  		
  			
				if(!in_array(38,$location))
{
	
					$query=$query.'And mp.location_id in ('.$location_id.')';
					}
				}
		}
	
	
	
		// If Filter For Date From and To
		if (isset($alldate)) {

			$query = $query . ' And ' . $alldate;
		}
		
		//Filter For Feedback Status
		if (isset($feedback)) {
			$query = $query . ' And ' . $feedback;
		}

		//Filter For Next Action
		if (isset($nextaction)) {
			$query = $query . ' And ' . $nextaction;
		}

		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		
		if (isset($username)) {
			$query = $query . ' And ' . $username;
		}
	
	

	

		$query = $this -> db -> query($query);
	//echo $this->db->last_query();
		$query = $query -> result();

		return $query;


	}
	
	
	
	
	
	
	
	
}
?>