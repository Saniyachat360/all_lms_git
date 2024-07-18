<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class api_reports extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');		
		$this -> load -> model('api_reports_model');
		date_default_timezone_set('Asia/Kolkata');		
	}
	public function lead_sourcewise() {
		
		$campaign_name = $this -> input -> post('campaign_name');
		$fromdate=$this -> input -> post('fromdate');
		$todate=$this -> input -> post('todate');
		$role=$this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		$process_id = $this -> input -> post('process_id');
		$process_name=$this -> input -> post('process_name');
		$query=$this -> api_reports_model -> select_lead_sourcewise_count($campaign_name,$fromdate,$todate,$role,$user_id,$process_id,$process_name);	
		$response["lead_sourcewise"] = $query;
		echo json_encode($response);
	}
public function cse_performance() {
		
		$cse_id = $this -> input -> post('cse_id');
		$fromdate=$this -> input -> post('fromdate');
		$todate=$this -> input -> post('todate');
		$role=$this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		$process_id = $this -> input -> post('process_id');
		$process_name=$this -> input -> post('process_name');
		$query=$this -> api_reports_model -> search_performance($cse_id,$fromdate,$todate,$role,$user_id,$process_id,$process_name);	
		$response["cse_performance"] = $query;
		echo json_encode($response);
	}
public function cse_productivity() {
		
		$cse_id = $this -> input -> post('cse_id');
		$fromdate=$this -> input -> post('fromdate');
		$todate=$this -> input -> post('todate');
		$role=$this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		$process_id = $this -> input -> post('process_id');
		$process_name=$this -> input -> post('process_name');
		$query=$this -> api_reports_model -> cse_productivity($cse_id,$fromdate,$todate,$role,$user_id,$process_id,$process_name);	
		$response["cse_productivity"] = $query;
		echo json_encode($response);
	}
public function appointment_report() {
		
		$location_id=$this->input->post('location_id');
		$fromdate=$this -> input -> post('fromdate');
		$todate=$this -> input -> post('todate');
		$role=$this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		$process_id = $this -> input -> post('process_id');
		$process_name=$this -> input -> post('process_name');
		$query=$this -> api_reports_model -> appointment_report($location_id,$fromdate,$todate,$role,$user_id,$process_id,$process_name);	
		$response["appointment_report"] = $query;
		echo json_encode($response);
	}
public function locationwise_report() {
		
		$location_id=$this->input->post('location_id');
		$fromdate=$this -> input -> post('fromdate');
		$todate=$this -> input -> post('todate');
		$role=$this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		$process_id = $this -> input -> post('process_id');
		$process_name=$this -> input -> post('process_name');
		$query=$this -> api_reports_model -> locationwise_report($location_id,$fromdate,$todate,$role,$user_id,$process_id,$process_name);	
		$response["locationwise_report"] = $query;
		echo json_encode($response);
	}
public function dse_productivity() {
		$location=$this->input->post('location_id');
		$dse_name=$this->input->post('dse_id');
		
		$fromdate=$this -> input -> post('fromdate');
		$todate=$this -> input -> post('todate');
		$role=$this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		$process_id = $this -> input -> post('process_id');
		$process_name=$this -> input -> post('process_name');
		$query=$this -> api_reports_model -> dse_productivity($location,$dse_name,$fromdate,$todate,$role,$user_id,$process_id,$process_name);	
		$response["dse_productivity"] = $query;
		echo json_encode($response);
	}
public function dse_performance() {
		
		$location=$this->input->post('location_id');
		$dse_name=$this->input->post('dse_id');
		$fromdate=$this -> input -> post('fromdate');
		$todate=$this -> input -> post('todate');
		$role=$this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		$process_id = $this -> input -> post('process_id');
		$process_name=$this -> input -> post('process_name');
		$query=$this -> api_reports_model -> dse_performance($location,$dse_name,$fromdate,$todate,$role,$user_id,$process_id,$process_name);	
		$response["dse_performance"] = $query;
		echo json_encode($response);
	}
} 