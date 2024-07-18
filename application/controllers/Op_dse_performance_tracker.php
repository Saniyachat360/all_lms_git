<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Op_dse_performance_tracker extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('op_dse_performance_tracker_model');
		$this -> process_id = $_SESSION['process_id'];
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	function leads() {
		$this -> session();
		
	
		$from_date= $data['from_date']= $this -> input -> get('from_date');
		$to_date=$data['to_date']= $this -> input -> get('to_date');
		$source=$data['source']=$this -> input -> get('source');
		$dse_id=$data['cse_id']= $this -> input -> get('dse_id');
		if($dse_id ==''){
			
		$dse_id=$data['cse_id']= $this -> input -> get('cse_id');	
		}
		
		$query = $this -> op_dse_performance_tracker_model -> $source($from_date,$to_date,$dse_id);
		$source_count=$source.'_count';
		$data['select_lead'] = $query;
		$data['count_lead']=$this -> op_dse_performance_tracker_model -> $source_count($from_date,$to_date,$dse_id);
		$data['id']=$dse_id;
		$enq = $source;
		$data['enq'] = ucwords((str_replace('_', ' ', $enq)));
		$data['tracker_name']='Op_dse_performance_tracker';
		$this -> load -> view('include/admin_header.php');
		
		$this -> load -> view('report/one_pager_report_leads_view.php', $data);
		$this -> load -> view('include/footer.php');
	
		/*if ($_SESSION['process_id'] == 7) {
			$this -> download_used_car();
		}*/
	}
	
	public function download_used_car() {

		$from_date = $this -> input -> get('from_date');
		$to_date = $this -> input -> get('to_date');
		$source = $this -> input -> get('source');
		$dse_id = $this -> input -> get('dse_id');
		$query = $this -> op_dse_performance_tracker_model -> $source($from_date,$to_date,$dse_id);
		//print_r($query);

	if ($this -> process_id == 6) {
			$csv = "Sr No,Lead Source,Sub Lead Source,Customer Name,Mobile Number,Alternate Mobile Number,Address,Email ID,Lead Date,Lead Time,Assistance Required,Booking within Days,Customer Location,Lead Assigned Date(CSE),Lead Assigned Time(CSE),CSE Name,CSE Call Date,CSE Call Time,CSE Call Status,CSE Feedback,CSE Next Action,CSE Remark,CSE NFD,CSE NFT,Appointment Type,Appointment Date,Appointment Time,Appointment Status,Showroom Location,DSE Name,Lead Assigned Date,Lead Assigned Time,DSE Call Date,DSE Call Time,DSE Call Status,DSE Feedback,DSE Next Action,DSE Remark,DSE NFD,DSE NFT,Interested in Finance,Interested in Accessories,Interested in Insurance,Interested in EW,Buyer Type,Model,Variant,Auditor Name,Auditor call Date,Auditor call Time,Auditor call Status,Followup Pending,Call Received from Showroom,Fake Updation,Service Feedback,Auditor Remark\n";

		} else if ($this -> process_id == 7) {
			$csv = "Sr No,Lead Source,Sub Lead Source,Customer Name,Mobile Number,Alternate Mobile Number,Address,Email ID,Lead Date,Lead Time,Assistance Required,Booking within Days,Customer Location,Lead Assigned Date(CSE),Lead Assigned Time(CSE),CSE Name,CSE Call Date,CSE Call Time,CSE Call Status,CSE Feedback,CSE Next Action,CSE Remark,CSE NFD,CSE NFT,Appointment Type,Appointment Date,Appointment Time,Appointment Status,Showroom Location,DSE Name,Lead Assigned Date,Lead Assigned Time,DSE Call Date,DSE Call Time,DSE Call Status,DSE Feedback,DSE Next Action,DSE Remark,DSE NFD,DSE NFT,Interested in Finance,Interested in Accessories,Interested in Insurance,Interested in EW,Buyer Type,Model,Variant,Exchange Make,Exchange Model,Manufacturing Year,Ownership,KM,Budget From,Budget To,Accidental Claim,Auditor Name,Auditor call Date,Auditor call Time,Auditor call Status,Followup Pending,Call Received from Showroom,Fake Updation,Service Feedback,Auditor Remark\n";

		} else {

			$csv = "Sr No,Lead Source,Sub Lead Source,Customer Name,Mobile Number,Alternate Mobile Number,Address,Email ID,Lead Date,Lead Time,Assistance Required,Booking within Days,Customer Location,Lead Assigned Date(CSE),Lead Assigned Time(CSE),CSE Name,CSE Call Date,CSE Call Time,CSE Call Status,CSE Feedback,CSE Next Action,CSE Remark,CSE NFD,CSE NFT,Appointment Type,Appointment Date,Appointment Time,Appointment Status,Showroom Location,Evaluator Name,Lead Assigned Date(Evaluator),Lead Assigned Time(Evaluator),Evaluator Call Date,Evaluator Call Time,Evaluator Call Status,Evaluator Feedback,Evaluator Next Action,Evaluator Remark,Evaluator NFD,Evaluator NFT,Exchange Make,Exchange Model,Manufacturing Year,	Ownership,KM,Accidental Claim,Evaluation within days,Fuel Type,Color,Registration Number,Quoted Price,Expected Price,Auditor Name,Auditor call Date,Auditor call Time,Auditor call Status,Followup Pending,Call Received from Showroom,Fake Updation,Service Feedback,Auditor Remark\n";

		}

		$i = 0;
		foreach ($query as $row) {
			$i++;
			if ($row -> assign_to_cse == 0) {
				$cse_name = $row -> csetl_fname . ' ' . $row -> csetl_lname;
			} else {
				$cse_name = $row -> cse_fname . ' ' . $row -> cse_lname;
			}
			if ($row -> assign_to_dse == 0) {
				$dse_name = $row -> dsetl_fname . ' ' . $row -> dsetl_lname;
			} else {
				$dse_name = $row -> dse_fname . ' ' . $row -> dse_lname;
			}

			if ($row -> lead_source == '') { $lead_source = "Web";
			}
			
			else { $lead_source = $row -> lead_source;
			}
			$cse_comment = preg_replace('#[^\w()/.%\-&]#', " ", $row -> cse_comment);
			$dse_comment = preg_replace('#[^\w()/.%\-&]#', " ", $row -> dse_comment);
			if ($this -> process_id == 6) {
				$csv .= $i . ',"' . $lead_source . '","' . $row -> enquiry_for . '","' . $row -> name . '","' . $row -> contact_no . '","' . $row -> alternate_contact_no . '","' . $row -> address . '","' . $row -> email . '","' . $row -> lead_date . '","' . $row -> created_time . '","' . $row -> assistance . '","' . $row -> days60_booking . '","' . $row -> customer_location . '","' . $row -> assign_to_cse_date . '","' . $row -> assign_to_cse_time . '","' . $cse_name . '","' . $row -> cse_date . '","' . $row -> cse_time . '","' . $row -> csecontactibility . '","' . $row -> csefeedback . '","' . $row -> csenextAction . '","' . $cse_comment . '","' . $row -> cse_nfd . '","' . $row -> cse_nftime . '","' . $row -> appointment_type . '","' . $row -> appointment_date . '","' . $row -> appointment_time . '","' . $row -> appointment_status . '","' . $row -> showroom_location . '","' . $dse_name . '","' . $row -> assign_to_dse_date . '","' . $row -> assign_to_dse_time . '","' . $row -> dse_date . '","' . $row -> dse_time . '","' . $row -> dsecontactibility . '","' . $row -> dsefeedback . '","' . $row -> dsenextAction . '","' . $dse_comment . '","' . $row -> dse_nfd . '","' . $row -> dse_nftime . '","' . $row -> interested_in_finance . '","' . $row -> interested_in_accessories . '","' . $row -> interested_in_insurance . '","' . $row -> interested_in_ew . '","' . $row -> buyer_type . '","' . $row -> new_model_name . '",' . $row -> variant_name . '","' . $row -> auditfname . ' ' . $row -> auditlname . '","' . $row -> auditor_date . '","' . $row -> auditor_time . '","' . $row -> auditor_call_status . '","' . $row -> followup_pending . '","' . $row -> call_received . '","' . $row -> fake_updation . '","' . $row -> service_feedback . '","' . $row -> auditor_remark . '"' . "\n";

			} elseif ($this -> process_id == 7) {
				$csv .= $i . ',"' . $lead_source . '","' . $row -> enquiry_for . '","' . $row -> name . '","' . $row -> contact_no . '","' . $row -> alternate_contact_no . '","' . $row -> address . '","' . $row -> email . '","' . $row -> lead_date . '","' . $row -> created_time . '",' . $row -> assistance . ',' . $row -> days60_booking . ',"' . $row -> customer_location . '",' . $row -> assign_to_cse_date . ',' . $row -> assign_to_cse_time . ',' . $cse_name . ',' . $row -> cse_date . ',' . $row -> cse_time . ',' . $row -> csecontactibility . ',"' . $row -> csefeedback . '","' . $row -> csenextAction . '","' . $row -> cse_comment . '",' . $row -> cse_nfd . ',' . $row -> cse_nftime . ',"' . $row -> appointment_type . '",' . $row -> appointment_date . ',' . $row -> appointment_time . ',"' . $row -> appointment_status . '","' . $row -> showroom_location . '",' . $dse_name . ',' . $row -> assign_to_dse_date . ',' . $row -> assign_to_dse_time . ',' . $row -> dse_date . ',' . $row -> dse_time . ',' . $row -> dsecontactibility . ',' . $row -> dsefeedback . ',' . $row -> dsenextAction . ',"' . $row -> dse_comment . '",' . $row -> dse_nfd . ',' . $row -> dse_nftime . ',' . $row -> interested_in_finance . ',' . $row -> interested_in_accessories . ',' . $row -> interested_in_insurance . ',' . $row -> interested_in_ew . ',' . $row -> buyer_type . ',' . $row -> new_model_name . ',' . $row -> variant_name . ',' . $row -> old_make . ',' . $row -> old_model . ',' . $row -> manf_year . ',' . $row -> ownership . ',' . $row -> km . ',' . $row -> budget_from . ',' . $row -> budget_to . ',' . $row -> accidental_claim . ',"' . $row -> auditfname . ' ' . $row -> auditlname . '",' . $row -> auditor_date . ',' . $row -> auditor_time . ',' . $row -> auditor_call_status . ',' . $row -> followup_pending . ',' . $row -> call_received . ',' . $row -> fake_updation . ',' . $row -> service_feedback . ',"' . $row -> auditor_remark . '"' . "\n";

			} else {
				$csv .= $i . ',"' . $lead_source . '","' . $row -> enquiry_for . '","' . $row -> name . '","' . $row -> contact_no . '","' . $row -> alternate_contact_no . '","' . $row -> address . '","' . $row -> email . '","' . $row -> lead_date . '","' . $row -> created_time . '",' . $row -> assistance . ',' . $row -> days60_booking . ',"' . $row -> customer_location . '",' . $row -> assign_to_cse_date . ',' . $row -> assign_to_cse_time . ',' . $cse_name . ',' . $row -> cse_date . ',' . $row -> cse_time . ',' . $row -> csecontactibility . ',"' . $row -> csefeedback . '","' . $row -> csenextAction . '","' . $row -> cse_comment . '",' . $row -> cse_nfd . ',' . $row -> cse_nftime . ',"' . $row -> appointment_type . '",' . $row -> appointment_date . ',' . $row -> appointment_time . ',"' . $row -> appointment_status . '","' . $row -> showroom_location . '",' . $dse_name . ',' . $row -> assign_to_dse_date . ',' . $row -> assign_to_dse_time . ',' . $row -> dse_date . ',' . $row -> dse_time . ',' . $row -> dsecontactibility . ',' . $row -> dsefeedback . ',' . $row -> dsenextAction . ',"' . $row -> dse_comment . '",' . $row -> dse_nfd . ',' . $row -> dse_nftime . ',' . $row -> old_make . ',' . $row -> old_model . ',' . $row -> manf_year . ',' . $row -> ownership . ',' . $row -> km . ',' . $row -> accidental_claim . ',' . $row -> evaluation_within_days . ',' . $row -> fuel_type . ',' . $row -> color . ',' . $row -> reg_no . ',' . $row -> quotated_price . ',' . $row -> expected_price . ',"' . $row -> auditfname . ' ' . $row -> auditlname . '",' . $row -> auditor_date . ',' . $row -> auditor_time . ',' . $row -> auditor_call_status . ',' . $row -> followup_pending . ',' . $row -> call_received . ',' . $row -> fake_updation . ',' . $row -> service_feedback . ',' . $row -> auditor_remark . "\n";

			}

		}
		$csv_handler = fopen('tracker.csv', 'w');
		fwrite($csv_handler, $csv);
		fclose($csv_handler);

		$this -> load -> helper('download');
		$filename = 'Tracker ' . $from_date . ' - ' . $to_date . '.csv';
		$data = file_get_contents('https://autovista.in/all_lms_demo/tracker.csv');
		// Read the file's contents

		force_download($filename, $data);

	}

}
?>