<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Api_service_model extends CI_model {
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
    function select_lead_source($process_id) {
			
		$this->db->select('*');
		$this->db->from('lead_source');
		$this->db->where('process_id',$process_id);
		$query=$this->db->get();	
		return $query->result();
		

	}
    	/* Insert Service Followup */
	public function insert_service_followup()
	{
	 $assign_to=$this->input->post('user_id');
	 $enq_id=$this->input->post('booking_id');
	 $email=$this->input->post('email');
	 $feedbackstatus=$this->input->post('feedbackstatus');
	 $nextAction=$this->input->post('nextAction');
	 $eagerness=$this->input->post('eagerness');
	 $address=$this->input->post('address');
	 $followupdate=$this->input->post('followupdate');
	 $comment=$this->input->post('comment');
	//echo '<br>';
	 $service_center=$this->input->post('service_center');
	 $car_model=$this->input->post('car_model');
	 $registration_no=$this->input->post('registration_no');
	 $km=$this->input->post('km');
	 $service_type=$this->input->post('service_type');
	 $pick_up=$this->input->post('pick_up');
	 $pickup_date=$this->input->post('pickup_date');
	$today=date('Y-m-d');
    
	$mcp_offers=$this->input->post('mcp_offers');
	 $mcp_type=$this->input->post('mcp_type');
	$pickup_time_slot=$this->input->post('pickup_time_slot');
	
	$insert_query=$this->db->query("INSERT INTO `lead_followup_all`
	(`leadid`, `assign_to`,  `nextfollowupdate`, `comment`, `eagerness`,  `feedbackStatus`, `nextAction`, `date`, `pick_up_date`,`pick_up_required`,`service_type`) 
	VALUES ('$enq_id','$assign_to','$followupdate','$comment','$eagerness','$feedbackstatus','$nextAction','$today','$pickup_date','$pick_up','$service_type')");
	$followup_id=$this->db->insert_id();
	$update_query=$this->db->query("update lead_master_all set cse_followup_id='$followup_id', email='$email',feedbackStatus='$feedbackstatus',nextAction='$nextAction',address='$address',
	service_center='$service_center',model_id='$car_model',reg_no='$registration_no',service_type='$service_type',pickup_required='$pick_up',pick_up_date='$pickup_date',km='$km',mcp_offers='$mcp_offers',mcp_type='$mcp_type',pickup_time_slot='$pickup_time_slot' where enq_id='$enq_id'");
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
	/////////////////////////////////////////////////////////////////////////////////////////////////
	/* Insert Finance Followup */
	public function insert_finance_followup()
	{
	 $assign_to=$this->input->post('user_id');
	 $enq_id=$this->input->post('booking_id');
	 $email=$this->input->post('email');
	 $feedbackstatus=$this->input->post('feedbackstatus');
	 $nextAction=$this->input->post('nextAction');
	 $eagerness=$this->input->post('eagerness');
	 $address=$this->input->post('address');
	 $followupdate=$this->input->post('followupdate');
	 $comment=$this->input->post('comment');
	//echo '<br>';
	 $bank_name=$this->input->post('bank_name');
	 $loan_type=$this->input->post('loan_type');
	 $roi=$this->input->post('roi');
	 $tenure=$this->input->post('tenure');
	 $dealer=$this->input->post('dealer');
	 $car_model=$this->input->post('car_model');
	 $registration_no=$this->input->post('registration_no');
	 $los_no=$this->input->post('los_no');
	 $loanamount=$this->input->post('loan_amount');
	//echo '<br>';
	 $pickup_date=$this->input->post('pickup_date');
	 $excutive_name=$this->input->post('excutive_name');
	 $loan_status=$this->input->post('loan_status');
	 $login_date=$this->input->post('login_date');
	 $approved_date=$this->input->post('approved_date');
	 $disburse_date=$this->input->post('disburse_date');
	 $disburse_amount=$this->input->post('disburse_amount');
	 $process_fee=$this->input->post('process_fee');
	 $emi=$this->input->post('emi');

	
	$today=date('Y-m-d');
	
	$insert_query=$this->db->query("INSERT INTO `lead_followup_all`(`leadid`, `assign_to`,  `nextfollowupdate`, `comment`, `eagerness`,  `feedbackStatus`, `nextAction`, `date`, `pick_up_date`, `executive_name`, `login_status_name`, `disburse_amount`, `disburse_date`, `process_fee`, `emi`, `approved_date`, `file_login_date`) 
	VALUES ('$enq_id','$assign_to','$followupdate','$comment','$eagerness','$feedbackstatus','$nextAction','$today','$pickup_date','$excutive_name','$loan_status','$disburse_amount','$disburse_date','$process_fee','$emi','$approved_date','$login_date')");
	$followup_id=$this->db->insert_id();
	$update_query=$this->db->query("update lead_master_all set cse_followup_id='$followup_id', email='$email',feedbackStatus='$feedbackstatus',nextAction='$nextAction',address='$address',bank_name='$bank_name',model_id='$car_model',loan_type='$loan_type',	reg_no='$registration_no',roi='$roi',los_no='$los_no',tenure='$tenure',loanamount='$loanamount',dealer='$dealer',login_status_name='$loan_status' where enq_id='$enq_id'");
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