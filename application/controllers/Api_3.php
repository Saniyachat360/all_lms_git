<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_3 extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session','email'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model('api_3_model');
		date_default_timezone_set('Asia/Kolkata');		
	}
	public function select_lead_source() {
		$query1=$this -> api_3_model -> select_lead_source(6);
		$response["select_lead_source"] = $query1;
		echo json_encode($response);

	}
	public function select_process() {
		$query1= $this -> api_3_model -> select_process();
		$response["select_process"] = $query1;
		echo json_encode($response);

	}
	public function select_transfer_to_user() {
		
		$transfer_process=$this->input->post('transfer_process_id');
		$transfer_location=$this->input->post('transfer_location_id');
		$role = $this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		$session_process=$this->input->post('session_process_id');
		$response["select_transfer_to_user"] = $this -> api_3_model -> select_transfer_to_user($transfer_process,$transfer_location,$role,$user_id,$session_process);
		echo json_encode($response);
	}
	public function sign_up() {
		$this -> api_3_model -> sign_up();

	}
	
		
	public function send_otp() {
		//$response["otp"] =
		$this -> api_3_model -> send_otp();
		//echo json_encode($response);
	}
	public function add_cross_lead() {
		$this -> api_3_model -> add_cross_lead();
		//echo json_encode($response);
	}
	public function select_all_cross_lead() {
		$process_id = $this -> input -> post('process_id');
		$process_name = $this -> input -> post('process_name');
		$user_id = $this -> input -> post('user_id');
		$date = $this -> input -> post('date');
		$status = $this -> input -> post('status');
		if ($process_id == '') {
			$query = $this -> api_3_model -> select_all_cross_lead($user_id,$date,$status);
			$query1 = $this -> api_3_model -> select_all_cross_lead_count($user_id,$date,$status);
		} else {
			$query = $this -> api_3_model -> select_all_cross_lead_processwise($user_id, $process_id, $process_name,$date,$status);
			$query1 = $this -> api_3_model -> select_all_cross_lead_count_processwise($user_id, $process_id, $process_name,$date,$status);
		}
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);

	}
	public function dashboard() {
		$query1= $this -> api_3_model -> cross_lead_dashboard();
		$response["dashboard"] = $query1;
		echo json_encode($response);

	}
	public function dashboard_show_data() {
		$lead_type = $this -> input -> post('lead_type');
		$process_name = $this -> input -> post('process_name');
		$user_id = $this -> input -> post('user_id');
		
		$query1= $this -> api_3_model -> select_lead($user_id, $process_name, $lead_type);
		$query2= $this -> api_3_model -> select_lead_count($user_id, $process_name, $lead_type);
		$response["lead_details_count"] = $query2;
		$response["lead_details"] = $query1;
		echo json_encode($response);

	}
	public function customer_details()
	{
		$id = $this -> input -> post('enq_id');
		$process_id= $this -> input -> post('process_id');
		$sub_poc_purchase =$this -> input -> post('sub_poc_purchase');
		/*if($process_id==9){
			$query = $this -> api_new_complaint_model -> customer_details($id,$process_id);
		}
		else {*/
			$query = $this -> api_3_model -> customer_details($id,$process_id,$sub_poc_purchase);
		//}		
		
		$response["customer_details"] = $query;
		echo json_encode($response);
	}
}
