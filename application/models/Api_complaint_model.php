<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class api_complaint_model extends CI_model {
	function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this -> today = date('Y-m-d');
		$this -> time = date("h:i:s A");
	}

	public function add_customer_complaint($fname, $email, $address, $contact_no, $comment, $assign, $lead_source, $assignby, $username, $process_id, $location, $role_session, $user_id_session,$sub_lead_source) {

		$nextaction = "(nextAction !='Close' and nextAction != 'Complaint Closed')";
		$this -> db -> select("*");
		$this -> db -> from('lead_master_complaint');
		//$this -> db -> where('process', $process);
		$this -> db -> where('contact_no', $contact_no);
		$this -> db -> where($nextaction);
		$query = $this -> db -> get() -> result();
		//echo $this->db->last_query();
		if (count($query) > 0) {
			// failed to insert row
			$response["success"] = 0;
			$response["message"] = "Customer Already Exists.";

			// echoing JSON response
			echo json_encode($response);
		} else {

			$date = date('Y-m-d');
			$time = date("H:i:s A");

			$check_role = $this -> db -> query("select role from lmsuser where id='$assign'") -> result();

			if ($check_role[0] -> role == 2) {
				$cse_tl = $assign;
				$cse = $assign;
				$cse_date = $date;
				$cse_time = $time;
			} else {
				$tl_id = $this -> db -> query("select tl_id from tbl_mapdse where dse_id='$assign'") -> result();
				if (count($tl_id) > 0) {
					$cse_tl = $tl_id[0] -> tl_id;
					$cse = $assign;
					$cse_date = $date;
					$cse_time = $time;
				} else {
					$response["success"] = 0;
					$response["message"] = "Oops! An error occurred.";

					// echoing JSON response
					echo json_encode($response);
					break;
				}
			}
			$query = $this -> db -> query("insert into lead_master_complaint(`lead_source`,`enquiry_for`,`manual_lead`,`name`,`email`,`address`,`contact_no`,`comment`,`created_date`,`created_time`,`assign_by_cse_tl`,`assign_to_cse`,`assign_to_cse_date`,`assign_to_cse_time`,`app` )
				values('$lead_source','$sub_lead_source','$username','$fname','$email','$address','$contact_no','$comment','$date','$time','$cse_tl','$cse','$cse_date','$cse_time','1')");

			if ($this -> db -> affected_rows() > 0) {
				$response["success"] = 1;
				$response["message"] = "Data successfully Inserted.";
				// echoing JSON response
				echo json_encode($response);
			} else {
				// failed to insert row
				$response["success"] = 0;
				$response["message"] = "Oops! An error occurred.";

				// echoing JSON response
				echo json_encode($response);
			}
		}
	}

	function assign_new_leads_source($process_id, $process_name) {
		$this -> db -> select('lead_source,count(lead_source) as wcount ');
		$this -> db -> from('lead_master_complaint');
		$this -> db -> where('assign_by_cse_tl', '0');
		$this -> db -> group_by('lead_source');
		$query = $this -> db -> get();
		return $query -> result();
	}

	function assign_new_leads_all_count($process_id, $process_name) {

		$this -> db -> select('count(complaint_id)as acount');
		$this -> db -> from('lead_master_complaint');
		$this -> db -> where('assign_by_cse_tl', '0');
		$query = $this -> db -> get();
		return $query -> result();
	}

	function assign_new_lead_assign_user($location, $process_id, $role, $user_id) {
		$all_array = array("2", "3", "5", "7", "9", "11", "13");
		$tl_array = array("2", "5", "7", "9", "11", "13");
		$tl_list = '("2","5", "7", "9", "11", "13")';
		$executive_array = array("4", "8", "10", "12", "14");
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		//$this -> db -> join('tbl_user_group u', 'u.user_id=l.id');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		$this -> db -> where('l.status', '1');
		$this -> db -> where('u.process_id', $process_id);

		if ($role == 1 || $role == 2 || $role == 3) {
			//	echo "hi";
			//$a = "(role=2 or role=3 or role=5)";
			$this -> db -> where_in('role', $all_array);

		} elseif (in_array($role, $tl_array)) {
			$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $user_id . '"') -> result();

			$c = count($q);
			$t = ' ( ';
			if (count($q) > 0) {

				for ($i = 0; $i < $c; $i++) {

					$t = $t . "id = " . $q[$i] -> dse_id . " or ";

				}

			}
			$t = $t . "role in" . $tl_list;
			$st = $t . ')';

			$this -> db -> where($st);
		} elseif (in_array($role, $executive_array)) {
			$q1 = $this -> db -> query('select tl_id from tbl_mapdse where dse_id="' . $user_id . '"') -> result();
			if (count($q1) > 0) {
				$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $q1[0] -> tl_id . '"') -> result();
				$c = count($q);
				$t = ' ( ';
				if (count($q) > 0) {

					for ($i = 0; $i < $c; $i++) {

						$t = $t . "id = " . $q[$i] -> dse_id . " or ";

					}

				}
				$t = $t . "role in" . $tl_list;
				$st = $t . ')';

				$this -> db -> where($st);

			} else {
				$t = $t . "role in" . $tl_list;
			}
		}
		$this -> db -> where('role !=', '1');
		$this -> db -> where('u.location_id', $location);
		$this -> db -> group_by("l.id");
		$this -> db -> order_by("fname", "asc");
		$query = $this -> db -> get();
		//echo $this -> db -> last_query();
		return $query -> result();

	}

	function assign_new_lead_update() {
		$process_name = $this -> input -> post('process_name');
		$process_id = $this -> input -> post('process_id');

		$assign_by = $this -> input -> post('user_id');
		$assign_date = date('Y-m-d');
		$time = date("H:i:s A");
		$cse_name = json_decode($_POST['cse_name']);
		$cse_count = count($cse_name);

		$web_lead_name = $this -> input -> post('leads1');
		if (isset($web_lead_name)) {

			if ($this -> input -> post('lead_count1') == '') {

				$lead_count = $this -> input -> post('web_count');
				$web_lead_count = $this -> input -> post('web_count');

			} else {

				$lead_count = $this -> input -> post('lead_count1');
				$web_lead_count = $this -> input -> post('lead_count1');

			}

		} else {
			$web_lead_count = '';
		}

		if ($web_lead_name == 'Web') {

			$web_lead_name = '';

		}

		$assign_count = $lead_count % $cse_count;
		if ($assign_count == 0)//check remainder
		{

			$assign_count1 = $lead_count / $cse_count;
			$assign_count_reminder = $assign_count1;
		} else {

			$lead_count = $lead_count - $assign_count;
			$assign_count1 = $lead_count / $cse_count;
			$assign_count_reminder = $assign_count1 + $assign_count;
		}

		for ($i = 0; $i < $cse_count; $i++) {
			if ($i == 0) {

				$query = $this -> db -> query("select complaint_id from lead_master_complaint where lead_source='$web_lead_name' and assign_by_cse_tl='0'  limit $assign_count_reminder ") -> result();
			} else {

				$query = $this -> db -> query("select complaint_id from lead_master_complaint where lead_source='$web_lead_name' and assign_by_cse_tl='0'  limit $assign_count1 ") -> result();
			}

			foreach ($query as $row) {
				$complaint_id = $row -> complaint_id;

				$this -> db -> query("update lead_master_complaint set  assign_by_cse_tl='$assign_by',assign_to_cse_date='$assign_date',assign_to_cse_time='$time',assign_to_cse='$cse_name[$i]' where complaint_id='$complaint_id'");

			}
		}
		if ($this -> db -> affected_rows() > 0) {
			$response["success"] = 1;
			$response["message"] = "Data successfully Updated.";
			// echoing JSON response
			echo json_encode($response);
		} else {
			// failed to insert row
			$response["success"] = 0;
			$response["message"] = "Oops! An error occurred.";

			// echoing JSON response
			echo json_encode($response);
		}

	}// Select All Lead Details

	public function select_all_followup_lead($role, $process_name, $user_id, $contact_no, $page, $process_id, $role_name) {

		$executive_array = array("3", "8", "10", "12", "14");
		$tl_array = array("2", "7", "9", "11", "13");
		ini_set('memory_limit', '-1');

		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$this -> db -> select('
			l.complaint_id,l.complaint_id,l.lead_source,l.business_area,l.name,l.contact_no,l.alternate_contact_no,l.email,l.address,l.service_center,l.created_date,l.assign_to_cse,l.nextAction,l.feedbackStatus,l.comment,
		f.date,f.nextfollowupdate,f.nextfollowuptime,f.comment as cse_comment,
		CONCAT (u.fname," ",u.lname) as cse_name');
		$this -> db -> from('lead_master_complaint l');
		$this -> db -> join('lead_followup_complaint f', 'f.complaint_id=l.complaint_id', 'left');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_cse', 'left');

		//if search contact no
		if (!empty($contact_no)) {
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}

		if (in_array($role, $executive_array)) {
			$this -> db -> where('assign_to_cse', $user_id);
		} elseif (in_array($role, $tl_array)) {
			$w = "(assign_by_cse_tl='$user_id' or assign_by_cse_tl=0)";
			$this -> db -> where($w);
			//$this -> db -> where('assign_by_cse_tl', $user_id);
		}
		if ($role_name == 'Manager') {
			$get_location = $this -> db -> query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$user_id'") -> result();
			$location = array();
			if (count($get_location) > 0) {

				foreach ($get_location as $row) {
					$location[] = $row -> location_id;
				}
				$location_id = implode(",", $location);

				if (!in_array(38, $location)) {
					$where = 'mp.location_id in (' . $location_id . ')';
					$this -> db -> where($where);
					//$query=$query.'And  in ('.$location_id.')';
				}
			}
		}
		$this -> db -> group_by('l.complaint_id');
		$this -> db -> order_by('l.complaint_id', 'desc');
		//Limit
		$this -> db -> limit($rec_limit, $offset);
		$query = $this -> db -> get();
		//echo $this->db->last_query();

		return $query -> result();

	}

	// Select All Lead Details
	public function select_all_followup_lead_count($role, $process_name, $user_id, $contact_no, $page, $process_id, $role_name) {

		$executive_array = array("3", "8", "10", "12", "14");
		$tl_array = array("2", "7", "9", "11", "13");
		ini_set('memory_limit', '-1');

		$this -> db -> select('count(l.complaint_id) as count_lead');
		$this -> db -> from('lead_master_complaint l');
		$this -> db -> join('lead_followup_complaint f', 'f.complaint_id=l.complaint_id', 'left');
		//if search contact no
		if (in_array($role, $executive_array)) {
			$this -> db -> where('assign_to_cse', $user_id);
		} elseif (in_array($role, $tl_array)) {
			$w = "(assign_by_cse_tl='$user_id' or assign_by_cse_tl=0)";
			$this -> db -> where($w);
			//$this -> db -> where('assign_by_cse_tl', $user_id);
		}
		if ($role_name == 'Manager') {
			$get_location = $this -> db -> query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$user_id'") -> result();
			$location = array();
			if (count($get_location) > 0) {

				foreach ($get_location as $row) {
					$location[] = $row -> location_id;
				}
				$location_id = implode(",", $location);

				if (!in_array(38, $location)) {
					$where = 'mp.location_id in (' . $location_id . ')';
					$this -> db -> where($where);
					//$query=$query.'And  in ('.$location_id.')';
				}
			}
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	//Insert Followup
	function insert_complaint_followup() {

		$today = date("Y-m-d");
		$time = date("h:i:s A");
		$complaint_id = $this -> input -> post('complaint_id');
		$old_data = $this -> db -> query("select name,contact_no,email,address from lead_master_complaint where complaint_id='" . $complaint_id . "'") -> result();

		//Basic Followup
		$name = $old_data[0] -> name;
		$contact_no = $old_data[0] -> contact_no;

		$alternate_contact = $this -> input -> post('alternate_contact');

		$contactibility = $this -> input -> post('contactibility');
		if ($contactibility == 'Connected' || $contactibility == 'Not Connected') {
			//$this->send_sms($contactibility,$contact_no);
		}
		$feedback = $this -> input -> post('feedback');
		$nextaction = $this -> input -> post('nextaction');

		$email = $this -> input -> post('email');
		if (!$email) {
			if ($old_data[0] -> email != null) {
				$email = $old_data[0] -> email;
			}
		}

		$followupdate = $this -> input -> post('followupdate');
		$followuptime = $this -> input -> post('followuptime');
		if ($followupdate == '') {
			if ($nextaction == 'Close' || $nextaction == 'Complaint Closed') {
				$followupdate = '0000-00-00';
				$followuptime = '00:00:00';
			} else {
				$tomarrow_date = date('Y-m-d', strtotime(' +1 day'));

				$followupdate = $tomarrow_date;
				$followuptime = '11:00:00';
			}
		}
		$address1 = $this -> input -> post('address');
		if (!$address1) {

			$address1 = $old_data[0] -> address;

		}
		$address = addslashes($address1);

		$comment1 = $this -> input -> post('comment');
		$reg_no = $this -> input -> post('reg_no');
		$complaint_type = $this -> input -> post('complaint_type');
		$location = $this -> input -> post('location');
		$comment = addslashes($comment1);

		//$assign_to_telecaller=$this->user_id;
		$assign_to_telecaller = $this -> input -> post('user_id');
		//Insert in lead_followup
		$insert = $this -> db -> query("INSERT INTO `lead_followup_complaint`
		(`complaint_id`,  `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`, `date` ,`created_time`,`feedbackStatus`,`nextAction`,`contactibility`,app) 
		VALUES ('$complaint_id','$comment','$followupdate','$followuptime','$assign_to_telecaller','$today','$time','$feedback','$nextaction','$contactibility','1')") or die(mysql_error());

		$followup_id = $this -> db -> insert_id();
		//echo $this->db->last_query();

		$update = $this -> db -> query("update lead_master_complaint set cse_followup_id='$followup_id',email='$email',alternate_contact_no='$alternate_contact',address='$address',
	nextAction='$nextaction',feedbackStatus='$feedback',reg_no='$reg_no',business_area='$complaint_type',location='$location'
	where complaint_id='$complaint_id'");
		if ($this -> db -> affected_rows() > 0) {
			$response["success"] = 1;
			$response["message"] = "Data successfully Inserted.";
			// echoing JSON response
			echo json_encode($response);
		} else {
			// failed to insert row
			$response["success"] = 0;
			$response["message"] = "Oops! An error occurred.";

			// echoing JSON response
			echo json_encode($response);
		}
	}

	/* Followup Details */
	public function followup_details($id, $process_id) {
		$this -> db -> select('f.id as followup_id,f.date as c_date,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime, 
		f.feedbackStatus,f.nextAction,f.created_time,f.contactibility,	 
		u.fname,u.lname
		 ');
		$this -> db -> from('lead_followup_complaint f');
		$this -> db -> join('lmsuser u', 'u.id=f.assign_to', 'left');
		$this -> db -> where('f.complaint_id', $id);
		$this -> db -> order_by('f.id', 'desc');
		$query = $this -> db -> get();
		return $query -> result();
	}

	public function customer_details($id, $process_id) {
		$this -> db -> select('l.complaint_id,l.alternate_contact_no,l.address,l.complaint_id,l.lead_source,l.business_area,l.name,l.contact_no,l.email,l.service_center,l.created_date,l.assign_to_cse,l.nextAction,l.feedbackStatus,l.comment,
		f.date,f.nextfollowupdate,f.nextfollowuptime,f.comment as cse_comment,
		CONCAT (u.fname," ",u.lname) as cse_name');
		$this -> db -> from('lead_master_complaint l');
		$this -> db -> join('lead_followup_complaint f', 'f.complaint_id=l.complaint_id', 'left');
		$this -> db -> join('lmsuser u', 'u.id=l.assign_to_cse', 'left');
		$this -> db -> where('l.complaint_id', $id);
		$query = $this -> db -> get();
		return $query -> result();
	}

	///////////////////////////////////////////////////////////////
	//Tracker search
	public function select_lead_tracker($process_name, $process_id, $campaign_name, $feedback_name, $nextaction_name, $date_type, $fromdate, $todate, $role_session, $role_name_session, $user_id, $page) {
	
		$executive_array = array("3", "8", "10", "12", "14");
		$tl_array = array("2", "7", "9", "11", "13");
		ini_set('memory_limit', '-1');

		ini_set('memory_limit', '-1');
		$rec_limit = 100;

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
		if ($feedback_name != '') {
			$feedback = "l.feedbackStatus='" . $feedback_name . "'";
		}
		// Next Action
		if ($nextaction_name != '') {
			$nextaction = "l.nextaction='" . $nextaction_name . "'";
		}

		// Date

		if ($fromdate == '' && $todate != '') {
			$fromdate1 = $today;
		} else {
			//echo "2";
			$fromdate1 = $fromdate;
		}
		if ($todate == '' && $fromdate != '') {
			//echo "3";
			$todate1 = $today;
		} else {
			//echo "4";
			$todate1 = $todate;
		}

		if ($date_type == 'Lead') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate1 . "' and l.created_date<='" . $todate1 . "'";
			}
		}
		if ($date_type == 'CSE') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "csef.date>= '" . $fromdate1 . "' and csef.date<= '" . $todate1 . "' and csef.date!='0000-00-00'";

			}
		}

		//User

		if (in_array($role_session, $executive_array)) {
			$username = "assign_to_cse ='" . $user_id . "'";
		} elseif (in_array($role_session, $tl_array)) {
			if ($role_name_session != 'Manager' && $role_name_session != 'Auditor') {
				$username = "assign_by_cse_tl ='" . $user_id . "'";
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
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`";

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

		if ($role_name_session == 'Manager') {
			$get_location = $this -> db -> query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$user_id'") -> result();
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
		$query = $query . " group by l.complaint_id";
		$query = $query . " order by l.complaint_id desc";
		$query = $query . " limit " . $offset . "," . $rec_limit . "";

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();

		return $query;

	}

	//Tracker search count
	public function select_lead_tracker_count($process_name, $process_id, $campaign_name, $feedback_name, $nextaction_name, $date_type, $fromdate, $todate, $role_session, $role_name_session, $user_id, $page) {
	

		$executive_array = array("3", "8", "10", "12", "14");
		$tl_array = array("2", "7", "9", "11", "13");
		ini_set('memory_limit', '-1');

		ini_set('memory_limit', '-1');
		$rec_limit = 100;

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
		if ($feedback_name != '') {
			$feedback = "l.feedbackStatus='" . $feedback_name . "'";
		}
		// Next Action
		if ($nextaction_name != '') {
			$nextaction = "l.nextaction='" . $nextaction_name . "'";
		}

		// Date

		if ($fromdate == '' && $todate != '') {
			$fromdate1 = $today;
		} else {
			//echo "2";
			$fromdate1 = $fromdate;
		}
		if ($todate == '' && $fromdate != '') {
			//echo "3";
			$todate1 = $today;
		} else {
			//echo "4";
			$todate1 = $todate;
		}

		if ($date_type == 'Lead') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "l.created_date>='" . $fromdate1 . "' and l.created_date<='" . $todate1 . "'";
			}
		}
		if ($date_type == 'CSE') {
			if ($fromdate != '' && $todate != '') {
				$alldate = "csef.date>= '" . $fromdate1 . "' and csef.date<= '" . $todate1 . "' and csef.date!='0000-00-00'";

			}
		}

		//User

		if (in_array($role_session, $executive_array)) {
			$username = "assign_to_cse ='" . $user_id . "'";
		} elseif (in_array($role_session, $tl_array)) {
			if ($role_name_session != 'Manager' && $role_name_session != 'Auditor') {
				$username = "assign_by_cse_tl ='" . $user_id . "'";
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

		if ($role_name_session == 'Manager') {
			$get_location = $this -> db -> query("select distinct(location_id) as location_id from tbl_manager_process where user_id='$user_id'") -> result();
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
		//$query = $query . " group by l.enq_id";

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();

		return $query;

	}
		/////////////////////////////////////////////////////////////////////
	//Calling Notification
	
	//New Lead 
	public function select_new_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page)
{	
	
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$today=date('Y-m-d');
		if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
		$this -> db -> select('l.complaint_id,l.complaint_id,l.lead_source,l.business_area,l.name,l.contact_no,l.email,l.service_center,l.created_date,l.assign_to_cse,l.nextAction,l.feedbackStatus,l.comment,
		f.date,f.nextfollowupdate,f.nextfollowuptime,f.comment as cse_comment,
		CONCAT (u.fname," ",u.lname) as cse_name');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
			
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		
	
		$this -> db -> where('l.nextAction!=', "Close");
		
		if (in_array($role,$executive_array) && $user_id=='') {
			$this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('l.assign_to_cse_date', $today);
		}
			// If role all executive
		elseif (in_array($role,$this->executive_array) && $user_id !='') {
			$this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('l.assign_to_cse_date', $today);
		}
	
		
		//If role is all TL and dashboard id is blank(for calling task)
		
		elseif(in_array($role,$tl_array) && $user_id==''){
          $this -> db -> where('l.cse_followup_id', 0);
		  	
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('l.assign_to_cse_date', $today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
        $this -> db -> where('l.cse_followup_id', 0);
			
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('l.assign_to_cse_date', $today);
        }
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this->db->group_by('l.complaint_id');
		$this -> db -> order_by('l.complaint_id', 'desc');
		
		$this -> db -> limit($rec_limit,$offset);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
}
//New Lead Count
public function select_new_lead_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page){
			
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		$table=$this->select_table($process_id_session);	
			
		$today=date('Y-m-d');
	
        if($user_id=='')
        {
            $userid=$user_id_session;
        }else{
			$userid=$user_id;
		}
      
        if($role=='')
        {
            $role=$role_session;
        }
		
		$this->db->select('count(distinct l.complaint_id) as count_lead');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
	
	if (in_array($role,$executive_array) && $user_id=='') {
			$this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('l.assign_to_cse_date', $today);
		}
			// If role all executive
		elseif (in_array($role,$this->executive_array) && $user_id !='') {
			$this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('l.assign_to_cse_date', $today);
		}
	
		
		//If role is all TL and dashboard id is blank(for calling task)
		
		elseif(in_array($role,$tl_array) && $user_id==''){
          $this -> db -> where('l.cse_followup_id', 0);
		  	
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('l.assign_to_cse_date', $today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
        $this -> db -> where('l.cse_followup_id', 0);
			
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('l.assign_to_cse_date', $today);
        }
		if(!empty($contact_no)){
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		
		$this -> db -> order_by('l.complaint_id', 'desc');
	
		$query = $this -> db -> get();
		//	echo $this->db->last_query();
		return $query -> result();

	}
	// Unassign leads 
	public function select_unassigned_lead($role,$user_id,$user_id_session,$process_name_session,$process_id_session,$contact_no,$page) {

	$executive_array=array("3","8","10","12","14");
	$tl_array=array("2","7","9","11","13");
	ini_set('memory_limit', '-1');

	$rec_limit = 100;
	if (isset($page)) {
		$page = $page + 1;
		$offset = $rec_limit * $page;
	} else {
		$page = 0;
		$offset = 0;
	}
	
	$this->db->select('l.complaint_id,l.complaint_id,l.lead_source,l.business_area,l.name,l.contact_no,l.email,l.service_center,l.created_date,l.assign_to_cse,l.nextAction,l.feedbackStatus,l.comment,
		f.date,f.nextfollowupdate,f.nextfollowuptime,f.comment as cse_comment,
		CONCAT (u.fname," ",u.lname) as cse_name');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		$this->db->join('lmsuser u','u.id=l.assign_to_cse','left');
		
		//$this->db->where('l.process',$process_name_session);
		$this -> db -> where('l.nextAction!=', "Close");
		if (in_array($role,$executive_array)) {
		
			$this -> db -> where('l.assign_by_cse_tl', 0);
			$this -> db -> where('l.assign_to_cse', $user_id_session);
		
		}elseif(in_array($role,$tl_array) && $user_id==''){
           $this -> db -> where('l.assign_by_cse_tl', 0);
        }
		elseif(in_array($role,$tl_array) && $user_id !=''){
         $this -> db -> where('l.assign_by_cse_tl', 0);
        }
			$this -> db -> group_by('l.complaint_id');
		$this -> db -> order_by('l.complaint_id', 'desc');
		$this -> db -> limit($rec_limit,$offset);
		$query = $this -> db -> get();
//		echo $this->db->last_query();
		return $query -> result();

	}
	//Count of unassigned leads 
	public function select_unassigned_lead_count($role,$user_id,$user_id_session,$process_name_session,$process_id_session,$contact_no,$page){
	
	$executive_array=array("3","8","10","12","14");
	$tl_array=array("2","7","9","11","13");
	$this -> db -> select('count(l.complaint_id) as count_lead');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		$this->db->join('lmsuser u','u.id=l.assign_to_cse','left');
		$this -> db -> where('l.nextAction!=', "Close");
		if (in_array($role,$executive_array)) {
		
			$this -> db -> where('l.assign_by_cse_tl', 0);
			$this -> db -> where('l.assign_to_cse', $user_id_session);
		
		}elseif(in_array($role,$tl_array) && $user_id==''){
           $this -> db -> where('l.assign_by_cse_tl', 0);
        }
		elseif(in_array($role,$tl_array) && $user_id !=''){
         $this -> db -> where('l.assign_by_cse_tl', 0);
        }
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}
	public function select_today_followup_lead($role,$user_id,$user_id_session,$process_name_session,$process_id_session,$contact_no,$page)
{
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		$today=date('Y-m-d');
		$this->db->select('l.complaint_id,l.complaint_id,l.lead_source,l.business_area,l.name,l.contact_no,l.email,l.service_center,l.created_date,l.assign_to_cse,l.nextAction,l.feedbackStatus,l.comment,
		f.date,f.nextfollowupdate,f.nextfollowuptime,f.comment as cse_comment,
		CONCAT (u.fname," ",u.lname) as cse_name');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		$this->db->join('lmsuser u','u.id=l.assign_to_cse','left');
		$this -> db -> where('l.nextAction!=', "Close");
		if (in_array($role,$executive_array)) {
			$this -> db -> where('l.assign_to_cse', $user_id_session);
			$this -> db -> where('f.nextfollowupdate', $today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$tl_array) && $user_id==''){
			$this -> db -> where('l.assign_to_cse', $user_id_session);
			$this -> db -> where('f.assign_to', $user_id_session);
			$this -> db -> where('f.nextfollowupdate', $today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
			$this -> db -> where('l.assign_by_cse_tl', $user_id);
			$this -> db -> where('f.nextfollowupdate', $today);
        }
		if(!empty($contact_no)){
				
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		////////////// Time Filter ///////////////////
		$times = strtotime(date("H:i")) + 60*60;
		$timet = date("H:i:s", $times); 
		$times1 = strtotime(date("H:i")) - 60*60;
		$timet1 = date("H:i:s", $times1);
		if($this->input->post('name')=='current')
		{
			
				$this->db->where('f.nextfollowuptime>=',$timet1);
				$this->db->where('f.nextfollowuptime<=',$timet);
				$this->db->where('f.nextfollowuptime!=','');
			
		}
		$this->db->group_by('l.complaint_id');
		$this -> db -> order_by('l.complaint_id', 'desc');
		
		$this -> db -> limit($rec_limit,$offset);
		
		$query = $this -> db -> get();
		
		//echo $this->db->last_query();
		return $query -> result();
}
	public function select_today_followup_lead_count($role,$user_id,$user_id_session,$process_name_session,$process_id_session,$contact_no,$page){
		//Today followup Leads
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$today=date('Y-m-d');
		$this -> db -> select('count(l.complaint_id) as count_lead');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		$this->db->join('lmsuser u','u.id=l.assign_to_cse','left');	
	
		$this -> db -> where('l.nextAction!=', "Close");
			if (in_array($role,$executive_array)) {
			$this -> db -> where('l.assign_to_cse', $user_id_session);
			$this -> db -> where('f.nextfollowupdate', $today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$tl_array) && $user_id==''){
			$this -> db -> where('l.assign_to_cse', $user_id_session);
			$this -> db -> where('f.assign_to', $user_id_session);
			$this -> db -> where('f.nextfollowupdate', $today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
			$this -> db -> where('l.assign_by_cse_tl', $user_id);
			$this -> db -> where('f.nextfollowupdate', $today);
        }
		if(!empty($contact_no)){
				
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		////////////// Time Filter ///////////////////
		$times = strtotime(date("H:i")) + 60*60;
		$timet = date("H:i:s", $times); 
		$times1 = strtotime(date("H:i")) - 60*60;
		$timet1 = date("H:i:s", $times1);
		if($this->input->post('name')=='current')
		{
			
				$this->db->where('f.nextfollowuptime>=',$timet1);
				$this->db->where('f.nextfollowuptime<=',$timet);
				$this->db->where('f.nextfollowuptime!=','');
			
			
		}
		
		$this -> db -> order_by('l.complaint_id', 'desc');
		
		
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

	//Pending not attend leads for cse
	public function select_pending_new_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page)
{
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
		$today=date('Y-m-d');
		$this->db->select('l.complaint_id,l.complaint_id,l.lead_source,l.business_area,l.name,l.contact_no,l.email,l.service_center,l.created_date,l.assign_to_cse,l.nextAction,l.feedbackStatus,l.comment,
		f.date,f.nextfollowupdate,f.nextfollowuptime,f.comment as cse_comment,
		CONCAT (u.fname," ",u.lname) as cse_name');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		$this->db->join('lmsuser u','u.id=l.assign_to_cse','left');
		if (in_array($role,$executive_array)) {
			$this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('l.assign_to_cse_date <', $this->today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$tl_array) && $user_id==''){
          $this -> db -> where('l.cse_followup_id', 0);
		  
			$this -> db -> where('l.assign_to_cse',$userid);
			$this -> db -> where('l.assign_to_cse_date <', $this->today);
			
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
        $this -> db -> where('l.cse_followup_id', 0);
		 
		
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('l.assign_to_cse_date <', $this->today);
			
        }
		if(!empty($contact_no)){
				
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this->db->group_by('l.complaint_id');
		$this -> db -> order_by('l.complaint_id', 'desc');
		
		$this -> db -> limit($rec_limit,$offset);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
}

	public function select_pending_new_lead_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page) {
		//Pending Not Attened Leads
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
		$today=date('Y-m-d');
		$this -> db -> select('count(l.complaint_id) as count_lead');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		$this->db->join('lmsuser u','u.id=l.assign_to_cse','left');
		//$this -> db -> where('l.nextAction!=', "Close");
		if (in_array($role,$executive_array)) {
			$this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_cse', $userid);
			$this -> db -> where('l.assign_to_cse_date <', $this->today);
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$tl_array) && $user_id==''){
          $this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_to_cse',$userid);
			$this -> db -> where('l.assign_to_cse_date <', $this->today);
			
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
        $this -> db -> where('l.cse_followup_id', 0);
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			$this -> db -> where('l.assign_to_cse_date <', $this->today);
			
        }
		if(!empty($contact_no)){
				
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		
		$this -> db -> order_by('l.complaint_id', 'desc');
		
		$this -> db -> limit($rec_limit,$offset);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}
		// Pending attended live leads for cse and dse
	public function select_pending_followup_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page)
{
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
		$today=date('Y-m-d');
		$this->db->select('l.complaint_id,l.complaint_id,l.lead_source,l.business_area,l.name,l.contact_no,l.email,l.service_center,l.created_date,l.assign_to_cse,l.nextAction,l.feedbackStatus,l.comment,
		f.date,f.nextfollowupdate,f.nextfollowuptime,f.comment as cse_comment,
		CONCAT (u.fname," ",u.lname) as cse_name');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		$this->db->join('lmsuser u','u.id=l.assign_to_cse','left');
		$this -> db -> where('l.nextAction!=', "Close");
		
		if (in_array($role,$executive_array)) {
		$this -> db -> where('l.assign_to_cse', $userid);
			// if u dont want to show transferred leads.
			$this -> db -> where("f.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f.nextfollowupdate <", $this->today);
			
			
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$tl_array) && $user_id==''){
			$this -> db -> where('l.assign_to_cse',$userid);
			$this -> db -> where("f.nextfollowupdate!=", '0000-00-00');			
			$this -> db -> where("f.nextfollowupdate <", $this->today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
    
			$this -> db -> where("f.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f.nextfollowupdate <", $this->today);	  
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			
        }
		if(!empty($contact_no)){
				
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		$this->db->group_by('l.complaint_id');
		$this -> db -> order_by('l.complaint_id', 'desc');
		
		$this -> db -> limit($rec_limit,$offset);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
}

	public function select_pending_followup_lead_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page) {
		//Pending Attened Leads
		$executive_array=array("3","8","10","12","14");
		$tl_array=array("2","7","9","11","13");
		ini_set('memory_limit', '-1');
		$rec_limit = 100;
		if (isset($page)) {
			$page = $page + 1;
			$offset = $rec_limit * $page;
		} else {
			$page = 0;
			$offset = 0;
		}
		if($user_id=='')    {         $userid=$user_id_session;       }
		else {	 $userid=$user_id;	}
		 if($role=='')
        {
            $role=$role_session;
        }
		$today=date('Y-m-d');
		$this -> db -> select('count(l.complaint_id) as count_lead');
		$this->db->from('lead_master_complaint l');
		$this->db->join('lead_followup_complaint f','f.complaint_id=l.complaint_id','left');
		$this->db->join('lmsuser u','u.id=l.assign_to_cse','left');
		
		$this -> db -> where('l.nextAction!=', "Close");
		
	if (in_array($role,$executive_array)) {
		$this -> db -> where('l.assign_to_cse', $userid);
			// if u dont want to show transferred leads.
			//$this -> db -> where('l.assign_to_dse_tl', 0);
			$this -> db -> where("f.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f.nextfollowupdate <", $this->today);
			
			
		}
		//If role is all TL and dashboard id is blank(for calling task)
		elseif(in_array($role,$tl_array) && $user_id==''){
			$this -> db -> where('l.assign_to_cse',$userid);
			$this -> db -> where("f.nextfollowupdate!=", '0000-00-00');			
			$this -> db -> where("f.nextfollowupdate <", $this->today);
        }
		// If role is all TL and dashboard id is not blank(for dashboard)
		elseif(in_array($role,$tl_array) && $user_id !=''){
    
			$this -> db -> where("f.nextfollowupdate!=", '0000-00-00');
			$this -> db -> where("f.nextfollowupdate <", $this->today);	  
			$this -> db -> where('l.assign_by_cse_tl', $userid);
			
        }
		if(!empty($contact_no)){
				
			$this -> db -> where("l.contact_no  LIKE '%$contact_no%'");
		}
		//$this->db->group_by('l.enq_id');
		$this -> db -> order_by('l.complaint_id', 'desc');
		
		$this -> db -> limit($rec_limit,$offset);
		
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		
		return $query -> result();

	}
/********************* New Dashboard(with TL,Executive button) ****************************************/
	public function new_dashboard()
	{
			//post_values
			$user=$this->input->post('user_type');
			$location_name=$this->input->post('location_name');
			$process_id=$this->input->post('process_id');
			$user_id=$this->input->post('user_id');
			$role=$this->input->post('role');
			$role_name=$this->input->post('role_name');
			$process_name=$this->input->post('process_name');
			// Array values
			$select_role=array("3","4","8","10","12","14","16");
			$tl_role=array("CSE Team Leader","DSE Team Leader","Service TL","Insurance TL","Accessories TL","Finance TL","Evaluation Team Leader");
			$executive_role=array("CSE","DSE","Service Excecutive","Insurance Executive","Accessories Executive","Finance Executive","Evaluation Executive");
			
			$this -> db -> select('u.id,u.fname,u.lname,u.location ,u.role,l.location as location_name');
			$this -> db -> from('lmsuser u');
			$this->db->join('tbl_manager_process p','p.user_id=u.id');
			$this->db->join('tbl_location l','l.location_id=p.location_id');
			$this->db->join('tbl_mapdse m','m.dse_id=u.id','left');
		
			$this -> db -> where('p.location_id', $location_name);
			$this -> db -> where('p.process_id', $process_id);
			$this -> db -> where('u.status', 1);
		
			if(in_array($role,$select_role)){
					$this->db->where('id',$user_id);
			}else{
					if($user=='DSE'){
					
					if(in_array($role_name,$tl_role)){
					$this->db->where('m.tl_id',$user_id);
					}else{
						$this->db->where_in('role_name',$executive_role);
					}
					
					}else{
						
					if(in_array($role_name,$tl_role)){
					$this->db->where('id',$user_id);
					}else{
						$this->db->where_in('role_name',$tl_role);
					}
					}
				}
			$query = $this -> db -> get() ;
			//echo $this->db->last_query();
			$query=$query-> result();
			//print_r($query);
			if(count($query)>0){
				if($user =='')
			{
				$unassigned_leads_count=0;
				$new_leads_count=0;
				$call_today_leads_count=0;
				$pending_new_leads_count=0;
				$pending_followup_leads_count=0;
				
			}
			foreach($query as $row){
			
				$unassigned_leads = $this -> unassigned_leads_new($row -> id,$row->role,$process_name,$process_id);
				$new_leads=$this -> new_leads_new($row -> id,$row->role,$process_name,$process_id);
				$call_today=$this -> call_today_new($row -> id,$row->role,$process_name,$process_id);
				$pending_new_leads=$this -> pending_new_leads_new($row -> id,$row->role,$process_name,$process_id);
				$pending_followup=$this -> pending_followup_new($row -> id,$row->role,$process_name,$process_id);
				
				
				
				if($user !='')
				{
					$select_leads[] = array('id'=>$row -> id,'role'=>$row->role, 'location_name'=>$row->location_name,'fname' => $row -> fname, 'lname' => $row -> lname, 'unassigned_leads' => $unassigned_leads,  'new_leads' => $new_leads,'call_today' => $call_today, 'pending_new_leads' => $pending_new_leads, 'pending_followup' => $pending_followup);
			
				}
				else {
					
					
					$unassigned_leads_count=$unassigned_leads; 
					$new_leads_count=$new_leads_count+$new_leads;
					$call_today_leads_count=$call_today_leads_count+$call_today;
					$pending_new_leads_count=$pending_new_leads_count+$pending_new_leads;
					$pending_followup_leads_count=$pending_followup_leads_count+$pending_followup;
			
				}
				
			}
			if($user =='')
			{
			$select_leads[] = array('unassigned_leads' => $unassigned_leads_count,  'new_leads' => $new_leads_count,'call_today' => $call_today_leads_count, 'pending_new_leads' => $pending_new_leads_count, 'pending_followup' => $pending_followup_leads_count);
			}
			}else{
				$select_leads = array();
				
			}
			 		return	$select_leads;
	}
	public function unassigned_leads_new($id,$role,$process_name,$process_id){
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(complaint_id) as unassign');
		$this -> db -> from('lead_master_complaint ln');
		
	
		$this -> db -> where('ln.nextAction!=', "Close");
		if (in_array($role,$this->executive_array)) {
			$this -> db -> where('assign_by_cse_tl', 0);
			$this -> db -> where('ln.assign_to_cse', $id);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> where('assign_by_cse_tl', 0);
		}
		$query = $this -> db -> get();
		$query1 = $query -> result();
		$total_unassigned = $query1[0] -> unassign;
		return $total_unassigned;
	}
	public function new_leads_new($id,$role,$process_name,$process_id){
		$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(complaint_id) as new_leads');
		$this -> db -> from('lead_master_complaint ln');
		
		
		$this -> db -> where('ln.nextAction!=', "Close");
		if (in_array($role,$this->executive_array)) {
			$this -> db -> where('cse_followup_id', 0);
			$this -> db -> where('ln.assign_to_cse', $id);
			$this -> db -> where('ln.assign_to_cse_date', $today);
		}elseif(in_array($role,$this->tl_array)){
			$this -> db -> where('assign_by_cse_tl', $id);
		
			$this -> db -> where('ln.assign_to_cse_date', $today);
			$this -> db -> where('cse_followup_id', 0);
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_new_lead = $query1[0] -> new_leads;
		return $total_new_lead;
	}
	public function call_today_new($id,$role,$process_name,$process_id){
		//echo $role;
		$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(ln.complaint_id) as call_today');
		$this -> db -> from('lead_master_complaint ln');
		$this -> db -> join('lead_followup_complaint f','f.id=ln.cse_followup_id');
		if (in_array($role,$this->executive_array)) {
			
			$this -> db -> where('ln.assign_to_cse', $id);
			
		}elseif(in_array($role,$this->tl_array)){
			
			$this -> db -> where('assign_by_cse_tl', $id);
		}
		

		$this -> db -> where('f.nextfollowupdate', $today);
		$this -> db -> where('ln.nextAction!=', "Close");	
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_call_today = $query1[0] -> call_today;
		return $total_call_today;
	}
public function pending_new_leads_new($id,$role,$process_name,$process_id){
		
		$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(complaint_id) as pending_new');
		$this -> db -> from('lead_master_complaint ln');
		
		if (in_array($role,$this->executive_array)) {
			
			$this -> db -> where('cse_followup_id', 0);
			$this -> db -> where('ln.assign_to_cse', $id);
			$this -> db -> where('ln.assign_to_cse_date < ', $today);
			$this -> db -> where('ln.assign_to_cse_date!=', '0000-00-00');
		}
		elseif(in_array($role,$this->tl_array)) {
		
			$this -> db -> where('assign_by_cse_tl', $id);
			$this -> db -> where('ln.assign_to_cse_date < ', $today);
			$this -> db -> where('ln.assign_to_cse_date!=', '0000-00-00');
			$this -> db -> where('cse_followup_id', 0);
		}
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_pending_new = $query1[0] -> pending_new;
		return $total_pending_new;
	}
public function pending_followup_new($id,$role,$process_name,$process_id){
		//echo $id;
		//echo $role;
		$today=date('Y-m-d');
		$this->executive_array=array("3","8","10","12","14");
		$this->tl_array=array("2","7","9","11","13");
		$this -> db -> select('count(ln.complaint_id) as call_today');
		$this -> db -> from('lead_master_complaint ln');
		$this -> db -> join('lead_followup_complaint f','f.id=ln.cse_followup_id');
		if (in_array($role,$this->executive_array)) {
			
			$this -> db -> where('ln.assign_to_cse', $id);
			
		}elseif(in_array($role,$this->tl_array)){
			
			$this -> db -> where('assign_by_cse_tl', $id);
			
		}
	
		$this -> db -> where('f.nextfollowupdate <', $today);
		$this -> db -> where('f.nextfollowupdate!=', '0000-00-00');
		$this -> db -> where('ln.nextAction!=', "Close");	
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		$query1 = $query -> result();
		$total_call_today = $query1[0] -> call_today;
		return $total_call_today;
	}
///////////////////////////////////////////////////////////////////
/* Search By Name and contact Number */
public function search_by_name_contact($customer_name,$process_name,$process_id) {
		

		$query = "select l.service_center,l.comment,l.business_area,
		l.complaint_id,l.lead_source,l.name,l.contact_no,l.alternate_contact_no,l.address,l.email,l.created_date as lead_date,l.created_time as lead_time,l.feedbackStatus,l.nextAction,
		`l`.`assign_by_cse_tl`,`l`.`assign_to_cse`,
		l.assign_to_cse_date,l.assign_to_cse_time,
		`ucse`.`fname` as `cse_fname`, `ucse`.`lname` as `cse_lname`, `ucse`.`role` as `cse_role`,
		`csef`.`date` as `cse_date`, `csef`.`nextfollowupdate` as `cse_nfd`,`csef`.`nextfollowuptime` as `cse_nftime`, `csef`.`comment` as `cse_comment`, 
		`csef`.`feedbackStatus` as `csefeedback`, `csef`.`nextAction` as `csenextAction`,`csef`.`contactibility` as `csecontactibility`,`csef`.`created_time` as `cse_time`,
		ua.fname as auditfname,ua.lname as auditlname,	
		mr.followup_pending,mr.call_received,mr.fake_updation,mr.service_feedback,mr.remark as auditor_remark,mr.created_date as auditor_date,mr.created_time as auditor_time,mr.call_status as auditor_call_status
		
		FROM lead_master_complaint l 
		LEFT JOIN lead_followup_complaint `csef` ON `csef`.`id`=`l`.`cse_followup_id` 
		
		LEFT JOIN `tbl_manager_remark` `mr` ON `mr`.`remark_id`=`l`.`remark_id`
		LEFT JOIN `lmsuser` `ucse` ON `ucse`.`id`=`l`.`assign_to_cse` 
	
		LEFT JOIN `lmsuser` `ua` ON `ua`.`id`=`l`.`auditor_user_id`  
		
		";
		
		
		if (is_numeric($customer_name)) {
				
			$query = $query . ' And contact_no like "' . '%'.$customer_name .'%'. '"';			
		} else {
			$query = $query . ' And name like "' . '%'.$customer_name .'%'. '"';

		}
		$query = $query . " group by l.complaint_id";
		$query = $query . " order by l.complaint_id desc";
		$query = $query . " limit 50";

		$query = $this -> db -> query($query);
		//echo $this->db->last_query();
		$query = $query -> result();
		return $query;
		

	}

}
?>