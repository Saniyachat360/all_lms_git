<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class api_new extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper('form');
		$this -> load -> helper('url');
		$this -> load -> model(array('api_new_model','api_new_complaint_model','api_new_lead_report_model','api_cross_lead_model'));
		date_default_timezone_set('Asia/Kolkata');		
	}


	/////////////////////////////////////////////////
	//Spiner
	//For Add Customer and tracker
	function select_lead_source() {
		$process_id=$this->input->post('process_id');	
		$query = $this -> api_new_model -> select_lead_source($process_id);
		$response["select_lead_source"] = $query;
		echo json_encode($response);
	}
	//For Add Customer and tracker
	function select_sub_lead_source() {
		$process_id=$this->input->post('process_id');	
		$lead_source_name=$this->input->post('lead_source_name');
		$query = $this -> api_new_model -> select_sub_lead_source($process_id,$lead_source_name);
		$response["select_sub_lead_source"] = $query;
		echo json_encode($response);
	}
	
	//For Add Customer
	function select_user() {
			
		$process_id=$this->input->post('process_id');
		$query = $this -> api_new_model -> select_user($process_id);
		$response["select_user"] = $query;
		echo json_encode($response);
	}
function select_user_map() {
			
		$process_id=$this->input->post('process_id');
		$location_id=$this->input->post('location_id');
		$query = $this -> api_new_model -> select_user_map($process_id,$location_id);
		$response["select_user"] = $query;
		echo json_encode($response);
	}
	
	//For Add Customer
	function select_feedback(){
			
		$process_id=$this->input->post('process_id');
		$query = $this -> api_new_model -> select_feedback($process_id);
		$response["select_feedback"] = $query;
		echo json_encode($response);
	}

function select_next_action_feedback(){
			
		$process_id=$this->input->post('process_id');
		$feedback=$this->input->post('feedback');
		$query = $this -> api_new_model -> select_next_action_feedback($process_id,$feedback);
		$response["select_nextaction"] = $query;
		echo json_encode($response);
	}
	public function select_car_make() {
		$query = $this -> api_new_model -> select_make();
		$response["select_car_make"] = $query;
		echo json_encode($response);

	}
function select_car_model(){
			
		$make_id=$this->input->post('make_id');
		$query = $this -> api_new_model -> select_model($make_id);
		$response["select_car_model"] = $query;
		echo json_encode($response);
	}
public function select_car_variant() {
		$model_id = $this -> input -> post('model_id');
		$query = $this -> api_new_model -> model_variant($model_id);
		$response["select_car_variant"] = $query;
		echo json_encode($response);

	}
function select_login_status(){
			
	
		$query = $this -> api_new_model -> select_login_status();
		$response["select_login_status"] = $query;
		echo json_encode($response);
	}
function select_accessories(){
			
	
		$query = $this -> api_new_model -> select_accessories();
		$response["select_accessories"] = $query;
		echo json_encode($response);
	}
function select_accessories_car_model(){
			
	
		$query = $this -> api_new_model -> select_accessories_car_model();
		$response["select_accessories_car_model"] = $query;
		echo json_encode($response);
	}

//For Add Customer
	function select_location(){
		$process_id=$this->input->post('process_id');
		$user_id=$this->input->post('user_id');
		$role=$this->input->post('role');
		$location_id=$this->input->post('location_id');
		$query = $this -> api_new_model ->select_location($process_id,$role,$location_id,$user_id);
		$response["select_location"] = $query;
		echo json_encode($response);
	}
	
	
	//////////////////////////////////////
	//Login lms user
	public function login_user() {
		$username=$this->input->post('username'); 
		$password=$this->input->post('password'); 
		
		$query = $this -> api_new_model -> login_form($username, $password);
		
		if (count($query) > 0) {
			$response["success"] = 1;
			$response["user_detail"] = $query;
			$id = $query[0] -> id;
			$process_id = $query[0] -> process_id;
			$fname = $query[0] -> fname;
			$lname = $query[0] -> lname;
			$username = $fname . ' ' . $lname;
			if($query[0] -> role=='17')
			{
				$process=$this -> api_new_model -> select_user_all_process($id);
				$s[] = array('user_id' => $id,'username' => $username,  'role' => $query[0] -> role,'role_name'=>$query[0]->role_name);			
				$response["session_data"] = $s;
				$get_rights = $this -> api_cross_lead_model -> get_rights_cross_lead($id);
				$response["rights"] = $get_rights;
			}
			else {
		
			$process=$this -> api_new_model -> select_user_all_process($id);
			
			$s[] = array('user_id' => $id,'username' => $username,  'role' => $query[0] -> role,'role_name'=>$query[0]->role_name,'process'=>$process);
			
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

	public function change_password() {
		$old_pwd = $this -> input -> post('old_password');
		$new_pwd = $this -> input -> post('new_password');
		$user_id = $this -> input -> post('user_id');

		$query = $this -> api_new_model -> change_password($old_pwd, $new_pwd,$user_id);
	
		

	}
		//Change Process Name
	function change_header_data()
	{
		$process_id=$this->input->post('process_id');
		$query=$this->db->query("select process_name from tbl_process where process_id='$process_id'")->result();
		$response["process_name"] = $query;
		echo json_encode($response);	
	}
	/////////////////////////////////////////////////////////////////
/********************* New Dashboard(with TL,Executive button) ****************************************/
	public function new_dashboard() {
		//echo "hi";
		$process_id=$this->input->post('process_id');
		if($process_id==9)
		{
			$response["new_dashboard"] = $this -> api_new_complaint_model -> new_dashboard();
		}
		else {
			$response["new_dashboard"] = $this -> api_new_model -> new_dashboard();
		}
		
		
		echo json_encode($response);
	}
	/////////////////////////////////////////////////////////////
//////////////Calling Notification///////////////////////


//New Lead Details and Count
public function select_new_lead() {
		//IF check from Dashboard
		$role = $this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		
		//login user data
		$role_session=$this -> input -> post('role_session');
		$user_id_session=$this -> input -> post('user_id_session');
		$process_id_session = $this -> input -> post('process_id_session');
		$process_name_session=$this -> input -> post('process_name_session');
		$sub_poc_purchase_session=$this -> input -> post('sub_poc_purchase_session');
		//Filter data
		$contact_no=$this -> input -> post('contact_no');
		$page = $this -> input -> post('page');
		if($process_id_session==9)
		{
			$query = $this -> api_new_complaint_model -> select_new_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
			$query1 = $this -> api_new_complaint_model -> select_new_lead_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
		}
		else {
			$query = $this -> api_new_model -> select_new_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$sub_poc_purchase_session);
			$query1 = $this -> api_new_model -> select_new_lead_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$sub_poc_purchase_session);
		}
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}

	//Unassigned Lead Details and Count
	public function select_unassigned_lead() {
		//If check from dashboard
		$role = $this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		
		//login user data
		$process_name_session=$this -> input -> post('process_name_session');
		$process_id_session = $this -> input -> post('process_id_session');
		$user_id_session= $this -> input -> post('user_id_session');
		$role_session=$this -> input -> post('role_session');
		$sub_poc_purchase_session=$this -> input -> post('sub_poc_purchase_session');
		
		//Filter Data
		$contact_no=$this -> input -> post('contact_no');
		 $page = $this -> input -> post('page');
		 if($process_id_session==9)
		{
			$query = $this -> api_new_complaint_model -> select_unassigned_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
			$query1 = $this -> api_new_complaint_model -> select_unassigned_lead_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
		
		}
		else {
			$query = $this -> api_new_model -> select_unassigned_lead($role,$user_id,$user_id_session,$process_name_session,$process_id_session,$contact_no,$page,$sub_poc_purchase_session);
		$query1 = $this -> api_new_model -> select_unassigned_lead_count($role,$user_id,$user_id_session,$process_name_session,$process_id_session,$contact_no,$page,$sub_poc_purchase_session);
		
		}
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}

//Today Followup Lead Details and Count
public function select_today_followup_lead() {
	
		$role = $this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		
		//login user data
		$process_name_session=$this -> input -> post('process_name_session');
		$process_id_session = $this -> input -> post('process_id_session');
		$user_id_session= $this -> input -> post('user_id_session');
		$role_session=$this -> input -> post('role_session');
		$sub_poc_purchase_session=$this -> input -> post('sub_poc_purchase_session');
		//Filter Data
		$contact_no=$this -> input -> post('contact_no');
		 $page = $this -> input -> post('page');
		  if($process_id_session==9)
		{
			$query = $this -> api_new_complaint_model -> select_today_followup_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
			$query1 = $this -> api_new_complaint_model -> select_today_followup_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
		
		}
		else {
			$query = $this -> api_new_model -> select_today_followup_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$sub_poc_purchase_session);
		$query1 = $this -> api_new_model -> select_today_followup_lead_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$sub_poc_purchase_session);
		
		}
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}
//pending New Lead Details and Count
public function select_pending_new_lead() {
		
		$role = $this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');		
		//login user data
		$process_name_session=$this -> input -> post('process_name_session');
		$process_id_session = $this -> input -> post('process_id_session');
		$user_id_session= $this -> input -> post('user_id_session');
		$role_session=$this -> input -> post('role_session');		
		$sub_poc_purchase_session=$this -> input -> post('sub_poc_purchase_session');		
		//Filter Data
		$contact_no=$this -> input -> post('contact_no');
		 $page = $this -> input -> post('page');
		 
		  if($process_id_session==9)
		{
			$query = $this -> api_new_complaint_model -> select_pending_new_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
			$query1 = $this -> api_new_complaint_model -> select_pending_new_lead_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
		
		}
		else {
			$query = $this -> api_new_model -> select_pending_new_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$sub_poc_purchase_session);
		$query1 = $this -> api_new_model -> select_pending_new_lead_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$sub_poc_purchase_session);
		
		}
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}
//pending Followup Lead Details and Count
public function select_pending_followup_lead() {
		$role = $this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');		
		//login user data
		$process_name_session=$this -> input -> post('process_name_session');
		$process_id_session = $this -> input -> post('process_id_session');
		$user_id_session= $this -> input -> post('user_id_session');
		$role_session=$this -> input -> post('role_session');		
		$sub_poc_purchase_session=$this -> input -> post('sub_poc_purchase_session');		
		//Filter Data
		$contact_no=$this -> input -> post('contact_no');
		 $page = $this -> input -> post('page');
		   if($process_id_session==9)
		{
			$query = $this -> api_new_complaint_model -> select_pending_followup_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
			$query1 = $this -> api_new_complaint_model -> select_pending_followup_lead_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
		
		}
		else {
				$query = $this -> api_new_model -> select_pending_followup_lead($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$sub_poc_purchase_session);
		$query1 = $this -> api_new_model -> select_pending_followup_lead_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$sub_poc_purchase_session);
		
		}
	$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}
///////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////
	
	
	//Add New Customer
	//spinner
	public function select_user_for_new_customer() 
	{
		
		$query = $this -> api_new_model ->select_user_for_new_customer();
		$response["select_user"] = $query;
		echo json_encode($response);
		
	}
	public function add_customer() {

		$fname = $this -> input -> post('fname');
	
		$email = $this -> input -> post('email');
		$address = $this -> input -> post('address');
		$contact_no = $this -> input -> post('contact_no');
		$comment = $this -> input -> post('comment');
		$role_session = $this -> input -> post('role_session');
		$user_id_session = $this -> input -> post('user_id_session');
		$assign = $this -> input -> post('assign');
		$lead_source = $this -> input -> post('lead_source');
		$sub_lead_source = $this -> input -> post('sub_lead_source');
		$assignby=$this->input->post('assignby');
		$username=$this->input->post('username');
		$process_id=$this->input->post('process_id');
		$location=$this->input->post('location');
		
		if($lead_source=='Web'){
			$lead_source='';
	}
	if($process_id==8){
		$query = $this -> api_new_model -> add_customer_evaluation_new($fname,$email,$address,$contact_no,$comment,$assign,$lead_source,$assignby,$username,$process_id,$location,$role_session,$user_id_session,$sub_lead_source);
	}
	elseif($process_id==9){
		//$query = $this -> api_new_complaint_model -> add_customer_complaint($fname,$email,$address,$contact_no,$comment,$assign,$lead_source,$assignby,$username,$process_id,$location,$role_session,$user_id_session,$sub_lead_source);
	}
	else{
		
		$query = $this -> api_new_model -> add_customer($fname,$email,$address,$contact_no,$comment,$assign,$lead_source,$assignby,$username,$process_id,$location,$role_session,$user_id_session,$sub_lead_source);
													
	}
	}
	////////////////////////////////////////////////////////

//Select Tracker 
public function select_lead_tracker() {
		//login user data
		$process_name=$this -> input -> post('process_name');
		$process_id = $this -> input -> post('process_id');
		$role_session= $this -> input -> post('role');
		$user_id= $this -> input -> post('user_id');
		$role_name_session= $this -> input -> post('role_name');
		$sub_poc_purchase_session=$this -> input -> post('sub_poc_purchase_session');		
		
		//Filter data
		$campaign_name = $this -> input -> post('campaign_name');
		$feedback=$this -> input -> post('feedback');
		$nextaction=$this -> input -> post('nextaction');
		$date_type = $this -> input -> post('date_type');
		$fromdate = $this -> input -> post('fromdate');
		$todate = $this -> input -> post('todate');
		$page=$this -> input -> post('page');
		if($process_id==9)
		{
			$query = $this -> api_new_complaint_model -> select_lead_tracker($process_name,$process_id,$campaign_name,$feedback,$nextaction,$date_type,$fromdate,$todate,$role_session,$role_name_session,$user_id,$page);
			$query1 = $this -> api_new_complaint_model -> select_lead_tracker_count($process_name,$process_id,$campaign_name,$feedback,$nextaction,$date_type,$fromdate,$todate,$role_session,$role_name_session,$user_id,$page);
	
		}
		else {
			$query = $this -> api_new_model -> select_lead_tracker($process_name,$process_id,$campaign_name,$feedback,$nextaction,$date_type,$fromdate,$todate,$role_session,$role_name_session,$user_id,$page,$sub_poc_purchase_session);
			$query1 = $this -> api_new_model -> select_lead_tracker_count($process_name,$process_id,$campaign_name,$feedback,$nextaction,$date_type,$fromdate,$todate,$role_session,$role_name_session,$user_id,$page,$sub_poc_purchase_session);
		}
		//$query1=count($query1);
		$response["user_details_count"] = $query1;
		$response["user_details"] = $query;
		echo json_encode($response);
	}
//////////////////////////////////////////////////////////



//All Lead Details and Count
public function select_all_followup_lead() {
	 $process_name= $this -> input -> post('process_name');
		 $process_id = $this -> input -> post('process_id');
		$role = $this -> input -> post('role');
		 $user_id=$this -> input -> post('user_id');
		$contact_no=$this -> input -> post('contact_no');
		$page = $this -> input -> post('page');
		$role_name = $this -> input -> post('role_name');
	$sub_poc_purchase_session=$this->input->post('sub_poc_purchase_session');
		$query = $this -> api_new_model -> select_all_followup_lead($role,$process_name,$user_id,$contact_no,$page,$process_id,$role_name,$sub_poc_purchase_session);
		$query1 = $this -> api_new_model -> select_all_followup_lead_count($role,$process_name,$user_id,$contact_no,$page,$process_id,$role_name,$sub_poc_purchase_session);
		$response["lead_details_count"] = $query1;
		
		$response["lead_details"] = $query;
		echo json_encode($response);
	}
///////////////////////////////////////////////////////////////////////
// search by name and contact Number
	 public function search_by_name_contact()
	{
		$customer_name = $this -> input -> post('customer_name');
		$process_name= $this -> input -> post('process_name');
		$process_id= $this -> input -> post('process_id');
		$sub_poc_purchase_session= $this -> input -> post('sub_poc_purchase_session');
		if($process_id==9){
			$query = $this -> api_new_complaint_model -> search_by_name_contact($customer_name,$process_name,$process_id);
		}
		else {
			$query = $this -> api_new_model -> search_by_name_contact($customer_name,$process_name,$process_id,$sub_poc_purchase_session);
		}		
		$response["lead_data"] = $query;
		echo json_encode($response);
	}
	// search transfer customer flow
	 public function searchCustomer_flow()
	{
		
		$process_id= $this -> input -> post('process_id');
			$enq_id= $this -> input -> post('enq_id');
		$query = $this -> api_new_model -> searchCustomer_flow($enq_id,$process_id);
		$response["lead_data"] = $query;
		echo json_encode($response);
	}
		/////////////////////////////////////////////////////////////////
	// fetch customer details for edit
	 public function edit_customer()
	{
		$id = $this -> input -> post('enq_id');
			$process_id= $this -> input -> post('process_id');
		$query = $this -> api_new_model -> edit_customer($id,$process_id);
		$response["lead_data"] = $query;
		echo json_encode($response);
	}
	// fetch customer details for edit
	 public function update_customer()
	{
		 $id = $this -> input -> post('enq_id');
	$name = $this -> input -> post('name');
	$contact = $this -> input -> post('contact');
	$email = $this -> input -> post('email');
	$address = $this -> input -> post('address');
	$process_id= $this -> input -> post('process_id');
	$user_id= $this -> input -> post('user_id');
		$query = $this -> api_new_model -> update_customer($id,$process_id,$user_id,$name,$contact,$email,$address);
		
	}
	///////////////////////////////////////////////////////
	// Customer Details
	public function customer_details()
	{
		$id = $this -> input -> post('enq_id');
		$process_id= $this -> input -> post('process_id');
		$sub_poc_purchase =$this -> input -> post('sub_poc_purchase');
		if($process_id==9){
			$query = $this -> api_new_complaint_model -> customer_details($id,$process_id);
		}
		else {
			$query = $this -> api_new_model -> customer_details($id,$process_id,$sub_poc_purchase);
		}		
		
		$response["customer_details"] = $query;
		echo json_encode($response);
	}
	public function followup_details()
	{
		$id = $this -> input -> post('enq_id');		
		$process_id= $this -> input -> post('process_id');
		
		if($process_id==9){		
		$query1 = $this -> api_new_complaint_model -> followup_details($id,$process_id);
		}
		else {
			$query1 = $this -> api_new_model -> followup_details($id,$process_id);
		}
		$response["followup_details"] = $query1;
		echo json_encode($response);
	}
	/////////////////////////////////////////////////////////////////////////////////////////
	//Insert Finance follow up
	 public function insert_finance_followup()
	{
		$query = $this -> api_new_model -> insert_finace_followup();
	
	}
	//Insert service follow up
	 public function insert_service_followup()
	{
		$query = $this -> api_new_model -> insert_service_followup();
	}
	//Insert new car follow up
	 public function insert_new_car_followup()
	{
		$query = $this -> api_new_model -> insert_new_car_followup();
		
		//Send quotation 
		$customer_name = $this -> input -> post('customer_name');
		$email = $this -> input -> post('email');
		$phone = $this -> input -> post('phone');
		
		$quotation_location = $this -> input -> post('qlocation');
		$quotation_model_name = $this -> input -> post('model_id');
		$quotation_description = $this -> input -> post('description');
		$accessories_package_name = $this -> input -> post('accessories_package_name');
	
		$new_model=$this->input->post('new_model');
		$brochure=$this->input->post('brochure');
		
		if (isset($brochure)) {
			$brochure='Checked';
		}else{
			$brochure='Not Checked';
		}
		if($quotation_model_name!='' ||  $brochure == 'Checked')
		{
		$this->send_mail($email,$customer_name,$quotation_location, $quotation_model_name, $quotation_description,$accessories_package_name,$phone,$new_model,$brochure);
		}
	}
	
	//Insert new car follow up
	 public function insert_used_car_followup()
	{
		$query = $this -> api_new_model -> insert_used_car_followup();
	}
	//Insert new car follow up
	 public function insert_used_car_followup_demo()
	{
		$query = $this -> api_new_model -> insert_used_car_followup_demo();
	}
	//Insert new car follow up
	 public function insert_evaluation_followup()
	{
		$query = $this -> api_new_model -> insert_evaluation_followup();
	}
	//Insert Accessories follow up
	 public function insert_accessories_followup()
	{
		$query = $this -> api_new_model -> insert_accessories_followup();
	}
	 public function insert_escalation_detail()
	{
		$enq_id = $this -> input -> post('booking_id');	
		$escalation_type = $this->input->post('escalation_type');
		$process_id = $this->input->post('process_id');
		$query = $this -> api_new_model -> insert_escalation_detail();
		$this->send_escalation_mail($enq_id,$escalation_type,$process_id);
	}
	
		//Send Quotation mail to used 
  public function send_escalation_mail($enq_id,$escalation_type,$process_id)
  {
	 
	 $query=$this->api_new_model -> get_escalation_detail($enq_id,$process_id);
	 $data['query']=$query;
	  $csetl_email= $query[0]->csetl_email;
	 $dsetl_email=$query[0]->dsetl_email;
	 $gm_email=$query[0]->gm_email;
	 $sm_email=$query[0]->sm_email;
	
	//"pereira_irwin@autovista.in","shaikh.hafiz@autovista.in",'$csetl_email','$dsetl_email','$gm_email','$sm_email'
  	$this->load->helper('path');
 	$config = Array(       
          'mailtype'  => 'html'
         );
   	$this->load->library('email', $config);
	$this->email->from('support@autovista.in', 'Autovista.in');
	if($escalation_type=='Escalation Level 1')
	{
		//$this->email->to("jamil@autovista.in");
		if($process_id=='7')
		{
		$this->email->to("pereira_irwin@autovista.in,samarth.sharma@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
		else 
		{
			$this->email->to("pereira_irwin@autovista.in,shaikh.hafiz@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
	}
	elseif($escalation_type=='Escalation Level 2')
	{
		//$this->email->to("jamil.shaikh50@gmail.com");
		if($process_id=='7')
		{
		$this->email->to("pereira_irwin@autovista.in,samarth.sharma@autovista.in,anuj.agarwal@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}else
		{
			$this->email->to("pereira_irwin@autovista.in,shaikh.hafiz@autovista.in,amitesh.agrawal@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
	}
	elseif($escalation_type=='Escalation Level 3')
	{
		if($process_id=='7')
		{
		$this->email->to("pereira_irwin@autovista.in,samarth.sharma@autovista.in,anuj.agarwal@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
		else
		{
			$this->email->to("pereira_irwin@autovista.in,shaikh.hafiz@autovista.in,amitesh.agrawal@autovista.in,vishal12.autovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
	}
	else {
		$this->email->to("jamil@autovista.in,satyam@autovista.in");
	}
	
	$this->email->bcc('snehal@autovista.in,jamil@autovista.in');
	$this->email->subject("LMS Escalation (".$escalation_type.")");
	 $data['enq_id']=$enq_id;
	  $data['escalation_type']=$escalation_type;
	$body =$this->load->view('send_evaluation_mail_view.php',$data,true);
	$this->email->message($body);  
	$this->email->send();
   }		
  public function send_escalation_mail1($enq_id,$escalation_type,$process_id)
  {
	 $query=$this->api_new_model -> get_escalation_detail($enq_id,$process_id);
	 $data['query']=$query;
	  $csetl_email= $query[0]->csetl_email;
	 $dsetl_email=$query[0]->dsetl_email;
	 $gm_email=$query[0]->gm_email;
	 $sm_email=$query[0]->sm_email;
  	$this->load->helper('path');
 	$config = Array(       
          'mailtype'  => 'html'
         );
   	$this->load->library('email', $config);
	$this->email->from('support@autovista.in', 'Autovista.in');
	/*if($escalation_type=='Escalation Level 1')
	{
		//$this->email->to("jamil@autovista.in");
		if($_SESSION['process_id']=='8')
		{
			$this->email->to("pereira_irwin@autovista.in,sanel.baby@autovista.in,nidashaikhautovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
	}
		elseif($_SESSION['process_id']=='7')
		{
		$this->email->to("pereira_irwin@autovista.in,samarth.sharma@autovista.in,nidashaikhautovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
		else 
		{
			$this->email->to("pereira_irwin@autovista.in,shaikh.hafiz@autovista.in,nidashaikhautovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
	}
	elseif($escalation_type=='Escalation Level 2')
	{
		//$this->email->to("jamil.shaikh50@gmail.com");
		if($_SESSION['process_id']=='8')
		{
		$this->email->to("pereira_irwin@autovista.in,sanel.baby@autovista.in,anuj.agarwal@autovista.in,rajesht@autovista.in,nidashaikhautovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
		elseif($_SESSION['process_id']=='7')
		{
		$this->email->to("pereira_irwin@autovista.in,samarth.sharma@autovista.in,nidashaikhautovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
		else
		{
			$this->email->to("pereira_irwin@autovista.in,shaikh.hafiz@autovista.in,amitesh.agrawal@autovista.in,nidashaikhautovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
	}
	elseif($escalation_type=='Escalation Level 3')
	{
		if($_SESSION['process_id']=='8')
		{
			$this->email->to("pereira_irwin@autovista.in,sanel.baby@autovista.in,anuj.agarwal@autovista.in,rajesht@autovista.in,nidashaikhautovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
	}
		elseif($_SESSION['process_id']=='7')
		{
		$this->email->to("pereira_irwin@autovista.in,samarth.sharma@autovista.in,nidashaikhautovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
		else
		{
			$this->email->to("pereira_irwin@autovista.in,shaikh.hafiz@autovista.in,amitesh.agrawal@autovista.in,nidashaikhautovista@gmail.com,$dsetl_email,$gm_email,$sm_email");
		}
	}
	else {*/
		$this->email->to("jamil@autovista.in");
	//}
	
	$this->email->bcc('snehal@autovista.in,jamil@autovista.in');
	$this->email->subject("LMS Escalation (".$escalation_type.")");
	 $data['enq_id']=$enq_id;
	  $data['escalation_type']=$escalation_type;
	$body =$this->load->view('send_evaluation_mail_view.php',$data,true);
	$this->email->message($body);  
	$this->email->send();
	
   }
	/////////////////////////////////////////////////////////////////
	//Send Quotation mail to used 
  public function send_mail($email,$customer_name,$quotation_location, $quotation_model_name, $quotation_description,$accessories_package_name,$phone,$new_model,$brochure)
  {
  	$this->load->helper('path');
 	$select_data=$data['select_data']=$this -> api_new_model -> select_quotation_data($quotation_location, $quotation_model_name, $quotation_description,$accessories_package_name);
 	$data['customer_name']=$customer_name;
	$data['quotation_location']=$quotation_location;	
	$data['model_id']=$quotation_model_name;	
	$data['accessories_package_name']=$accessories_package_name;
	//$this->load->view('new_send_quotation_view.php',$data);
	
 	$config = Array(       
          'mailtype'  => 'html'
         );
   	$this->load->library('email', $config);
 /*	$id=$_SESSION['user_id'];
 	$query=$this->db->query("select email from lmsuser where id='$id'")->result();
 	$user_email_id=$query[0]->email;
	if($user_email_id=='admin@autovista.in')
	{
		$user_email_id='jamil@autovista.in';
	}*/
	$this->email->from('support@autovista.in', 'Autovista.in');
	$this->email->to($email);
	//$this->email->cc($user_email_id);
	//$this->email->bcc('snehal@autovista.in');	
	if(isset($select_data[0]->model)){
	$this->email->subject('Maruti '.$select_data[0]->model.' Quotation From Autovista');
	$body = $this->load->view('new_send_quotation_view.php',$data,TRUE);
	$this->email->message($body);  
	}
	
	//$this->email->attach('https://autovista.in/all_lms/car_quotation.csv');
	if($brochure=='Checked' ){
		$select_brochure=$this->api_new_model->select_brochure($new_model);
		if($quotation_model_name == ''){
			$this->email->subject('Maruti '.$select_brochure[0]->model_name.' Brochure From Autovista');
			$this->email->message('Maruti '.$select_brochure[0]->model_name.' Brochure');  
		}
		 $this->email->attach('https://autovista.in/assets/Brochure/'.$select_brochure[0]->brochure);
		
	}
	if($new_model!='' || $quotation_model_name!=''){
	$this->email->send();
	}

   }public function insert_brochure()
	{
		$new_model=$this->input->post('new_model');
		$email=$this->input->post('email');
		$config = Array(       
          'mailtype'  => 'html'
         );
   	$this->load->library('email', $config);	
	$this->email->from('support@autovista.in', 'Autovista.in');
	$this->email->to($email);
	$select_brochure=$this->api_new_model->select_brochure($new_model);
	if($new_model !=''){
		$this->email->subject('Maruti '.$select_brochure[0]->model_name.' Brochure From Autovista');
		$this->email->message('PFA of Maruti '.$select_brochure[0]->model_name.' Brochure');  
		 $this->email->attach('https://autovista.in/assets/Brochure/'.$select_brochure[0]->brochure);
		if($this->email->send()){
		
				$response["success"] = 1;
				$response["message"] = "Brochure successfully sent.";
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
	
	public function accessories_list_details()
	{
		$id = $this -> input -> post('enq_id');
		$process_name= $this -> input -> post('process_name');
		
		$query2 = $this -> api_new_model -> select_accessories_list($id);
		$response["accessories_list"] = $query2;
		
		echo json_encode($response);
	}

	public function new_car_stock() {
		$model_id = $this -> input -> post('model');
		if(isset($model_id))
		{
			$model_id = json_decode($model_id);
		}
		$fuel_type = $this -> input -> post('fuel_type');
		if(isset($fuel_type))
		{
			$fuel_type = json_decode($fuel_type);
		}
		$location = $this -> input -> post('location');
		if(isset($location))
		{
			$location = json_decode($location);
		}
		$color = $this -> input -> post('color');
		$ageing = $this -> input -> post('ageing');
		/*if(isset($ageing))
		{
			$ageing = json_decode($ageing);
		}*/
		$query = $this -> api_new_model -> new_car_stock($model_id,$fuel_type,$location,$color,$ageing);
		$response["new_car_stock"] = $query;
		$response["new_stock_count"] = $this -> api_new_model -> new_stock_count($model_id,$fuel_type,$location,$color,$ageing);
		echo json_encode($response);
	}
	public function new_stock_count() {
		
		//$filter_data[]=array('model'=>$model,'assigned_location'=>$assigned_location,'vehicle_status'=>$vehicle_status,'ageing'=>$ageing,'price'=>$price);
		
	
		$response["new_stock_count"] = $this -> api_new_model -> new_stock_count();
		
		echo json_encode($response);
	}
	public function poc_stock() {
		$make_id = $this -> input -> post('make_id');
		$model = $this -> input -> post('model');
		$fuel_type = $this -> input -> post('fuel_type');
		$stock_location = $this -> input -> post('stock_location');
		$ageing = $this -> input -> post('ageing');
		$color = $this -> input -> post('color');
		$mfg_yr = $this -> input -> post('mfg_yr');
		
		$query = $this -> api_new_model -> poc_stock($make_id,$model,$fuel_type,$stock_location,$ageing,$color,$mfg_yr);
		$response["poc_stock"] = $query;
		echo json_encode($response);
	}
	public function quotation_location() {

		$response["quotation_location"] = $this -> api_new_model -> quotation_location();
		echo json_encode($response);
	}
	public function quotation_model_name() {
		
		$quotation_location = $this -> input -> post('qlocation');
		$response["quotation_model_name"] = $this -> api_new_model -> quotation_model_name($quotation_location);
		echo json_encode($response);
	}
	public function quotation_description() {
		
		$quotation_location = $this -> input -> post('qlocation');
		$quotation_model_name = $this -> input -> post('qmodel_name');
		$response["quotation_description"] = $this -> api_new_model -> quotation_description($quotation_location,$quotation_model_name);
		echo json_encode($response);
	}
	public function accessories_package() {
		
		//$quotation_location = $this -> input -> post('qlocation');
		$quotation_model_name = $this -> input -> post('model_id');
		$response["accessories_package"] = $this -> api_new_model -> accessories_package($quotation_model_name);
		echo json_encode($response);
	}
	function all_process(){		
		$response["all_process"]= $this -> api_new_model -> all_process();
		echo json_encode($response);
	}
	function evaluation_process_removed(){		
		$response["all_process"]= $this -> api_new_model -> select_transfer_process();
		echo json_encode($response);
	}
	public function select_transfer_location() {
		
		$transfer_process=$this->input->post('transfer_process_id');
		$response["select_transfer_location"] = $this -> api_new_model -> select_transfer_location($transfer_process);
		echo json_encode($response);
	}
	public function select_transfer_to_user() {
		
		$transfer_process=$this->input->post('transfer_process_id');
		$transfer_location=$this->input->post('transfer_location_id');
		$role = $this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		$session_process=$this->input->post('session_process_id');
		$response["select_transfer_to_user"] = $this -> api_new_model -> select_transfer_to_user($transfer_process,$transfer_location,$role,$user_id,$session_process);
		echo json_encode($response);
	}
	public function insert_dse_daily_report(){
			$user_date=date('Y-m-d');
			$time = date("H:i:s A");
			$location_id=$this->input->post('location');
			$user_id=$this->input->post('user_id');
			$enquiry_count=$this->input->post('enquiry_count');
			$enquiry_remark=$this->input->post('enquiry_remark');
			$walk_in_count=$this->input->post('walk_in_count');
			$walk_in_remark=$this->input->post('walk_in_remark');
			$home_visit_count=$this->input->post('home_visit_count');
			$home_visit_remark=$this->input->post('home_visit_remark');
			$test_drive_count=$this->input->post('test_drive_count');
			$test_drive_remark=$this->input->post('test_drive_remark');
			$booking_count=$this->input->post('booking_count');
			$booking_remark=$this->input->post('booking_remark');
			$gatepass_count=$this->input->post('gatepass_count');
			$gatepass_remark=$this->input->post('gatepass_remark');
			$evaluation_count=$this->input->post('evaluation_count');
			$evaluation_remark=$this->input->post('evaluation_remark');
			$delivery_count=$this->input->post('delivery_count');
		
			
			$this -> api_new_model -> insert_dse_daily_report($user_date,$time,$location_id,$user_id,$enquiry_count,$enquiry_remark,$walk_in_count,$walk_in_remark,$home_visit_count,$home_visit_remark,$test_drive_count,$test_drive_remark,$booking_count,$booking_remark,$gatepass_count,$gatepass_remark,$evaluation_count,$evaluation_remark,$delivery_count);
}
public function daily_tracker_show_data(){
			$location_id=$this->input->post('location_id');
			$from_date=$this->input->post('fromdate');
			$status=$this->input->post('status');
			$response['daily_tracker_show_data'] =$this -> api_new_model ->daily_tracker_show_data($location_id,$from_date,$status);		
	
	echo json_encode($response);
}
public function daliy_dse_tracker_location()
{
			$role=$this->input->post('role');
			$location=$this->input->post('location');
			
			$response['daliy_dse_tracker_location'] =$this -> api_new_model -> daliy_dse_tracker_location($role,$location);		
	
	echo json_encode($response);
}
public function daily_dse_tracker_check_time()
{
	$user_id=$this->input->post('user_id');
		
	$response['daliy_dse_tracker_time'] =$this -> api_new_model -> daily_dse_tracker_check_time($user_id);		
	
	echo json_encode($response);
}
public function message_list() {
		$user_id = $this -> input -> post('user_id');
		$query2 = $this -> api_new_model -> message_list($user_id);
		$response["message_list"] = $query2;
		echo json_encode($response);
	}
	public function message_home() {
			
		$user_id = $this -> input -> post('user_id');
		$query2 = $this -> api_new_model -> message_home($user_id);
		$response["message_home"] = $query2;
		echo json_encode($response);
	}
	/*public function message_status_change() {
			
		$id = $this -> input -> post('id');
		$query2 = $this -> api_new_model -> message_status_change($id);		
	}
	public function message_insert()
	{
		$message = $this -> input -> post('message');
		// $token = $this -> input -> post('token');
		$user_id = $this -> input -> post('user_id');
		//$location = $this -> input -> post('location');
		$location = json_decode($_POST['location']);
		//$tl = $this -> input -> post('tl');
		$tl = json_decode($_POST['tl']);
		$dse = json_decode($_POST['dse']);
		//$dse = $this -> input -> post('dse');
		$query = $this -> api_new_model -> message_insert($message,$user_id,$location,$tl,$dse);
	}
	public function message_delete()
	{	$message_id = json_decode($_POST['message_id']);
		//$message_id = $this -> input -> post('message_id');
		$query = $this -> api_new_model -> message_delete($message_id);
	}*/
	public function assign_new_lead_spinner() {
		$process_name = $this -> input -> post('process_name');
		$process_id= $this -> input -> post('process_id');
		//$response["process_all_location"] = $this -> api_new_model -> process_all_location($process_id);
		if($process_id==9)
		{
			$response["assign_new_leads_all_count"]=$this -> api_new_complaint_model -> assign_new_leads_all_count($process_id,$process_name);
			$response["assign_new_leads_source"]=$this -> api_new_complaint_model -> assign_new_leads_source($process_id,$process_name);
		}
		else {
			$response["assign_new_leads_all_count"]=$this -> api_new_model -> assign_new_leads_all_count($process_id,$process_name);
			$response["assign_new_leads_source"]=$this -> api_new_model -> assign_new_leads_source($process_id,$process_name);
		}
	
		echo json_encode($response);
	}
	public function assign_new_lead_location() {
		$process_name = $this -> input -> post('process_name');
		$process_id= $this -> input -> post('process_id');
		$response["process_all_location"] = $this -> api_new_model -> process_all_location($process_id);
		//$response["assign_new_leads_all_count"]=$this -> api_new_model -> assign_new_leads_all_count($process_id,$process_name);
		//$response["assign_new_leads_source"]=$this -> api_new_model -> assign_new_leads_source($process_id,$process_name);
		echo json_encode($response);
	}
	public function assign_new_lead_assign_user()
	{
		$location = $this -> input -> post('location');
		$process_id= $this -> input -> post('process_id');
		$user_id = $this -> input -> post('user_id');
		$role = $this -> input -> post('role');
		$response["assign_new_lead_assign_user"]=$this -> api_new_model -> assign_new_lead_assign_user($location,$process_id,$role,$user_id);
		echo json_encode($response);
	}
	public function assign_new_lead_update()
	{
		$process_id= $this -> input -> post('process_id');
		if($process_id==9)
		{
			$this -> api_new_complaint_model -> assign_new_lead_update();
		}
		else {
			$this -> api_new_model -> assign_new_lead_update();
		}
		
		
	}
	public function assign_transferred_lead_spinner() {
		//$process_name = $this -> input -> post('process_name');
		$process_id= $this -> input -> post('process_id');
		$user_id = $this -> input -> post('user_id');
		$response["from_location"] = $this -> api_new_model -> from_location($process_id,$user_id);
		$response["to_location"]=$this -> api_new_model -> to_location($process_id);
		//$response["assign_new_leads_source"]=$this -> api_new_model -> assign_new_leads_source($process_id,$process_name);
		echo json_encode($response);
	}
	public function assign_transferred_lead_from_user() {
		 $location = $this -> input -> post('location_id');
		 $process_id= $this -> input -> post('process_id');
		$user_id = $this -> input -> post('user_id');			
		$role = $this -> input -> post('role');
		$response["assign_transferred_lead_from_user"] = $this -> api_new_model -> assign_transferred_lead_from_user($location,$process_id,$role,$user_id);
		//$response["assign_new_leads_source"]=$this -> api_new_model -> assign_new_leads_source($process_id,$process_name);
		echo json_encode($response);
	}
	public function assign_transferred_lead_check_lead() {
		
		 $process_id= $this -> input -> post('process_id');
		$process_name = $this -> input -> post('process_name');
		$assign_to = $this -> input -> post('fromUser');
		$all_array = array("2", "3", "8", "7", "9", "11", "13", "10", "12", "14","15","16");
		$response["assign_transferred_leads_all_count"]=$this -> api_new_model -> assign_transferred_leads_all_count($process_id,$process_name,$assign_to,$all_array);
		$response["assign_transferred_leads_source"]=$this -> api_new_model -> assign_transferred_leads_source($process_id,$process_name,$assign_to,$all_array);
		echo json_encode($response);
	}
public function assign_transferred_lead_to_user() {
		
		 $process_id= $this -> input -> post('process_id');
		$toLocation = $this -> input -> post('toLocation_id');
		$fromUser = $this -> input -> post('fromUser');
		$response["assign_transferred_lead_to_user"] = $this -> api_new_model -> assign_transferred_lead_to_user($toLocation,$fromUser,$process_id);
		//$response["assign_new_leads_source"]=$this -> api_new_model -> assign_new_leads_source($process_id,$process_name);
		echo json_encode($response);
	}
public function assign_transferred_lead_update()
	{
		$this -> api_new_model -> assign_transferred_lead_update();
		
	}
	public function dsewiseReport()
{
		$location = $this -> input -> post('location_id');
		$fromdate = $this -> input -> post('fromdate');
		$todate = $this -> input -> post('todate');
		$role = $this -> input -> post('role');
	 	$user_id = $this -> input -> post('user_id');
		$process_id= $this -> input -> post('process_id');
		if ($fromdate == '') {
			$fromdate = "2017-01-01";
		}
		if ($todate == '') {
			$todate = date('Y-m-d');
		}
		$response['dsewise_count'] =$this -> api_new_lead_report_model -> get_dse_name($role,$user_id,$location, $fromdate, $todate,$process_id);		
		echo json_encode($response);
}
public function leadReport()
{
		$process_name = $this -> input -> post('process_name');	
		$role = $this -> input -> post('role');
	 	$user_id = $this -> input -> post('user_id');
		$process_id= $this -> input -> post('process_id');	
		$location_id=$this->input->post('location_id');
		$fromdate=$this->input->post('fromdate');
		$todate=$this->input->post('todate');
		if ($fromdate == '') {
			$fromdate = "2017-01-01";
		}
		if ($todate == '') {
			$todate = date('Y-m-d');
		}
		$response['total_count'] =$this -> api_new_lead_report_model -> total_lead($process_name,$role,$user_id,$location_id, $fromdate, $todate,$process_id);
		$response['total_feedback'] =$this -> api_new_lead_report_model -> total_feedback($process_name,$role,$user_id,$location_id, $fromdate, $todate,$process_id);
		echo json_encode($response);
}
public function insertToken()
	{
		$mobileNumber = $this -> input -> post('moblieNumber');
		 $token = $this -> input -> post('token');
		 $user_id = $this -> input -> post('user_id');
		$query = $this -> api_new_model -> insertToken($mobileNumber, $token,$user_id);
	}
	function poc_stock_model(){
			$make_id = $this -> input -> post('make_id');
			$query = $this -> api_new_model -> poc_stock_model($make_id);
		$response["poc_stock_model"] = $query;
		echo json_encode($response);
	}

	function poc_stock_make(){
		
			$query = $this -> api_new_model -> poc_stock_make();
		$response["poc_stock_make"] = $query;
		echo json_encode($response);
	}
	function poc_stock_spinner(){
		$response["poc_stock_location"]= $this -> api_new_model -> poc_stock_location();
		//$response["poc_stock_color"] =$this -> api_new_model -> poc_stock_color();
		//$response["poc_stock_fuel_type"] =$this -> api_new_model -> poc_stock_fuel_type();
		echo json_encode($response);
	}
	
function new_stock_spinner(){
			$response["new_stock_location"] = $this -> api_new_model -> new_stock_location();
		//	$response["new_stock_color"] = $this -> api_new_model -> new_stock_color();
	//	$response["new_stock_fuel_type"] =$this -> api_new_model -> new_stock_fuel_type();
		$response["vehicle_type"] =$this -> api_new_model -> new_stock_vehicle_type();
		$response["new_stock_model"] =$this -> api_new_model -> new_stock_model();
		echo json_encode($response);
	}
	public function poc_stock_count() {
		
		$make=$this->input->post('make');
		$model=$this->input->post('model');
		$stock_location=$this->input->post('stock_location');
		
		$mfg_year=$this->input->post('mfg_year');
		
		
		$owner=$this->input->post('owner');
		
		
		$ageing=$this->input->post('ageing');
		
		
		$price=$this->input->post('price');
		
		$filter_data[]=array('make'=>$make,'model'=>$model,'stock_location'=>$stock_location,'mfg_year'=>$mfg_year,'owner'=>$owner,'ageing'=>$ageing,'price'=>$price);
		$response["poc_stock_count"] = $this -> api_new_model -> poc_stock_count($make,$model,$stock_location,$mfg_year,$owner,$ageing,$price);
		
		$response["poc_stock_filter"] =$filter_data;
		echo json_encode($response);
	}
	public function poc_stock_list() {
		$model=$this->input->post('model');
		if(isset($model))
		{
			$model = json_decode($model);
		}
		
		$make=$this->input->post('make');
		$fuel_type=$this->input->post('fuel_type');
		if(isset($fuel_type))
		{
			$fuel_type = json_decode($fuel_type);
		}
		$stock_location=$this->input->post('stock_location');
		if(isset($stock_location))
		{
			$stock_location = json_decode($stock_location);
		}
		
		$ageing=$this->input->post('ageing');	
		$search_model=$this->input->post('search_model');	
		$response["poc_stock_count"] = $this -> api_new_model -> poc_stock_count($make,$model,$fuel_type,$stock_location,$ageing,$search_model);
		$response["poc_stock_list"] = $this -> api_new_model -> poc_stock_list($make,$model,$fuel_type,$stock_location,$ageing,$search_model);
		echo json_encode($response);
	}
	
	
	public function new_stock_list() {
		
		
		$response["new_stock_list"] = $this -> api_new_model -> new_stock_list();
		echo json_encode($response);
	}
		
	/********************* New Dashboard(with TL,Executive button) ****************************************/
	public function daily_productivity_report() {
		
		
		$response["daily_productivity_report"] = $this -> api_new_model -> daily_productivity_report();
		echo json_encode($response);
	}
	/********************* Home visit today count click from dashboard ****************************************/
	public function select_home_visit_today() {
		//IF check from Dashboard
		$role = $this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		
		//login user data
		$role_session=$this -> input -> post('role_session');
		$user_id_session=$this -> input -> post('user_id_session');
		$process_id_session = $this -> input -> post('process_id_session');
		$process_name_session=$this -> input -> post('process_name_session');
		
		//Filter data
		$contact_no=$this -> input -> post('contact_no');
		$page = $this -> input -> post('page');
		
		$query = $this -> api_new_model -> select_home_visit_today($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
		$query1 = $this -> api_new_model -> select_home_visit_today_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}
	/********************* Showroom visit today count click from dashboard ****************************************/
	public function select_showroom_visit_today() {
		//IF check from Dashboard
		$role = $this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		
		//login user data
		$role_session=$this -> input -> post('role_session');
		$user_id_session=$this -> input -> post('user_id_session');
		$process_id_session = $this -> input -> post('process_id_session');
		$process_name_session=$this -> input -> post('process_name_session');
		
		//Filter data
		$contact_no=$this -> input -> post('contact_no');
		$page = $this -> input -> post('page');
		
		$query = $this -> api_new_model -> select_showroom_visit_today($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
		$query1 = $this -> api_new_model -> select_showroom_visit_today_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}
	/********************* Test drive today count click from dashboard ****************************************/
	public function select_test_drive_today() {
		//IF check from Dashboard
		$role = $this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		
		//login user data
		$role_session=$this -> input -> post('role_session');
		$user_id_session=$this -> input -> post('user_id_session');
		$process_id_session = $this -> input -> post('process_id_session');
		$process_name_session=$this -> input -> post('process_name_session');
		
		//Filter data
		$contact_no=$this -> input -> post('contact_no');
		$page = $this -> input -> post('page');
		
		$query = $this -> api_new_model -> select_test_drive_today($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
		$query1 = $this -> api_new_model -> select_test_drive_today_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}
	/********************* Evaluation allotted today count click from dashboard ****************************************/
	public function select_evaluation_today() {
		//IF check from Dashboard
		$role = $this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		
		//login user data
		$role_session=$this -> input -> post('role_session');
		$user_id_session=$this -> input -> post('user_id_session');
		$process_id_session = $this -> input -> post('process_id_session');
		$process_name_session=$this -> input -> post('process_name_session');
		
		//Filter data
		$contact_no=$this -> input -> post('contact_no');
		$page = $this -> input -> post('page');
		
		$query = $this -> api_new_model -> select_evaluation_today($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
		$query1 = $this -> api_new_model -> select_evaluation_today_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page);
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}
	public function select_escalation_level1() {
		//IF check from Dashboard
		$role = $this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		
		//login user data
		$role_session=$this -> input -> post('role_session');
		$user_id_session=$this -> input -> post('user_id_session');
		$process_id_session = $this -> input -> post('process_id_session');
		$process_name_session=$this -> input -> post('process_name_session');
		
		//Filter data
		$contact_no=$this -> input -> post('contact_no');
		$page = $this -> input -> post('page');
		$feedback='esc_level1';	
		$query = $this -> api_new_model -> select_escalation($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$feedback);
		$query1 = $this -> api_new_model -> select_escalation_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$feedback);
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}
	public function select_escalation_level2() {
		//IF check from Dashboard
		$role = $this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		
		//login user data
		$role_session=$this -> input -> post('role_session');
		$user_id_session=$this -> input -> post('user_id_session');
		$process_id_session = $this -> input -> post('process_id_session');
		$process_name_session=$this -> input -> post('process_name_session');
		
		//Filter data
		$contact_no=$this -> input -> post('contact_no');
		$page = $this -> input -> post('page');
		$feedback='esc_level2';	
		$query = $this -> api_new_model -> select_escalation($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$feedback);
		$query1 = $this -> api_new_model -> select_escalation_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$feedback);
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}
	public function select_escalation_level3() {
		//IF check from Dashboard
		$role = $this -> input -> post('role');
		$user_id=$this -> input -> post('user_id');
		
		//login user data
		$role_session=$this -> input -> post('role_session');
		$user_id_session=$this -> input -> post('user_id_session');
		$process_id_session = $this -> input -> post('process_id_session');
		$process_name_session=$this -> input -> post('process_name_session');
		
		//Filter data
		$contact_no=$this -> input -> post('contact_no');
		$page = $this -> input -> post('page');
		$feedback='esc_level3';	
		$query = $this -> api_new_model -> select_escalation($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$feedback);
		$query1 = $this -> api_new_model -> select_escalation_count($role,$role_session,$user_id,$user_id_session,$process_id_session,$process_name_session,$contact_no,$page,$feedback);
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}
	public function customer_corporate_name()
	{	
		$query1 = $this -> api_new_model -> customer_corporate_name();
		$response["customer_corporate_name"] = $query1;
		echo json_encode($response);
	}
	public function get_app_version()
	{	
		$query1 = $this -> api_new_model -> get_app_version();
		$response["get_app_version"] = $query1;
		echo json_encode($response);
	}
	public function update_app_version()
	{	
		$id = $this -> input -> post('id');
		 $version_code = $this -> input -> post('version_code');
		 $version_name = $this -> input -> post('version_name');
		$query = $this -> api_new_model -> update_app_version($version_code, $version_name,$id);
	}
	//All Lead Details and Count
public function select_all_followup_lead_complaint() {
	 $process_name= $this -> input -> post('process_name');
		 $process_id = $this -> input -> post('process_id');
		$role = $this -> input -> post('role');
		 $user_id=$this -> input -> post('user_id');
		$contact_no=$this -> input -> post('contact_no');
		$page = $this -> input -> post('page');
		$role_name = $this -> input -> post('role_name');
	
		$query = $this -> api_new_complaint_model -> select_all_followup_lead($role,$process_name,$user_id,$contact_no,$page,$process_id,$role_name);
		$query1 = $this -> api_new_complaint_model -> select_all_followup_lead_count($role,$process_name,$user_id,$contact_no,$page,$process_id,$role_name);
		$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}
//Insert new car follow up
	 public function insert_complaint_followup()
	{
		$query = $this -> api_new_complaint_model -> insert_complaint_followup();
	}
	 public function insert_auditor_remark()
	{
		$query = $this -> api_new_model -> insert_auditor_remark();
	}
	public function auditor_remark_detail()
	{
		
		$query1 = $this -> api_new_model -> auditor_remark_detail();
		$response["auditor_remark_detail"] = $query1;
		echo json_encode($response);
	}
	public function forgot_password()
	{
		$email=$this->input->post('email');
		
		$query=$this->api_new_model->forgot_pwd($email);
	}
		public function my_profile()
	{
		$user_id=$this->input->post('user_id');
		
		$query=$this->api_new_model->my_profile($user_id);
			$response["my_profile"] = $query;
		echo json_encode($response);
	}
		public function insert_user_map_location()
	{
		$user_id=$this->input->post('user_id');
		$role_id=$this->input->post('role_id');
		$role_name=$this->input->post('role_name');
		$latitude=$this->input->post('latitude');
		$logitude=$this->input->post('logitude');
		$query = $this -> api_new_model -> insert_user_map_location($user_id,$role_id,$role_name,$latitude,$logitude);
	}
public function select_user_map_location()
	{
		$location_id=$this->input->post('location_id');
		$process_id = $this -> input -> post('process_id');
		
		$query = $this -> api_new_model -> select_user_map_location($location_id,$process_id);
		$response["select_user_map_location"] = $query;
		echo json_encode($response);
	}
	public function all_user_details()
	{
		
		$query = $this -> api_new_model -> all_user_details();
		$count_lmsuser= $this -> api_new_model -> count_lmsuser();
		$response["user_count"] = $count_lmsuser;
		$response["all_user_details"] = $query;
		
		echo json_encode($response);
	}
		 public function insert_resolved_escalation_detail()
	{
		
		$query = $this -> api_new_model -> insert_resolved_escalation_detail();
		//$this->send_escalation_mail($enq_id,$escalation_type,$process_id);
	}
	/*********************** New changes 20-02-2019 *******************************/
	 public function insert_new_car_followup_with_transfer()
	{
		$query = $this -> api_new_model -> insert_new_car_followup_with_transfer();
			//Send quotation 
		$customer_name = $this -> input -> post('customer_name');
		$email = $this -> input -> post('email');
		$phone = $this -> input -> post('phone');
		
		$quotation_location = $this -> input -> post('qlocation');
		$quotation_model_name = $this -> input -> post('qmodel_name');
		$quotation_description = $this -> input -> post('description');
		$accessories_package_name = $this -> input -> post('accessories_package_name');
	
		$new_model=$this->input->post('new_model');
		$brochure=$this->input->post('brochure');
		
		if (isset($brochure)) {
			$brochure='Checked';
		}else{
			$brochure='Not Checked';
		}
		if($quotation_model_name!='' ||  $brochure == 'Checked')
		{
		$this->send_mail($email,$customer_name,$quotation_location, $quotation_model_name, $quotation_description,$accessories_package_name,$phone,$new_model,$brochure);
		}
	}
	
	 public function insert_used_car_followup_with_transfer()
	{
		$query = $this -> api_new_model -> insert_used_car_followup_with_transfer();
	}
	//Insert new car follow up
	 public function insert_evaluation_followup_with_transfer()
	{
		$query = $this -> api_new_model -> insert_evaluation_followup_with_transfer();
	}
	/* public function select_evaluation_tracking()
	{
		$process_name= $this -> input -> post('process_name');
		 $process_id = $this -> input -> post('process_id');
		$role = $this -> input -> post('role');
		 $user_id=$this -> input -> post('user_id');
		$contact_no=$this -> input -> post('contact_no');
		$page = $this -> input -> post('page');
		$role_name = $this -> input -> post('role_name');
	
		$query = $this -> api_new_model -> select_evaluation_tracking_lead($role,$process_name,$user_id,$contact_no,$page,$process_id,$role_name);
	//	$query1 = $this -> api_new_model -> select_all_followup_lead_count($role,$process_name,$user_id,$contact_no,$page,$process_id,$role_name);
		//$response["lead_details_count"] = $query1;
		$response["lead_details"] = $query;
		echo json_encode($response);
	}*/
	 public function insert_followup_evaluation_tracking()
	{
		$query = $this -> api_new_model -> insert_followup_evaluation_tracking();
	}
	 public function select_transfer_process()
	{
		$query = $this -> api_new_model -> select_transfer_process();
		$response["select_transfer_process"] = $query;
		echo json_encode($response);
	}	
	 public function select_user_process()
	{
		$user_id=$this->input->post('user_id');
		$query = $this -> api_new_model -> select_user_process($user_id);
		$response["select_user_process"] = $query;
		echo json_encode($response);
	}
	
	public function send_quotation()
	{
		$enq_id = $this -> input -> post('enq_id');
		$role_id_session= $this -> input -> post('role_id_session');
		$user_id_session= $this -> input -> post('user_id_session');
	
		//Send quotation 
		$customer_name = $this -> input -> post('customer_name');
		$email = $this -> input -> post('email');
		
		$phone = $this -> input -> post('phone');
		
		$quotation_location = $this -> input -> post('qlocation');
		$quotation_model_name=$data['model_name']= $this -> input -> post('qmodel_name');
		$quotation_description = $this -> input -> post('description');
		$quotation_type=$data['type']=$this->input->post('quotation_type');
		$finance_data=$data['finance_data']=$this->input->post('finance_data');
		$this -> api_new_model -> insert_header_quotation($quotation_location, $quotation_model_name, $quotation_description,
		$email,$customer_name,$quotation_type,$finance_data,$user_id_session);
		$this->load->helper('path');
	 	$select_data=$data['select_data']=$this -> api_new_model -> select_quotation_data($quotation_location, $quotation_model_name, $quotation_description);
	 	
	 	if(count($select_data)>0)
		{
	 	$data['customer_name']=$customer_name;
		$data['quotation_location']=$quotation_location;	
		$data['model_id']=$quotation_model_name;	
		if($quotation_model_name!=''){
				
		//$this->load->view('new_send_quotation_view.php',$data);
		   $this->load->library('email');
        $config = array (
                  'mailtype' => 'html',
                  'charset'  => 'utf-8',
                  'priority' => '1',
                   'smtp_timeout' => '7'
                   );
       $this->load->library('email', $config);
       	$this->email->initialize($config);
		$this->email->from('websupport@autovista.in', 'Autovista.in');
		$this->email->to($email);
		$this->email->bcc('jamil.shaikh50@gmail.com');
		//$this->email->to('jabbarsayyad2326@gmail.com');
		if(isset($select_data[0]->model_id)){
		
		$this->email->subject('Maruti '.$select_data[0]->model_name.' Quotation From Autovista');
		$body = $this->load->view('new_send_quotation_view.php',$data,TRUE);
	//	$body.="send quotation";
		$this->email->message($body);  
		if($this->email->send()){
		
					$response["success"] = 1;
					$response["message"] = "Quotation Send Successfully.";
					// echoing JSON response
					echo json_encode($response);
		}else{
		
			$response["success"] = 0;
					$response["message"] = "Opps! Error Occur.";
					// echoing JSON response
					echo json_encode($response);
		}
		}
		
		
		}
	else
		{
		
			$response["success"] = 0;
					$response["message"] = "Opps! Error Occurs.";
					// echoing JSON response
					echo json_encode($response);
		}
		}
else {
	
	$response["success"] = 0;
					$response["message"] = "Opps! Error Occurs.";
					// echoing JSON response
					echo json_encode($response);
}
}
		/*$enq_id = $this -> input -> post('enq_id');
		$role_id_session= $this -> input -> post('role_id_session');
		$user_id_session= $this -> input -> post('user_id_session');
		//Send quotation 
		$customer_name = $this -> input -> post('customer_name');
		$email = $this -> input -> post('email');
		$phone = $this -> input -> post('phone');
		
		$quotation_location = $this -> input -> post('qlocation');
		$quotation_model_name=$data['model_name']= $this -> input -> post('qmodel_name');
		$quotation_description = $this -> input -> post('description');
		$quotation_type=$data['type']=$this->input->post('quotation_type');
		$finance_data=$data['finance_data']=$this->input->post('finance_data');
		$this -> api_new_model -> insert_quotation($enq_id,$user_id_session,$role_id_session,$quotation_location, $quotation_model_name, $quotation_description,$email);
	 	
		$this->load->helper('path');
	 	$select_data=$data['select_data']=$this -> api_new_model -> select_quotation_data($quotation_location, $quotation_model_name, $quotation_description);
	 
	 	if(count($select_data)>0)
		{
	 	$data['customer_name']=$customer_name;
		$data['quotation_location']=$quotation_location;	
		$data['model_id']=$quotation_model_name;	
			if($quotation_model_name!=''){
		//$this->load->view('new_send_quotation_view.php',$data);
	
         $this->load->library('email');
        $config = array (
                  'mailtype' => 'html',
                  'charset'  => 'utf-8',
                  'priority' => '1',
                   'smtp_timeout' => '7'
                   );
       $this->load->library('email', $config);
       	$this->email->initialize($config);
		$this->email->from('websupport@autovista.in', 'Autovista.in');
		$this->email->to($email);
		$this->email->bcc('jamil.shaikh50@gmail.com');
		//$this->email->to('jabbarsayyad2326@gmail.com');
		if(isset($select_data[0]->model_id)){
		
		$this->email->subject('Maruti '.$select_data[0]->model_name.' Quotation From Autovista');
		$body = $this->load->view('new_send_quotation_view.php',$data,TRUE);
	//	$body.="send quotation";
		$this->email->message($body);  
		if($this->email->send()){
			
					$response["success"] = 1;
					$response["message"] = "Quotation Send Successfully.";
					// echoing JSON response
					echo json_encode($response);
		}else{
		//	echo"eee";
			$response["success"] = 0;
					$response["message"] = "Opps! Error Occur.";
					// echoing JSON response
					echo json_encode($response);
		}
		}
		
		
		}
	else
		{
		//	echo"sss";
			$response["success"] = 0;
					$response["message"] = "Opps! Error Occurs.";
					// echoing JSON response
					echo json_encode($response);
		}
		
		}
else
	{
	//	echo"aa";
		$response["success"] = 0;
					$response["message"] = "Opps! Error Occurs.";
					// echoing JSON response
					echo json_encode($response);
	}
			
		}
*/

	/// Not used Function
		// Dashboard unassigned,new lead,today followup ,pending leads  count 
	/*public function dashboard_count() {
		$process_name_seesion=$this -> input -> post('process_name');
		$process_id_session=$this -> input -> post('process_id');
		$role_session=$this -> input -> post('role');
		$user_id_session=$this -> input -> post('user_id');
		$location_name_select=$this -> input -> post('location_select');
		$sub_poc_purchase_session=$this -> input -> post('sub_poc_purchase_session');
		$query = $this -> api_new_model -> dashboard_count($process_name_seesion,$location_name_select,$process_id_session,$role_session,$user_id_session,$sub_poc_purchase_session);
		$response["dashboard_count"] = $query;
		echo json_encode($response);
	}*/
	public function send_quotation_from_nav()
	{
		
		$role_id_session= $this -> input -> post('role_id_session');
		$user_id_session= $this -> input -> post('user_id_session');
		//Send quotation 
		$customer_name = $this -> input -> post('customer_name');
		$email = $this -> input -> post('email');
		
		$phone = $this -> input -> post('phone');
		
		$quotation_location = $this -> input -> post('qlocation');
		$quotation_model_name=$data['model_name']= $this -> input -> post('qmodel_name');
		$quotation_description = $this -> input -> post('description');
		$quotation_type=$data['type']=$this->input->post('quotation_type');
		$finance_data=$data['finance_data']=$this->input->post('finance_data');
		$this -> api_new_model -> insert_header_quotation($quotation_location, $quotation_model_name, $quotation_description,
		$email,$customer_name,$quotation_type,$finance_data,$user_id_session);
		$this->load->helper('path');
	 	$select_data=$data['select_data']=$this -> api_new_model -> select_quotation_data($quotation_location, $quotation_model_name, $quotation_description);
	 	//print_r($select_data);
	 	if(count($select_data)>0)
		{
	 	$data['customer_name']=$customer_name;
		$data['quotation_location']=$quotation_location;	
		$data['model_id']=$quotation_model_name;	
		if($quotation_model_name!=''){
				
		//$this->load->view('new_send_quotation_view.php',$data);
		   $this->load->library('email');
        $config = array (
                  'mailtype' => 'html',
                  'charset'  => 'utf-8',
                  'priority' => '1',
                   'smtp_timeout' => '7'
                   );
       $this->load->library('email', $config);
       	$this->email->initialize($config);
		$this->email->from('websupport@autovista.in', 'Autovista.in');
		$this->email->to($email);
		$this->email->bcc('jamil.shaikh50@gmail.com');
		//$this->email->to('jabbarsayyad2326@gmail.com');
		if(isset($select_data[0]->model_id)){
		
		$this->email->subject('Maruti '.$select_data[0]->model_name.' Quotation From Autovista');
		$body = $this->load->view('new_send_quotation_view.php',$data,TRUE);
	//	$body.="send quotation";
		$this->email->message($body);  
		if($this->email->send()){
		//	echo"ddd";
					$response["success"] = 1;
					$response["message"] = "Quotation Send Successfully.";
					// echoing JSON response
					echo json_encode($response);
		}else{
		//	echo"eee";
			$response["success"] = 0;
					$response["message"] = "Opps! Error Occur.";
					// echoing JSON response
					echo json_encode($response);
		}
		}
		
		
		}
	else
		{
		//	echo"aaa";
			$response["success"] = 0;
					$response["message"] = "Opps! Error Occurs.";
					// echoing JSON response
					echo json_encode($response);
		}
		}
else {
	//echo"www";
	$response["success"] = 0;
					$response["message"] = "Opps! Error Occurs.";
					// echoing JSON response
					echo json_encode($response);
}
		
			
		}
public function quotation_location_with_location() {

		$response["quotation_location"] = $this -> api_new_model -> quotation_location1();
		echo json_encode($response);
	}
public function quotation_model_name_with_model() {
		
		$quotation_location = $this -> input -> post('qlocation');
		$response["quotation_model_name"] = $this -> api_new_model -> quotation_model_name1($quotation_location);
		echo json_encode($response);
	}
public function quotation_description_with_description() {
		
		$quotation_location = $this -> input -> post('qlocation');
		$quotation_model_name = $this -> input -> post('qmodel_name');
		$response["quotation_description"] = $this -> api_new_model -> quotation_description1($quotation_location,$quotation_model_name);
		echo json_encode($response);
	}
	public function send_notification()
	{
		 $tokens = $this -> input -> post('token');
		//$tokens = $this -> input -> post('token');	
		//$tokens="";
 		$msg='New Lead Assign ed4';
		//$this -> api_cross_lead_model -> send_notification($tokens,$msg);
		$this -> api_new_model -> demo_send_noti($tokens,$msg);
	}
	public function calender_notification()
	{		 
		$this -> api_new_model -> calender_notification();
	}
		public function select_mfg_year()
	{
		
		 	$y = date('Y');
		$a = array();
		$i=0;
		for($i=2019;$i>=1980;$i--){
		
			array_push($a, $i);
		}
		$response["mfg_year"] = $a;
		echo json_encode($response);
	}
 public function calender_task()
	{
		$user_id=$this->input->post('user_id');
		$date1=$this->input->post('date');
		$month=$this->input->post('month');
		$year=$this->input->post('year');
		$role=$this->input->post('role');
		$process_id=$this->input->post('process_id');
		$process_name=$this->input->post('process_name');
		if($date1 !='')
		{
			 $date = date("Y-m-d", strtotime($date1));
		}
		else {
			$date='';
		}
		/*$query = $this -> api_new_model -> calender_task($user_id,$date,$month,$year);
		$response["calender_task"] = $query;*/
		$query = $this -> api_new_model -> select_reminder($user_id,$date,$month,$year);
		$response["select_reminder"] = $query;
		if($role!='')
		{
			$query = $this -> api_new_model -> appointment($user_id,$date,$month,$year,$role,$process_id,$process_name,'all');
		$response["appointment"] = $query;
			
		}
		
		echo json_encode($response);
	}
	public function insert_calender_task()
	{$this -> api_new_model -> insert_calender_task();
		
	}
	public function insert_reminder()
	{$this -> api_new_model -> insert_reminder();
		
	}
	public function delete_reminder()
	
	{
		$this -> api_new_model -> delete_reminder();
	}
	public function update_reminder()
	{$this -> api_new_model -> update_reminder();
		
	}
	/*public function update_reminder_done()
	{$this -> api_new_model -> update_reminder();
		
	}*/
	 public function select_reminder()
	{
		$user_id=$this->input->post('user_id');
		$date1=$this->input->post('date');
		$month=$this->input->post('month');
		$year=$this->input->post('year');
		$role=$this->input->post('role');
		$process_id=$this->input->post('process_id');
		$process_name=$this->input->post('process_name');
		if($date1 !='')
		{
			 $date = date("Y-m-d", strtotime($date1));
		}
		else {
			$date='';
		}
		$query = $this -> api_new_model -> select_reminder($user_id,$date,$month,$year);
		$response["select_reminder"] = $query;
		
		
		echo json_encode($response);
	}
	public function appointment_insert()
	
	{
		$this -> api_new_model -> appointment_insert();
	}
	public function missed_appointment()
	
	{
		$user_id=$this->input->post('user_id');
		$date1=$this->input->post('date');
		$month=$this->input->post('month');
		$year=$this->input->post('year');
		$role=$this->input->post('role');
		$process_id=$this->input->post('process_id');
		$process_name=$this->input->post('process_name');
		$sub_poc_purchase_session=$this->input->post('sub_poc_purchase_session');
		if($date1 !='')
		{
			 $date = date("Y-m-d", strtotime($date1));
		}
		else {
			$date='';
		}
		$query = $this -> api_new_model -> pending_appointment_list1($user_id,$role,$process_name,$process_id,$sub_poc_purchase_session);
	
		$response["lead_details"] = $query;
		echo json_encode($response);
	}
	public function send_quotation_on_whatsapp()
	{
		$enq_id = $this -> input -> post('enq_id');
		$role_id_session= $this -> input -> post('role_id_session');
		$user_id_session= $this -> input -> post('user_id_session');
	
		//Send quotation 
		$customer_name = $this -> input -> post('customer_name');
		$email = $this -> input -> post('email');
		
		$phone = $this -> input -> post('phone');
		
		$quotation_location = $this -> input -> post('qlocation');
		$quotation_model_name=$data['model_name']= $this -> input -> post('qmodel_name');
		$quotation_description = $this -> input -> post('description');
		$quotation_type=$data['type']=$this->input->post('quotation_type');
		$finance_data=$data['finance_data']=$this->input->post('finance_data');
		/*$this -> api_new_model -> insert_header_quotation($quotation_location, $quotation_model_name, $quotation_description,
		$email,$customer_name,$quotation_type,$finance_data,$user_id_session);*/		
	 	$select_data=$this -> api_new_model -> select_quotation_data($quotation_location, $quotation_model_name, $quotation_description);
		 $response["quotation_data"] = $select_data;
		echo json_encode($response);
	 }
	
}
?>
