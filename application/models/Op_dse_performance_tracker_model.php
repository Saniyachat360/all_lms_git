<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Op_dse_performance_tracker_model extends CI_model {
	function __construct() {
		parent::__construct();
		parent::__construct();
		$this -> today = date('Y-m-d');
		$this -> process_name = $this -> session -> userdata('process_name');
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');

		$this -> process_id = $_SESSION['process_id'];
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master';
			$this -> table_name1 = 'lead_followup';
			$this -> selectElement = 'l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id,ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.nextAction,l.feedbackStatus,l.days60_booking,
			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.eagerness,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km
			';

		} elseif ($this -> process_id == 8) {
			$this -> table_name = 'lead_master_evaluation';
			$this -> table_name1 = 'lead_followup_evaluation';
			$this -> selectElement = 'ucse.fname as cse_fname,ucse.lname as cse_lname,
			udse.fname as dse_fname,udse.lname as dse_lname,
			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			f1.date as cse_date,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,
			f2.date as dse_date,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,
			l.nextAction,l.feedbackStatus,l.days60_booking,l.enq_id,l.enquiry_for,l.lead_source,l.name,l.created_date,l.contact_no,l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id';

		} else {
			$this -> table_name = 'lead_master_all';
			$this -> table_name1 = 'lead_followup_all';
			$this -> selectElement = 'l.assign_to_dse,assign_to_dse_tl,l.dse_followup_id';
		}
		$this -> executive_array = array("3", "8", "10", "12", "14");
		$this -> tl_array = array("2", "7", "9", "11", "13");
	}

	public function assign_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');

		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('assign_to_e_exe', $dse_id);
				$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('assign_to_dse', $dse_id);
				$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
	
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function assign_leads($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}

		$this -> db -> select($this -> selectElement);

		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		if($this->process_id==8){
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl ', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		$this -> db -> where('assign_to_e_exe', $dse_id);

		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this -> db -> where('assign_to_dse', $dse_id);

		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
	

		

		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	public function new_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');

		$this -> db -> where('l.nextAction!=', "Close");
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('exe_followup_id', 0);
		$this -> db -> where('assign_to_e_exe_date', $today);
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('dse_followup_id', 0);
		$this -> db -> where('assign_to_dse_date', $today);
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
		
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function new_leads($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}

		$this -> db -> select($this -> selectElement);

		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');

		if($this->process_id==8){
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		
		$this -> db -> where('l.evaluation', 'Yes');
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('exe_followup_id', 0);
		$this -> db -> where('assign_to_e_exe_date', $today);
		$this -> db -> where('l.nextAction!=', "Close");
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		
		$this -> db -> where('l.process', $this -> process_name);
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('dse_followup_id', 0);
		$this -> db -> where('assign_to_dse_date', $today);
		$this -> db -> where('l.nextAction!=', "Close");
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
		

		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function new_leads1($from_date, $to_date, $dse_id) {
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 300);
		//120 seconds
		$today = date('Y-m-d');
		$query = "SELECT 
		`l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.alternate_contact_no,l.address,l.email,l.created_date as lead_date,l.created_time as lead_time,l.feedbackStatus,l.nextAction,
		 l.ownership,l.budget_from,l.budget_to,l.accidental_claim,`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,l.quotated_price,l.expected_price,
		l.reg_no,l.km,`l`.`buyer_type`,  `l`.`manf_year`,l.assign_to_cse_date,l.assign_to_cse_time,l.assign_to_dse_date,l.assign_to_dse_time,l.assign_to_dse_tl_date,l.assign_to_dse_tl_time,
		l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_address,l.appointment_status,l.appointment_rating,l.appointment_feedback,l.evaluation_within_days,l.fuel_type,l.color,
		l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,l.created_time,
		
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,`ucsetl`.`fname` as `csetl_fname`, `ucsetl`.`lname` as `csetl_lname`, `ucsetl`.`role` as `csetl_role`,
		" . $this -> selectElement . ",
		m.model_name,
		`v`.`variant_name`,`m`.`model_name` as `new_model_name`,
		
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, `csef`.`td_hv_date`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,`csef`.`contactibility` as `csecontactibility`,`csef`.`created_time` as `cse_time`,
		
		ua.fname as auditfname,ua.lname as auditlname,
		
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date,mr.created_time as auditor_time,mr.call_status as auditor_call_status,
		m2.make_name as old_make,m1.model_name as old_model
		
		FROM  lead_master l
		LEFT JOIN lead_followup `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ucsetl` ON `ucsetl`.`id`=`l`.`assign_by_cse_tl`
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		LEFT JOIN `make_models` `m` ON `m`.`model_id`=`l`.`model_id` 
		LEFT JOIN `model_variant` `v` ON `v`.`variant_id`=`l`.`variant_id` 
		LEFT JOIN `make_models` `m1` ON `m1`.`model_id`=`l`.`old_model` 
		LEFT JOIN `makes` `m2` ON `m2`.`make_id`=`l`.`old_make`";

		$query = $query . " LEFT JOIN lead_followup `dsef` ON `dsef`.`id`=`l`.`dse_followup_id` 
		LEFT JOIN `lmsuser` `udse` ON `udse`.`id`=`l`.`assign_to_dse` 
		LEFT JOIN `lmsuser` `udsetl` ON `udsetl`.`id`=`l`.`assign_to_dse_tl` ";

		$query = $query . "LEFT JOIN `tbl_manager_process` `mp` on `mp`.`user_id` =`udsetl`.`id`
		LEFT JOIN `tbl_location` `tloc` ON `tloc`.`location_id`= `mp`.`location_id`";

		$alldate = "l.assign_to_dse_date>= '" . $from_date . "' and l.assign_to_dse_date<= '" . $to_date . "' and l.assign_to_dse_date!='0000-00-00'";

		if (isset($alldate)) {

			$query = $query . ' where ' . $alldate;
		}
		$query = $query . ' And l.assign_to_dse="' . $dse_id . '"';
		$query = $query . ' And l.assign_to_dse_date="' . $today . '"';
		$query = $query . ' And dse_followup_id="0"';
		$query = $query . ' And l.nextAction!="Close"';

		if ($_SESSION['role_name'] == 'Manager') {
			$get_location = $this -> db -> query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$dse_id'") -> result();
			$location = array();
			if (count($get_location) > 0) {

				foreach ($get_location as $row) {
					$location[] = $row -> location_id;
				}
				$location_id = implode(",", $location);

				if (!in_array(38, $location)) {

					$query = $query . 'And mp.location_id in (' . $location_id . ')';
				}
			}
		}

		$query = $query . ' And l.process="' . $this -> process_name . '"';

		$query = $query . " group by enq_id";

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();

		return $query;
	}

	public function pending_new_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');

		
		$this -> db -> where('l.nextAction!=', "Close");
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('exe_followup_id', 0);
		$this -> db -> where('assign_to_e_exe_date<', $today);
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('dse_followup_id', 0);
		$this -> db -> where('assign_to_dse_date<', $today);
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
		
		$query = $this -> db -> get();
		return $query -> result();

	}
	

	public function pending_new_leads($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');

		if($this->process_id==8){
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id ', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		
		$this -> db -> where('l.evaluation', 'Yes');
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('exe_followup_id', 0);
		$this -> db -> where('assign_to_e_exe_date<', $today);
		$this -> db -> where('l.nextAction!=', "Close");
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
			
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('dse_followup_id', 0);
		$this -> db -> where('assign_to_dse_date<', $today);
		$this -> db -> where('l.nextAction!=', "Close");
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
			
		}
		
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
public function pending_followup_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');
		

		
		if ($this -> process_id == 8) {
			$this->db->join($this -> table_name1 .' f2','l.exe_followup_id =f2.id');
			
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('assign_to_e_exe', $dse_id);
			$this -> db -> where('l.assign_to_e_exe_date >=', $from_date);
			$this -> db -> where('l.assign_to_e_exe_date <=', $to_date);
			$this -> db -> where('f2.nextfollowupdate <', $today);
			$this -> db -> where('f2.nextfollowupdate!=', '0000-00-00');
			$this -> db -> where('l.nextAction!=', "Close");	
		} else {
			$this->db->join($this -> table_name1 .' f2','l.dse_followup_id=f2.id');
			
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('assign_to_dse', $dse_id);
			$this -> db -> where('l.assign_to_dse_date>=', $from_date);
			$this -> db -> where('l.assign_to_dse_date<=', $to_date);
			$this -> db -> where('f2.nextfollowupdate <', $today);
			$this -> db -> where('f2.nextfollowupdate!=', '0000-00-00');
			$this -> db -> where('l.nextAction!=', "Close");	
		}
		
		$query = $this -> db -> get();
		return $query -> result();

	}
public function pending_followup_leads($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');

		if($this->process_id==8){
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id ', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl ', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('assign_to_e_exe', $dse_id);		
			$this -> db -> where('f2.nextfollowupdate <', $today);
			$this -> db -> where('f2.nextfollowupdate!=', '0000-00-00');
			$this -> db -> where('l.nextAction!=', "Close");
			$this -> db -> where('l.assign_to_e_exe_date
			>=', $from_date);
			$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('assign_to_dse', $dse_id);		
			$this -> db -> where('f2.nextfollowupdate <', $today);
			$this -> db -> where('f2.nextfollowupdate!=', '0000-00-00');
			$this -> db -> where('l.nextAction!=', "Close");
			$this -> db -> where('l.assign_to_dse_date>=', $from_date);
			$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
		
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function live_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('l.exe_followup_id !=', '0');
			$this -> db -> where('assign_to_e_exe', $dse_id);
			$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
			$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('l.dse_followup_id !=', '0');
			$this -> db -> where('assign_to_dse', $dse_id);
			$this -> db -> where('l.assign_to_dse_date>=', $from_date);
			$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}

		$this -> db -> where('l.nextAction !=', 'Booked From Autovista');
		$this -> db -> where('l.nextAction !=', 'Close');

		$query = $this -> db -> get();
		return $query -> result();

	}
public function live_leads($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');

		if($this->process_id==8){
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl ', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
		
		$this -> db -> where('l.evaluation', 'Yes');
		$this -> db -> where('l.exe_followup_id !=', '0');
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.nextAction!=', "Close");
		$this -> db -> where('l.nextAction !=', 'Booked From Autovista');
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		$this -> db -> where('l.dse_followup_id !=', '0');
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.nextAction!=', "Close");
		$this -> db -> where('l.nextAction !=', 'Booked From Autovista');
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
		
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function lost_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
				
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		} else {
			$this -> db -> where('l.process', $this -> process_name);
				
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
	
		
		$this -> db -> where('l.nextAction', 'Close');

		$query = $this -> db -> get();
		return $query -> result();

	}
public function lost_leads($from_date, $to_date, $dse_id) {
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');

if ($this -> process_id == 8) {
			
	$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl ', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe ', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.nextAction', "Close");
		
		$this -> db -> where('l.assign_to_e_exe_date >=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date <=', $to_date);
}else{
	$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.nextAction', "Close");
		
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
	
}
		
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function lost_to_codealer_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		$this -> db -> where('l.feedbackStatus ', 'Lost to Co-Dealer');
		$this -> db -> where('l.nextAction', 'Close');
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		$this -> db -> where('l.feedbackStatus ', 'Lost to Co-Dealer');
		$this -> db -> where('l.nextAction', 'Close');
		}
		
		

		$query = $this -> db -> get();
		return $query -> result();

	}
public function lost_to_codealer_leads($from_date, $to_date, $dse_id) {
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');

		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id ', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl ', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe ', 'left');
		
		$this -> db -> where(' 	assign_to_e_exe ', $dse_id);
		$this -> db -> where('l.nextAction', "Close");
		$this -> db -> where('l.feedbackStatus ', 'Lost to Co-Dealer');
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.nextAction', "Close");
		$this -> db -> where('l.feedbackStatus ', 'Lost to Co-Dealer');
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
			
		}
		
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function lost_to_other_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
				$this -> db -> where('assign_to_e_exe ', $dse_id);
		$this -> db -> where('l.assign_to_e_exe_date >=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date <=', $to_date);
		$this -> db -> where('l.feedbackStatus ', 'Others');
		$this -> db -> where('l.nextAction', 'Close');
		} else {
			$this -> db -> where('l.process', $this -> process_name);
				$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		$this -> db -> where('l.feedbackStatus ', 'Others');
		$this -> db -> where('l.nextAction', 'Close');
		}
		
	

		$query = $this -> db -> get();
		return $query -> result();

	}
public function lost_to_other_leads($from_date, $to_date, $dse_id) {
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');

		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe ', 'left');
		
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.nextAction', "Close");
		$this -> db -> where('l.feedbackStatus ', 'Others');
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		}else{
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.nextAction', "Close");
		$this -> db -> where('l.feedbackStatus ', 'Others');
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
			
		}
	
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function booked_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where(' 	assign_to_e_exe ', $dse_id);
		$this -> db -> where('l.assign_to_e_exe_date >=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date <=', $to_date);
		$this -> db -> where('l.nextAction', 'Booked From Autovista');
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		$this -> db -> where('l.nextAction', 'Booked From Autovista');
		}
		
		

		$query = $this -> db -> get();
		return $query -> result();

	}
public function booked_leads($from_date, $to_date, $dse_id) {
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');

		if($this->process_id==8){
			
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe ', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.nextAction', 'Booked From Autovista');
		$this -> db -> where('l.assign_to_e_exe_date >=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date <=', $to_date);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.nextAction', 'Booked From Autovista');
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
		
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function esc_level1_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
				$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		$this -> db -> where('esc_level1', "Yes");
			
		} else {
			$this -> db -> where('l.process', $this -> process_name);
				$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		$this -> db -> where('esc_level1', "Yes");
			
		}
		
	
		$query = $this -> db -> get();
		return $query -> result();

	}
public function esc_level1_leads($from_date, $to_date, $dse_id) {
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');

			if($this->process_id==8){
			
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe ', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.esc_level1', "Yes");
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
	
			}else{
		$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.esc_level1', "Yes");
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
	
			}
			$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function esc_level2_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		$this -> db -> where('esc_level2', "Yes");
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		$this -> db -> where('esc_level2', "Yes");
		}
		
		

		$query = $this -> db -> get();
		return $query -> result();

	}
public function esc_level2_leads($from_date, $to_date, $dse_id) {
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');

		if($this->process_id==8){
			
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe ', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		
		
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.esc_level2', "Yes");
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		}else{
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.esc_level2', "Yes");
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
	
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function esc_level3_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		$this -> db -> where('esc_level3', "Yes");
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		$this -> db -> where('esc_level3', "Yes");
		}
		
		

		$query = $this -> db -> get();
		return $query -> result();

	}
public function esc_level3_leads($from_date, $to_date, $dse_id) {
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		
		
		if($this->process_id==8){
			
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe ', 'left');
		$this -> db -> where('l.evaluation', 'Yes');

		
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.esc_level3', "Yes");
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		}else{
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.esc_level3', "Yes");
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
	
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function esc_level1_resolved_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		$this -> db -> where('esc_level1_resolved', "Yes");
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		$this -> db -> where('esc_level1_resolved', "Yes");
		}
		
		

		$query = $this -> db -> get();
		return $query -> result();

	}
public function esc_level1_resolved_leads($from_date, $to_date, $dse_id) {
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');

		if($this->process_id==8){
			
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe ', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
	
		
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.esc_level1_resolved', "Yes");
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		}else{
			$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.esc_level1_resolved', "Yes");
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}


		
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function esc_level2_resolved_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
			$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		$this -> db -> where('esc_level2_resolved', "Yes");
		} else {
			$this -> db -> where('l.process', $this -> process_name);
			$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		$this -> db -> where('esc_level2_resolved', "Yes");
		}
		
		

		$query = $this -> db -> get();
		return $query -> result();

	}
public function esc_level2_resolved_leads($from_date, $to_date, $dse_id) {
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		
		
		if($this->process_id==8){
			
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe ', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
	
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.esc_level2_resolved', "Yes");
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		}else{
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.esc_level2_resolved', "Yes");
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		}
	
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
public function esc_level3_resolved_leads_count($from_date, $to_date, $dse_id) {
		$today = date('Y-m-d');
		$this -> db -> select('count(distinct l.enq_id) as count_lead');

		$this -> db -> from($this -> table_name . ' l');		
		if ($this -> process_id == 8) {
			$this -> db -> where('l.evaluation', 'Yes');
				$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		$this -> db -> where('esc_level3_resolved', "Yes");
		} else {
			$this -> db -> where('l.process', $this -> process_name);
				$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);
		$this -> db -> where('esc_level3_resolved', "Yes");
		}
		
	

		$query = $this -> db -> get();
		return $query -> result();

	}
public function esc_level3_resolved_leads($from_date, $to_date, $dse_id) {
		
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		$page = $this -> uri -> segment(4);
		//echo $page;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select($this -> selectElement);
		$this -> db -> from($this -> table_name . ' l');
		$this -> db -> join($this -> table_name1 . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');


			if($this->process_id==8){
			
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.exe_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe ', 'left');
		$this -> db -> where('l.evaluation', 'Yes');
		
		$this -> db -> where('assign_to_e_exe', $dse_id);
		$this -> db -> where('l.esc_level3_resolved', "Yes");
		$this -> db -> where('l.assign_to_e_exe_date>=', $from_date);
		$this -> db -> where('l.assign_to_e_exe_date<=', $to_date);
		
			}else{
				$this -> db -> join($this -> table_name1 . ' f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this -> db -> where('l.process', $this -> process_name);
		
		$this -> db -> where('assign_to_dse', $dse_id);
		$this -> db -> where('l.esc_level3_resolved', "Yes");
		$this -> db -> where('l.assign_to_dse_date>=', $from_date);
		$this -> db -> where('l.assign_to_dse_date<=', $to_date);	
			}
	
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	

}
?>