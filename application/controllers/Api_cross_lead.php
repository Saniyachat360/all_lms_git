<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class api_cross_lead extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model(array('api_new_model', 'api_new_complaint_model', 'api_cross_lead_model'));
		date_default_timezone_set('Asia/Kolkata');
	}
	public function change_password() {
		$old_pwd = $this -> input -> post('old_password');
		$new_pwd = $this -> input -> post('new_password');
		$user_id = $this -> input -> post('user_id');
		$query = $this -> api_new_model -> change_password($old_pwd, $new_pwd,$user_id);
	}
	public function send_otp() {
		//$response["otp"] =
		$this -> api_cross_lead_model -> send_otp();
		//echo json_encode($response);
	}

	public function sign_up() {
		$this -> api_cross_lead_model -> sign_up();

	}

	public function add_cross_lead() {
		$this -> api_cross_lead_model -> add_cross_lead();
		//echo json_encode($response);
	}

	public function select_all_cross_lead() {
		$process_id = $this -> input -> post('process_id');
		$process_name = $this -> input -> post('process_name');
		$user_id = $this -> input -> post('user_id');
		$date = $this -> input -> post('date');
		$status = $this -> input -> post('status');
		if ($process_id == '') {
			$query = $this -> api_cross_lead_model -> select_all_cross_lead($user_id,$date,$status);
			$query1 = $this -> api_cross_lead_model -> select_all_cross_lead_count($user_id,$date,$status);
		} else {
			$query = $this -> api_cross_lead_model -> select_all_cross_lead_processwise($user_id, $process_id, $process_name,$date,$status);
			$query1 = $this -> api_cross_lead_model -> select_all_cross_lead_count_processwise($user_id, $process_id, $process_name,$date,$status);
		}
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);

	}

	public function slider_image() {

		$response["slider_image"] = $this -> api_cross_lead_model -> slider_image();
		echo json_encode($response);
	}
	public function lat_long() {

		$response["lat_long"] = $this -> api_cross_lead_model -> lat_long();
		echo json_encode($response);
	}

	public function cl_dashboard_count() {
		$user_id = $this -> input -> post('user_id');
		$query1 = $this -> api_cross_lead_model -> cl_dashboard_count($user_id);
		$response["cl_dashboard_count"] = $query1;
		echo json_encode($response);
	}

	public function cl_dashboard_leads() {
		$user_id = $this -> input -> post('user_id');
		$type = $this -> input -> post('type');
		if ($type == 'converted_lead') {
			$query = $this -> api_cross_lead_model -> cl_dashboard_converted_leads($user_id);
			$query1 = $this -> api_cross_lead_model -> converted_leads($user_id);
		} else if ($type == 'lost_leads') {
			$query = $this -> api_cross_lead_model -> cl_dashboard_lost_leads($user_id);
			$query1 = $this -> api_cross_lead_model -> lost_leads($user_id);
		} else if ($type == 'live_lead') {
			$query = $this -> api_cross_lead_model -> cl_dashboard_live_leads($user_id);
			$query1 = $this -> api_cross_lead_model -> live_leads($user_id);
		} else {

			$query = $this -> api_cross_lead_model -> select_all_cross_lead($user_id);
			$query1 = $this -> api_cross_lead_model -> select_all_cross_lead_count($user_id);
		}
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}

	public function check_incentive_offer() {
		$process = $this -> input -> post('process');
		$scheme_name = $this -> input -> post('scheme_name');
		$query1 = $this -> api_cross_lead_model -> check_incentive_offer($process, $scheme_name);
		$response["check_incentive_offer"] = $query1;
		echo json_encode($response);
	}

	public function select_status() {
		$process = $this -> input -> post('process');
		$response["select_status"] = $this -> api_cross_lead_model -> select_status1($process);
		echo json_encode($response);
	}

	public function get_cross_lead_version() {
		$query1 = $this -> api_cross_lead_model -> get_app_version();
		$response["get_cross_lead_version"] = $query1;
		echo json_encode($response);
	}

	public function get_today_winner() {
		$query1 = $this -> api_cross_lead_model -> get_today_winner();
		$response["get_today_winner"] = $query1;
		echo json_encode($response);
	}

	public function insert_lead_incentive_details() {
		$query1 = $this -> api_cross_lead_model -> insert_lead_incentive_details();

	}

	public function bank_list() {
		$query1 = $this -> api_cross_lead_model -> bank_list();
		$response["bank_list"] = $query1;
		echo json_encode($response);
	}

	public function total_earning() {
		$query1 = $this -> api_cross_lead_model -> total_earning();
		$response["total_earning"] = $query1;
		echo json_encode($response);
	}

	public function insert_user_details() {
		$query1 = $this -> api_cross_lead_model -> insert_user_details();

	}

	public function payment_details() {
		$response["payment_details"] = $this -> api_cross_lead_model -> payment_details();
		echo json_encode($response);
	}

	public function wallet_detail() {
		$response["total_earning"] = $this -> api_cross_lead_model -> total_earning();

		$response["wallet_count"] = $this -> api_cross_lead_model -> wallet_count();
		//echo json_encode($response);
		$response["claim_history"] = $this -> api_cross_lead_model -> claim_history();
		echo json_encode($response);
	}

	//////////////////////////////////////
	//Login lms user
	public function login_cross_lead_user() {
		$username = $this -> input -> post('username');
		$password = $this -> input -> post('password');

		$query = $this -> api_cross_lead_model -> login_form($username, $password);

		if (count($query) > 0) {
			$response["success"] = 1;
			$response["user_detail"] = $query;
			$id = $query[0] -> id;
			$process_id = $query[0] -> process_id;
			$fname = $query[0] -> fname;
			$lname = $query[0] -> lname;
			$username = $fname . ' ' . $lname;
			if ($query[0] -> role == '17') {
				$get_rights = $this -> api_cross_lead_model -> get_rights_cross_lead($id);
				$response["rights"] = $get_rights;
			} else {

				$process = $this -> api_new_model -> select_user_all_process($id);

				$s[] = array('user_id' => $id, 'username' => $username, 'role' => $query[0] -> role, 'role_name' => $query[0] -> role_name, 'process' => $process);

				$response["session_data"] = $s;
				//Set Rights in session
				$get_rights = $this -> api_new_model -> get_right($id);
				$get_rights_poc_tracking = $this -> api_new_model -> get_poc_tracking_right($id);
				if (count($get_rights) > 0) {
					$response["rights"] = $get_rights;
					$response["poc_purchase_tracking_rights"] = $get_rights_poc_tracking;
				} else {
					$response["rights"] = 'No Rights Found !!';

				}
			}

		} else {

			$response["success"] = 0;
			$response["user_detail"] = "Oops! An error occurred.";

		}
		echo json_encode($response);

	}

	public function forgot_password_otp() {
		//$email=$this->input->post('email');

		$query = $this -> api_cross_lead_model -> forgot_password_otp();
	}

	public function forgot_password_cross_lead() {
		$email = $this -> input -> post('moblie_no');

		$query = $this -> api_cross_lead_model -> forgot_pwd($email);
	}

	public function insert_incentive_claim() {
		$query1 = $this -> api_cross_lead_model -> insert_incentive_claim();

	}
	public function date_filter() {

		$response["date_filter"] = $this -> api_cross_lead_model -> date_filter();
		echo json_encode($response);
	}

}
