<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Duplicate_lead_tracker_model extends CI_model {
	function __construct() {
		parent::__construct();
		$this -> role = $this -> session -> userdata('role');
		$this -> user_id = $this -> session -> userdata('user_id');
		$this -> process_id = $_SESSION['process_id'];
			$this -> process_name = $_SESSION['process_name'];
		//Select Table
		if ($this -> process_id == 6 || $this -> process_id == 7) {
			$this -> table_name = 'lead_master_repeat l';
			$this -> table_name1 = 'lead_followup';
			}
		elseif ($this -> process_id == 8) {
			$this -> table_name = 'lead_master_repeat l';
			$this -> table_name1 = 'lead_followup';
		
		} else {
			$this -> table_name = 'lead_master_all l';
			$this -> table_name1 = 'lead_followup_all';
	
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
		
		
		

		
		

		$query = "SELECT 
		
		 `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.alternate_contact_no,l.address,l.email,l.created_date as lead_date,l.created_time as lead_time,
		 
		 min(l.created_date) as min_date, max(l.created_date) as max_date 
		
		
		FROM " .$this->table_name. " 
		";
		
		

		if (isset($alldate)) {

			$query = $query . ' where ' . $alldate;
		}
		
		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		
		
		$query = $query . ' And l.process="' . $this->process_name . '"';
		$query = $query . " group by l.enq_id limit ".$offset.' , '. $rec_limit;

	

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
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
		
		
	
		

		$query = "Select count(distinct enq_id) as lead_count FROM " .$this->table_name. " 
		";
		
		
	
		if (isset($alldate)) {

			$query = $query . ' where ' . $alldate;
		}
		
		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		
	
		
		$query = $query . ' And l.process="' . $this->process_name . '"';
		
		

	

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();

		return $query;

	}

	public function select_lead_download() {

		
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
		
		
		

		
		

		$query = "SELECT 
		
		 `l`.`assistance`,  `l`.`customer_location`,`l`.`days60_booking`,
		l.enq_id,l.lead_source,l.enquiry_for,l.process,l.name,l.contact_no,l.alternate_contact_no,l.address,l.email,l.created_date as lead_date,l.created_time as lead_time,
		 
		 min(l.created_date) as min_date, max(l.created_date) as max_date 
		
		
		FROM " .$this->table_name. " 
		";
		
		

		if (isset($alldate)) {

			$query = $query . ' where ' . $alldate;
		}
		
		if (isset($lead_info)) {
			$query = $query . ' And ' . $lead_info;
		}
		
		
		$query = $query . ' And l.process="' . $this->process_name . '"';
		$query = $query . " group by l.enq_id ";

	

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
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

}
?>