<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_cross_lead_model extends CI_model {
	function __construct() {
		parent::__construct();
		date_default_timezone_set("Asia/Kolkata");
		$this -> today = date('Y-m-d');
		$this -> time = date("h:i:s A");
	}

	public function select_status($process_id) {
		$status_query = $this -> db -> query("select nextActionName from tbl_add_default_close_lead_status where process_id='$process_id'") -> result();
		if (count($status_query) > 0) {
			$default_close_lead_status = $status_query[0] -> nextActionName;
			//echo $default_close_lead_status;
			$default_close_lead_status = json_decode($default_close_lead_status);

		}
		/*$a= array('default_close_lead_status'=>$default_close_lead_status) ;
		 print_r($a['default_close_lead_status']);*/
		return $default_close_lead_status;

	}

	public function select_status1($process) {
		$this -> db -> select('nextActionName');
		$this -> db -> from('tbl_add_default_close_lead_status');
		$this -> db -> where('process_id', $process);
		$query = $this -> db -> get();
		return $query -> result();
	}
public function lat_long() {
		$this -> db -> select('*');
		$this -> db -> from('tbl_late_long');
		$query = $this -> db -> get();
		return $query -> result();
	}
	public function select_table($process_id) {

		/*if($process_id=='0')
		 {
		 $selectelement='f1.comment as cse_comment,f1.date as cse_call_date,f1.nextfollowupdate as cse_nfd,
		 f2.comment as dse_comment,f2.date as dse_call_date,f2.nextfollowupdate as dse_nfd,
		 l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
		 l.cse_followup_id,l.exe_followup_id as ese_followup_id,l.lead_source,
		 l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time';
		 $selectelement='f1.comment as cse_comment,f1.date as cse_call_date,f1.nextfollowupdate as cse_nfd,
		 f2.comment as dse_comment,f2.date as dse_call_date,f2.nextfollowupdate as dse_nfd,
		 l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
		 l.cse_followup_id,l.exe_followup_id as dse_followup_id,l.lead_source,
		 l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time';
		 return array('selectelement' => $selectelement,'selectelement' => $selectelement);

		 }
		 else
		 {*/
		if ($process_id == 6 || $process_id == 7) {

			$lead_master = 'lead_master';
			$lead_followup = 'lead_followup';
			$request_to_lead_transfer = 'request_to_lead_transfer';
			$tbl_manager_remark = 'tbl_manager_remark';
			$selectelement = 'f1.comment as cse_comment,f1.date as cse_call_date,f1.nextfollowupdate as cse_nfd,
			f2.comment as dse_comment,f2.date as dse_call_date,f2.nextfollowupdate as dse_nfd,
			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
			l.cse_followup_id,l.dse_followup_id,l.lead_source,
			l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time';
		} elseif ($process_id == 8) {
			$lead_master = 'lead_master_evaluation';
			$lead_followup = 'lead_followup_evaluation';
			$request_to_lead_transfer = 'request_to_lead_transfer_evaluation';
			$tbl_manager_remark = 'tbl_manager_remark_evaluation';
			$selectelement = 'f1.comment as cse_comment,f1.date as cse_call_date,f1.nextfollowupdate as cse_nfd,
			f2.comment as dse_comment,f2.date as dse_call_date,f2.nextfollowupdate as dse_nfd,
			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
			l.cse_followup_id,l.exe_followup_id as dse_followup_id,l.lead_source,
			l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time';
		} else {

			$lead_master = 'lead_master_all';
			$lead_followup = 'lead_followup_all';
			$request_to_lead_transfer = 'request_to_lead_transfer_all';
			$tbl_manager_remark = 'tbl_manager_remark_all';
			$selectelement = 'f1.comment as cse_comment,f1.date as cse_call_date,f1.nextfollowupdate as cse_nfd,
			f2.comment as dse_comment,f2.date as dse_call_date,f2.nextfollowupdate as dse_nfd,
			l.process,l.nextAction,l.feedbackStatus,l.days60_booking,
			l.cse_followup_id,l.dse_followup_id,l.lead_source,
			l.enq_id,name,l.email,contact_no,enquiry_for,l.created_date,l.created_time';
		}

		return array('tbl_manager_remark' => $tbl_manager_remark, 'selectelement' => $selectelement, 'lead_master' => $lead_master, 'lead_followup' => $lead_followup, 'request_to_lead_transfer' => $request_to_lead_transfer);
		//}
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
			if (count($query) > 3) {
				$response["success"] = 0;
				$response["message"] = "Todays OTP quota is finished.Try again after 12 AM";
				$response["otp"] = "NULL";
				echo json_encode($response);
			} else {

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

				$msg = $code . ' is Your SECRET One Time Password (OTP) for LMS Registration';

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
				curl_close($ch);

				$response["success"] = 1;
				$response["message"] = "OTP Sent Successfully...!";
				$response["otp"] = $code;
				echo json_encode($response);
				//return ;
			}
		}
	}

	public function maxEmpId() {
		$this -> db -> select_max('empId');
		$this -> db -> from('lmsuser');
		//	$this -> db -> where('empId','');
		$query = $this -> db -> get();
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

	public function add_cross_lead() {
		$process_id = $this -> input -> post('process_id');
		$user_id = $this -> input -> post('user_id');
		$lead_source = 'Cross Lead';
		$fname = $this -> input -> post('fname');
		$email = $this -> input -> post('email');
		$address = $this -> input -> post('address');
		$pnum = $this -> input -> post('pnum');
		$comment = $this -> input -> post('comment');
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

			$this -> session -> set_flashdata('message', '<div class="alert alert-success"><strong> Customer Added Successfully ...!</strong>	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>	</div>');

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
		$process_id = '5';
		$table = $this -> select_table($process_id);

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

	public function get_rights_cross_lead($id) {
		$this -> db -> select('user_id,form_name,view');
		$this -> db -> from('tbl_rights_cross_lead');
		$this -> db -> where('user_id', $id);
		$query = $this -> db -> get();
		return $query -> result();
	}

	public function cl_dashboard_count($user_id) {

		$live_lead = $this -> live_leads($user_id);
		$converted_lead = $this -> converted_leads($user_id);
		$lost_lead = $this -> lost_leads($user_id);
		$total_leads = $this -> total_leads($user_id);
		$t = $total_leads[0] -> all_count;
		$cl = $converted_lead[0] -> all_count;
		$ll = $lost_lead[0] -> all_count;
		$lil = $live_lead[0] -> all_count;
		$select_data[] = array('user_id' => $user_id, 'total_leads' => $t, 'converted_lead' => $cl, 'lost_leads' => $ll, 'live_lead' => $lil);
		return $select_data;

	}

	public function total_leads($user_id) {

		$q = $this -> db -> query("select 
		 ( select count(enq_id) from lead_master where  cross_lead_user_id='$user_id' )
		+ 
		 ( select count(enq_id) from lead_master_evaluation where cross_lead_user_id='$user_id') 
		 + 
		 ( select count(enq_id) from lead_master_all where cross_lead_user_id='$user_id')
		as 
		   all_count
		from 
		   dual") -> result();
		return $q;
	}

	public function live_leads($user_id) {
		/*$table1 = $this -> select_status(6);
		 //print_r($table1);
		 $a=array_values($table1);
		 print_r($a);*/

		$q = $this -> db -> query("select 
		 ( select count(enq_id) from lead_master where  cross_lead_user_id='$user_id' and nextaction !='Close' and nextaction !='Booked From Autovista' )
		+ 
		 ( select count(enq_id) from lead_master_evaluation where cross_lead_user_id='$user_id' and nextaction !='Close' and nextaction !='Booked From Autovista') 
		 + 
		 ( select count(enq_id) from lead_master_all where cross_lead_user_id='$user_id' and nextaction !='Close' and nextaction !='Booked From Autovista')
		as 
		   all_count
		from 
		   dual");
		// echo $this->db->last_query();
		$q = $q -> result();
		return $q;
	}

	public function converted_leads($user_id) {

		$q = $this -> db -> query("select 
		 ( select count(enq_id) from lead_master where  cross_lead_user_id='$user_id' and nextaction='Booked From Autovista')
		+ 
		 ( select count(enq_id) from lead_master_evaluation where cross_lead_user_id='$user_id' and nextaction='Booked From Autovista') 
		 + 
		 ( select count(enq_id) from lead_master_all where cross_lead_user_id='$user_id' and nextaction='Booked From Autovista')
		as 
		   all_count
		from 
		   dual") -> result();
		return $q;
	}

	public function lost_leads($user_id) {

		$q = $this -> db -> query("select 
		 ( select count(enq_id) from lead_master where  cross_lead_user_id='$user_id' and nextaction='Close')
		+ 
		 ( select count(enq_id) from lead_master_evaluation where cross_lead_user_id='$user_id' and nextaction='Close') 
		 + 
		 ( select count(enq_id) from lead_master_all where cross_lead_user_id='$user_id' and nextaction='Close')
		as 
		   all_count
		from 
		   dual") -> result();
		return $q;
	}

	public function cl_dashboard_converted_leads($user_id) {
		$process_id = '5';
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
		$this -> db -> from('lead_master l');
		$this -> db -> join('lead_followup f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lead_followup f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> where('l.nextaction', 'Booked From Autovista');
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
		$this -> db -> where('l.nextaction', 'Booked From Autovista');
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
		$this -> db -> where('l.nextaction', 'Booked From Autovista');
		$this -> db -> where('cross_lead_user_id', $user_id);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$query3 = $this -> db -> get() -> result();

		return $query = array_merge($query1, $query2, $query3);
	}

	public function cl_dashboard_lost_leads($user_id) {
		$process_id = '5';
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
		$this -> db -> from('lead_master l');
		$this -> db -> join('lead_followup f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lead_followup f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> where('l.nextaction', 'Close');
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
		$this -> db -> where('l.nextaction', 'Close');
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
		$this -> db -> where('l.nextaction', 'Close');
		$this -> db -> where('cross_lead_user_id', $user_id);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$query3 = $this -> db -> get() -> result();

		return $query = array_merge($query1, $query2, $query3);
	}

	public function cl_dashboard_live_leads($user_id) {
		$process_id = '5';
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
		$this -> db -> from('lead_master l');
		$this -> db -> join('lead_followup f1', 'f1.id=l.cse_followup_id', 'left');
		$this -> db -> join('lead_followup f2', 'f2.id=l.dse_followup_id', 'left');
		$this -> db -> where('l.nextaction !=', 'Close');
		$this -> db -> where('l.nextaction!=', 'Booked From Autovista');
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
		$this -> db -> where('l.nextaction !=', 'Close');
		$this -> db -> where('l.nextaction!=', 'Booked From Autovista');
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
		$this -> db -> where('l.nextaction !=', 'Close');
		$this -> db -> where('l.nextaction!=', 'Booked From Autovista');
		$this -> db -> where('cross_lead_user_id', $user_id);
		$this -> db -> group_by('l.enq_id');
		$this -> db -> order_by('l.enq_id', 'desc');
		$query3 = $this -> db -> get() -> result();

		return $query = array_merge($query1, $query2, $query3);
	}

	public function check_incentive_offer($process, $scheme_name) {
		$this -> db -> select('*');
		$this -> db -> from('tbl_incentive_scheme');
		if ($process != '') {
			$this -> db -> where('process_name', $process);
		}
		if ($scheme_name != '') {
			$this -> db -> where('scheme_name', $scheme_name);
		}
		$this -> db -> where('status', '1');
		$query = $this -> db -> get();
		return $query -> result();
	}

	function get_app_version() {
		$this -> db -> select('*');
		$this -> db -> from('tbl_cross_lead_app_version');
		$query = $this -> db -> get();
		return $query -> result();
	}

	function slider_image() {

		$this -> db -> select('process,image_name,icon_image');
		$this -> db -> from('tbl_app_slider');
		$this -> db -> where('status', 1);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function get_today_winner() {
		$today = date('Y-m-d');
		$this -> db -> select('i.incentive_type,i.commission_amount,i.approved_status,i.approved_date,s.process_name,s.scheme_name,l.fname,l.lname');
		$this -> db -> from('tbl_lead_incentive i');
		$this -> db -> join('lmsuser l', 'l.id=i.user_id');
		$this -> db -> join('tbl_incentive_scheme s', 's.id=i.incentive_scheme_id');
		$this -> db -> where('i.approved_status', 1);
		$this -> db -> order_by('i.approved_date');
		$this -> db -> limit('10');
		$query = $this -> db -> get();
		return $query -> result();
	}

	public function insert_lead_incentive_details() {
		$lead_id = $this -> input -> post('lead_id');
		$incentive_scheme_id = $this -> input -> post('incentive_scheme_id');
		$user_id = $this -> input -> post('user_id');
		$commission_type = $this -> input -> post('commission_type');
		$payout_cycle = $this -> input -> post('payout_cycle');
		$incentive_type = $this -> input -> post('incentive_type');
		$commission_amount = $this -> input -> post('commission_amount');
		$remark = $this -> input -> post('remark');
		$today = date('Y-m-d');

		$this -> db -> query("INSERT INTO `tbl_lead_incentive`
	(`lead_id`, `incentive_scheme_id`, `user_id`, `commission_type`, `payout_cycle`, `incentive_type`, `commission_amount`, `remark`, `created_date`) 
	VALUES ('$lead_id',$incentive_scheme_id,'$user_id','$commission_type','$payout_cycle','$incentive_type','$commission_amount','$remark','$today') ");
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

	function bank_list() {

		$this -> db -> select('*');
		$this -> db -> from('tbl_bank');
		$this -> db -> where('status', 1);
		$this -> db -> order_by('bank_id', 'asc');
		$query = $this -> db -> get();
		return $query -> result();

	}

	function total_earning() {
		$user_id = $this -> input -> post('user_id');
		//$today=date('Y-m-d');
		$this -> db -> select('sum(commission_amount) as total_earning1');
		$this -> db -> from('tbl_lead_incentive i');
		$this -> db -> where('i.user_id', $user_id);
		$this -> db -> where('i.approved_status', 1);
		$query = $this -> db -> get() -> result();
		$totale = $query[0] -> total_earning1;
		$this -> db -> select('sum(commission_amount) as pending');
		$this -> db -> from('tbl_lead_incentive i');
		$this -> db -> where('i.user_id', $user_id);
		$this -> db -> where('i.approved_status', 0);
		$query1 = $this -> db -> get() -> result();
		$pending = $query1[0] -> pending;

		$select_leads[] = array('total' => $totale, 'pending' => $pending, 'user_id' => $user_id);
		return $select_leads;

	}

	public function insert_user_details() {
		$payment_mode = $this -> input -> post('payment_mode');
		$user_name_bankwise = $this -> input -> post('user_name_bankwise');
		$user_id = $this -> input -> post('user_id');
		$paytm_no = $this -> input -> post('paytm_no');
		$paytm_name = $this -> input -> post('paytm_name');
		$upi_name = $this -> input -> post('upi');
		$bank_name = $this -> input -> post('bank_name');
		$acc_no = $this -> input -> post('acc_no');
		$ifsc = $this -> input -> post('ifsc');
		$today = date('Y-m-d');
		$q = $this -> db -> query("select * from tbl_cross_lead_user_detail where user_id='$user_id'") -> result();
		if (count($q) > 0) {
			$this -> db -> query("UPDATE `tbl_cross_lead_user_detail` set payment_mode='$payment_mode', payment_mode='$payment_mode',
		user_name_bankwise='$user_name_bankwise',	payment_mode='$payment_mode',	paytm_no='$paytm_no',		paytm_name='$paytm_name',
		upi='$upi_name',		bank_name='$bank_name',		acc_no='$acc_no', ifsc='$ifsc', updated_date='$today' where user_id='$user_id'");
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
		} else {
			$this -> db -> query("INSERT INTO `tbl_cross_lead_user_detail`
			(`payment_mode`, `user_name_bankwise`, `user_id`, `paytm_no`, `paytm_name`, `upi`, `bank_name`, `acc_no`, `updated_date`,ifsc) 
	VALUES ('$payment_mode','$user_name_bankwise','$user_id','$paytm_no','$paytm_name','$upi_name','$bank_name','$acc_no','$today','$ifsc') ");
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

	function payment_details() {
		$user_id = $this -> input -> post('user_id');
		$this -> db -> select('*');
		$this -> db -> from('tbl_cross_lead_user_detail');
		$this -> db -> where('user_id', $user_id);
		//$this -> db -> where('status', 1);
		$query = $this -> db -> get();
		return $query -> result();

	}

	function wallet_count() {
		$user_id = $this -> input -> post('user_id');
		//$today=date('Y-m-d');
		$this -> db -> select('sum(commission_amount) as total_earning1');
		$this -> db -> from('tbl_lead_incentive i');
		$this -> db -> where('i.user_id', $user_id);
		$this -> db -> where('i.approved_status', 1);
		$query = $this -> db -> get() -> result();
		$totale = $query[0] -> total_earning1;

		$this -> db -> select('sum(claim_amount) as claim_amount');
		$this -> db -> from('tbl_incentive_claim i');
		$this -> db -> where('i.user_id', $user_id);
		$this -> db -> where('i.status', 1);
		$query1 = $this -> db -> get() -> result();
		$claim_amount = $query1[0] -> claim_amount;
		$wallet = $totale - $claim_amount;
		$select_leads[] = array('claim_amount' => $claim_amount, 'wallet' => $wallet, 'user_id' => $user_id);
		return $select_leads;

	}

	function claim_history() {
		$user_id = $this -> input -> post('user_id');
		$this -> db -> select('*');
		$this -> db -> from('tbl_incentive_claim');
		$this -> db -> where('user_id', $user_id);
		//$this -> db -> where('status', 1);
		$query = $this -> db -> get();
		return $query -> result();

	}

	public function login_form($username, $password) {
		//$order=" FIELD(p.process_id,'6', '7','8', '1', '4', '5','9')";
		$this -> db -> select('role,role_name,id,fname,lname,p1.process_id,p1.process_name,p.location_id as location_id,l.location');
		$this -> db -> from('lmsuser u');

		$this -> db -> join('tbl_manager_process p', 'p.user_id=u.id', 'left');
		$this -> db -> join('tbl_process p1', 'p1.process_id=p.process_id', 'left');

		$this -> db -> join('tbl_location l', 'l.location_id=p.location_id', 'left');
		$t = "(email='$username' || mobileno='$username')";
		$this -> db -> where($t);
		$this -> db -> where('password', $password);
		$this -> db -> where('u.status', 1);
		$this -> db -> where('u.role', '17');
		//$this->db->order_by($order);
		$this -> db -> limit(1);

		$query = $this -> db -> get();
		//echo $this->db->last_query();
		return $query -> result();

	}

	public function forgot_password_otp() {
		$today = $this -> today;
		$moblie_number = $this -> input -> post('moblie_no');
		$q1 = $this -> db -> query("select mobileno from lmsuser where mobileno='$moblie_number'") -> result();
		if (count($q1) > 0) {

			$query = $this -> db -> query("select * from mobile_numbers where mobile_number='$moblie_number' and date='$today'") -> result();
			if (count($query) > 3) {
				$response["success"] = 0;
				$response["message"] = "Todays OTP quota is finished.Try again after 12 AM";
				$response["otp"] = "NULL";
				echo json_encode($response);
			} else {

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

				$msg = $code . ' is Your SECRET One Time Password (OTP) for Forget Password';

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
				curl_close($ch);

				$response["success"] = 1;
				$response["message"] = "OTP Sent Successfully...!";
				$response["otp"] = $code;
				echo json_encode($response);
				//return ;
			}

		} else {

			$response["success"] = 0;
			$response["message"] = "This Contact No is Not Registred ...!";
			$response["otp"] = "NULL";
			echo json_encode($response);
		}
	}

	public function forgot_pwd($email) {
		$generated_otp = $this -> input -> post('generated_otp');
		$customer_otp = $this -> input -> post('customer_otp');
		$password = $this -> input -> post('password');

		if ($generated_otp == $customer_otp) {
			$this -> db -> select('*');
			$this -> db -> from('lmsuser');
			$t = "(email='$email' || mobileno='$email')";
			$this -> db -> where($t);
			$this -> db -> where('status', 1);
			$this -> db -> where('role', '17');
			$query = $this -> db -> get() -> result();

			//print_r($query);
			if (count($query) > 0) {

				/*$email1=$query[0]->email;
				 $fname=$query[0]->fname;*/
				$id = $query[0] -> id;
				$this -> db -> query('update lmsuser set password="' . $password . '" where id="' . $id . '"');
				$response["success"] = 1;
				$response["message"] = "Password Successfully Updated.";
				// echoing JSON response
				echo json_encode($response);

			} else {

				$response["success"] = 0;
				$response["message"] = "Please Enter Registered Mobile No.";
				// echoing JSON response
				echo json_encode($response);

			}
		} else {
			$response["success"] = 0;
			$response["message"] = "Please Enter Correct OTP.";
			// echoing JSON response
			echo json_encode($response);
		}

	}

	public function insert_incentive_claim() {
		$user_id = $this -> input -> post('user_id');
		$payment_mode = $this -> input -> post('payment_mode');
		$user_name_bankwise = $this -> input -> post('user_name_bankwise');

		$paytm_no = $this -> input -> post('paytm_no');
		$upi_name = $this -> input -> post('upi');
		$bank_name = $this -> input -> post('bank_name');
		$acc_no = $this -> input -> post('acc_no');
		$ifsc = $this -> input -> post('ifsc');
		$claim_amount = $this -> input -> post('claim_amount');
		$today = date('Y-m-d');

		$this -> db -> query("INSERT INTO `tbl_incentive_claim`
			(`payment_mode`, `user_name_bankwise`, `user_id`, `paytm_no`, `upi`, `bank_name`, `acc_no`, `claim_created_date`,ifsc,claim_amount) 
	VALUES ('$payment_mode','$user_name_bankwise','$user_id','$paytm_no','$upi_name','$bank_name','$acc_no','$today','$ifsc','$claim_amount') ");

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

	public function send_notification($tokens, $msg) {
		//push notification
		$ch = curl_init("https://fcm.googleapis.com/fcm/send");
		$header = array('Content-Type: application/json', "Authorization: key=AIzaSyDUmFCBePTTQ2tS2Y0Hzzo9FrOY9dVVe-A");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//$tokens='AAAAPCYSOXM:APA91bGDCVNARh3dwbZZsVtJJwEI0Pm1MaG21rXiezO_4Rm6I7AA_IKn81sCK7YYXqv8PU6w7_pU85OK6ziATByO9ioGCg5yz5caQtDN_ZcWYlVWKGgcCI8wKaCbiqEO5EaqQEPppMBU';

		$token = json_encode($tokens);
		//$msg='New lead Assigned from LMS';
		$msg = json_encode($msg);

		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{ \"notification\": {\"title\": \"LMS autovista.in\", \"text\":$msg}, \"to\" :$token }");
		//finally executing the curl request
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}
		//Now close the connection
		curl_close($ch);

		//and return the result
		//return $result;
	}

	function date_filter() {

		$m = date('m');
		$y = date('Y');
		$effectiveDate = date('Y-m-d');
		$date1 = mktime(0, 0, 0, 3, 0, 2019);
		// m d y, use 0 for day
		$date2 = mktime(0, 0, 0, $m, 0, $y);
		// m d y, use 0 for day

		$diff = round(($date2 - $date1) / 60 / 60 / 24 / 30);

		$diff1 = 0;
		$a = array();
		for ($i = 0; $i < $diff; $i++) {

			$effectiveDate1 = date('Y-M', strtotime("-" . $diff1 . " months", strtotime($effectiveDate)));
			$t['date'] = $effectiveDate1;
			array_push($a, $effectiveDate1);
			$diff1 = $diff1 + 1;
		}
		//$select_leads[] = array('total' => $totale, 'pending' => $pending, 'user_id' => $user_id);
		//print_r($a);
		return $a;
		//$select_leads[] = array('claim_amount' => '500', 'wallet' => '100', 'user_id' => '200');
		//print_r($select_leads);
		//return $select_leads;

	}

}
?>