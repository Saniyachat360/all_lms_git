<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Add_followup_new_car_model extends CI_model
{
	function __construct()
	{
		parent::__construct();
		$this->process_id = $_SESSION['process_id'];
		$this->location_id = $_SESSION['location_id'];
		$this->role = $this->session->userdata('role');
		$this->user_id = $this->session->userdata('user_id');
		$this->executive_array = array("4", "8", "10", "12", "14");
		$this->all_array = array("2", "3", "8", "7", "9", "11", "13", "10", "12", "14", "16");
		$this->tl_array = array("2", "5", "7", "9", "11", "13", "15");
		$this->tl_list = '("2","5", "7", "9", "11", "13","15")';
	}

	//Select feedbackstatus
	function select_feedback_status()
	{

		//$this->db->distinct();
		$this->db->select('feedbackStatusName');
		$this->db->from('tbl_feedback_status');
		$this->db->where('process_id', $this->process_id);
		$this->db->where('fstatus!=', 'Deactive');
		$query = $this->db->get();
		return $query->result();
	}

	//Map Nextaction and Feedbackstatus
	public function select_next_action()
	{
		$feedback = $this->input->post('feedback');
		$this->db->select('feedbackStatusName,nextActionName');
		$this->db->from('tbl_mapNextAction');
		$this->db->where('feedbackStatusName', $feedback);
		$this->db->where('map_next_to_feed_status!=', 'Deactive');
		$this->db->where('process_id', $_SESSION['process_id']);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	//Select Nextaction Status
	function next_action_status()
	{
		//$this->db->distinct();
		$this->db->select('nextActionName');
		$this->db->from('tbl_nextaction');
		$this->db->where('process_id', $this->process_id);
		$this->db->where('nextActionstatus!=', 'Deactive');
		$query = $this->db->get();
		return $query->result();
	}
	//Select process
	function process()
	{
		//$this->db->distinct();
		$this->db->select('*');
		$this->db->from('tbl_process');
		//$this -> db -> where('nextActionstatus!=', 'Deactive');
		$query = $this->db->get();
		return $query->result();
	}

	//Select Model
	function make_models()
	{
		$this->db->select('*');
		$this->db->from('make_models');
		$this->db->where('make_id', '1');
		$this -> db -> where('status', '1');
		$query = $this->db->get();
		return $query->result();
	}
	//select variant from model id
	function select_variant_main()
	{
		$this->db->select('*');
		$this->db->from('model_variant');
		//$this -> db -> where('is_active', '1');
		$query = $this->db->get();
		return $query->result();
	}
	//select variant from model id
	function select_variant($model)
	{
		$this->db->select('*');
		$this->db->from('model_variant');
		$this->db->where('model_id', $model);
		//$this -> db -> where('is_active', '1');
		$query = $this->db->get();
		return $query->result();
	}
	// Transfer lead location
	function select_transfer_location($tprocess)
	{
		$this->db->select('l.*');
		$this->db->from('tbl_location l');
		$this->db->join('tbl_map_process p', 'p.location_id=l.location_id');
		$this->db->where('process_id', $tprocess);
		$this->db->where('p.status !=', '-1');
		$this->db->where('l.location_status !=', 'Deactive');
		$query = $this->db->get();
		return $query->result();
	}
	//Select lms user
	function lmsuser($location, $tprocess)
	{
		$toLocation = $location;
		$cctprocess = explode("#", $tprocess);
		$tprocess = $cctprocess[0];
		$tprocess_name = $cctprocess[1];
		$from_user_role = $this->role;
		$fromUser = $this->user_id;
		$this->db->select('id,fname,lname');
		$this->db->from('lmsuser l');
		$this->db->join('tbl_manager_process u', 'u.user_id=l.id');
		$this->db->join('tbl_rights r', 'r.user_id=l.id');
		$this->db->join('tbl_location l1', 'l1.location_id=u.location_id', 'left');
		$this->db->where('r.form_name', 'Calling Notification');
		$this->db->where('r.view', '1');
		/*if($from_user_role==3)*/
		if ($tprocess == $this->process_id) {

			if ($from_user_role == 1 || $from_user_role == 2 || $from_user_role == 3) {
				//echo"1";
				$tl_array = array("2", "3", "5", "4", "7", "9", "11", "13", "15");
				$this->db->where_in('role', $tl_array);
				//$k="(role=3 or role IN ('2','5', '7', '9', '11', '13'))";
				//$this -> db -> where($k);
			} elseif (in_array($from_user_role, $this->tl_array)) {
				$q = $this->db->query('select dse_id from tbl_mapdse where tl_id="' . $fromUser . '"')->result();

				$c = count($q);
				$t = ' ( ';
				if (count($q) > 0) {

					for ($i = 0; $i < $c; $i++) {

						$t = $t . "id = " . $q[$i]->dse_id . " or ";
					}
				}
				$t = $t . "role in" . $this->tl_list;
				$st = $t . ')';

				$this->db->where($st);
			} elseif (in_array($from_user_role, $this->executive_array)) {
				//echo"2";
				$q1 = $this->db->query('select tl_id from tbl_mapdse where dse_id="' . $fromUser . '"')->result();

				if (count($q1) > 0) {

					$q = $this->db->query('select dse_id from tbl_mapdse where tl_id="' . $q1[0]->tl_id . '"')->result();
					$c = count($q);
					$t = ' ( ';
					if (count($q) > 0) {

						for ($i = 0; $i < $c; $i++) {

							$t = $t . "id = " . $q[$i]->dse_id . " or ";
						}
					}
					$t = $t . "role in" . $this->tl_list;
					$st = $t . ')';

					$this->db->where($st);
				} else {
					$t = $t . "role in" . $this->tl_list;
				}
			}
		} else {
			if ($from_user_role == 1 || $from_user_role == 2 || $from_user_role == 3) {
				//echo"3";

				$tl_array = array("2", "3", "5", "4", "7", "9", "11", "13", "15");
				$this->db->where_in('role', $tl_array);
				//$k="(role=3 or role IN ('2','5', '7', '9', '11', '13'))";
				//$this -> db -> where($k);w
			} elseif (in_array($from_user_role, $this->tl_array)) {

				$t = ' ( ';

				$t = $t . "role in" . $this->tl_list;
				$st = $t . ')';

				$this->db->where($st);
			} elseif (in_array($from_user_role, $this->executive_array)) {
				//	echo"4";
				$q1 = $this->db->query('select tl_id from tbl_mapdse where dse_id="' . $fromUser . '"')->result();

				if (count($q1) > 0) {
					$t = ' ( ';

					$t = $t . "role in" . $this->tl_list;
					$st = $t . ')';

					$this->db->where($st);
				} else {
					$t = $t . "role in" . $this->tl_list;
					$this->db->where($t);
				}
			}
		}
		//$this -> db -> where_in('role',$this->tl_array);
		$this->db->where('l.status', '1');
		$this->db->where('role !=', '1');
		$this->db->where('l.id !=', $this->user_id);
		$this->db->where('u.process_id', $tprocess);
		$this->db->where('l1.location', $toLocation);
		$this->db->group_by("l.id");
		$this->db->order_by("fname", "asc");
		$query = $this->db->get();

		//echo $this -> db -> last_query();
		return $query->result();
	}
	//Select lms user
	function lmsuser1($location, $tprocess)
	{
		$toLocation = $location;

		$from_user_role = $this->role;
		$fromUser = $this->user_id;
		$this->db->select('id,fname,lname');
		$this->db->from('lmsuser l');
		$this->db->join('tbl_manager_process u', 'u.user_id=l.id');
		$this->db->join('tbl_rights r', 'r.user_id=l.id');
		$this->db->join('tbl_location l1', 'l1.location_id=u.location_id', 'left');
		$this->db->where('r.form_name', 'Calling Notification');
		$this->db->where('r.view', '1');
		/*if($from_user_role==3)*/
		if ($tprocess == $this->process_id) {

			if ($from_user_role == 1 || $from_user_role == 2 || $from_user_role == 3) {
				//echo"1";
				$tl_array = array("2", "3", "5", "7", "9", "11", "13", "15");
				$this->db->where_in('role', $tl_array);
				//$k="(role=3 or role IN ('2','5', '7', '9', '11', '13'))";
				//$this -> db -> where($k);
			} elseif (in_array($from_user_role, $this->tl_array)) {
				$q = $this->db->query('select dse_id from tbl_mapdse where tl_id="' . $fromUser . '"')->result();

				$c = count($q);
				$t = ' ( ';
				if (count($q) > 0) {

					for ($i = 0; $i < $c; $i++) {

						$t = $t . "id = " . $q[$i]->dse_id . " or ";
					}
				}
				$t = $t . "role in" . $this->tl_list;
				$st = $t . ')';

				$this->db->where($st);
			} elseif (in_array($from_user_role, $this->executive_array)) {
				//echo"2";
				$q1 = $this->db->query('select tl_id from tbl_mapdse where dse_id="' . $fromUser . '"')->result();

				if (count($q1) > 0) {

					$q = $this->db->query('select dse_id from tbl_mapdse where tl_id="' . $q1[0]->tl_id . '"')->result();
					$c = count($q);
					$t = ' ( ';
					if (count($q) > 0) {

						for ($i = 0; $i < $c; $i++) {

							$t = $t . "id = " . $q[$i]->dse_id . " or ";
						}
					}
					$t = $t . "role in" . $this->tl_list;
					$st = $t . ')';

					$this->db->where($st);
				} else {
					$t = $t . "role in" . $this->tl_list;
				}
			}
		} else {
			if ($from_user_role == 1 || $from_user_role == 2 || $from_user_role == 3) {
				//echo"3";

				$tl_array = array("2", "5", "7", "9", "11", "13", "15");
				$this->db->where_in('role', $tl_array);
				//$k="(role=3 or role IN ('2','5', '7', '9', '11', '13'))";
				//$this -> db -> where($k);
			} elseif (in_array($from_user_role, $this->tl_array)) {

				$t = ' ( ';

				$t = $t . "role in" . $this->tl_list;
				$st = $t . ')';

				$this->db->where($st);
			} elseif (in_array($from_user_role, $this->executive_array)) {
				//	echo"4";
				$q1 = $this->db->query('select tl_id from tbl_mapdse where dse_id="' . $fromUser . '"')->result();

				if (count($q1) > 0) {
					$t = ' ( ';

					$t = $t . "role in" . $this->tl_list;
					$st = $t . ')';

					$this->db->where($st);
				} else {
					$t = $t . "role in" . $this->tl_list;
					$this->db->where($t);
				}
			}
		}
		//$this -> db -> where_in('role',$this->tl_array);
		$this->db->where('l.status', '1');
		$this->db->where('role !=', '1');
		$this->db->where('l.id !=', $this->user_id);
		$this->db->where('u.process_id', $tprocess);
		$this->db->where('l1.location', $toLocation);
		$this->db->group_by("l.id");
		$this->db->order_by("fname", "asc");
		$query = $this->db->get();
		//echo $this -> db -> last_query();
		return $query->result();
	}
	//Select All Lead Data
	public function select_lead($enq_id)
	{
		$this->db->select('
		u.fname,u.lname,
		v.variant_id,v.variant_name,
		m.model_id as new_model_id,m.model_name as new_model_name,
		m1.model_name as old_model_name,l.process,l.followup_fuel_type,l.followup_stock,
		l.enq_id,name,l.email,l.address,l.alternate_contact_no,l.dms_enq_number,l.contact_no,l.transfer_process	,l.comment,enquiry_for,l.created_date,l.created_time,l.location,l.eagerness,l.days60_booking,l.buyer_type,l.color,l.km,l.manf_year,l.accidental_claim,l.ownership,l.old_make,l.old_model,l.assign_to_dse_tl,
		f.id as followup_id,f.activity,f.date as c_date,f.contactibility,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime,f.visit_location,f.visit_booked,f.visit_status,f.visit_booked_date,f.sale_status,f.car_delivered,
		f.td_hv_date,f.feedbackStatus,f.nextAction,l.appointment_type,l.appointment_status,l.appointment_date,f.appointment_rating,f.appointment_time,f.appointment_feedback,f.appointment_address,l.customer_occupation,l.customer_designation,l.customer_corporate_name,l.interested_in_finance,l.interested_in_accessories,l.interested_in_insurance,l.interested_in_ew,l.esc_level1 ,l.esc_level1_remark,l.esc_level2 ,l.esc_level2_remark ,l.esc_level3 ,esc_level3_remark,l.evaluation_location,
		esc_level1_resolved ,esc_level2_resolved,esc_level3_resolved,esc_level1_resolved_remark ,esc_level2_resolved_remark ,esc_level3_resolved_remark ');
		$this->db->from('lead_master l');
		$this->db->join('make_models m', 'm.model_id=l.model_id', 'left');
		$this->db->join('model_variant v', 'v.variant_id=l.variant_id', 'left');
		$this->db->join('make_models m1', 'm1.model_id=l.old_model', 'left');
		if ($_SESSION['role'] == '3' || $_SESSION['role'] == '2' || $_SESSION['role'] == '1') {
			$this->db->join('lead_followup f', 'f.id=l.cse_followup_id', 'left');
		} else {
			$this->db->join('lead_followup f', 'f.id=l.dse_followup_id', 'left');
		}
		$this->db->join('lmsuser u', 'u.id=f.assign_to', 'left');
		$this->db->where('l.enq_id', $enq_id);

		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function select_brochure($model)
	{
		$this->db->select('brochure,model_name');
		$this->db->from('make_models');
		$this->db->where('model_id', $model);
		$query = $this->db->get();
		return $query->result();
	}
	public function send_sms($contactibility, $contact_no)
	{
		//$contactibility = $this -> input -> post('contactibility');
		$q = $this->db->query("select fname,mobileno from lmsuser where id='$this->user_id'")->result();
		if (count($q) > 0) {
			if ($contactibility == 'Connected') {

				$msg = 'Hello, Thank you for your enquiry with Autovista Group. In case of any queries, Please contact ' . $q[0]->fname . ' on ' . $q[0]->mobileno . ' or visit our website www.autovista.in';
			} elseif ($contactibility == 'Not Connected') {
				$msg = 'Hello Greetings from Autovista Group. We are unable to reach you on your number at the moment. In case of any queries, Please contact ' . $q[0]->fname . ' on ' . $q[0]->mobileno . ' or visit our website www.autovista.in';
			}

			//request parameters array
			$sendsms = ""; //initialize the sendsms variable
			$requestParams = array(
				'user' => 'atvsta',
				'password' => 'atvsta',
				'senderid' => 'ATVSTA',
				'channel' => 'Trans',
				'DCS' => '0',
				'flashsms' => '0',
				'route' => '46',
				'number' => $contact_no,
				'text' => $msg,
				'PEID' => '1601100000000001945'

			);

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

			/*$request = ""; //initialize the request variable
			$param["user"] = "autovista"; //this is the username of our TM4B account
			$param["password"] = "Autoapi@123"; //this is the password of our TM4B account			
			$param["text"] = $msg; //this is the message that we want to send
			$param["PhoneNumber"] = $contact_no; //these are the recipients of the message			
			$param["sender"] = "ATVSTA";//this is our sender 			
			foreach($param as $key=>$val) //traverse through each member of the param array
			{ 
			  $request.= $key."=".urlencode($val); //we have to urlencode the values
			  $request.= "&"; //append the ampersand (&) sign after each paramter/value pair
			}			
			$request = substr($request, 0, strlen($request)-1); //remove the final ampersand sign from the request			
			//First prepare the info that relates to the connection
			$host = "sms.fortunemicrosystem.com";
			$script = "/sendsms.asp";
			$request_length = strlen($request);
			$method = "POST"; // must be POST if sending multiple messages
			if ($method == "GET") 
			{
			  $script .= "?$request";
			}			
			//Now comes the header which we are going to post. 
			$header = "$method $script HTTP/1.1\r\n";
			$header .= "Host: $host\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Content-Length: $request_length\r\n";
			$header .= "Connection: close\r\n\r\n";
			$header .= "$request\r\n";
			
			//Now we open up the connection
			$socket = @fsockopen($host, 80, $errno, $errstr); 
			if ($socket) //if its open, then...
			{ 
			  fputs($socket, $header); // send the details over
			  while(!feof($socket))
			  {
			    $output[] = fgets($socket); //get the results 
			  }
			  fclose($socket); 
			} */
		}
	}
	
	
	// To send the whatsapp sms to the customer after the followup 
	public function whatsapp_sms($customer_name, $phone, $new_model, $rm_name)
	{
		if ($new_model != '') {
			$query = $this->db->query("select model_name from make_models where model_id='$new_model'")->result();
			$model_name = $query[0]->model_name;
		}
		
		if ($new_model == "") {
			$model_name = "Model Name";
		}
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://app.chat360.io/service/v1/task',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{
    		"task_name": "whatsapp_push_notification",
    		"extra": "",
    		"task_body": [
       			{
        	    "client_number": "919209402151",
				"receiver_number": "9175687700",
            	"template_data": {
                "template_id": "1de82d31-584e-4e64-867a-fa5b848578e0",
                "param_data": {
                    "Customer Name": "' . $customer_name . '",
                    "CSE": "' . $rm_name . '",
                    "Model Name1": "' . $model_name . '",
                    "Model Name2": "' . $model_name . '"},
					"button_param_data":{}
            				}
        		}
    		]
			}',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Api-Key sUszpKAL.BGzNy8EDrfdGUhFuJNwN2dzBOTOE3Jqb',
				'Content-Type: application/json',
				'Cookie: multidb_pin_writes=y'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
		print_r($response);
	}
	
	
	public function whatsapp_sms1($customer_name, $phone, $new_model, $rm_name, $trans_id)
	{
	   
		if ($new_model != '') {
			$query = $this->db->query("select model_name from make_models where model_id='$new_model'")->result();
			$model_name = $query[0]->model_name;
		}
		
		if ($new_model == "") {
			$model_name = "Maruti Car";
		}

		if ($trans_id != '') {
			$query = $this->db->query("select CONCAT(fname,' ',lname) as rmname, mobileno from lmsuser where id='$trans_id'")->result();
			$trs_rmname = $query[0]->rmname;
			$trs_rmphone = $query[0]->mobileno;
		}

		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => 'https://app.chat360.io/service/v1/task',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => '{
    		"task_name": "whatsapp_push_notification",
    		"extra": "",
    		"task_body": [
       			{
        	    "client_number": "919209402151",
				"receiver_number": "9175687700",
            	"template_data": {
                "template_id": "7bc0d6eb-a8d5-440b-a18f-1574be2ad92d",
                
                "param_data": {
                                "customer name":"'. $customer_name .'",
                                "CSE":"' . $rm_name . '",
                                "Model Name":"'. $model_name .'",
                                "Model name2":"'. $model_name .'",
                                "RM Name":"' . $trs_rmname . '",
                                "Rm Number":"' . $trs_rmphone . '"},
					"button_param_data":{}
            				}
        		}
    		]
			}',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Api-Key sUszpKAL.BGzNy8EDrfdGUhFuJNwN2dzBOTOE3Jqb',
				'Content-Type: application/json',
				'Cookie: multidb_pin_writes=y'
			),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		echo $response;
		print_r($response);
// 		die;
	}
	
// 	end whats app followup
	
	//send sms
	public function send_sms_calling_task($customer_name, $phone, $new_model, $username)
	{
		$fetch_model = $this->db->query("select model_name,model_id from make_models where model_id='" . $new_model . "'")->result();

		if ($new_model == '') {
			$model = 'Select Model';
		} else {
			$model = $fetch_model[0]->model_name;
		}
		$api_key = '46538D3A63198C';
		$contacts = $phone;
		$from = 'ATVSTA';
		$sms_text = urlencode('Dear ' . $customer_name . ', Thank you for Contacting With Autovista. Our ' . $username . ' Spoke to you on this Model ' . $model . ' . Book Your ' . $model . ' and Get Exiting Offers Only With Autovista Group. Visit Our Website To Book Online Visit: https://www.autovista.in/ For More Details Call On : 9209200071');
		$template_id = '1707169942759635212';
		$pe_id = '1601100000000001945';
		

		//Submit to server
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://dtsms.dialtext.com/app/smsapi/index.php");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&campaign=12150&routeid=101813&type=text&contacts=" . $contacts . "&senderid=" . $from . "&msg=" . $sms_text . "&template_id=" . $template_id . "&pe_id=" . $pe_id);
		$response = curl_exec($ch);
		curl_close($ch);
		echo $response;
	}
	
	
	
// 	//Insert Followup
	function insert_followup()
	{
		$today1 = date("Y-m-d");
		$time = date("h:i:s A");
		$enq_id = $this->input->post('booking_id');
		$old_data = $this->db->query("select name,dms_enq_number,contact_no,lead_source,enquiry_for,email,address,model_id,variant_id,buy_status,buyer_type,quotation_sent,evaluation_location,assign_by_cse_tl,assign_to_cse,assign_to_cse_date,assign_to_cse_time,transfer_process,edms_booking_id,visitor_number  from lead_master where enq_id='" . $enq_id . "'")->result();
		//print_r($old_data);
		//Basic Followup
		$name = $old_data[0]->name;
		$contact_no = $old_data[0]->contact_no;
		$lead_source = $old_data[0]->lead_source;
		$enquiry_for = $old_data[0]->enquiry_for;
		$dms_enq_number = $old_data[0]->dms_enq_number;
		$assign_to_telecaller = $_SESSION['user_id'];
		$alternate_contact = $this->input->post('alternate_contact');
		if ($this->input->post('activity') == '') {
			$activity = '';
		} else {
			$activity = $this->input->post('activity');
		}
		$contactibility = $this->input->post('contactibility');
		if ($contactibility == 'Connected' || $contactibility == 'Not Connected') {
			//$this->send_sms($contactibility,$contact_no);
		}


		$feedback = $this->input->post('feedback');
		$nextaction = $this->input->post('nextaction');

		$dms_enq_number = $this->input->post('dms_enq_number');
		if (!$dms_enq_number) {
			if ($old_data[0]->dms_enq_number != null) {
				$dms_enq_number = $old_data[0]->dms_enq_number;
			}
		}

		$email = $this->input->post('email');
		if (!$email) {
			if ($old_data[0]->email != null) {
				$email = $old_data[0]->email;
			}
		}
		$showroom_location = $this->input->post('showroom_location');
		$followupdate = $this->input->post('followupdate');
		$followuptime = $this->input->post('followuptime');
		if ($followupdate == '') {
			if ($nextaction == 'Close' || $nextaction == 'Booked From Autovista' || $nextaction == 'Lead Transfer') {
				$followupdate = '0000-00-00';
				$followuptime = '00:00:00';
			} else {
				$tomarrow_date = date('Y-m-d', strtotime(' +1 day'));

				$followupdate = $tomarrow_date;
				$followuptime = '11:00:00';
			}
		}

		/*if($contactibility=='Not Connected')
		{
			 if($nextaction=='Close' || $nextaction=='Booked From Autovista' || $nextaction=='Lead Transfer'){
		 	$followupdate='0000-00-00';
					$followuptime='00:00:00';
				 }else{
				 	$tomarrow_date = date('Y-m-d', strtotime(' +1 day'));
					
				 	$followupdate = $tomarrow_date;
					$followuptime='11:00:00 AM';
				 }				
		}*/
		$address1 = $this->input->post('address');
		if (!$address1) {

			$address1 = $old_data[0]->address;
		}
		$address = addslashes($address1);

		//New Car Details
		$new_model = $this->input->post('new_model');
		if (!$new_model) {
			$new_model = $old_data[0]->model_id;
		}
		$new_variant = $this->input->post('new_variant');
		if (!$new_variant) {
			$new_variant = $old_data[0]->variant_id;
		}
		$book_status = $this->input->post('book_status');
		if (!$book_status) {
			$book_status = $old_data[0]->buy_status;
		}
		$buyer_type = $this->input->post('buyer_type');
		if (!$buyer_type) {
			$buyer_type = $old_data[0]->buyer_type;
		}

		$comment1 = $this->input->post('comment');
		$comment = addslashes($comment1);

		//Exchange Car Details

		$old_make = $this->input->post('old_make');
		$old_model = $this->input->post('old_model');
		$color = $this->input->post('color');
		$ownership = $this->input->post('ownership');
		$mfg = $this->input->post('mfg');
		$km = $this->input->post('km');
		$claim = $this->input->post('claim');

		//Transfer Lead
		$assign_by = $_SESSION['user_id'];
		$assign = $this->input->post('transfer_assign');
		$tlocation = $this->input->post('tlocation');
		$transfer_reason = $this->input->post('transfer_reason');

		//>60 Days Booking
		$days60_booking = $this->input->post('days60_booking');


		//Showroom Location 
		if ($this->input->post('tlocation') != '') {
			$slocation = $this->input->post('tlocation');
		} else {
			$getlocation = $this->db->query("select location from lead_master where enq_id='$enq_id'")->result();
			if (count($getlocation) > 0) {
				$slocation = $getlocation[0]->location;
			} else {
				$slocation = '';
			}
		}

		//Appointment
		$appointment_type = $this->input->post('appointment_type');
		$appointment_date = $this->input->post('appointment_date');
		$appointment_time = $this->input->post('appointment_time');
		$appointment_status = $this->input->post('appointment_status');


		//interested In
		$interested_in_finance = $this->input->post('interested_in_finance');
		$interested_in_accessories = $this->input->post('interested_in_accessories');
		$interested_in_insurance = $this->input->post('interested_in_insurance');
		$interested_in_ew = $this->input->post('interested_in_ew');
		$customer_occupation = $this->input->post('customer_occupation');
		$customer_designation = $this->input->post('customer_designation');
		$customer_corporate_name = $this->input->post('customer_corporate_name');

		//SANIYA code
		$followup_fuel_type = $this->input->post('followup_fuel_type');
		$followup_stock = $this->input->post('followup_stock');
		//eof 

        //send sms
        $sms = $this->input->post('sms');
		if ($sms == 'on') {
			$sms = '1';
		} else {
			$sms = '0';
		}

        //send $whatsapp
		$whatsapp = $this->input->post('whatsapp');
		if ($whatsapp == 'on') {
			$whatsapp = '1';
		} else {
			$whatsapp = '0';
		}

		//Insert in lead_followup
		$checktime = date("h:i");
		$checkfollowup = $this->db->query("select id from lead_followup where leadid='$enq_id' and assign_to='$assign_to_telecaller' and date='$today1'
		and comment ='$comment' and contactibility='$contactibility' and created_time like '$checktime%'")->result();
		if (count($checkfollowup) < 1) {
			$insert = $this->db->query("INSERT INTO `lead_followup`
		(`leadid`, `activity`, `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`, `transfer_reason`, `date` ,`created_time`,`days60_booking`,`feedbackStatus`,`nextAction`,`contactibility`,`appointment_type`,`appointment_date`,`appointment_time`,`appointment_status`,web,`sms`,`whatsapp`) 
		VALUES ('$enq_id','$activity','$comment','$followupdate','$followuptime','$assign_to_telecaller','$transfer_reason','$today1','$time','$days60_booking','$feedback','$nextaction','$contactibility','$appointment_type','$appointment_date','$appointment_time','$appointment_status','1','$sms','$whatsapp')") or die(mysql_error());


			$followup_id = $this->db->insert_id();
			//echo $this->db->last_query();
			if ($lead_source == 'Cardekho API') {
				//$feedback,$nextaction
				$f_query = $this->db->query("select cardekho_nextstatus from tbl_feedback_status where feedbackStatusName='$feedback' and process_id='6'")->result();
				if (count($f_query) > 0) {
					$cardekho_nextstatus = $f_query[0]->cardekho_nextstatus;
				} else {
					$cardekho_nextstatus = '';
				}
				$n_query = $this->db->query("select cardekho_nextevent from tbl_nextaction where nextActionName='$nextaction' and process_id='6'")->result();
				if (count($n_query) > 0) {
					$cardekho_nextevent = $n_query[0]->cardekho_nextevent;
				} else {
					$cardekho_nextevent = '';
				}
				$visitor_number = $old_data[0]->visitor_number;
				$name = $old_data[0]->name;
				//$url = 'http://carsales.cardekho.com/rest/updateLeads/excellAutovista';
				$url = 'http://carsales-qa.cardekho.com/rest/updateLeads/excellAutovista';
				//$url = 'https://www.autovista.in/all_lms/index.php/api_2/demo';
				//$url = 'http://vistacars.in/all_lms1/index.php/add_sms/demo';
				// Create a new cURL resource
				$ch = curl_init($url);

				// Setup request to send json via POST

				$data = array(

					'id' => $visitor_number,
					'scheduleDate' => '2020-06-25 01:01:01',
					'nextEvent' => $cardekho_nextevent,
					'nextStatus' => $cardekho_nextstatus,
					'comments' => $comment,
					'bookingName' => $name,
					'bookingDate' => '0000-00-00',
					'bookingNumber' => $contact_no,
					'engineNo' => '', 'chassis' => '', 'rc' => '',
					'purchasedModelName' => 'Ertiga', 'purchasedFrom' => 'Autovista', 'purchasedBrand' => '',
					'retailDate' => ''
				);
				$payload = json_encode($data);

				// Attach encoded JSON string to the POST fields
				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

				// Set the content type to application/json
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

				// Return response instead of outputting
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				// Execute the POST request
				$result = curl_exec($ch);

				// Close cURL resource
				curl_close($ch);
				echo $result;
			}
			//Update Follow up in lead__master
			if ($_SESSION['role'] == 2 || $_SESSION['role'] == 3) {
				$follwup = 'cse_followup_id=' . $followup_id;
			} else {
				$follwup = 'dse_followup_id=' . $followup_id;
			}
			if (!$appointment_type) {
				if (isset($old_data[0]->appointment_type)) {
					$appointment_type = $old_data[0]->appointment_type;
				} else {
					$appointment_type = '';
				}
			}
			if (!$appointment_date) {
				if (isset($old_data[0]->appointment_date)) {
					$appointment_date = $old_data[0]->appointment_date;
				} else {
					$appointment_date = '';
				}
			}
			if (!$appointment_time) {
				if (isset($old_data[0]->appointment_time)) {
					$appointment_time = $old_data[0]->appointment_time;
				} else {
					$appointment_time = '';
				}
			}

			if (!$appointment_status) {
				if (isset($old_data[0]->appointment_status)) {
					$appointment_status = $old_data[0]->appointment_status;
				} else {
					$appointment_status = '';
				}
			}


			$qlocation = $this->input->post('qlocation');
			if ($qlocation != '') {
				$quotation_sent = 'Yes';
			} else {
				$old_quotation_sent = $old_data[0]->quotation_sent;
				if ($old_quotation_sent != '') {
					$quotation_sent = $old_quotation_sent;
				} else {
					$quotation_sent = '';
				}
			}

			$evaluation_location = $this->input->post('evaluation_location');
			if ($evaluation_location == '') {
				$evaluation_location = $old_data[0]->evaluation_location;
			}
			$edms_booking_id = $this->input->post('edms_booking_id');
			if (!$edms_booking_id) {
				$edms_booking_id = $old_data[0]->edms_booking_id;
			}
			$customer_name = $this->input->post('customer_name');
			
			// echo "Customer name in model: ". $customer_name;
			// exit;


			$update = $this->db->query("update lead_master set $follwup,email='$email',alternate_contact_no='$alternate_contact',location='$slocation',address='$address',
		model_id='$new_model',variant_id='$new_variant',buyer_type='$buyer_type', name = '$customer_name', dms_enq_number = '$dms_enq_number',
		old_make='$old_make',old_model='$old_model',color='$color',ownership='$ownership',manf_year='$mfg',km='$km',accidental_claim='$claim',days60_booking='$days60_booking',nextAction='$nextaction',feedbackStatus='$feedback', 
		appointment_type='$appointment_type',appointment_date='$appointment_date',
		appointment_time='$appointment_time',appointment_status='$appointment_status',
		interested_in_finance='$interested_in_finance',interested_in_accessories='$interested_in_accessories',interested_in_insurance='$interested_in_insurance',interested_in_ew='$interested_in_ew',followup_stock='$followup_stock',followup_fuel_type='$followup_fuel_type',
		customer_occupation='$customer_occupation',customer_corporate_name='$customer_corporate_name',customer_designation='$customer_designation', quotation_sent='$quotation_sent',evaluation_location='$evaluation_location',edms_booking_id='$edms_booking_id' where enq_id='$enq_id'");

			if ($update) {
				$this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Added Successfully...!</strong>');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Not added ...!</strong>');
			}

			// echo $this->db->last_query();
			// exit;

			//Transfer Lead
			$ctprocess = $this->input->post('tprocess');


			if ($ctprocess != '') {


				$cctprocess = explode("#", $ctprocess);
				$tprocess = $cctprocess[0];
				$tprocess_name = $cctprocess[1];

				$transfer_array = array();
				if ($old_data[0]->transfer_process != '') {
					$old_tprocess = json_decode($old_data[0]->transfer_process);
					array_push($transfer_array, $tprocess);
					$transfer_array = array_merge($transfer_array, $old_tprocess);
				} else {
					array_push($transfer_array, $tprocess);
				}

				$transfer_array = json_encode($transfer_array);
				$process_id = $_SESSION['process_id'];
				$lead_status = $this->input->post('lead_status');

				$select_process = $this->db->query("select process_name from tbl_process where process_id='$tprocess'")->result();
				$process_name = $select_process[0]->process_name;

				if ($assign != '') {
					// Assign User Details
					$get_user_role = $this->db->query("select role from lmsuser where id='$assign'")->result();
					echo $get_user_role[0]->role;
					//Assign CSE To CSE
					if (($get_user_role[0]->role == 2 or $get_user_role[0]->role == 3) && ($_SESSION['role'] == 3 or $_SESSION['role'] == 2)) {
						$assign_user = 'assign_to_cse=' . $assign;
						$assign_date = 'assign_to_cse_date';
						$assign_time = 'assign_to_cse_time';
						$user_followup_id = 'cse_followup_id = 0';
						$assign_by_cse = 'assign_by_cse=' . $assign_by . ',';
					}
					//Assign CSE To DSE TL
					if ($get_user_role[0]->role == 5 && ($_SESSION['role'] == 2 || $_SESSION['role'] == 3)) {
						$assign_user = 'assign_to_dse_tl=' . $assign;
						$assign_date = 'assign_to_dse_tl_date';
						$assign_time = 'assign_to_dse_tl_time';
						//$user_followup_id='dse_followup_id = 0';
						$assign_by_cse = 'assign_by_cse=' . $assign_by . ',';
						$user_followup_id = 'dse_followup_id = 0,assign_to_dse=0,assign_to_dse_date="0000-00-00"';
					}
					//Assign CSE To DSE 
					if ($get_user_role[0]->role == 4 && ($_SESSION['role'] == 2 || $_SESSION['role'] == 3)) {
						$get_dse_tl = $this->db->query("select tl_id from tbl_mapdse where dse_id='$assign'")->result();
						if (count($get_dse_tl) > 0) {
							$tl_id = $get_dse_tl[0]->tl_id;
						} else {
							$tl_id = 0;
						}
						$assign_user = 'assign_to_dse_tl=' . $tl_id . ',assign_to_dse=' . $assign;
						$assign_date = 'assign_to_dse_date="' . $today1 . '",assign_to_dse_tl_date';
						$assign_time = 'assign_to_dse_time="' . $time . '",assign_to_dse_tl_time';
						$user_followup_id = 'dse_followup_id = 0';
						$assign_by_cse = 'assign_by_cse=' . $assign_by . ',';
					}
					//Assign  DSE To DSE TL
					if ($get_user_role[0]->role == 5 && $_SESSION['role'] == 4) {
						$assign_user = 'assign_to_dse_tl=' . $assign;
						$assign_date = 'assign_to_dse_tl_date';
						$assign_time = 'assign_to_dse_tl_time';
						$user_followup_id = 'dse_followup_id = 0,assign_to_dse=0,assign_to_dse_date="0000-00-00"';
						//$user_followup_id='dse_followup_id = 0';
						$assign_by_cse = '';
					}
					//Assign DSE TL TO DSE 
					if ($get_user_role[0]->role == 4 &&  $_SESSION['role'] == 5) {
						$assign_user = 'assign_to_dse=' . $assign;
						$assign_date = 'assign_to_dse_date';
						$assign_time = 'assign_to_dse_time';
						$user_followup_id = 'dse_followup_id = 0';
						$assign_by_cse = '';
					}
					//Assign DSE TL To DSE TL
					if ($get_user_role[0]->role == 5 &&  $_SESSION['role'] == 5) {
						$assign_user = 'assign_to_dse_tl=' . $assign;
						$assign_date = 'assign_to_dse_tl_date';
						$assign_time = 'assign_to_dse_tl_time';
						//$user_followup_id='dse_followup_id = 0';
						$user_followup_id = 'dse_followup_id = 0,assign_to_dse=0,assign_to_dse_date="0000-00-00"';
						$assign_by_cse = '';
					}


					//Assign DSE  To DSE 
					if ($get_user_role[0]->role == 4 &&  $_SESSION['role'] == 4) {
						$assign_user = 'assign_to_dse=' . $assign;
						$assign_date = 'assign_to_dse_date';
						$assign_time = 'assign_to_dse_time';
						$user_followup_id = 'dse_followup_id = 0';
						$assign_by_cse = '';
					}

					//Assign Evaluation CSE To DSE TL
					if ($get_user_role[0]->role == 15 && ($_SESSION['role'] == 2 || $_SESSION['role'] == 3)) {
						$assign_user = 'assign_to_cse=' . $old_data[0]->assign_to_cse . ',assign_to_e_tl=' . $assign;
						$assign_date = 'assign_to_cse_date="' . $old_data[0]->assign_to_cse_date . '",assign_to_e_tl_date';
						$assign_time = 'assign_to_cse_time="' . $old_data[0]->assign_to_cse_time . '",assign_to_e_tl_time';
						//$user_followup_id='dse_followup_id = 0';
						$assign_by_cse = 'assign_by_cse=' . $assign_by . ',';
						$user_followup_id = 'exe_followup_id = 0,assign_to_e_exe=0,assign_to_e_exe_date="0000-00-00"';
					}
					//Assign Evaluation CSE To DSE 
					if ($get_user_role[0]->role == 16 && ($_SESSION['role'] == 2 || $_SESSION['role'] == 3)) {
						$get_dse_tl = $this->db->query("select tl_id from tbl_mapdse where dse_id='$assign'")->result();
						if (count($get_dse_tl) > 0) {
							$tl_id = $get_dse_tl[0]->tl_id;
						} else {
							$tl_id = 0;
						}
						$assign_user = 'assign_to_cse=' . $old_data[0]->assign_to_cse . ',assign_to_e_tl=' . $tl_id . ',assign_to_e_exe =' . $assign;
						$assign_date = 'assign_to_cse_date="' . $old_data[0]->assign_to_cse_date . '",assign_to_e_exe_date="' . $today1 . '",assign_to_e_tl_date';
						$assign_time = 'assign_to_cse_time="' . $old_data[0]->assign_to_cse_time . '",assign_to_e_exe_time ="' . $time . '",assign_to_e_tl_time';
						$user_followup_id = 'exe_followup_id  = 0';
						$assign_by_cse = 'assign_by_cse=' . $assign_by . ',';
					}


					if ($old_data[0]->assign_by_cse_tl == 0) {
						$assign_by_cse_tl = $_SESSION['user_id'];
					} else {
						$assign_by_cse_tl = $old_data[0]->assign_by_cse_tl;
					}
				}

				if ($tprocess == '6') {
					//$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
					$insertQuery = $this->db->query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
					echo $insertQuery;
					$transfer_id = $this->db->insert_id();

					//$update1 = $this -> db -> query("update lead_master set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$enq_id'");
					$update1 = $this->db->query("update lead_master set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl'," . $user_followup_id . "," . $assign_user . "," . $assign_by_cse . $assign_date . "='$today1'," . $assign_time . "='$time' where enq_id='$enq_id'");
					if ($update1) {
						$this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
					} else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
					}
					//	echo $this->db->last_query();	
				} elseif ($tprocess == '7') {
					$checkLead = $this->db->query("select enq_id from lead_master where contact_no='$contact_no' and process='$process_name' and nextAction!='Close'")->result();
					echo $this->db->last_query();
					if (count($checkLead) > 0) {
						$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
					} else {
						if ($lead_status == 'Close') {
							$updated_field = "transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
							$update_followup = $this->db->query("UPDATE `lead_followup` SET `feedbackStatus`='Lead Transfer To Other Process',`nextAction`='Close',`nextfollowupdate`='0000-00-00',`nextfollowuptime`='' WHERE id='$followup_id'");
						} else {
							$updated_field = "transfer_process='$transfer_array'";
						}
						$update1 = $this->db->query("update lead_master set " . $updated_field . " where enq_id='$enq_id'");


						$insert_new_lead = $this->db->query("insert into lead_master(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
						$new_enq_id = $this->db->insert_id();
						echo $this->db->last_query();

						$transfer_other_process = $this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
						if ($assign != '') {
							$insertQuery = $this->db->query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $new_enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
							echo $insertQuery;
							$transfer_id = $this->db->insert_id();
							$update1 = $this->db->query("update lead_master set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl'," . $user_followup_id . "," . $assign_user . "," . $assign_by_cse . $assign_date . "='$today1'," . $assign_time . "='$time' where enq_id='$new_enq_id'");
							//Insert in lead_followup
							$insert = $this->db->query("INSERT INTO `lead_followup`(`leadid`,  `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`, `date` ,`created_time`,`feedbackStatus`,`nextAction`,web) 
		VALUES ('$new_enq_id','Lead Transfer','$today1','$time','$assign_by','$today1','$time','Interested','Follow-up','1')") or die(mysql_error());
						}
						if ($update1) {
							$this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
						} else {
							$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
						}
					}
				} elseif ($tprocess == '8') {




					$checkLead = $this->db->query("select enq_id from  lead_master_evaluation where contact_no='$contact_no' and evaluation='Yes' and nextAction!='Close'")->result();
					echo $this->db->last_query();
					if (count($checkLead) > 0) {
						$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
					} else {
						if ($lead_status == 'Close') {
							$updated_field = "transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
							$update_followup = $this->db->query("UPDATE `lead_followup` SET `feedbackStatus`='Lead Transfer To Other Process',`nextAction`='Close',`nextfollowupdate`='0000-00-00',`nextfollowuptime`='' WHERE id='$followup_id'");
						} else {
							$updated_field = "transfer_process='$transfer_array'";
						}
						$update1 = $this->db->query("update lead_master set " . $updated_field . " where enq_id='$enq_id'");


						$insert_new_lead = $this->db->query("insert into lead_master_evaluation(process,name,contact_no,email,lead_source,enquiry_for,created_date,evaluation) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1','Yes')");
						$new_enq_id = $this->db->insert_id();
						//echo $this->db->last_query();
						$transfer_other_process = $this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead_evaluation`,`from_process`, `to_process`, `created_date`) VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
						echo $this->db->last_query();

						if ($assign != '') {
							$insertQuery = $this->db->query('INSERT INTO request_to_lead_transfer_evaluation( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time` ,status)  VALUES("' . $new_enq_id . '","' . $assign . '","' . $assign_by . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
							echo $insertQuery;
							$transfer_id = $this->db->insert_id();
							if ($get_user_role[0]->role != 3) {
								//Insert in lead_followup
								$insert = $this->db->query("INSERT INTO `lead_followup_evaluation`(`leadid`,  `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`, `date` ,`created_time`,`feedbackStatus`,`nextAction`,web) 
		VALUES ('$new_enq_id','Lead Transfer','$today1','$time','$assign_by','$today1','$time','Interested','Follow-up','1')") or die(mysql_error());
								$new_followup_id = $this->db->insert_id();

								$tfolloup_details = " cse_followup_id=" . $new_followup_id . ",feedbackStatus='Interested',nextAction='Follow-up',";
							} else {
								$tfolloup_details = '';
							}
							$update1 = $this->db->query("update lead_master_evaluation set" . $tfolloup_details . " transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl'," . $user_followup_id . "," . $assign_user . "," . $assign_by_cse . $assign_date . "='$today1'," . $assign_time . "='$time' where enq_id='$new_enq_id'");
							//echo $this->db->last_query();
						}
						if ($update1) {
							$this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
						} else {
							$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
						}
					}
				} else {
					// check lead already avaliable in that process or not
					$checkLead = $this->db->query("select enq_id from lead_master_all where contact_no='$contact_no' and process='$process_name' and nextAction!='Close'")->result();
					if (count($checkLead) > 0) {
						$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
					} else {

						//check old lead want to close or not
						if ($lead_status == 'Close') {
							$updated_field = "transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
							$update_followup = $this->db->query("UPDATE `lead_followup` SET `feedbackStatus`='Lead Transfer To Other Process',`nextAction`='Close',`nextfollowupdate`='0000-00-00',`nextfollowuptime`='' WHERE id='$followup_id'");
						} else {
							$updated_field = "transfer_process='$transfer_array'";
						}
						$update1 = $this->db->query("update lead_master set " . $updated_field . " where enq_id='$enq_id'");

						// Insert new lead in lead master
						$insert_new_lead = $this->db->query("insert into lead_master_all(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
						$new_enq_id = $this->db->insert_id();

						//Lead mapping 
						$transfer_other_process = $this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead_all`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
						if ($update1) {
							$this->session->set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
						} else {
							$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
						}
					}
				}
			}
		}
	}



    
    //Insert Followup
// 	function insert_followup() {

		
// 		$today1 = date("Y-m-d");
// 		$time = date("h:i:s A");
// 		$enq_id = $this -> input -> post('booking_id');
// 		$old_data=$this->db->query("select name,contact_no,lead_source,enquiry_for,email,address,model_id,variant_id,buy_status,buyer_type,quotation_sent,evaluation_location,assign_by_cse_tl,assign_to_cse,assign_to_cse_date,assign_to_cse_time,transfer_process,edms_booking_id,visitor_number  from lead_master where enq_id='".$enq_id."'")->result();
// 		//print_r($old_data);
// 		//Basic Followup
// 		$name=$old_data[0]->name;
// 		$contact_no=$old_data[0]->contact_no;
// 		$lead_source=$old_data[0]->lead_source;
// 		$enquiry_for=$old_data[0]->enquiry_for;
// 		$assign_to_telecaller = $_SESSION['user_id'];
// 		$alternate_contact=$this->input->post('alternate_contact');
// 		if($this -> input -> post('activity')=='')
// 		{
// 			$activity='';
// 		}
// 		else {
// 			$activity = $this -> input -> post('activity');
// 		}
// 		$contactibility = $this -> input -> post('contactibility');
// 		if($contactibility=='Connected' || $contactibility=='Not Connected')
// 		{
// 			//$this->send_sms($contactibility,$contact_no);
// 		}
		
		
// 		$feedback = $this -> input -> post('feedback');
// 		$nextaction = $this -> input -> post('nextaction');
		
// 		 $email = $this -> input -> post('email');
// 		if(!$email)
// 		{
// 			if($old_data[0]->email!=null)
// 			{
// 			 $email = $old_data[0]->email;
// 			}
// 		}
// 		 $showroom_location = $this -> input -> post('showroom_location');
// 		 $followupdate = $this -> input -> post('followupdate');
// 		 $followuptime = $this -> input -> post('followuptime');
// 		 if($followupdate=='')
// 		 {
// 		 	 if($nextaction=='Close' || $nextaction=='Booked From Autovista' || $nextaction=='Lead Transfer'){
// 		 	$followupdate='0000-00-00';
// 			$followuptime='00:00:00';
// 		 }else{
// 		 	$tomarrow_date = date('Y-m-d', strtotime(' +1 day'));
			
// 		 	$followupdate = $tomarrow_date;
// 			$followuptime='11:00:00';
// 		 }
// 		 }
		 
// 		 /*if($contactibility=='Not Connected')
// 		{
// 			 if($nextaction=='Close' || $nextaction=='Booked From Autovista' || $nextaction=='Lead Transfer'){
// 		 	$followupdate='0000-00-00';
// 					$followuptime='00:00:00';
// 				 }else{
// 				 	$tomarrow_date = date('Y-m-d', strtotime(' +1 day'));
					
// 				 	$followupdate = $tomarrow_date;
// 					$followuptime='11:00:00 AM';
// 				 }				
// 		}*/
// 		$address1 = $this -> input -> post('address');
// 		if(!$address1)
// 		{
			
// 			 $address1 = $old_data[0]->address;
		
// 		}
// 		$address = addslashes($address1);

// 		//New Car Details
// 		$new_model = $this -> input -> post('new_model');
// 		if(!$new_model)
// 		{
// 			 $new_model = $old_data[0]->model_id;
// 		}
// 		 $new_variant = $this -> input -> post('new_variant');
// 		if(!$new_variant)
// 		{
// 			 $new_variant = $old_data[0]->variant_id;
// 		}
// 		$book_status = $this -> input -> post('book_status');
// 		if(!$book_status)
// 		{
// 			 $book_status = $old_data[0]->buy_status;
// 		}
// 		$buyer_type = $this -> input -> post('buyer_type');
// 		if(!$buyer_type)
// 		{
// 			 $buyer_type = $old_data[0]->buyer_type;
// 		}
		
// 		$comment1 = $this -> input -> post('comment');
// 		 $comment = addslashes($comment1);

// 		//Exchange Car Details

// 		 $old_make = $this -> input -> post('old_make');
// 		 $old_model = $this -> input -> post('old_model');
// 		 $color = $this -> input -> post('color');
// 		 $ownership = $this -> input -> post('ownership');
// 		 $mfg = $this -> input -> post('mfg');
// 		 $km = $this -> input -> post('km');
// 		 $claim = $this -> input -> post('claim');
		 
// 		//Transfer Lead
// 		 $assign_by = $_SESSION['user_id'];
// 		 $assign = $this -> input -> post('transfer_assign');
// 		 $tlocation = $this -> input -> post('tlocation');
// 		 $transfer_reason = $this -> input -> post('transfer_reason');
		
// 		//>60 Days Booking
// 		$days60_booking = $this -> input -> post('days60_booking');
		 
	
// 		 //Showroom Location 
// 		 if($this -> input -> post('tlocation')!=''){
// 		 	$slocation= $this -> input -> post('tlocation');
// 		 }else{
// 		 	$getlocation=$this->db->query("select location from lead_master where enq_id='$enq_id'")->result();
// 			if(count($getlocation)>0){
// 				$slocation=$getlocation[0]->location;
// 			}else{
// 				$slocation='';
// 			}
// 		 }
		
// 		  //Appointment
// 		 $appointment_type = $this->input->post('appointment_type');
// 		 $appointment_date = $this->input->post('appointment_date');
// 		 $appointment_time = $this->input->post('appointment_time');
// 		 $appointment_status = $this->input->post('appointment_status');
		
		
// 		 //interested In
// 		$interested_in_finance=$this->input->post('interested_in_finance');
// 		$interested_in_accessories=$this->input->post('interested_in_accessories');
// 		$interested_in_insurance=$this->input->post('interested_in_insurance');
// 		$interested_in_ew=$this->input->post('interested_in_ew');
// 		$customer_occupation=$this->input->post('customer_occupation');
// 		$customer_designation=$this->input->post('customer_designation');
// 		$customer_corporate_name=$this->input->post('customer_corporate_name');
		
		
// 		//Insert in lead_followup
// 		$checktime=date("h:i");
// 		$checkfollowup=$this->db->query("select id from lead_followup where leadid='$enq_id' and assign_to='$assign_to_telecaller' and date='$today1'
// 		and comment ='$comment' and contactibility='$contactibility' and created_time like '$checktime%'")->result();
// 		if(count($checkfollowup)< 1)
// 		{
// 		$insert = $this -> db -> query("INSERT INTO `lead_followup`
// 		(`leadid`, `activity`, `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`, `transfer_reason`, `date` ,`created_time`,`days60_booking`,`feedbackStatus`,`nextAction`,`contactibility`,`appointment_type`,`appointment_date`,`appointment_time`,`appointment_status`,web) 
// 		VALUES ('$enq_id','$activity','$comment','$followupdate','$followuptime','$assign_to_telecaller','$transfer_reason','$today1','$time','$days60_booking','$feedback','$nextaction','$contactibility','$appointment_type','$appointment_date','$appointment_time','$appointment_status','1')") or die(mysql_error());
		
		
// 		$followup_id = $this->db->insert_id();
// 		//echo $this->db->last_query();
// 		if($lead_source=='Cardekho API')
// 		{
// 			//$feedback,$nextaction
// 			$f_query=$this->db->query("select cardekho_nextstatus from tbl_feedback_status where feedbackStatusName='$feedback' and process_id='6'")->result();
// 			if(count($f_query)>0)
// 			{
// 				$cardekho_nextstatus=$f_query[0]->cardekho_nextstatus;
// 			}
// 			else
// 			{
// 				$cardekho_nextstatus='';
// 			}
// 			$n_query=$this->db->query("select cardekho_nextevent from tbl_nextaction where nextActionName='$nextaction' and process_id='6'")->result();
// 			if(count($n_query)>0)
// 			{
// 				$cardekho_nextevent=$n_query[0]->cardekho_nextevent;
// 			}
// 			else
// 			{
// 				$cardekho_nextevent='';
// 			}
// 			$visitor_number=$old_data[0]->visitor_number;
// 			$name=$old_data[0]->name;
// 			//$url = 'http://carsales.cardekho.com/rest/updateLeads/excellAutovista';
// 				$url = 'http://carsales-qa.cardekho.com/rest/updateLeads/excellAutovista';
// 				//$url = 'https://www.autovista.in/all_lms/index.php/api_2/demo';
// 				//$url = 'http://vistacars.in/all_lms1/index.php/add_sms/demo';
// 				// Create a new cURL resource
// 				$ch = curl_init($url);

// 				// Setup request to send json via POST

// 				$data = array(

// 				    'id' => $visitor_number,
// 				     'scheduleDate' => '2020-06-25 01:01:01',
// 				      'nextEvent' => $cardekho_nextevent,
// 				       'nextStatus' => $cardekho_nextstatus,
// 				        'comments' => $comment,
// 				         'bookingName' => $name,
// 				          'bookingDate' => '0000-00-00',
// 				           'bookingNumber' => $contact_no,
// 				           'engineNo' => '','chassis' => '','rc' => '',
// 				           'purchasedModelName' => 'Ertiga','purchasedFrom' => 'Autovista','purchasedBrand' => '',
// 				    'retailDate' => ''
// 				);
// 				$payload = json_encode($data);

// 				// Attach encoded JSON string to the POST fields
// 				curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

// 				// Set the content type to application/json
// 				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

// 				// Return response instead of outputting
// 				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// 				// Execute the POST request
// 				$result = curl_exec($ch);

// 				// Close cURL resource
// 				curl_close($ch);
// 				echo $result;
// 		}
// 		//Update Follow up in lead__master
// 		if($_SESSION['role']==2 || $_SESSION['role']==3){
// 			$follwup='cse_followup_id='.$followup_id;
// 		}else{
// 			$follwup='dse_followup_id='.$followup_id;
// 		}
// 		if(!$appointment_type)
// 		{
// 			if(isset($old_data[0]->appointment_type)){
// 			$appointment_type = $old_data[0]->appointment_type;
// 			}else{
// 				$appointment_type='';
// 			}
// 		}
// 		if(!$appointment_date)
// 		{
// 			if(isset($old_data[0]->appointment_date)){
// 			$appointment_date = $old_data[0]->appointment_date;
// 				}else{
// 				$appointment_date='';
// 			}
// 		}
// 		if(!$appointment_time)
// 		{
// 			if(isset($old_data[0]->appointment_time)){
// 			$appointment_time = $old_data[0]->appointment_time;
// 			}else{
// 				$appointment_time='';
// 			}
// 		}
		
// 		if(!$appointment_status)
// 		{
// 			if(isset($old_data[0]->appointment_status)){
// 			$appointment_status = $old_data[0]->appointment_status;
// 			}else{
// 				$appointment_status='';
// 			}
// 		}
	

// 		$qlocation=$this->input->post('qlocation');
// 			if($qlocation!=''){
// 				$quotation_sent='Yes';
// 			}else{
// 				$old_quotation_sent=$old_data[0]->quotation_sent;
// 				if($old_quotation_sent!=''){
// 					$quotation_sent=$old_quotation_sent;
// 				}else{
// 					$quotation_sent='';
// 				}
				
// 			}
		
// 			$evaluation_location=$this->input->post('evaluation_location');
// 			if($evaluation_location==''){
// 				$evaluation_location=$old_data[0]->evaluation_location;
// 			}
// 			$edms_booking_id = $this -> input -> post('edms_booking_id');
// 		if(!$edms_booking_id)
// 		{
// 			 $edms_booking_id = $old_data[0]->edms_booking_id;
// 		}
// 	$update = $this -> db -> query("update lead_master set $follwup,email='$email',alternate_contact_no='$alternate_contact',location='$slocation',address='$address',
// 		model_id='$new_model',variant_id='$new_variant',buyer_type='$buyer_type',
// 		old_make='$old_make',old_model='$old_model',color='$color',ownership='$ownership',manf_year='$mfg',km='$km',accidental_claim='$claim',days60_booking='$days60_booking',nextAction='$nextaction',feedbackStatus='$feedback', 
// 		appointment_type='$appointment_type',appointment_date='$appointment_date',
// 		appointment_time='$appointment_time',appointment_status='$appointment_status',
// 		interested_in_finance='$interested_in_finance',interested_in_accessories='$interested_in_accessories',interested_in_insurance='$interested_in_insurance',interested_in_ew='$interested_in_ew'
// 		,customer_occupation='$customer_occupation',customer_corporate_name='$customer_corporate_name',customer_designation='$customer_designation', quotation_sent='$quotation_sent',evaluation_location='$evaluation_location',edms_booking_id='$edms_booking_id' where enq_id='$enq_id'");
	
// 	 	if($update){
// 			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Added Successfully...!</strong>');
// 			} else {
// 			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Followup Not added ...!</strong>');
// 			}
// 	  	//echo $this->db->last_query();
		
// 		//Transfer Lead
// 			$ctprocess=$this->input->post('tprocess');
			
			
// 		if ($ctprocess != '') {
				
				
// 			$cctprocess=explode("#",$ctprocess);
// 			$tprocess=$cctprocess[0];
// 			$tprocess_name=$cctprocess[1];
			
// 			$transfer_array=array();
// 			if($old_data[0]->transfer_process!=''){
// 				$old_tprocess=json_decode($old_data[0]->transfer_process);
// 				array_push($transfer_array,$tprocess);
// 				$transfer_array=array_merge($transfer_array,$old_tprocess);
				
// 			}else{
// 				array_push($transfer_array,$tprocess);
// 			}
			
// 			$transfer_array=json_encode($transfer_array);
// 			$process_id=$_SESSION['process_id'];
// 			$lead_status=$this->input->post('lead_status');
			
// 			$select_process=$this->db->query("select process_name from tbl_process where process_id='$tprocess'")->result();
// 			$process_name=$select_process[0]->process_name;
			
// 			if($assign !=''){
// 			// Assign User Details
// 			$get_user_role=$this->db->query("select role from lmsuser where id='$assign'")->result();
// 			echo $get_user_role[0]->role ;
// 			//Assign CSE To CSE
// 			if(($get_user_role[0]->role == 2 or $get_user_role[0]->role==3) && ($_SESSION['role']==3 or $_SESSION['role']==2)){
// 				$assign_user='assign_to_cse='.$assign;
// 				$assign_date='assign_to_cse_date';
// 				$assign_time='assign_to_cse_time';
// 				$user_followup_id='cse_followup_id = 0';
// 				$assign_by_cse='assign_by_cse='.$assign_by.',';
// 			}
// 			//Assign CSE To DSE TL
// 			if($get_user_role[0]->role == 5 && ($_SESSION['role']==2 || $_SESSION['role']==3)){
// 				$assign_user='assign_to_dse_tl='.$assign;
// 				$assign_date='assign_to_dse_tl_date';
// 				$assign_time='assign_to_dse_tl_time';
// 				//$user_followup_id='dse_followup_id = 0';
// 				$assign_by_cse='assign_by_cse='.$assign_by.',';
// 				$user_followup_id='dse_followup_id = 0,assign_to_dse=0,assign_to_dse_date="0000-00-00"';
// 			}
// 			//Assign CSE To DSE 
// 			if($get_user_role[0]->role == 4 && ($_SESSION['role']==2 || $_SESSION['role']==3)){
// 				$get_dse_tl=$this->db->query("select tl_id from tbl_mapdse where dse_id='$assign'")->result();
// 				if(count($get_dse_tl)>0){
// 					$tl_id=$get_dse_tl[0]->tl_id;
// 				}else{
// 					$tl_id=0;
// 				}
// 				$assign_user='assign_to_dse_tl='.$tl_id.',assign_to_dse='.$assign;
// 				$assign_date='assign_to_dse_date="'.$today1.'",assign_to_dse_tl_date';
// 				$assign_time='assign_to_dse_time="'.$time.'",assign_to_dse_tl_time';
// 				$user_followup_id='dse_followup_id = 0';
// 				$assign_by_cse='assign_by_cse='.$assign_by.',';
// 			}
// 			//Assign  DSE To DSE TL
// 			if($get_user_role[0]->role == 5 && $_SESSION['role']==4 ){
// 				$assign_user='assign_to_dse_tl='.$assign;
// 				$assign_date='assign_to_dse_tl_date';
// 				$assign_time='assign_to_dse_tl_time';
// 				$user_followup_id='dse_followup_id = 0,assign_to_dse=0,assign_to_dse_date="0000-00-00"';
// 				//$user_followup_id='dse_followup_id = 0';
// 				$assign_by_cse='';
// 			}
// 			//Assign DSE TL TO DSE 
// 			if($get_user_role[0]->role == 4 &&  $_SESSION['role']==5){
// 				$assign_user='assign_to_dse='.$assign;
// 				$assign_date='assign_to_dse_date';
// 				$assign_time='assign_to_dse_time';
// 				$user_followup_id='dse_followup_id = 0';
// 				$assign_by_cse='';
// 			}
// 			//Assign DSE TL To DSE TL
// 			if($get_user_role[0]->role == 5 &&  $_SESSION['role']==5){
// 				$assign_user='assign_to_dse_tl='.$assign;
// 				$assign_date='assign_to_dse_tl_date';
// 				$assign_time='assign_to_dse_tl_time';
// 				//$user_followup_id='dse_followup_id = 0';
// 				$user_followup_id='dse_followup_id = 0,assign_to_dse=0,assign_to_dse_date="0000-00-00"';
// 				$assign_by_cse='';
// 			}
			
			
// 			//Assign DSE  To DSE 
// 			if($get_user_role[0]->role == 4 &&  $_SESSION['role']==4){
// 				$assign_user='assign_to_dse='.$assign;
// 				$assign_date='assign_to_dse_date';
// 				$assign_time='assign_to_dse_time';
// 				$user_followup_id='dse_followup_id = 0';
// 				$assign_by_cse='';
// 			}

// 				//Assign Evaluation CSE To DSE TL
// 			if($get_user_role[0]->role == 15 && ($_SESSION['role']==2 || $_SESSION['role']==3)){
// 				$assign_user='assign_to_cse='.$old_data[0]->assign_to_cse.',assign_to_e_tl='.$assign;
// 				$assign_date='assign_to_cse_date="'.$old_data[0]->assign_to_cse_date.'",assign_to_e_tl_date';
// 				$assign_time='assign_to_cse_time="'.$old_data[0]->assign_to_cse_time.'",assign_to_e_tl_time';
// 				//$user_followup_id='dse_followup_id = 0';
// 				$assign_by_cse='assign_by_cse='.$assign_by.',';
// 				$user_followup_id='exe_followup_id = 0,assign_to_e_exe=0,assign_to_e_exe_date="0000-00-00"';
// 			}
// 			//Assign Evaluation CSE To DSE 
// 			if($get_user_role[0]->role == 16 && ($_SESSION['role']==2 || $_SESSION['role']==3)){
// 				$get_dse_tl=$this->db->query("select tl_id from tbl_mapdse where dse_id='$assign'")->result();
// 				if(count($get_dse_tl)>0){
// 					$tl_id=$get_dse_tl[0]->tl_id;
// 				}else{
// 					$tl_id=0;
// 				}
// 				$assign_user='assign_to_cse='.$old_data[0]->assign_to_cse.',assign_to_e_tl='.$tl_id.',assign_to_e_exe ='.$assign;
// 				$assign_date='assign_to_cse_date="'.$old_data[0]->assign_to_cse_date.'",assign_to_e_exe_date="'.$today1.'",assign_to_e_tl_date';
// 				$assign_time='assign_to_cse_time="'.$old_data[0]->assign_to_cse_time.'",assign_to_e_exe_time ="'.$time.'",assign_to_e_tl_time';
// 				$user_followup_id='exe_followup_id  = 0';
// 				$assign_by_cse='assign_by_cse='.$assign_by.',';
// 			}
			

// 			if($old_data[0]->assign_by_cse_tl==0){
// 				$assign_by_cse_tl=$_SESSION['user_id'];
// 			}else{
// 				$assign_by_cse_tl=$old_data[0]->assign_by_cse_tl;
// 			}
// 			}
			
// 			if($tprocess=='6'){
// 				//$insertQuery = $this -> db -> query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
// 				$insertQuery =$this->db->query ('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
// 				echo $insertQuery;
// 				$transfer_id=$this->db->insert_id();
		
// 			//$update1 = $this -> db -> query("update lead_master set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$enq_id'");
// 			 $update1 =$this->db->query("update lead_master set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$enq_id'");
// 				if($update1){
// 			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
// 			} else {
// 			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
// 			}			
// 			//	echo $this->db->last_query();	
// 			}
							
// 			elseif($tprocess == '7'){
				
			
		
			
// 			$checkLead =$this->db->query("select enq_id from lead_master where contact_no='$contact_no' and process='$process_name' and nextAction!='Close'")->result();
// 			echo $this->db->last_query();
// 			if(count($checkLead)>0){
// 			$this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
	
// 			}else{
// 			if($lead_status == 'Close'){
// 				$updated_field="transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
// 				$update_followup=$this->db->query("UPDATE `lead_followup` SET `feedbackStatus`='Lead Transfer To Other Process',`nextAction`='Close',`nextfollowupdate`='0000-00-00',`nextfollowuptime`='' WHERE id='$followup_id'");
			
			
// 			}else{
// 				$updated_field="transfer_process='$transfer_array'";
// 			}
// 			 $update1 = $this->db->query("update lead_master set ".$updated_field." where enq_id='$enq_id'");	
			
			
// 			$insert_new_lead =$this->db->query("insert into lead_master(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
// 			$new_enq_id = $this->db->insert_id();
// 			echo $this->db->last_query();
			
// 			 $transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead`,`from_process`, `to_process`, `created_date`) 
// 			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
// 			if($assign !=''){
// 				$insertQuery =$this->db->query ('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $new_enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
// 				echo $insertQuery;
// 				$transfer_id=$this->db->insert_id();
// 			$update1 =$this->db->query("update lead_master set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$new_enq_id'");
// 			//Insert in lead_followup
// 		$insert = $this -> db -> query("INSERT INTO `lead_followup`(`leadid`,  `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`, `date` ,`created_time`,`feedbackStatus`,`nextAction`,web) 
// 		VALUES ('$new_enq_id','Lead Transfer','$today1','$time','$assign_by','$today1','$time','Interested','Follow-up','1')") or die(mysql_error());
		
// 			}
// 			if($update1){
// 			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
// 			} else {
// 			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
// 			}	
// 			}
				

			
// 			}
// 				elseif($tprocess == '8'){
				
			
		
			
// 			$checkLead =$this->db->query("select enq_id from  lead_master_evaluation where contact_no='$contact_no' and evaluation='Yes' and nextAction!='Close'")->result();
// 			echo $this->db->last_query();
// 			if(count($checkLead)>0){
// 			$this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
	
// 			}else{
// 			if($lead_status == 'Close'){
// 				$updated_field="transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
// 				$update_followup=$this->db->query("UPDATE `lead_followup` SET `feedbackStatus`='Lead Transfer To Other Process',`nextAction`='Close',`nextfollowupdate`='0000-00-00',`nextfollowuptime`='' WHERE id='$followup_id'");
			
			
// 			}else{
// 				$updated_field="transfer_process='$transfer_array'";
// 			}
// 			 $update1 = $this->db->query("update lead_master set ".$updated_field." where enq_id='$enq_id'");	
			
			
// 			 $insert_new_lead =$this->db->query("insert into lead_master_evaluation(process,name,contact_no,email,lead_source,enquiry_for,created_date,evaluation) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1','Yes')");
// 			$new_enq_id = $this->db->insert_id();
// 			//echo $this->db->last_query();
// 			 $transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead_evaluation`,`from_process`, `to_process`, `created_date`) VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
// 			 echo $this->db->last_query();
			
// 			if($assign !=''){
// 				$insertQuery =$this->db->query ('INSERT INTO request_to_lead_transfer_evaluation( `lead_id` , `assign_to` , `assign_by` , `location` , `created_date` , `created_time` ,status)  VALUES("' . $new_enq_id . '","' . $assign . '","' . $assign_by . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
// 				echo $insertQuery;
// 				$transfer_id=$this->db->insert_id();
// 				if($get_user_role[0]->role!=3 ){
// 						//Insert in lead_followup
// 		$insert = $this -> db -> query("INSERT INTO `lead_followup_evaluation`(`leadid`,  `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`, `date` ,`created_time`,`feedbackStatus`,`nextAction`,web) 
// 		VALUES ('$new_enq_id','Lead Transfer','$today1','$time','$assign_by','$today1','$time','Interested','Follow-up','1')") or die(mysql_error());
// 		$new_followup_id=$this->db->insert_id();
			
// 			$tfolloup_details=" cse_followup_id=".$new_followup_id.",feedbackStatus='Interested',nextAction='Follow-up',";
		
// 		}else{
// 			$tfolloup_details='';
// 		}
// 			$update1 =$this->db->query("update lead_master_evaluation set".$tfolloup_details." transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl',".$user_followup_id.",".$assign_user.",".$assign_by_cse.$assign_date."='$today1',".$assign_time."='$time' where enq_id='$new_enq_id'");
// 		//echo $this->db->last_query();
// 			}
// 			if($update1){
// 			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
// 			} else {
// 			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
// 			}	
// 			}
				
			
// 			}
// 			else{
// 				// check lead already avaliable in that process or not
// 				$checkLead =$this->db->query("select enq_id from lead_master_all where contact_no='$contact_no' and process='$process_name' and nextAction!='Close'")->result();
// 			if(count($checkLead)>0){
// 			$this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Already exists in transferred process ...!</strong>');
	
// 			}else{
					
// 				//check old lead want to close or not
// 					if($lead_status == 'Close'){
// 						$updated_field="transfer_process='$transfer_array',feedbackStatus='Lead Transfer To Other Process',nextAction ='Close'";
// 						$update_followup=$this->db->query("UPDATE `lead_followup` SET `feedbackStatus`='Lead Transfer To Other Process',`nextAction`='Close',`nextfollowupdate`='0000-00-00',`nextfollowuptime`='' WHERE id='$followup_id'");
			
			
// 			}else{
// 				$updated_field="transfer_process='$transfer_array'";
// 			}
// 			 $update1 = $this->db->query("update lead_master set ".$updated_field." where enq_id='$enq_id'");	
			
// 			// Insert new lead in lead master
// 			$insert_new_lead = $this -> db -> query("insert into lead_master_all(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
// 			$new_enq_id = $this->db->insert_id();
			
// 			//Lead mapping 
// 			$transfer_other_process=$this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead_all`,`from_process`, `to_process`, `created_date`) 
// 			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
// 			if($update1){
// 			 $this -> session -> set_flashdata('message', '<div class="alert alert-success text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Transferred Successfully...!</strong>');
// 			} else {
// 			 $this -> session -> set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> Lead Not Transferred Successfully ...!</strong>');
// 			}	
			
// }
			
// 			}	
// 		}
	
		
// 		}	
	
// 	}
    
    
    
    
	//Insert Followup
	function insert_followup1()
	{
		$today1 = date("Y-m-d");
		$time = date("h:i:s A");
		$date = $this->input->post('date');
		$enq_id = $this->input->post('booking_id');
		$old_data = $this->db->query("select name,contact_no,lead_source,enquiry_for,email,address,model_id,variant_id,buy_status,buyer_type,quotation_sent,evaluation_location,assign_by_cse_tl from lead_master where enq_id='" . $enq_id . "'")->result();
		//print_r($old_data);
		//Basic Followup
		$name = $old_data[0]->name;
		$contact_no = $old_data[0]->contact_no;
		$lead_source = $old_data[0]->lead_source;
		$enquiry_for = $old_data[0]->enquiry_for;
		$assign_to_telecaller = $_SESSION['user_id'];
		$alternate_contact = $this->input->post('alternate_contact');
		if ($this->input->post('activity') == '') {
			$activity = '';
		} else {
			$activity = $this->input->post('activity');
		}
		$contactibility = $this->input->post('contactibility');
		if ($contactibility == 'Connected' || $contactibility == 'Not Connected') {
			//$this->send_sms($contactibility,$contact_no);
		}
		echo $status = $this->input->post('status1');
		$eagerness = $this->input->post('eagerness');
		$disposition = $this->input->post('disposition1');

		$feedback = $this->input->post('feedback');
		$nextaction = $this->input->post('nextaction');

		$email = $this->input->post('email');
		if (!$email) {
			if ($old_data[0]->email != null) {
				$email = $old_data[0]->email;
			}
		}
		$showroom_location = $this->input->post('showroom_location');

		$followupdate = $this->input->post('followupdate');
		$followuptime = $this->input->post('followuptime');
		if ($followupdate == '') {
			if ($nextaction == 'Close' || $nextaction == 'Booked From Autovista' || $nextaction == 'Done') {
				$followupdate = '0000-00-00';
				$followuptime = '00:00:00';
			} else {
				$tomarrow_date = date('Y-m-d', strtotime(' +1 day'));

				$followupdate = $tomarrow_date;
				$followuptime = '11:00:00';
			}
		}

		/*$check_status=$this->db->query("select status_name from tbl_status where status_id='$status'")->result();
		 if(($check_status[0]->status_name == 'Live' || $check_status[0]->status_name == 'Postponed' ) && $followupdate =='')
		 {
		 	$tomarrow_date = date('Y-m-d', strtotime(' +1 day'));
			
		 	$followupdate = $tomarrow_date;
			
		 }*/

		$address1 = $this->input->post('address');
		if (!$address1) {

			$address1 = $old_data[0]->address;
		}
		$address = addslashes($address1);

		//New Car Details
		$new_model = $this->input->post('new_model');
		if (!$new_model) {
			$new_model = $old_data[0]->model_id;
		}
		$new_variant = $this->input->post('new_variant');
		if (!$new_variant) {
			$new_variant = $old_data[0]->variant_id;
		}
		$book_status = $this->input->post('book_status');
		if (!$book_status) {
			$book_status = $old_data[0]->buy_status;
		}
		$buyer_type = $this->input->post('buyer_type');
		if (!$buyer_type) {
			$buyer_type = $old_data[0]->buyer_type;
		}

		$comment1 = $this->input->post('comment');
		$comment = addslashes($comment1);

		//Exchange Car Details

		$old_make = $this->input->post('old_make');
		$old_model = $this->input->post('old_model');
		$color = $this->input->post('color');
		$ownership = $this->input->post('ownership');
		$mfg = $this->input->post('mfg');
		$km = $this->input->post('km');
		$claim = $this->input->post('claim');

		//Buy used car Details
		$buy_make = $this->input->post('buy_make');
		$buy_model = $this->input->post('buy_model');
		$visit_status = $this->input->post('visit_status');
		$budget_from = $this->input->post('budget_from');
		$budget_to = $this->input->post('budget_to');
		$visit_location = $this->input->post('visit_location');
		$visit_booked = $this->input->post('visit_booked');
		$visit_date = $this->input->post('visit_date');
		$sales_status = $this->input->post('sales_status');
		$car_delivered = $this->input->post('car_delivered');


		//Transfer Lead
		$assign_by = $_SESSION['user_id'];
		$assign = $this->input->post('transfer_assign');
		$tlocation = $this->input->post('tlocation');
		$transfer_reason = $this->input->post('transfer_reason');

		//print_r($group_id);
		//>60 Days Booking


		$days60_booking = $this->input->post('days60_booking');

		//Home visit or Test Drive date
		$td_hv_date = $this->input->post('td_hv_date');

		//Showroom Location 
		if ($this->input->post('tlocation') != '') {
			$slocation = $this->input->post('tlocation');
		} else {
			$getlocation = $this->db->query("select location from lead_master where enq_id='$enq_id'")->result();
			if (count($getlocation) > 0) {
				$slocation = $getlocation[0]->location;
			} else {
				$slocation = '';
			}
		}

		//Appointment
		$appointment_type = $this->input->post('appointment_type');
		$appointment_date = $this->input->post('appointment_date');
		$appointment_time = $this->input->post('appointment_time');
		$appointment_address = $this->input->post('appointment_address');
		$appointment_status = $this->input->post('appointment_status');
		$appointment_rating = $this->input->post('appointment_rating');
		$appointment_feedback = $this->input->post('appointment_feedback');


		//escalation
		$escalation_type = $this->input->post('escalation_type');
		$escalation_remark = $this->input->post('escalation_remark');

		//interested In
		$interested_in_finance = $this->input->post('interested_in_finance');
		$interested_in_accessories = $this->input->post('interested_in_accessories');
		$interested_in_insurance = $this->input->post('interested_in_insurance');
		$interested_in_ew = $this->input->post('interested_in_ew');
		$customer_occupation = $this->input->post('customer_occupation');
		$customer_designation = $this->input->post('customer_designation');
		$customer_corporate_name = $this->input->post('customer_corporate_name');
		//Insert in lead_followup
		$insert = $this->db->query("INSERT INTO `lead_followup`
		(`leadid`, `activity`, `comment`, `nextfollowupdate`, `nextfollowuptime`, `assign_to`, `transfer_reason`, `date`,`visit_status` ,`visit_location`,`visit_booked`,`visit_booked_date`,`sale_status`,`car_delivered`,`created_time`,`days60_booking`,`td_hv_date`,`feedbackStatus`,`nextAction`,`contactibility`
		,`appointment_type`,`appointment_date`,`appointment_time`,`appointment_address`,`appointment_status`,`appointment_rating`,`appointment_feedback`,`escalation_type`,`escalation_remark`,web) 
		VALUES ('$enq_id','$activity','$comment','$followupdate','$followuptime','$assign_to_telecaller','$transfer_reason','$today1','$visit_status','$visit_location','$visit_booked','$visit_date','$sales_status','$car_delivered','$time','$days60_booking','$td_hv_date','$feedback','$nextaction','$contactibility'
		,'$appointment_type','$appointment_date','$appointment_time','$appointment_address','$appointment_status','$appointment_rating','$appointment_feedback','$escalation_type','$escalation_remark','1')") or die(mysql_error());

		$followup_id = $this->db->insert_id();
		echo $this->db->last_query();
		//Update Follow up in lead__master
		if ($_SESSION['role'] == 2 || $_SESSION['role'] == 3) {
			$follwup = 'cse_followup_id=' . $followup_id;
		} else {
			$follwup = 'dse_followup_id=' . $followup_id;
		}
		if (!$appointment_type) {
			if (isset($old_data[0]->appointment_type)) {
				$appointment_type = $old_data[0]->appointment_type;
			} else {
				$appointment_type = '';
			}
		}
		if (!$appointment_date) {
			if (isset($old_data[0]->appointment_date)) {
				$appointment_date = $old_data[0]->appointment_date;
			} else {
				$appointment_date = '';
			}
		}
		if (!$appointment_time) {
			if (isset($old_data[0]->appointment_time)) {
				$appointment_time = $old_data[0]->appointment_time;
			} else {
				$appointment_time = '';
			}
		}
		if (!$appointment_address) {
			if (isset($old_data[0]->appointment_address)) {
				$appointment_address = $old_data[0]->appointment_address;
			} else {
				$appointment_address = '';
			}
		}
		if (!$appointment_status) {
			if (isset($old_data[0]->appointment_status)) {
				$appointment_status = $old_data[0]->appointment_status;
			} else {
				$appointment_status = '';
			}
		}
		if (!$appointment_rating) {
			if (isset($old_data[0]->appointment_rating)) {
				$appointment_rating = $old_data[0]->appointment_rating;
			} else {
				$appointment_rating = '';
			}
		}
		if (!$appointment_feedback) {
			if (isset($old_data[0]->appointment_feedback)) {
				$appointment_feedback = $old_data[0]->appointment_feedback;
			} else {
				$appointment_feedback = '';
			}
		}

		$qlocation = $this->input->post('qlocation');
		if ($qlocation != '') {
			$quotation_sent = 'Yes';
		} else {
			$old_quotation_sent = $old_data[0]->quotation_sent;
			if ($old_quotation_sent != '') {
				$quotation_sent = $old_quotation_sent;
			} else {
				$quotation_sent = '';
			}
		}

		$evaluation_location = $this->input->post('evaluation_location');
		if ($evaluation_location == '') {
			$evaluation_location = $old_data[0]->evaluation_location;
		}

		// Update customer name from followup page

		$customer_name = $this->input->post('customer_name');


		$update = $this->db->query("update lead_master set $follwup,email='$email',alternate_contact_no='$alternate_contact',location='$slocation',address='$address',
		model_id='$new_model',variant_id='$new_variant',buy_status='$book_status',buyer_type='$buyer_type',
		old_make='$old_make',old_model='$old_model',color='$color',ownership='$ownership',manf_year='$mfg',km='$km',accidental_claim='$claim',buy_make='$buy_make',buy_model='$buy_model',budget_from='$budget_from',budget_to='$budget_to',days60_booking='$days60_booking',nextAction='$nextaction',feedbackStatus='$feedback', 
		appointment_type='$appointment_type',appointment_date='$appointment_date',
		appointment_time='$appointment_time',appointment_address='$appointment_address',appointment_status='$appointment_status',
		appointment_rating='$appointment_rating',appointment_feedback='$appointment_feedback',interested_in_finance='$interested_in_finance',interested_in_accessories='$interested_in_accessories',interested_in_insurance='$interested_in_insurance',interested_in_ew='$interested_in_ew'
		,customer_occupation='$customer_occupation',customer_corporate_name='$customer_corporate_name',customer_designation='$customer_designation', quotation_sent='$quotation_sent',
		evaluation_location='$evaluation_location',name = '$customer_name' where enq_id='$enq_id'");
		echo $this->db->last_query();
		//Transfer Lead
		if ($assign != '') {
			$tprocess = $this->input->post('tprocess');
			$process_id = $_SESSION['process_id'];
			$today1 = date("Y-m-d");
			$select_process = $this->db->query("select process_name from tbl_process where process_id='$tprocess'")->result();
			$process_name = $select_process[0]->process_name;


			// Assign User Details
			$get_user_role = $this->db->query("select role from lmsuser where id='$assign'")->result();

			//Assign CSE To CSE
			if (($get_user_role[0]->role == 2 or $get_user_role[0]->role == 3) && ($_SESSION['role'] == 3 or $_SESSION['role'] == 2)) {
				$assign_user = 'assign_to_cse=' . $assign;
				$assign_date = 'assign_to_cse_date';
				$assign_time = 'assign_to_cse_time';
				$user_followup_id = 'cse_followup_id = 0';
				$assign_by_cse = 'assign_by_cse=' . $assign_by . ',';
			}
			//Assign CSE To DSE TL
			if ($get_user_role[0]->role == 5 && ($_SESSION['role'] == 2 || $_SESSION['role'] == 3)) {
				$assign_user = 'assign_to_dse_tl=' . $assign;
				$assign_date = 'assign_to_dse_tl_date';
				$assign_time = 'assign_to_dse_tl_time';
				$user_followup_id = 'dse_followup_id = 0';
				$assign_by_cse = 'assign_by_cse=' . $assign_by . ',';
			}
			//Assign  DSE To DSE TL
			if ($get_user_role[0]->role == 5 && $_SESSION['role'] == 4) {
				$assign_user = 'assign_to_dse_tl=' . $assign;
				$assign_date = 'assign_to_dse_tl_date';
				$assign_time = 'assign_to_dse_tl_time';
				$user_followup_id = 'dse_followup_id = 0,assign_to_dse=0,assign_to_dse_date="0000-00-00"';
				//$user_followup_id='dse_followup_id = 0';
				$assign_by_cse = '';
			}
			//Assign DSE TL TO DSE 
			if ($get_user_role[0]->role == 4 &&  $_SESSION['role'] == 5) {
				$assign_user = 'assign_to_dse=' . $assign;
				$assign_date = 'assign_to_dse_date';
				$assign_time = 'assign_to_dse_time';
				$user_followup_id = 'dse_followup_id = 0';
				$assign_by_cse = '';
			}
			//Assign DSE TL To DSE TL
			if ($get_user_role[0]->role == 5 &&  $_SESSION['role'] == 5) {
				$assign_user = 'assign_to_dse_tl=' . $assign;
				$assign_date = 'assign_to_dse_tl_date';
				$assign_time = 'assign_to_dse_tl_time';
				$user_followup_id = 'dse_followup_id = 0';
				$assign_by_cse = '';
			}


			//Assign DSE  To DSE 
			if ($get_user_role[0]->role == 4 &&  $_SESSION['role'] == 4) {
				$assign_user = 'assign_to_dse=' . $assign;
				$assign_date = 'assign_to_dse_date';
				$assign_time = 'assign_to_dse_time';
				$user_followup_id = 'dse_followup_id = 0';
				$assign_by_cse = '';
			}
			if ($old_data[0]->assign_by_cse_tl == 0) {
				$assign_by_cse_tl = $_SESSION['user_id'];
			} else {
				$assign_by_cse_tl = $old_data[0]->assign_by_cse_tl;
			}
			if ($tprocess == '6') {
				$insertQuery = $this->db->query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
				$transfer_id = $this->db->insert_id();
				//echo $this->db->last_query();


				$update1 = $this->db->query("update lead_master set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl'," . $user_followup_id . "," . $assign_user . "," . $assign_by_cse . $assign_date . "='$today1'," . $assign_time . "='$time' where enq_id='$enq_id'");
				//echo $this->db->last_query();	
			} elseif ($tprocess == '7') {


				$checkUserProcess = $this->db->query("select process_id from tbl_manager_process where user_id='$assign_by' and process_id='7'")->result();

				if (count($checkUserProcess) > 0) {
					$update1 = $this->db->query("update lead_master set process='POC Sales' where enq_id='$enq_id'");
					echo $this->db->last_query();

					$insertQuery = $this->db->query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`transfer_reason`, `location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $assign . '","' . $assign_by . '","' . $transfer_reason . '","' . $tlocation . '","' . $today1 . '","' . $time . '","Transfered")');
					$transfer_id = $this->db->insert_id();
					echo $this->db->last_query();


					$update1 = $this->db->query("update lead_master set transfer_id='$transfer_id',assign_by_cse_tl='$assign_by_cse_tl'," . $user_followup_id . "," . $assign_user . "," . $assign_by_cse . $assign_date . "='$today1'," . $assign_time . "='$time' where enq_id='$enq_id'");
					echo $this->db->last_query();
				} else {
					$update1 = $this->db->query("update lead_master set transfer_process='$process_name' where enq_id='$enq_id'");
					$insert_new_lead = $this->db->query("insert into lead_master(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
					$new_enq_id = $this->db->insert_id();
					$transfer_other_process = $this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead_all`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
				}
			} else {

				$update1 = $this->db->query("update lead_master set transfer_process='$process_name' where enq_id='$enq_id'");
				$insert_new_lead = $this->db->query("insert into lead_master_all(process,name,contact_no,email,lead_source,enquiry_for,created_date) values('$process_name','$name','$contact_no','$email','$lead_source','$enquiry_for','$today1')");
				$new_enq_id = $this->db->insert_id();
				$transfer_other_process = $this->db->query("INSERT INTO `tbl_maplead`(`from_lead`, `to_lead_all`,`from_process`, `to_process`, `created_date`) 
			VALUES ('$enq_id','$new_enq_id','$process_id','$tprocess','$today1')");
			}
		}


		$evaluation_location = $this->input->post('evaluation_location');
		$evaluation_assign_to = $this->input->post('evaluation_assign_to');
		if ($evaluation_location != '' && $evaluation_assign_to != '') {
			$insertevaluationQuery = $this->db->query('INSERT INTO request_to_lead_transfer( `lead_id` , `assign_to` , `assign_by` ,`location` , `created_date` , `created_time` ,status)  VALUES("' . $enq_id . '","' . $evaluation_assign_to . '","' . $assign_by . '","' . $evaluation_location . '","' . $today1 . '","' . $time . '","Transfered")');
			$evaluation_transfer_id = $this->db->insert_id();
			$updateevaluation = $this->db->query("update lead_master set transfer_id='" . $evaluation_transfer_id . " ',assign_to_e_tl ='" . $evaluation_assign_to . "',assign_to_e_tl_date='" . $today1 . "',assign_to_e_tl_time ='" . $time . "',evaluation='Yes' where enq_id='" . $enq_id . "'");
		}
	}


	public function select_contact_details()
	{
		$query = $this->db->query("SELECT * FROM `tbl_contact_details`");
		return $query->result();
	}

	//Select All Lead Data
	public function select_followup_lead($enq_id)
	{
		$this->db->select('f.id as followup_id,f.activity,f.date as c_date,f.comment as f_comment,f.nextfollowupdate,f.nextfollowuptime, 
		f.feedbackStatus,f.nextAction,f.escalation_remark,f.escalation_type,f.created_time,f.contactibility,f.appointment_type,f.appointment_date,f.appointment_time,f.appointment_status ,	 
		u.fname,u.lname
		 ');
		$this->db->from('lead_followup f');
		$this->db->join('lmsuser u', 'u.id=f.assign_to', 'left');
		//$this -> db -> join('tbl_disposition_status d', 'd.disposition_id=f.disposition', 'left');
		//$this -> db -> join('tbl_status s', 's.status_id=d.status_id', 'left');
		$this->db->where('f.leadid', $enq_id);
		$this->db->order_by('f.id', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	//Select Location
	public function select_location()
	{
		$this->db->select('p.location_id,l.location');
		//	$this -> db -> from('tbl_location');
		$this->db->from('tbl_map_process p');
		$this->db->join('tbl_location l', 'l.location_id=p.location_id');
		$this->db->where('p.process_id', $this->process_id);
		$this->db->where('p.status !=', '-1');
		$this->db->where('l.location_status !=', 'Deactive');
		$query = $this->db->get();

		return $query->result();
	}


	function select_city()
	{

		$this->db->distinct();
		$this->db->select('location');
		$this->db->from('tbl_quotation');

		$query = $this->db->get();
		return $query->result();
	}


	function check_accessories($model_name)
	{
		$query = $this->db->query("select max(upload_id) as upload_id from tbl_accessories_package_lms where model_id='$model_name'")->result();

		if (isset($query[0]->upload_id)) {

			$this->db->select('accessories_package_id,package_name');
			$this->db->from('tbl_accessories_package_lms');
			$this->db->where('model_id', $model_name);
			$this->db->where('upload_id', $query[0]->upload_id);


			$query1 = $this->db->get();
			//echo $this->db->last_query();
			$query1 = $query1->result();
		} else {

			$query1 = array();
		}

		return $query1;
	}

	function checkprize($model_name, $city, $description)
	{
		$query = $this->db->query("select * from tbl_quotation_name where location='$city' and status='Active'")->result();
		if (count($query) == 1) {

			$this->db->select('variant');
			$this->db->from($query[0]->table_name);
			$this->db->where('model', $model_name);
			$this->db->where('variant', $description);
			$select_variant = $this->db->get()->result();
		} else {
			$select_variant = array();
		}

		return $select_variant;
	}
	//Select data for qutation send
	function select_quotation($quotation_location, $quotation_model_name, $quotation_description)
	{
		$query = $this->db->query("select * from tbl_quotation_name where location='$quotation_location' and status='Active'")->result();


		$this->db->select('*');
		$this->db->from($query[0]->table_name);
		if ($quotation_model_name != '') {
			$this->db->where('model', $quotation_model_name);
		}
		if ($quotation_description != '') {
			$this->db->where('variant', $quotation_description);
		}
		$select_variant = $this->db->get()->result();


		echo $this->db->last_query();
		return $select_variant;
	}
	function select_quotation1($quotation_location, $quotation_model_name, $quotation_description)
	{
		$query = $this->db->query("select * from tbl_quotation_name where location='$quotation_location' and status='Active'")->result();
		$table_name = $query[0]->table_name;

		$coloumn_name = $this->db->query("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME`='$table_name'")->result();


		echo $this->db->last_query();
		return $coloumn_name;
	}
	function select_offer($quotation_location, $quotation_model_name)
	{
		$this->db->select('max(month) as created_date');
		$this->db->from("tbl_consumer_offer");
		if ($quotation_location == 'Pune-PCMC' || $quotation_location == 'Pune-PMC') {
			//echo "pune";

			$this->db->where('location', 'Pune');
		} else {
			$this->db->where('location', 'Mumbai');
		}
		$this->db->where('model', $quotation_model_name);

		$query = $this->db->get()->result();
		$this->db->select("*");
		$this->db->from("tbl_consumer_offer");
		if ($quotation_location == 'Pune-PCMC' || $quotation_location == 'Pune-PMC') {
			//echo "pune";

			$this->db->where('location', 'Pune');
		} else {
			$this->db->where('location', 'Mumbai');
		}
		$this->db->where('model', $quotation_model_name);
		$this->db->where('month', $query[0]->created_date);
		$query = $this->db->get();
		echo $this->db->last_query();
		return $query->result();
	}


	function select_model_main()
	{
		$this->db->select('*');
		$this->db->from('make_models');

		$query = $this->db->get();
		return $query->result();
	}
	//Select model using make id
	function select_model($make)
	{
		$this->db->select('*');
		$this->db->from('make_models');
		$this->db->where('make_id', $make);
		$query = $this->db->get();
		return $query->result();
	}
	//select make 
	function makes()
	{
		$this->db->select('*');
		$this->db->from('makes');
		$this->db->where('is_active', '1');
		$query = $this->db->get();
		return $query->result();
	}
	//Insert Manager Remark
	function insert_remark()
	{


		$today = date("Y-m-d");


		//add remark 
		$user_id = $_SESSION['user_id'];
		$remark = $this->input->post('comment');
		$enq_id = $this->input->post('booking_id');

		$query = $this->db->query("INSERT INTO `tbl_manager_remark`(`remark`, `user_id`, `lead_id`, `created_date`) VALUES ('$remark','$user_id','$enq_id','$today')");
		$remark_id = $this->db->insert_id();
		$update1 = $this->db->query("update lead_master set remark_id='$remark_id' where enq_id='$enq_id'");
	}

	public function select_dse_data()
	{
		$this->db->select('id,fname,mobileno');
		$this->db->from('lmsuser');
		$this->db->where('id', $_SESSION['user_id']);
		$query = $this->db->get();
		return $query->result();
	}

	function corporate()
	{
		$this->db->select('*');
		$this->db->from('tbl_corporate');
		$query = $this->db->get();
		return $query->result();
	}
	function insert_escalation_detail()
	{
		$enq_id = $this->input->post('booking_id');
		//escalation
		$escalation_type = $this->input->post('escalation_type');
		$escalation_remark = $this->input->post('escalation_remark');
		$get_escalation_data = $this->db->query("select esc_level1,esc_level2,esc_level3 from lead_master where enq_id='$enq_id'")->result();
		if ($escalation_type == 'Escalation Level 1') {
			$esc_level = "esc_level1='Yes'";
			$esc_remark = "esc_level1_remark= '" . $escalation_remark . "'";
			$update1 = $this->db->query("update lead_master set " . $esc_level . "," . $esc_remark . " where enq_id='$enq_id'");
		} elseif ($escalation_type == 'Escalation Level 2') {
			if (isset($get_escalation_data[0]->esc_level1)) {
				if ($get_escalation_data[0]->esc_level1 == 'Yes') {
					$esc_level = "esc_level2='Yes'";
					$esc_remark = "esc_level2_remark= '" . $escalation_remark . "'";
					$update1 = $this->db->query("update lead_master set " . $esc_level . "," . $esc_remark . " where enq_id='$enq_id'");
				} else {
					$esc_level = '';
					$esc_remark = '';
					$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> First Add Escalation Level 1  ...!</strong>');
				}
			} else {
				$esc_level = '';
				$esc_remark = '';
				$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> First Add Escalation Level 1  ...!</strong>');
			}
		} elseif ($escalation_type == 'Escalation Level 3') {
			if (isset($get_escalation_data[0]->esc_level1)) {
				if ($get_escalation_data[0]->esc_level1 == 'Yes' && $get_escalation_data[0]->esc_level2 == 'Yes') {
					$esc_level = "esc_level3='Yes'";
					$esc_remark = "esc_level3_remark= '" . $escalation_remark . "'";
					$update1 = $this->db->query("update lead_master set " . $esc_level . "," . $esc_remark . " where enq_id='$enq_id'");
				} else {
					$esc_level = '';
					$esc_remark = '';
					$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> First Add Escalation Level 1 and Level 2 ...!</strong>');
				}
			} else {
				$esc_level = '';
				$esc_remark = '';
				$this->session->set_flashdata('message', '<div class="alert alert-danger text-center">  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong> First Add Escalation Level 1 and Level 2 ...!</strong>');
			}
		}
	}
	function select_evaluation_location()
	{
		$this->db->select('p.location_id,l.location');
		//	$this -> db -> from('tbl_location');
		$this->db->from('tbl_map_process p');
		$this->db->join('tbl_location l', 'l.location_id=p.location_id');
		$this->db->where('p.status !=', '-1');
		$this->db->where('l.location_status !=', 'Deactive');
		$this->db->where('p.process_id', 8);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function get_escalation_detail($enq_id)
	{

		$this->db->select('gm_email,sm_email,name,contact_no,l1.location,esc_level1_remark,esc_level2_remark,esc_level3_remark, f.comment as cse_remark,f1.comment as dse_remark,ucsetl.fname as csetl_fname,ucsetl.lname as csetl_lname,ucsetl.email as csetl_email,ucse.fname as cse_fname,ucse.lname as cse_lname,udsetl.fname as dsetl_fname,udsetl.lname as dsetl_lname,udsetl.email as dsetl_email,udse.fname as dse_fname,udse.lname as dse_lname');
		$this->db->from('lead_master l');
		$this->db->join('lead_followup f', 'f.id=l.cse_followup_id ', 'left');
		$this->db->join('lead_followup f1', 'f1.id=l.dse_followup_id ', 'left');
		$this->db->join('lmsuser ucse', 'ucse.id=l.assign_to_cse', 'left');
		$this->db->join('tbl_mapdse mp', 'mp.dse_id=l.assign_to_cse', 'left');
		$this->db->join('lmsuser ucsetl', 'ucsetl.id=mp.tl_id', 'left');
		$this->db->join('lmsuser udsetl', 'udsetl.id=l.assign_to_dse_tl', 'left');
		$this->db->join('tbl_manager_process p', 'p.user_id=l.assign_to_dse_tl', 'left');
		$this->db->join('tbl_map_process p1', 'p1.location_id=p.location_id', 'left');
		$this->db->join('tbl_location l1', 'l1.location_id=p1.location_id', 'left');
		$this->db->join('lmsuser udse', 'udse.id=l.assign_to_dse', 'left');
		$this->db->where('p.process_id', $_SESSION['process_id']);
		$this->db->where('p1.process_id', $_SESSION['process_id']);
		$this->db->where('l.enq_id', $enq_id);

		$query = $this->db->get();

		return $query->result();
	}
	function insert_escalation_resolve_detail()
	{
		$enq_id = $this->input->post('booking_id');
		//escalation
		$resolved_escalation_type = $this->input->post('resolved_escalation_type');
		$resolved_escalation_remark = $this->input->post('resolved_escalation_remark');
		if ($resolved_escalation_type == 'Escalation Level 1') {
			$resolved_esc_level = "esc_level1_resolved ='Yes'";
			$resolved_esc_remark = "esc_level1_resolved_remark= '" . $resolved_escalation_remark . "'";
		} elseif ($resolved_escalation_type == 'Escalation Level 2') {
			$resolved_esc_level = "esc_level2_resolved ='Yes'";
			$resolved_esc_remark = "esc_level2_resolved_remark= '" . $resolved_escalation_remark . "'";
		} elseif ($resolved_escalation_type == 'Escalation Level 3') {
			$resolved_esc_level = "esc_level3_resolved ='Yes'";
			$resolved_esc_remark = "esc_level3_resolved_remark= '" . $resolved_escalation_remark . "'";
		} else {
			$resolved_esc_level = '';
			$resolved_esc_remark = '';
		}
		$update1 = $this->db->query("update lead_master set " . $resolved_esc_level . "," . $resolved_esc_remark . " where enq_id='$enq_id'");
	}
	public function get_duplicate_record($enq_id)
	{
		$getmoblienumberquery = $this->db->query("select contact_no from lead_master where enq_id='$enq_id'")->result();
		if (count($getmoblienumberquery) > 0) {
			$contact_no = $getmoblienumberquery[0]->contact_no;
			$query = $this->db->query("select enq_id from lead_master where contact_no='$contact_no' and enq_id!='$enq_id' and process='New Car'")->result();
		} else {
			$query = '';
		}
		return $query;
	}
	public function duplicate_record_details($enq_id)
	{
		$process_name = $_SESSION['process_name'];
		$getmoblienumberquery = $this->db->query("select contact_no from lead_master where enq_id='$enq_id'")->result();
		if (count($getmoblienumberquery) > 0) {
			$contact_no = $getmoblienumberquery[0]->contact_no;
			$query = $this->db->query("select * from lead_master where contact_no='$contact_no' and  enq_id!='$enq_id' and process='$process_name' order by created_date desc")->result();
		} else {
			$query = '';
		}
		return $query;
	}




	function select_max_upload_quotation($city, $model)
	{
		$this->db->distinct();
		$this->db->select('max(upload_id) as upload_id');
		$this->db->from('tbl_variant_onroad');
		$this->db->where('location', $city);
		if ($model != '') {
			$this->db->where('model_id', $model);
		}
		$query = $this->db->get();
		return $query->result();
	}



	function select_model_name($city)
	{
		$model = '';
		$query = $this->select_max_upload_quotation($city, $model);
		if (count($query) > 0) {
			$this->db->distinct();
			$this->db->select('m.model_name,m.model_id');
			$this->db->from('tbl_variant_onroad  vo');
			$this->db->join('make_models m', 'm.model_id=vo.model_id');
			$this->db->where('vo.location', $city);
			$this->db->where('vo.upload_id', $query[0]->upload_id);
			$this->db->group_by('vo.model_id');
			$query1 = $this->db->get();
			//echo $this->db->last_query();
			$query = $query1->result();
		} else {
			$query = array();
		}
		return $query;
	}
	function select_description($model_id, $city)
	{

		$query = $this->select_max_upload_quotation($city, $model_id);
		if (count($query) > 0) {
			$this->db->distinct();
			$this->db->select('v.variant_name,v.variant_id');
			$this->db->from('tbl_variant_onroad vo');
			$this->db->join('model_variant v', 'v.variant_id=vo.variant_id');
			$this->db->where('vo.model_id', $model_id);
			$this->db->where('vo.location', $city);
			$this->db->where('vo.upload_id', $query[0]->upload_id);
			$select_variant = $this->db->get();

			$select_variant = $select_variant->result();
		} else {
			$select_variant = array();
		}
		return $select_variant;
	}


	function select_quotation_data($quotation_location, $quotation_model_name, $quotation_description)
	{

		$this->db->select('q.*,m.model_name,m.model_url,v.variant_id,v.variant_name');
		$this->db->from('tbl_variant_onroad q');

		$this->db->join('make_models m', 'm.model_id=q.model_id');
		$this->db->join('model_variant v', 'v.variant_id=q.variant_id');
		$this->db->where('q.location', $quotation_location);
		$this->db->where('q.model_id', $quotation_model_name);
		if ($quotation_description != '') {
			$this->db->where('q.variant_id', $quotation_description);
		}



		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}
	function insert_header_quotation($quotation_location, $quotation_model_name, $quotation_description, $email, $customer_name, $quotation_type, $finance_data)
	{

		$today = date("Y-m-d");
		$user_id = $_SESSION['user_id'];
		$remark = $this->input->post('comment');
		$enq_id = $this->input->post('booking_id');

		$query = $this->db->query("INSERT INTO `tbl_quotation_customer_list`(`user_id`, `customer_name`,`customer_email`,`location`,`model`,`variant`,`type`,`need_finance`, `created_date`) 
		VALUES ('$user_id','$customer_name','$email','$quotation_location','$quotation_model_name','$quotation_description','$quotation_type','$finance_data','$today')");
	}



	/***************************************************************/

	public function quotation_location()
	{

		$this->db->select('location');
		$this->db->from('tbl_onroad_performa_invoice');
		$this->db->group_by('location');
		$query = $this->db->get();
		return $query->result();
	}
	public function select_quotation_model_name()
	{
		$quotation_location = $this->input->post('quotation_location');
		$this->db->select('*');
		$this->db->from('tbl_onroad_performa_invoice op');
		$this->db->join('make_models m', 'm.model_id=op.model_id');
		$this->db->where('op.location', $quotation_location);
		$this->db->where('m.status', 1);
		$this->db->group_by('op.model_id');
		$query = $this->db->get();
		return $query->result();
	}
	public function select_quotation_variant_name()
	{
		$qutotation_model = $this->input->post('qutotation_model');
		$quotation_location = $this->input->post('quotation_location');
		$this->db->select('*');
		$this->db->from('tbl_onroad_performa_invoice op');
		$this->db->join('model_variant v', 'v.variant_id=op.variant_id');
		$this->db->where('op.model_id', $qutotation_model);
		$this->db->where('op.location', $quotation_location);
		$this->db->where('v.is_active', 1);
		$this->db->group_by('op.variant_id');
		$query = $this->db->get();
		return $query->result();
	}
	public function select_quotation_onroad_price()
	{
		$qutotation_model = $this->input->post('qutotation_model');
		$quotation_location = $this->input->post('quotation_location');
		$quotation_variant = $this->input->post('quotation_variant');
		$this->db->select('*');
		$this->db->from('tbl_onroad_performa_invoice op');

		$this->db->where('op.model_id', $qutotation_model);
		$this->db->where('op.variant_id', $quotation_variant);
		$this->db->where('op.location', $quotation_location);
		$query = $this->db->get();
		return $query->result();
	}
	public function select_quotation_offer()
	{
		$qutotation_model = $this->input->post('qutotation_model');
		$quotation_location = $this->input->post('quotation_location');
		$quotation_variant = $this->input->post('quotation_variant');
		$this->db->select('cons_off,offer_id');
		$this->db->from('tbl_onroad_performa_offer op');

		$this->db->where('op.model_id', $qutotation_model);
		$this->db->where('op.variant_id', $quotation_variant);
		$this->db->where('op.location', $quotation_location);
		$query = $this->db->get();
		return $query->result();
	}
	public function select_quotation_model_exchange()
	{
		$qutotation_exchange_make = $this->input->post('qutotation_exchange_make');
		$this->db->select('*');
		$this->db->from('make_models');
		$this->db->where('make_id', $qutotation_exchange_make);
		$query = $this->db->get();
		return $query->result();
	}
	public function select_quotation_variant_exchange()
	{
		$qutotation_exchange_model = $this->input->post('qutotation_exchange_model');
		$this->db->select('*');
		$this->db->from('model_variant');
		$this->db->where('model_id', $qutotation_exchange_model);
		$query = $this->db->get();
		return $query->result();
	}


	public function insert_quotation_data()
	{
		$today = date('Y-m-d');

		// Set Quotation ID
		$maxEmpId = $this->db->query("select customer_quotation_id as empId from tbl_quotation_sent order by quotation_sent_id DESC limit 1")->result();
		//$maxEmpId="MS12222";
		if (isset($maxEmpId)) {
			$maxId = substr($maxEmpId[0]->empId, 2);
			//$maxId=substr($maxEmpId,2);
			$maxIdNew = $maxId + 1;
			if (strlen($maxIdNew) < 2) {
				$maxIdNew = "MS0000" . $maxIdNew;
			} elseif (strlen($maxIdNew) < 3) {
				$maxIdNew = "MS000" . $maxIdNew;
			} elseif (strlen($maxIdNew) < 4) {
				$maxIdNew = "MS00" . $maxIdNew;
			} elseif (strlen($maxIdNew) < 5) {
				$maxIdNew = "MS0" . $maxIdNew;
			} else {
				$maxIdNew = "MS" . $maxIdNew;
			}
		} else {
			$maxIdNew = "MS00001";
		}

		echo $maxIdNew;



		$quotation_location = $this->input->post('quotation_location');

		$qutotation_model = $this->input->post('qutotation_model');
		$quotation_variant = $this->input->post('quotation_variant');

		$qutotation_buyer = $this->input->post('qutotation_buyer');

		$qutotation_exchange_make = $this->input->post('qutotation_exchange_make');
		$qutotation_exchange_model = $this->input->post('qutotation_exchange_model');



		$on_road_price_1 = $this->input->post('on_road_price_1');


		$quotation_remark = $this->input->post('quotation_remark');

		$enq_id = $this->input->post('quotation_enq_id');
		$exchange_bonus = $this->input->post('qutotation_exchange_bouns');
		$additional_offer = $this->input->post('additional_offer');
		$quotation_invoice_id = $this->input->post('quotation_invoice_id');
		$quotation_offer_id = $this->input->post('quotation_offer_id');
		$customer_type = $this->input->post('customer_type');



		$consumer_offer = $this->input->post('consumer_offer');
		$corporate_offer = $this->input->post('corporate_offer');
		$qutotation_accessories = $this->input->post('qutotation_accessories');
		$ew = $this->input->post('ew');
		$rto = $this->input->post('rto');
		$registration = $this->input->post('registration');
		$auto_card = $this->input->post('auto_card');
		$insurance = $this->input->post('insurance');
		$ex_showroom = $this->input->post('ex_showroom');
		$confirmation_code = rand(0, 10000);
		/*	$this->db->query("INSERT INTO `tbl_quotation_data`(`location`, `model_id`, `variant_id`, `buyer_type`, `exchange_make`, `exchange_model`, `bank_name_1`, `bank_name_2`, `bank_name_3`, `tenure_1`, `tenure_2`, `tenure_3`, `on_road_price_1`, `loan_amount_1`, `loan_amount_2`, `loan_amount_3`, `margin_money_1`, `margin_money_2`, `margin_money_3`, `advance_emi_1`, `advance_emi_2`, `advance_emi_3`, `processing_fee_1`, `processing_fee_2`, `processing_fee_3`, `stamp_duty_1`, `stamp_duty_2`, `stamp_duty_3`, `down_payment_1`, `down_payment_2`, `down_payment_3`, `emi_per_month_1`, `emi_per_month_2`, `emi_per_month_3`, `enq_id`, `created_date`, `remark`) 
	VALUES ('$quotation_location','$qutotation_model','$quotation_variant','$qutotation_buyer','$qutotation_exchange_make','$qutotation_exchange_model',
	'$bank_name_1','$bank_name_2','$bank_name_3','$tenure_1','$tenure_2','$tenure_3','$on_road_price_1' '$loan_amount_1','$loan_amount_2','$loan_amount_3','$margin_money_1','$margin_money_2','$margin_money_3','$adv_emi_1','$adv_emi_2','adv_emi_3','$processing_fee_1','$processing_fee_2','$processing_fee_3','$stamp_duty_1','$stamp_duty_2','$stamp_duty_3','$down_payment_1','$down_payment_2','$down_payment_3','$emi_per_month_1','$emi_per_month_2','$emi_per_month_3','$enq_id','$today','$quotation_remark')");
	*/
		$user_id = $this->user_id;
		$this->db->query("INSERT INTO `tbl_quotation_sent`(`quotation_invoice_id`,`customer_quotation_id`,`quotation_offer_id`,`lead_id`, `user_id`,`location`, `model_id`, `variant_id`, `buyer_type`, `old_make`, `old_model`,`remark`,`exchange_bonus`,`additional_offer`,`customer_type`, `on_road_price`, `corporate_offer`, `consumer_offer`,`accessories`, `quotation_sent_date`,warranty,confirmation_code,rto,registration
		,auto_card,insurance,ex_showroom
		) 
	VALUES ('$quotation_invoice_id','$maxIdNew','$quotation_offer_id','$enq_id','$user_id','$quotation_location','$qutotation_model','$quotation_variant','$qutotation_buyer','$qutotation_exchange_make','$qutotation_exchange_model','$quotation_remark','$exchange_bonus','$additional_offer','$customer_type','$on_road_price_1','$corporate_offer','$consumer_offer','$qutotation_accessories','$today','$ew','$confirmation_code','$rto','$registration','$auto_card','$insurance','$ex_showroom')");
		$quotation_sent_id = $this->db->insert_id();
		for ($i = 1; $i <= 3; $i++) {
			$bank_name = $this->input->post('bank_name_' . $i);
			$tenure = $this->input->post('tenure_' . $i);
			$loan_amount = $this->input->post('loan_amount_' . $i);
			$margin_money = $this->input->post('margin_money_' . $i);
			$adv_emi = $this->input->post('adv_emi_' . $i);
			$processing_fee = $this->input->post('processing_fee_' . $i);
			$stamp_duty =  $this->input->post('stamp_duty_' . $i);
			$down_payment =  $this->input->post('down_payment_' . $i);
			$emi_per_month =  $this->input->post('emi_per_month_' . $i);
			$this->db->query("INSERT INTO `tbl_quotation_finance_scheme`(`quotation_sent_id`, `scheme_type`, `bank_name`, `tenure`, `loan_amount`, `margin_money`, `advance_emi`, `processing_fee`, `stamp_duty`, `emi_per_month`, `down_payment`) 
	VALUES ('$quotation_sent_id','$i','$bank_name','$tenure','$loan_amount','$margin_money','$adv_emi','$processing_fee','$stamp_duty','$emi_per_month','$down_payment')");
		}
		return $quotation_sent_id;
	}

	public function select_quotation_sent_data($quotation_id)
	{
		$this->db->select('op.ex_showroom,op.company_registration_with_hp,op.zero_dep_insurance_with_rti_and_engine_protect,op.individual_registration_with_hp,op.ins_corp,op.registration,op.nexa_card,qs.warranty,qs.quotation_sent_id,qs.lead_id,qs.customer_quotation_id,qs.user_id,qs.confirmation_code,qs.location,qs.buyer_type,qs.old_make,qs.old_model`,qs.remark,qs.exchange_bonus,qs.additional_offer,v.variant_name,m.model_name,qf.cons_off,qf.cons_offdlr,qs.customer_type,qs.on_road_price,l.enq_id,l.name,l.contact_no,l.address,l.email,qs.corporate_offer,l1.fname,l1.lname,qs.accessories,qs.consumer_offer');
		$this->db->from('tbl_quotation_sent qs');
		$this->db->join('tbl_onroad_performa_invoice op', 'op.quotation_id=qs.quotation_invoice_id');
		$this->db->join('tbl_onroad_performa_offer qf', 'qf.offer_id=qs.quotation_offer_id', 'left');
		$this->db->join('lead_master l', 'l.enq_id=qs.lead_id');
		$this->db->join('lmsuser l1', 'l1.id=l.assign_to_dse', 'left');
		$this->db->join('model_variant v', 'qs.variant_id=v.variant_id');
		$this->db->join('make_models m', 'qs.model_id=m.model_id');
		$this->db->where('qs.quotation_sent_id', $quotation_id);

		$query = $this->db->get();
		return $query->result();
	}
	public function select_finance_quotation($quotation_id)
	{
		$this->db->select('*');
		$this->db->from('tbl_quotation_finance_scheme qs');
		$this->db->where('quotation_sent_id', $quotation_id);
		$query = $this->db->get();
		return $query->result();
	}
	function select_quotation_download($enq_id)
	{

		//$this->db->distinct();
		$this->db->select('s.*,m.model_name,v.variant_name,l.fname,l.lname');
		$this->db->from('tbl_quotation_sent s');
		$this->db->join('make_models m', 'm.model_id=s.model_id');
		$this->db->join('model_variant v', 'v.variant_id=s.variant_id');
		$this->db->join('lmsuser l', 'l.id=s.user_id');
		$this->db->where('s.lead_id', $enq_id);
		//	$this -> db -> where('fstatus!=', 'Deactive');
		$query = $this->db->get();

		return $query->result();
	}
}
