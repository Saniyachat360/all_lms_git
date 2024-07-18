<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_service extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model('api_service_model');
		date_default_timezone_set('Asia/Kolkata');		
	}
    //For Add Customer and tracker
	function select_lead_source() {
		$process_id=$this->input->post('process_id');	
		$query = $this -> api_service_model -> select_lead_source($process_id);
		$response["select_lead_source"] = $query;
		echo json_encode($response);
	}
    //Insert service follow up
	 function insert_service_followup()
     {
         $query = $this -> api_service_model -> insert_service_followup();
     }
	 function insert_finance_followup()
     {
         $query = $this -> api_service_model -> insert_finance_followup();
     }

}