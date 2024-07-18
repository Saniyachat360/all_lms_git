<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_chat360 extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session','email'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model('api_chat360_model');
			
		date_default_timezone_set('Asia/Kolkata');		
	}
	function car_model(){
			
		$make_id=$this->input->post('make_id');
		$query = $this -> api_chat360_model -> select_model($make_id);
		$response["car_model"] = $query;
		$query1 = $this -> api_chat360_model -> select_model_count($make_id);
		$response["car_model_count"] = $query1[0]->modelcount;
		$response["min_count"] = "10";
		$response["max_count"] = "20";
		echo json_encode($response);
	}
public function car_variant() {
		$model_id = $this -> input -> post('model_id');
		if($model_id==''){
		$response["success"] = 0;
				$response["message"] = "Please provide model_id.";
}else{
		$query = $this -> api_chat360_model -> model_variant($model_id);
		$response["car_variant"] = $query;
		$query1 = $this -> api_chat360_model -> select_variant_count($model_id);
		$response["car_variant_count"] = $query1[0]->variantcount;
		$response["min_count"] = "4";
		$response["max_count"] = "15";
	}
		echo json_encode($response);

	}
	public function quotation_location() {

		$response["quotation_location"] = $query=$this -> api_chat360_model -> quotation_location();
		$query1 = $this -> api_chat360_model -> quotation_location_count();
		$response["quotation_location_count"] = $query1[0]->locationcount;
		echo json_encode($response);
	}
	public function price_detail() {
		$qutotation_model = $this -> input -> post('model_id');
 $quotation_location = $this -> input -> post('location');
$quotation_variant = $this -> input -> post('variant_id');
if($qutotation_model=='' || $quotation_location=='' || $quotation_variant==''){
$response["success"] = 0;
				$response["message"] = "Please Provide Model Id, Variant Id and Location.";

}else{
		$response["quotation_onroad_price"] = $this -> api_chat360_model -> select_quotation_onroad_price();		
		$response["quotation_offer"] = $this -> api_chat360_model -> select_quotation_offer();
	}
		echo json_encode($response);
	}
	public function add_lead()
	{
		$this -> api_chat360_model -> add_lead();
	}
	
		// Insurancecode
	public function add_insurance_lead()
	{
		$this -> api_chat360_model -> add_insurance_lead();
	}
	// Insurancecode
	
	public function car_service_details()
	{
		$this -> api_chat360_model -> car_service_details();
	}
	public function car_service_pickup_details()
	{
		$this -> api_chat360_model -> car_service_pickup_details();
	}
	public function test_drive()
	{
		$this -> api_chat360_model -> test_drive();
		
	}
	
	public function update_model_details()
	{

		$this -> api_chat360_model -> update_model_details();
		
	}
	public function update_poc_details()
	{
				$this -> api_chat360_model -> update_poc_details();
		
	}
	public function update_finance_details()
	{
				$this -> api_chat360_model -> update_finance_details();
		
	}
}
