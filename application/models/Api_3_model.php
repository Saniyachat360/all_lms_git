<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class api_3_model extends CI_model {
	function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");	
		$this->today=date('Y-m-d');
		$this->time=date("h:i:s A");
	}
	public function select_table($process_id)
	{
		
		if ($process_id == 6 || $process_id == 7) {

			$lead_master = 'lead_master';
			$lead_followup = 'lead_followup';
			$request_to_lead_transfer = 'request_to_lead_transfer';
			$tbl_manager_remark = 'tbl_manager_remark';
			$selectelement = 'f1.comment as cse_comment,f1.date as cse_call_date,f1.nextfollowupdate as cse_nfd,
			f2.comment as dse_comment,f2.date as dse_call_date,f2.nextfollowupdate as dse_nfd,
			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
			l.cse_followup_id,l.dse_followup_id,l.lead_source,l.address,
			l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time';
		} elseif ($process_id == 8) {
			$lead_master = 'lead_master_evaluation';
			$lead_followup = 'lead_followup_evaluation';
			$request_to_lead_transfer = 'request_to_lead_transfer_evaluation';
			$tbl_manager_remark = 'tbl_manager_remark_evaluation';
			$selectelement = 'f1.comment as cse_comment,f1.date as cse_call_date,f1.nextfollowupdate as cse_nfd,
			f2.comment as dse_comment,f2.date as dse_call_date,f2.nextfollowupdate as dse_nfd,
			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
			l.cse_followup_id,l.exe_followup_id as dse_followup_id,l.lead_source,l.address,
			l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time';
		} else {

			$lead_master = 'lead_master_all';
			$lead_followup = 'lead_followup_all';
			$request_to_lead_transfer = 'request_to_lead_transfer_all';
			$tbl_manager_remark = 'tbl_manager_remark_all';
			$selectelement = 'f1.comment as cse_comment,f1.date as cse_call_date,f1.nextfollowupdate as cse_nfd,
			f2.comment as dse_comment,f2.date as dse_call_date,f2.nextfollowupdate as dse_nfd,
			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
			l.cse_followup_id,l.dse_followup_id,l.lead_source,l.loan_type,l.address,
			l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time';
		}

		return array('tbl_manager_remark' => $tbl_manager_remark, 'selectelement' => $selectelement, 'lead_master' => $lead_master, 'lead_followup' => $lead_followup, 'request_to_lead_transfer' => $request_to_lead_transfer);
		
		
	}
	//Spiner
	function select_lead_source($process_id) {
			
		$this->db->select('*');
		$this->db->from('lead_source');
		$this->db->where('process_id',$process_id);
		$query=$this->db->get();	
		return $query->result();
		

	}
	function select_transfer_to_user($transfer_process,$transfer_location,$role,$user_id,$session_process)
	{
		$tprocess=$transfer_process;
		$toLocation = $transfer_location;
		 $from_user_role = $role;
		$fromUser=$user_id;
		$this -> db -> select('id,fname,lname');
		$this -> db -> from('lmsuser l');
		$this -> db -> join('tbl_manager_process u', 'u.user_id=l.id');
		$this -> db -> join('tbl_rights r', 'r.user_id=l.id');
		$this -> db -> join('tbl_location l1', 'l1.location_id=u.location_id', 'left');
		$this -> db -> where('r.form_name', 'Calling Notification');
		$this -> db -> where('r.view', '1');
		/*if($from_user_role==3)*/
		$tl_array = array("2", "5", "7", "9", "11", "13","15");
		$tl_list = '("2","5", "7", "9", "11", "13","15")';
		$executive_array = array("4", "8", "10", "12", "14", "16");
		if($tprocess==$session_process)
		{
		if ($from_user_role == 1 || $from_user_role == 2 || $from_user_role == 3) {
				
			$tl_array1 = array("2", "3", "5", "7", "9", "11", "13","15");
			$this -> db -> where_in('role', $tl_array1);
			//$k="(role=3 or role IN ('2','5', '7', '9', '11', '13'))";
			//$this -> db -> where($k);
		} elseif (in_array($from_user_role, $tl_array)) {
			$q = $this -> db -> query('select dse_id from tbl_mapdse where tl_id="' . $fromUser . '"') -> result();

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
		} elseif (in_array($from_user_role, $executive_array)) {
			$q1 = $this -> db -> query('select tl_id from tbl_mapdse where dse_id="' . $fromUser . '"') -> result();
			
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
		}
else {
	if ($from_user_role == 1 || $from_user_role == 2 || $from_user_role == 3) {
				
			$tl_array = array("2", "5", "7", "9", "11", "13","15");
			$this -> db -> where_in('role', $tl_array);
			//$k="(role=3 or role IN ('2','5', '7', '9', '11', '13'))";
			//$this -> db -> where($k);
		} elseif (in_array($from_user_role, $tl_array)) {
			
			$t = ' ( ';
			
			$t = $t . "role in" . $tl_list;
			$st = $t . ')';

			$this -> db -> where($st);
		} elseif (in_array($from_user_role, $executive_array)) {
			$q1 = $this -> db -> query('select tl_id from tbl_mapdse where dse_id="' . $fromUser . '"') -> result();
			
			if (count($q1) > 0) {
				$t = ' ( ';
				
				$t = $t . "role in" . $tl_list;
				$st = $t . ')';

				$this -> db -> where($st);

			} else {
				$t = $t . "role in" . $tl_list;
				$this -> db -> where($t);
			}
		}
}
		//$this -> db -> where_in('role',$this->tl_array);
		$this -> db -> where('l.status', '1');
		$this -> db -> where('role !=', '1');
		$this->db->where('l.id !=',$user_id);
		$this -> db -> where('u.process_id', $tprocess);
		$this -> db -> where('l1.location_id', $toLocation);
		$this -> db -> group_by("l.id");
		$this -> db -> order_by("fname", "asc");
		$query = $this -> db -> get();
		//echo $this -> db -> last_query();
		return $query -> result();
		
	}
	public function maxEmpId() {
		/*$this -> db -> select_max('empId');
		$this -> db -> from('lmsuser');*/
		$query=$this->db->query("SELECT  empId FROM lmsuser s
	   JOIN (SELECT MAX(id) AS mid FROM lmsuser GROUP BY id) max  ON s.id = max.mid order by s.id desc limit 1");
		//	$this -> db -> where('empId','');
	//	$query = $this -> db -> get();
		return $query -> result();

	}
	public function sign_up() {
		$today = $this -> today;
		$generated_otp = $this -> input -> post('generated_otp');
		$customer_otp = $this -> input -> post('customer_otp');
		if ($generated_otp == $customer_otp) {
			$maxEmpId = $this -> maxEmpId();
			if (isset($maxEmpId)) {
				$maxId = substr($maxEmpId[0] -> empId, 5);
				$maxIdNew = $maxId + 1;
				if (strlen($maxIdNew) < 2) {
					$maxIdNew = "AVLMS00" . $maxIdNew;
				} elseif (strlen($maxIdNew) < 3) {
					$maxIdNew = "AVLMS0" . $maxIdNew;
				} else {
					$maxIdNew = "AVLMS" . $maxIdNew;
				}
			} else {
				$maxIdNew = "AVLMS001";
			}

			$empId = $maxIdNew;
			$fname = $this -> input -> post('fname');
			$lname = $this -> input -> post('lname');
			$email = $this -> input -> post('emailid');
			$mobileno = $this -> input -> post('mobileno');
			$password = $this -> input -> post('password');

			//$updated_by=$_SESSION['user_id'];
			//role_id:17
			$role_name = "cross_lead_user";

			$query = $this -> db -> query("select email from lmsuser where mobileno='$mobileno' and role='17'") -> result();

			if (count($query) > 0) {
				$query1 = $this -> db -> query("select email from lmsuser where mobileno='$mobileno'  AND status='-1' and role='17'") -> result();
				if (count($query1) > 0) {

					$this -> db -> query("update lmsuser set status='1' where mobileno='$mobileno' AND status='-1' and role='17'");

				} else {
					$response["success"] = 0;
					$response["message"] = "This Mail id is Already Registered ...!";

				}
			} else {

				$this -> db -> query("insert into   lmsuser (empId,fname,lname,email,mobileno,password,status,role,role_name,date,is_active) value('$empId','$fname','$lname','$email','$mobileno','$password','1','17','Cross Lead User', '$today ','Offline')");
				$user_id = $this -> db -> insert_id();

				$this -> db -> query("insert into tbl_rights_cross_lead (user_id,`form_name`,`view`, `insert`, `modify`,`updated_date`) value('$user_id','Add new lead','1','1','1','$today ')");
				$this -> db -> query("insert into tbl_rights_cross_lead (user_id,`form_name`,`view`, `insert`, `modify`,`updated_date`) value('$user_id','Add escalation','1','1','1','$today ')");
				$this -> db -> query("insert into tbl_rights_cross_lead (user_id,`form_name`,`view`, `insert`, `modify`,`updated_date`) value('$user_id','reports','1','1','1','$today ')");
				$response["success"] = 1;
				$response["message"] = "Sign up Successfully Please Login ...!";

			}

		} else {
			$response["success"] = 0;
			$response["message"] = "Please Enter Correct OTP ...!";
		}
		echo json_encode($response);
	}
	public function send_otp() {
		$today = $this -> today;
		$moblie_number = $this -> input -> post('moblie_no');
		$q1 = $this -> db -> query("select mobileno from lmsuser where mobileno='$moblie_number'") -> result();
		if (count($q1) > 0) {
			$response["success"] = 0;
			$response["message"] = "This Contact No is Already Registred ...!";
			$response["otp"] = "NULL";
			echo json_encode($response);
		} else {

			$query = $this -> db -> query("select * from mobile_numbers where mobile_number='$moblie_number' and date='$today'") -> result();
			/*if (count($query) > 3) {
				$response["success"] = 0;
				$response["message"] = "Todays OTP quota is finished.Try again after 12 AM";
				$response["otp"] = "NULL";
				echo json_encode($response);
			} else {*/

				if (count($query) > 0) {
					$code = $query[0] -> verification_code;
				} else {
					$generator = "1357902468";
					$code = "";
					for ($i = 1; $i <= 4; $i++) {
						$code .= substr($generator, (rand() % (strlen($generator))), 1);
					}
				}
				$data = $this -> db -> query("insert into mobile_numbers (mobile_number,verification_code,date) value('$moblie_number','$code','$today')");

				/*$msg = $code . ' is Your SECRET One Time Password (OTP) for LMS Registration';

				//request parameters array
				$sendsms = "";
				//initialize the sendsms variable
				$requestParams = array('user' => 'atvsta', 'password' => 'atvsta', 'senderid' => 'ATVSTA', 'channel' => 'Trans', 'DCS' => '0', 'flashsms' => '0', 'route' => '46', 'number' => $moblie_number, 'text' => $msg);

				//merge API url and parameters
				$apiUrl = "http://smslogin.ismsexpert.com/api/mt/SendSMS?";
				//$apiUrl = "http://domain.ismsexpert.com/api/mt/SendSMS?";
				foreach ($requestParams as $key => $val) {
					$apiUrl .= $key . '=' . urlencode($val) . '&';
				}
				$apiUrl = rtrim($apiUrl, "&");

				//API call
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $apiUrl);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

				curl_exec($ch);
				curl_close($ch);*/

				$response["success"] = 1;
				$response["message"] = "OTP Sent Successfully...!";
				$response["otp"] = $code;
				echo json_encode($response);
				//return ;
			//}
		}
	}
	public function add_cross_lead() {
		echo $process_id = $this -> input -> post('process_id');
		echo $user_id = $this -> input -> post('user_id');
		$lead_source = 'Cross Lead';
		echo $fname = $this -> input -> post('fname');
		echo $email = $this -> input -> post('email');
		echo $address = $this -> input -> post('address');
		echo $pnum = $this -> input -> post('contact_no');
		echo $comment = $this -> input -> post('comments');
		$loan_type = $this -> input -> post('loan_type');
		if ($fname == '') {
			$fname = 'Unknown';
		}
		$checkProcessName = $this -> db -> query("select process_name from tbl_process where process_id='$process_id'") -> result();

		if (count($checkProcessName) > 0) {
			$process = $checkProcessName[0] -> process_name;
		} else {

			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Error Found ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

		}
		if ($process_id == 6 || $process_id == 7) {
			$table_name = 'lead_master';

		} else if ($process_id == 8) {
			$table_name = 'lead_master_evaluation';
		} else {
			$table_name = 'lead_master_all';
		}

		$nextaction = "(nextAction !='Close' and nextAction != 'Lost')";
		$this -> db -> select("*");
		$this -> db -> from($table_name);
		$this -> db -> where('process', $process);
		$this -> db -> where('contact_no', $pnum);
		$this -> db -> where($nextaction);
		$query = $this -> db -> get() -> result();
		//echo $this->db->last_query();
		if (count($query) > 0) {
			$this -> session -> set_flashdata('message', '<div class="alert alert-danger"><strong> Customer Already Exists ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');
		} else {

			$today = date("Y-m-d");

			$time = date("h:i:s A");

			$cross_lead_user_id = $user_id;
			if ($process == 'POC Purchase') {
				$purchase_field = ", evaluation";
				$purchase_field1 = ", 'Yes'";
			} else {
				$purchase_field = "";
				$purchase_field1 = '';
			}
			$query = $this -> db -> query("insert into " . $table_name . "	(process,`lead_source`,`name`,`email`,`address`,`contact_no`,`comment`,`created_date`,`created_time`,`cross_lead_user_id`,`web`" . $purchase_field . ")
				values('$process','$lead_source','$fname','$email','$address','$pnum','$comment','$today','$time','$cross_lead_user_id','1'" . $purchase_field1 . ")");
			//echo $this -> db -> last_query();
			$enq_id=$this->db->insert_id();
			if($process=='Finance')
			{
				$this->db->query("update lead_master_all set loan_type='$loan_type' where enq_id='$enq_id'");
			}
	
		}
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
	public function select_all_cross_lead_processwise($user_id, $process_id, $process_name,$date,$status) {
	//	$date1=date_format($date,"Y-m");
	
	
		$table = $this -> select_table($process_id);

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
		$this -> db -> select($table['selectelement']);
		$this -> db -> from($table['lead_master'] . ' l');
		$this -> db -> join($table['lead_followup'] . ' f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join($table['lead_followup'] . ' f2', 'f2.id=l.dse_followup_id', 'left');

		if ($process_id == '') {
			$this -> db -> where('l.process', $process_id);
		} else {
			$this -> db -> where('l.process', $process_name);
		}
		
		if($status == 'converted_lead') {
			$this -> db -> where('l.nextaction', 'Booked From Autovista');
		}
		elseif ($status == 'lost_leads') {
			$this -> db -> where('l.nextaction', 'Close');
		}
		elseif ($status == 'live_lead') {
			$this -> db -> where('l.nextaction !=', 'Close');
		$this -> db -> where('l.nextaction!=', 'Booked From Autovista');
		}
		if(!empty($date))
		{
			$date1=date("Y-m", strtotime($date));
			$w="l.created_date LIKE '$date1%'";
			$this -> db -> where($w);
		}
		
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		$this -> db -> where('cross_lead_user_id', $user_id);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');

		$query1 = $this -> db -> get() -> result();
		return $query1;
	}

	public function select_all_cross_lead_count_processwise($user_id, $process_id, $process_name,$date,$status) {

		$table = $this -> select_table($process_id);
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
		$this -> db -> select('
			
			count(enq_id) as all_count');
		$this -> db -> from($table['lead_master'] . ' l');
		if ($process_id == '') {
			$this -> db -> where('l.process', $process_id);
		} else {
			$this -> db -> where('l.process', $process_name);
		}
		if($status == 'converted_lead') {
			$this -> db -> where('l.nextaction', 'Booked From Autovista');
		}
		elseif ($status == 'lost_leads') {
			$this -> db -> where('l.nextaction', 'Close');
		}
		elseif ($status == 'live_lead') {
			$this -> db -> where('l.nextaction !=', 'Close');
		$this -> db -> where('l.nextaction!=', 'Booked From Autovista');
		}
		if(!empty($date))
		{
			$date1=date("Y-m", strtotime($date));
			$w="l.created_date LIKE '$date1%'";
			$this -> db -> where($w);
		}
		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		$this -> db -> where('cross_lead_user_id', $user_id);

		$this -> db -> order_by('l.enq_id', 'desc');

		$query1 = $this -> db -> get() -> result();
		return $query1;
	}

	public function select_all_cross_lead($user_id,$date,$status) {
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
		$process_id = '6';
		$table = $this -> select_table($process_id);
		//print_r($table);
		$this -> db -> select($table['selectelement']);
		$this -> db -> from('lead_master l');
		$this -> db -> join('lead_followup f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lead_followup f2', 'f2.id=l.dse_followup_id', 'left');

		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		if($status == 'converted_lead') {
			$this -> db -> where('l.nextaction', 'Booked From Autovista');
		}
		elseif ($status == 'lost_leads') {
			$this -> db -> where('l.nextaction', 'Close');
		}
		elseif ($status == 'live_lead') {
			$this -> db -> where('l.nextaction !=', 'Close');
		$this -> db -> where('l.nextaction!=', 'Booked From Autovista');
		}
		if(!empty($date))
		{
			$date1=date("Y-m", strtotime($date));
			$w="l.created_date LIKE '$date1%'";
			$this -> db -> where($w);
		}
		$this -> db -> where('cross_lead_user_id', $user_id);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$query1 = $this -> db -> get() -> result();
		$process_id = '8';
		$table = $this -> select_table($process_id);
		$this -> db -> select($table['selectelement']);
		$this -> db -> from('lead_master_evaluation l');
		$this -> db -> join('lead_followup_evaluation f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lead_followup_evaluation f2', 'f2.id=l.exe_followup_id', 'left');

		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		if($status == 'converted_lead') {
			$this -> db -> where('l.nextaction', 'Booked From Autovista');
		}
		elseif ($status == 'lost_leads') {
			$this -> db -> where('l.nextaction', 'Close');
		}
		elseif ($status == 'live_lead') {
			$this -> db -> where('l.nextaction !=', 'Close');
		$this -> db -> where('l.nextaction!=', 'Booked From Autovista');
		}
		if(!empty($date))
		{
			$date1=date("Y-m", strtotime($date));
			$w="l.created_date LIKE '$date1%'";
			$this -> db -> where($w);
		}
		$this -> db -> where('cross_lead_user_id', $user_id);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$query2 = $this -> db -> get() -> result();
		$process_id = '1';
		$table = $this -> select_table($process_id);
		$this -> db -> select($table['selectelement']);
		$this -> db -> from('lead_master_all l');
		$this -> db -> join('lead_followup_all f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lead_followup_all f2', 'f2.id=l.dse_followup_id', 'left');

		if (!empty($_POST['contact_no'])) {
			$contact = $this -> input -> post('contact_no');
			$this -> db -> where("l.contact_no  LIKE '%$contact%'");
		}
		if($status == 'converted_lead') {
			$this -> db -> where('l.nextaction', 'Booked From Autovista');
		}
		elseif ($status == 'lost_leads') {
			$this -> db -> where('l.nextaction', 'Close');
		}
		elseif ($status == 'live_lead') {
			$this -> db -> where('l.nextaction !=', 'Close');
		$this -> db -> where('l.nextaction!=', 'Booked From Autovista');
		}
		if(!empty($date))
		{
			$date1=date("Y-m", strtotime($date));
			$w="l.created_date LIKE '$date1%'";
			$this -> db -> where($w);
		}
		$this -> db -> where('cross_lead_user_id', $user_id);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$query3 = $this -> db -> get() -> result();

		return $query = array_merge($query1, $query2, $query3);
	}

	public function select_all_cross_lead_count($user_id,$date,$status) {

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
		if($status == 'converted_lead') {			
			$sl="and nextaction ='Booked From Autovista' ";
		}
		elseif ($status == 'lost_leads') {			
			$sl="and nextaction ='Close' ";
		}
		elseif ($status == 'live_lead') {
			$sl="and nextaction !='Close' and nextaction !='Booked From Autovista'";			
		}
		else {
			$sl='';
		}
		if(!empty($date))
		{
			$date1=date("Y-m", strtotime($date));
			$w="and created_date LIKE '$date1%'";			
		}else
			{
				$w='';
			}

		$q = $this -> db -> query("select 
		 ( select count(enq_id) from lead_master where  cross_lead_user_id='$user_id'".$sl.$w.")
		+ 
		 ( select count(enq_id) from lead_master_evaluation where cross_lead_user_id='$user_id'".$sl.$w.") 
		 + 
		 ( select count(enq_id) from lead_master_all where cross_lead_user_id='$user_id'".$sl.$w.")
		as 
		   all_count
		from 
		   dual") -> result();
		return $q;

	}
	public function select_process()
{
	$order="process_id='6' desc, process_id asc";
	$this -> db -> select('*');
		$this -> db -> from('tbl_process');
	$this->db->where('process_id!=','9');
	$this->db->order_by($order);
	$query = $this -> db -> get();
		return $query -> result();
}
public function cross_lead_dashboard(){

	$user_id = $this -> input -> post('user_id');

$this->db->select('*');

$this->db->from('tbl_process');

$this->db->where('process_name!=','Complaint');

$query=$this->db->get()->result();

foreach ($query as $row) {

	
	$live_lead=$this->live_leads($user_id,$row->process_name);

	$converted_lead=$this->converted_leads($user_id,$row->process_name);

	$lost_lead=$this->lost_leads($user_id,$row->process_name);

	$total_leads=$this->total_leads($user_id,$row->process_name);

	$select_data[]=array('process'=>$row->process_name,'user_id'=>$user_id,'live_lead'=>$live_lead,'converted_lead'=>$converted_lead,'lost_leads'=>$lost_lead,'total_leads'=>$total_leads);
}

	

	return $select_data;

	

}

public function total_leads($user_id,$process_name){

	if($process_name=='New Car' || $process_name=='POC Sales' )	{

		$table_name='lead_master';

	}else if($process_name=='POC Purchase'){

		$table_name='lead_master_evaluation';

	}else{

		$table_name='lead_master_all';

	}

	

	$this->db->select('count(enq_id) as lead_count');

	$this->db->from($table_name);

	$this->db->where('cross_lead_user_id',$user_id);

	$this->db->where ('process',$process_name);



	$query=$this->db->get();

	//echo $this->db->last_query();

	$query=$query->result();

	return $t_lead=$query[0]->lead_count;

	

}

public function live_leads($user_id,$process_name){

	if($process_name=='New Car' || $process_name=='POC Sales' )	{

		$table_name='lead_master';

	}else if($process_name=='POC Purchase'){

		$table_name='lead_master_evaluation';

	}else{

		$table_name='lead_master_all';

	}

	

	$this->db->select('count(enq_id) as lead_count');

	$this->db->from($table_name);

	$this->db->where('cross_lead_user_id',$user_id);

	$this->db->where ('process',$process_name);

	$this->db->where('nextaction!=','Close');

	$this->db->where('nextaction!=','Booked From Autovista');

	$query=$this->db->get()->result();

	return $t_lead=$query[0]->lead_count;

	

}

public function converted_leads($user_id,$process_name){

	if($process_name=='New Car' || $process_name=='POC Sales' )	{

		$table_name='lead_master';

	}else if($process_name=='POC Purchase'){

		$table_name='lead_master_evaluation';

	}else{

		$table_name='lead_master_all';

	}

	

	$this->db->select('count(enq_id) as lead_count');

	$this->db->from($table_name);

	$this->db->where('cross_lead_user_id',$user_id);

	$this->db->where ('process',$process_name);

	$this->db->where('nextaction','Booked From Autovista');

	$query=$this->db->get()->result();

	return $t_lead=$query[0]->lead_count;

}

public function lost_leads($user_id,$process_name){

	if($process_name=='New Car' || $process_name=='POC Sales' )	{

		$table_name='lead_master';

	}else if($process_name=='POC Purchase'){

		$table_name='lead_master_evaluation';

	}else{

		$table_name='lead_master_all';

	}

	

	$this->db->select('count(enq_id) as lead_count');

	$this->db->from($table_name);

	$this->db->where('cross_lead_user_id',$user_id);

	$this->db->where ('process',$process_name);

	$this->db->where('nextaction','Close');

$query=$this->db->get()->result();

	return $t_lead=$query[0]->lead_count;

}
public function select_lead($id,$process,$name) {

		if($process=='New Car' || $process=='POC Sales' )	{

		$table_name='lead_master';

		$ftable_name='lead_followup';

	}else if($process=='POC Purchase'){

		$table_name='lead_master_evaluation';

		$ftable_name='lead_followup_evaluation';

	}else{

		$table_name='lead_master_all';

		$ftable_name='lead_followup_all';

	}

	

		ini_set('memory_limit', '-1');

		$rec_limit = 100;

		$page = $this -> uri -> segment(6);

		

		if (isset($page)) {

			$page = $page + 1;

			$offset = $rec_limit * $page;

		} else {

			$page = 0;

			$offset = 0;

		}		if($process=='POC Purchase'){

		$this -> db -> select('

			ucse.fname as cse_fname,ucse.lname as cse_lname,

			udse.fname as dse_fname,udse.lname as dse_lname,

			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,

			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,

			f1.date as cse_date,f1.created_time as cse_time,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,

			f2.date as dse_date,f2.created_time as dse_time,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,

			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,

			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km

			,l.assign_to_e_exe as assign_to_dse,l.assign_to_e_tl as assign_to_dse_tl,l.exe_followup_id as dse_followup_id,l.cross_lead_escalation_remark');

		}else{

				$this -> db -> select('

			ucse.fname as cse_fname,ucse.lname as cse_lname,

			udse.fname as dse_fname,udse.lname as dse_lname,

			ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,

			udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,

			f1.date as cse_date,f1.created_time as cse_time,f1.nextfollowupdate as cse_nfd,f1.nextfollowuptime as cse_nftime,f1.comment as cse_comment,

			f2.date as dse_date,f2.created_time as dse_time,f2.nextfollowupdate as dse_nfd,f2.nextfollowuptime as dse_nftime,f2.comment as dse_comment,

			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,

			l.assign_by_cse_tl,l.assign_to_cse,l.cse_followup_id,l.lead_source,l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time,l.buyer_type,l.buy_status,l.model_id,l.variant_id,l.old_make,l.old_model,l.ownership,l.manf_year,l.color,l.km

			,l.assign_to_dse,l.assign_to_dse_tl,l.dse_followup_id,l.cross_lead_escalation_remark');

			

		}

		$this -> db -> from($table_name.' l');

		$this -> db -> join($ftable_name.' f1', 'f1.id=l.cse_followup_id', 'left');

		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');

		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');	

			if($process=='POC Purchase'){

		$this -> db -> join( 'lead_followup f2', 'f2.id=l.exe_followup_id', 'left');

		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl', 'left');

		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');

		}else{

			$this -> db -> join( 'lead_followup f2', 'f2.id=l.dse_followup_id', 'left');

		$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');

		$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');

		}

		$this -> db -> join('tbl_manager_process mp', 'mp.user_id=udsetl.id', 'left');		$process_name = $this -> input -> post('process_id');				

		

		$this -> db -> where('l.process', $process);	

		

		$this->db->where('cross_lead_user_id',$id);

		

		if($name=='total'){	}

		else if($name=='live'){

			$this->db->where('l.nextaction!=','Close');

			$this->db->where('l.nextaction!=','Booked From Autovista');

		}else if($name=='lost'){

			$this->db->where('l.nextaction','Close');

		}else if($name=='converted'){

			$this->db->where('l.nextaction','Booked From Autovista');

		}

		

		$this -> db -> group_by('l.enq_id');

		$this -> db -> order_by('l.enq_id', 'desc');

		//Limit

		$this -> db -> limit($rec_limit, $offset);

		$query1 = $this -> db -> get()-> result();

	//echo $this->db->last_query();				

		return $query1;

	}



	// Select All Lead Details

	public function select_lead_count($id,$process,$name) {

	ini_set('memory_limit', '-1');

	if($process=='New Car' || $process=='POC Sales' )	{

		$table_name='lead_master';

		$ftable_name='lead_followup';

	}else if($process=='POC Purchase'){

		$table_name='lead_master_evaluation';

		$ftable_name='lead_followup_evaluation';

	}else{

		$table_name='lead_master_all';

		$ftable_name='lead_followup_all';

	}

	

	

		$this -> db -> select('count(enq_id) as count_lead');



		$this -> db -> from($table_name.' l');

		$this -> db -> where('l.process', $process);	

		

		$this->db->where('cross_lead_user_id',$id);

		

			if($name=='total'){	}

		else if($name=='live'){

			$this->db->where('nextaction!=','Close');

			$this->db->where('nextaction!=','Booked From Autovista');

		}else if($name=='lost'){

			$this->db->where('nextaction','Close');

		}else if($name=='converted'){

			$this->db->where('nextaction','Booked From Autovista');

		}

		$query = $this -> db -> get();

	//	echo $this->db->last_query();

		return $query -> result();





	}
	/* customer details */
	 public function customer_details($id,$process_id,$sub_poc_purchase) {
	 	if($process_id !='')
	 	{
	 		$q=$this->db->query("select * from tbl_process where process_name='$process_id'")->result();
	 		if(count($q)>0)
	 		{
	 			$process_id=$q[0]->process_id;
	 		}
	 		else
	 		{
	 			$process_id='6';
	 		}
	 	}
	 	else
	 		{
	 			$process_id='6';
	 		}
	 	$table=$this->select_table($process_id);	
		//Get user all details
		if($process_id=='6' || $process_id=='7'){
			$this -> db -> select('l.enq_id,l.name,l.email,l.contact_no,l.alternate_contact_no,l.address,l.feedbackStatus,l.nextAction,l.eagerness,
		l.service_type,l.service_center,l.km,l.pick_up_date,l.pickup_required,l.buyer_type,l.color,l.manf_year,l.ownership,l.accidental_claim,
		l.budget_from,l.budget_to,l.assign_by_cse_tl,l.assign_to_cse,assign_to_dse_tl , l.assign_to_dse, l.dse_followup_id,
		l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_address,l.appointment_status,l.appointment_rating,l.appointment_feedback,
		l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,l.customer_occupation,l.customer_corporate_name,l.customer_designation,l.days60_booking,
	
			
		m1.model_name as old_model,
		m2.make_name as old_make,
		bm1.make_name as buy_make,
		bm2.model_name as buy_model,
		m.model_name,
		v.variant_name,
		
		udse.fname as dse_fname,udse.lname as dse_lname,
		udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			dsef.date as dse_call_date,dsef.created_time as dse_call_time,dsef.contactibility as dse_contactibility,dsef.comment as dse_remark,dsef.nextfollowupdate as dse_nfd , dsef.nextfollowuptime as dse_nft,
	
		ucse.fname as cse_fname,ucse.lname as cse_lname,
		ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
		csef.date as cse_call_date,csef.created_time as cse_call_time,csef.contactibility as cse_contactibility,csef.comment as cse_remark,csef.nextfollowupdate as cse_nfd , csef.nextfollowuptime as cse_nft');
		
		}elseif($process_id ==8){
				$this -> db -> select('m2.make_id as old_make_id,m2.make_name as old_make_name,
								m1.model_id as old_model_id,m1.model_name as old_model_name,
							v1.variant_id as old_variant_id,v1.variant_name as old_variant_name,
		
		l.appointment_type,l.appointment_date,l.appointment_time,l.appointment_address,l.appointment_status,l.exe_followup_id,
		l.quotated_price,l.evaluation_within_days,l.enq_id,name,l.email,l.address,l.alternate_contact_no,l.contact_no,l.comment,l.enquiry_for,l.created_date,l.created_time,l.process,l.assign_to_e_tl,l.assign_to_e_exe,l.assign_by_cse_tl,l.assign_to_cse,l.buyer_type,l.feedbackStatus,l.nextAction,
		l.old_make,l.old_model,l.old_variant,l.fuel_type,l.reg_no,l.reg_year,l.manf_year,l.color,l.ownership,l.km,l.type_of_vehicle,l.outright,l.old_car_owner_name,l.photo_uploaded,l.hp,l.financier_name,l.accidental_claim,l.accidental_details,l.insurance_type,l.insurance_company,l.insurance_validity_date,l.tyre_conditon,l.engine_work,l.body_work,l.vechicle_sale_category,l.refurbish_cost_bodyshop,l.refurbish_cost_mecahanical,l.refurbish_cost_tyre,l.refurbish_other,l.total_rf,l.price_with_rf_and_commission,l.expected_price,l.selling_price,l.bought_at,l.bought_date,l.payment_date,l.payment_mode,l.payment_made_to,
		l.esc_level1 ,l.esc_level1_remark,l.esc_level2 ,l.esc_level2_remark ,l.esc_level3 ,esc_level3_remark,esc_level1_resolved,esc_level2_resolved,esc_level3_resolved,esc_level1_resolved_remark,esc_level2_resolved_remark,esc_level3_resolved_remark,
		
		udse.fname as dse_fname,udse.lname as dse_lname,
		udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
			dsef.date as dse_call_date,dsef.created_time as dse_call_time,dsef.contactibility as dse_contactibility,dsef.comment as dse_remark,dsef.nextfollowupdate as dse_nfd , dsef.nextfollowuptime as dse_nft,
	
		ucse.fname as cse_fname,ucse.lname as cse_lname,
		ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
		csef.date as cse_call_date,csef.created_time as cse_call_time,csef.contactibility as cse_contactibility,csef.comment as cse_remark,csef.nextfollowupdate as cse_nfd , csef.nextfollowuptime as cse_nft');
	
		}else{
		$this -> db -> select('l.enq_id,l.name,l.email,l.contact_no,l.alternate_contact_no,l.address,l.feedbackStatus,l.nextAction,l.eagerness,
		l.service_type,l.service_center,l.km,l.pick_up_date,l.pickup_required,l.buyer_type,
		l.bank_name,l.loan_type,l.reg_no,l.roi,l.los_no,l.tenure,l.loanamount,l.dealer,l.assign_by_cse_tl,l.assign_to_cse,assign_to_dse_tl , l.assign_to_dse, 
		
		udse.fname as dse_fname,udse.lname as dse_lname,
		udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,
		dsef.date as dse_call_date,dsef.comment as dse_remark,dsef.nextfollowupdate as dse_nfd , dsef.nextfollowuptime as dse_nft,
	
		ucse.fname as cse_fname,ucse.lname as cse_lname,
		ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,
		csef.date as cse_call_date,csef.comment as cse_remark,csef.nextfollowupdate as cse_nfd , csef.nextfollowuptime as cse_nft,m.model_name');
	
			
			}
		$this -> db -> from($table['lead_master'].' l');
		$this -> db -> join($table['lead_followup'].' csef', 'csef.id=l.cse_followup_id', 'left');
		$this -> db -> join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this -> db -> join('lmsuser ucsetl', 'ucsetl.id=l.assign_by_cse_tl', 'left');
		if($process_id == 8){
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_e_exe', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_e_tl ', 'left');
			$this -> db -> join('model_variant v1', 'v1.variant_id=l.old_variant', 'left');
			if($sub_poc_purchase==2){
				$this -> db -> join($table['lead_followup'].' dsef', 'dsef.id=l.tracking_followup_id', 'left');	
				$this -> db -> where('l.nextAction_for_tracking ', 'Evaluation Done');
			}else{
				$this -> db -> join($table['lead_followup'].' dsef', 'dsef.id=l.exe_followup_id', 'left');
			}	
		
			
			$this -> db -> where('l.evaluation ', 'Yes');
		}else{
			$this -> db -> join($table['lead_followup'].' dsef', 'dsef.id=l.dse_followup_id', 'left');
			$this -> db -> join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
			$this -> db -> join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		}
		$this -> db -> join('make_models m', 'm.model_id=l.model_id', 'left');
		$this -> db -> join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this -> db -> join('makes m2', 'm2.make_id=l.old_make', 'left');
		$this -> db -> join('make_models m1', 'm1.model_id=l.old_model', 'left');		
		$this -> db -> join('makes bm1', 'bm1.make_id=l.buy_make', 'left');
		$this -> db -> join('make_models bm2', 'bm2.model_id=l.buy_model', 'left');
		//$this -> db -> join('tbl_status s', 's.status_id=l.status', 'left');
		$this -> db -> where('l.enq_id', $id);
		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();
	}

}