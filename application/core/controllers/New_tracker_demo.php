<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class new_tracker_demo extends CI_Controller {
private  $process_id;
private $process_name;
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('new_tracker_model');
		//$this -> load -> model('tracker_model1');
		 $this->process_id=$_SESSION['process_id'];
		  $this->process_name=$_SESSION['process_name'];		}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function leads() {

		$this -> session();
		// Get Filter select values
		$data['select_campaign'] = $this -> new_tracker_model -> select_campaign();
		$data['select_feedback'] = $this -> new_tracker_model -> select_feedback();
		$data['select_next_action'] = $this -> new_tracker_model -> select_next_action();
		$data['select_lead_source'] = $this -> new_tracker_model -> select_lead_source();
		$data['campaign_name'] = $this -> input -> get('campaign_name');
		
		// Get All Selected Values
		$data['nextaction'] = $this -> input -> get('nextaction');
		$data['feedback'] = $this -> input -> get('feedback');
		$data['fromdate'] = $this -> input -> get('fromdate');
		$data['todate'] = $this -> input -> get('todate');
		$data['date_type'] = $this -> input -> get('date_type');
		$data['process_id']=$this->process_id;
		
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('tracker_with_dse_tob_tab_view_new.php', $data);
		$this -> load -> view('tracker_with_dse_view_new.php', $data);
		$this -> load -> view('include/footer.php');
	}

	public function tracker_dse_filter() {
		$this -> session();
		
		//Select Box Values
		$data['select_campaign'] = $this -> new_tracker_model -> select_campaign();
		$data['select_feedback'] = $this -> new_tracker_model -> select_feedback();
		$data['select_next_action'] = $this -> new_tracker_model -> select_next_action();
		$data['select_lead_source'] = $this -> new_tracker_model -> select_lead_source();
		
		// Get All Selected Values
		$data['campaign_name'] = $this -> input -> get('campaign_name');
		$data['nextaction'] = $this -> input -> get('nextaction');
		$data['feedback'] = $this -> input -> get('feedback');
		$data['fromdate'] = $this -> input -> get('fromdate');
		$data['todate'] = $this -> input -> get('todate');
		$data['date_type'] = $this -> input -> get('date_type');
		
		// selected values
		$data['select_lead'] = $this -> new_tracker_model -> select_leads();
		$data['count_lead'] = $this -> new_tracker_model -> select_leads_count();
		$data['process_id']=$this->process_id;
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('tracker_with_dse_tob_tab_view_new.php', $data);
		$this -> load -> view('tracker_with_dse_filter_new.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function download_data() {

		
		if($_SESSION['process_id']==1){
			$this->download_finance();
		}
		else if($_SESSION['process_id']==4){
			$this->download_service();
		}
		else if($_SESSION['process_id']==5){
			$this->download_accessories();
		}
		else if ($_SESSION['process_id']==6){
			$this->download_new_car();
		}
		else if($_SESSION['process_id']==7){
			$this->download_new_car();
		}
		else if($_SESSION['process_id']==8){
			$this->download_evaluation();
		}
	
	}
public function download_finance()
{
		$from_date = $this -> input -> get('fromdate');
		$to_date = $this -> input -> get('todate');
	
		$query = $this -> new_tracker_model -> select_lead_download();
		//print_r($query);
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);

		$table_columns = array('Sr No', 'Lead Source', 'Assistance Required', 'Booking Within Days', 'Customer Location','Customer Name', 'Contact Number', 'Alternate Mobile Number','Address', 'Email', 'Lead Date',  'CSE Name', 'CSE Call Date', 'CSE Feedback', 'CSE Next Action', 'Eagerness', 'CSE NFD', 'CSE NFT','CSE Comment',
		'Auditor Name', 'Auditor Followup Date', 'Followup Pending', 'Call Received from Showroom', 'Fake Updation', 'Service Feedback', 'Auditor Remark',
		'Car Model','Reg No','Bank Name','Loan Type','ROI','LOS No','Tenure','Amount','Dealer/DSA','Collection Executive Name','Pickup Date','Login Date','Loan Status','Approved Date','Disburse Date','Disburse Amount','Processing Fee','EMI'
		);
		$column = 0;

		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}
		
		$excel_row = 2;

		foreach ($query as $row) {

			if ($row -> assign_to_cse == 0) {
				$cse_name = $row -> csetl_fname . ' ' . $row -> csetl_lname;
			} else {
				$cse_name = $row -> cse_fname . ' ' . $row -> cse_lname;
			}
			
			if ($row -> lead_source == '') { $lead_source = "Web";
			} 
			else if($row->lead_source=='Facebook')
			{
				$lead_source=$row->enquiry_for;
			}
			else { $lead_source = $row -> lead_source;
			}
	
			
			//Lead date
			$lead_date=$row->lead_date;
				if(!empty($lead_date) && $lead_date!='0000-00-00'){
			$PHPDateValue1 = strtotime($lead_date);
			
			$ExcelDateValue1 = PHPExcel_Shared_Date::PHPToExcel($lead_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $ExcelDateValue1); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(10, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, '00/00/00'); 
			}
			//CSE call date
			$cse_call_date=$row->cse_date;
			if(!empty($cse_call_date) && $cse_call_date!='0000-00-00'){
			$PHPDateValue2= strtotime($cse_call_date);
			$ExcelDateValue2 = PHPExcel_Shared_Date::PHPToExcel($cse_call_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $ExcelDateValue2); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(12, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, '00/00/00'); 
			}
			//CSE cse nfd
			$cse_nfd_date=$row->cse_nfd;
			if(!empty($cse_nfd_date) && $cse_nfd_date!='0000-00-00'){
			$PHPDateValue3 = strtotime($cse_nfd_date);
			$ExcelDateValue3 = PHPExcel_Shared_Date::PHPToExcel($cse_nfd_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, $ExcelDateValue3); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(16, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
			$object -> getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row,  '00/00/00'); 
				}
			
			//Auditor Date			
			$auditor_date=$row->auditor_date;
			if(!empty($auditor_date) && $auditor_date!='0000-00-00'){
			$PHPDateValue6 = strtotime($auditor_date);
			$ExcelDateValue = PHPExcel_Shared_Date::PHPToExcel($auditor_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row, $ExcelDateValue); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(20, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
			$object -> getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row,  '00/00/00'); 
			}	
			//pickup date
			$pickup_date=$row->pick_up_date;
			if(!empty($pickup_date) && $pickup_date!='0000-00-00' ){
			$PHPDateValue4 = strtotime($pickup_date);
			$ExcelDateValue4 = PHPExcel_Shared_Date::PHPToExcel($pickup_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(36, $excel_row, $ExcelDateValue4); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(36, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
			$object -> getActiveSheet()->setCellValueByColumnAndRow(36, $excel_row, '00/00/00'); 
					
			}
			//Login date
			$login_date=$row->file_login_date;
			if(!empty($login_date) && $login_date!='0000-00-00'){
			$PHPDateValue5 = strtotime($login_date);
			$ExcelDateValue5 = PHPExcel_Shared_Date::PHPToExcel($login_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(37, $excel_row, $ExcelDateValue5); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(37, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
			$object -> getActiveSheet()->setCellValueByColumnAndRow(37, $excel_row,  '00/00/00'); 
			}
			//Approved Date
			$approved_date=$row->approved_date;
			if(!empty($approved_date) && $approved_date!='0000-00-00'){
			$PHPDateValue6 = strtotime($approved_date);
			$ExcelDateValue6 = PHPExcel_Shared_Date::PHPToExcel($approved_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(39, $excel_row, $ExcelDateValue6); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(39, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
			$object -> getActiveSheet()->setCellValueByColumnAndRow(39, $excel_row,  '00/00/00'); 
			}
			//Disburse Date
			$disburse_date=$row->disburse_date;
			if(!empty($disburse_date) && $disburse_date!='0000-00-00'){
			$PHPDateValue7 = strtotime($disburse_date);
			$ExcelDateValue7 = PHPExcel_Shared_Date::PHPToExcel($disburse_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(40, $excel_row, $ExcelDateValue7); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(40, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
			$object -> getActiveSheet()->setCellValueByColumnAndRow(40, $excel_row,  '00/00/00'); 
			}
			//DSE nfd
			/*$dse_nfd_date=$row->dse_nfd;
				if(!empty($dse_nfd_date) && $dse_nfd_date!='0000-00-00'){
			$PHPDateValue6 = strtotime($dse_nfd_date);
			$ExcelDateValue = PHPExcel_Shared_Date::PHPToExcel($dse_nfd_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(25, $excel_row, $ExcelDateValue); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(25, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
			$object -> getActiveSheet()->setCellValueByColumnAndRow(25, $excel_row,  '00/00/00'); 
			}*/
			
				$auditor_name=$row -> auditfname . ' ' . $row -> auditlname ;
				//Auditor date
		
			$excel_row1 = $excel_row - 1;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $excel_row1);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $lead_source);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> assistance);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row, $row -> days60_booking);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(4, $excel_row, $row -> customer_location);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(5, $excel_row, $row -> name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $row -> contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $row -> alternate_contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, $row -> address);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $row -> email);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(10, $excel_row, $row -> lead_date);
		

			// CSE Information 
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(11, $excel_row, $cse_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(12, $excel_row, $row -> cse_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(13, $excel_row, $row -> csefeedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, $row -> csenextAction);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> eagerness);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> cse_nfd);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $row -> cse_nftime);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> cse_comment);
			
			//Auditor Remark
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(19, $excel_row,  $auditor_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(20, $excel_row, $row -> auditor_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(21, $excel_row, $row -> followup_pending);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(22, $excel_row, $row -> call_received);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(23, $excel_row, $row -> fake_updation);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(24, $excel_row, $row -> service_feedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(25, $excel_row, $row -> auditor_remark);
		
		// Other Information 

			$object -> getActiveSheet() -> setCellValueByColumnAndRow(26, $excel_row, $row->model_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(27, $excel_row, $row -> reg_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(28, $excel_row, $row -> bank_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(29, $excel_row, $row -> loan_type);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(30, $excel_row, $row -> roi);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(31, $excel_row, $row -> los_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(32, $excel_row, $row -> tenure);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(33, $excel_row, $row -> loanamount);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(34, $excel_row, $row -> dealer);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(35, $excel_row, $row -> executive_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(36, $excel_row, $row -> pickup_date);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(37, $excel_row, $row -> login_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(38, $excel_row, $row -> login_status_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(39, $excel_row, $row -> approved_date);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(40, $excel_row, $row -> disburse_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(41, $excel_row, $row -> disburse_amount);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(42, $excel_row, $row -> process_fee);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(43, $excel_row, $row -> emi);
			
			
			
			
			

			$excel_row++;

		}

		$filename = 'Tracker ' . $from_date . ' - ' . $to_date;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment;filename="' . $filename . ".zip");
		header('Content-Disposition: attachment;filename="' . $filename . ".zip");
		//$object_writer -> save('php://output');
	
	
}

public function download_new_car()
{
	$from_date = $this -> input -> get('fromdate');
		$to_date = $this -> input -> get('todate');
		//$select_lead_dse= $this -> new_tracker_model ->select_lead_dse_download();
		//$select_lead_dse_lc=$this -> new_tracker_model ->select_lead_dse_lc_download();
		//$query = array_merge($select_lead_dse,$select_lead_dse_lc);
		$query = $this -> new_tracker_model -> select_lead_download();
	//print_r($query);
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);
$table_columns = array('Sr No', 'Lead Source','Customer Name','Mobile Number','Alternate Mobile Number','Address','Email ID','Lead Date','Lead Time','Assistance Required','Booking within Days','Customer Location','Lead Assigned Date(CSE)','Lead Assigned Time(CSE)','CSE Name','CSE Call Date','CSE Call Time','CSE Call Status','CSE Feedback','CSE Next Action','CSE Remark','CSE NFD','CSE NFT','Appointment Type','Appointment Date','Appointment Time','Appointment Address','Appointment Status','Appointment Rating','Appointment Feeback','Showroom Location','TD/HV Date','DSE Name','	Lead Assigned Date','Lead Assigned Time','DSE Call Date','DSE Call Time','DSE Call Status','DSE Feedback','DSE Next Action','DSE Remark','DSE NFD','DSE NFT','Auditor Name','Auditor call Date','Auditor call Time','Auditor call Status','Followup Pending','Call Received from Showroom','Fake Updation','Service Feedback','Auditor Remark','Interested in Finance','Interested in Accessories','Interested in Insurance','Interested in EW','Buyer Type','Model','Variant');
if($_SESSION['process_id']=='7'){
	$other_array=array('Exchange Make','Exchange Model','Manufacturing Year','Ownership','KM','Budget From','Budget To','Accidental Claim');
	$table_columns=array_merge($table_columns,$other_array);
}
//print_r($table_columns);
$column = 0;

		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}
		
		$excel_row = 2;

		foreach ($query as $row) {

			
		

			
		
				
				//Auditor date
			$auditor_date=$row->auditor_date;
				if(!empty($auditor_date) && $auditor_date!='0000-00-00'){
			$PHPDateValue6 = strtotime($auditor_date);
			$ExcelDateValue = PHPExcel_Shared_Date::PHPToExcel($auditor_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(28, $excel_row, $ExcelDateValue); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(28, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(28, $excel_row,  '00/00/00'); 
			}
			
			$excel_row1 = $excel_row - 1;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $excel_row1);
			if ($row -> lead_source == '') { 
			
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, 'Web');
			} 
			else if($row->lead_source=='Facebook')
			{
				
					$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $row->enquiry_for);
			}
			else { 
	
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $row -> lead_source);
			}
		
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row, $row -> contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(4, $excel_row, $row -> alternate_contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(5, $excel_row, $row -> address);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $row -> email);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $row -> lead_date);
			//Lead date
			//$lead_date=$row->lead_date;
					$object -> getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,$row->lead_date); 
		
		/*		if(!empty($lead_date) && $lead_date!='0000-00-00'){
			$PHPDateValue1 = strtotime($lead_date);
			
			$ExcelDateValue1 = PHPExcel_Shared_Date::PHPToExcel($lead_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $ExcelDateValue1); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(7, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, '00/00/00'); 
			}*/
			/////////////////////////////////////////////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, $row -> created_time);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $row -> assistance);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(10, $excel_row, $row -> days60_booking);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(11, $excel_row, $row -> customer_location);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(12, $excel_row, $row -> assign_to_cse_date);
			//assign_to_cse_date
			//$cse_assign_to_cse_date=$row->assign_to_cse_date;
				$object -> getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row->assign_to_cse_date); 
			
			/*if(!empty($cse_assign_to_cse_date) && $cse_assign_to_cse_date!='0000-00-00'){
			$PHPDateValue2= strtotime($cse_assign_to_cse_date);
			$ExcelDateValue2 = PHPExcel_Shared_Date::PHPToExcel($cse_assign_to_cse_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $ExcelDateValue2); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(12, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, '00/00/00'); 
			}*/
			//////////////////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(13, $excel_row, $row -> assign_to_cse_time);
			
			
			// CSE Information 
			if ($row -> assign_to_cse == 0) {
						$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, $row -> csetl_fname . ' ' . $row -> csetl_lname);
			
			} else {
						$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, $row -> cse_fname . ' ' . $row -> cse_lname);
		
			}
	
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> cse_date);
			//CSE call date
			$cse_call_date=$row->cse_date;
					$object -> getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $row->cse_date); 
		
			/*if(!empty($cse_call_date) && $cse_call_date!='0000-00-00'){
			$PHPDateValue2= strtotime($cse_call_date);
			$ExcelDateValue2 = PHPExcel_Shared_Date::PHPToExcel($cse_call_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $ExcelDateValue2); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(15, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, '00/00/00'); 
			}*/
			/////////////////////////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> cse_time);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $row -> csecontactibility);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> csefeedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(19, $excel_row, $row -> csenextAction);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(20, $excel_row, $row -> cse_comment);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(21, $excel_row, $row -> cse_nfd);
				//CSE cse nfd
			//$cse_nfd_date=$row->cse_nfd;
			$object -> getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row, $row->cse_nfd); 
			
			/*if(!empty($cse_nfd_date) && $cse_nfd_date!='0000-00-00'){
			$PHPDateValue3 = strtotime($cse_nfd_date);
			$ExcelDateValue3 = PHPExcel_Shared_Date::PHPToExcel($cse_nfd_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row, $ExcelDateValue3); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(21, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
						$object -> getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row,  '00/00/00'); 
				}*/
				////////////////////////////////
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(22, $excel_row, $row -> cse_nftime);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(23, $excel_row, $row -> appointment_type);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(24, $excel_row, $row -> appointment_date);
				//appointment_date
			
					$object -> getActiveSheet()->setCellValueByColumnAndRow(24, $excel_row, '00/00/00'); 
					
			
			//////////////////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(25, $excel_row, $row -> appointment_time);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(26, $excel_row, $row -> appointment_address);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(27, $excel_row, $row -> appointment_status);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(28, $excel_row, $row -> appointment_rating);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(29, $excel_row, $row -> appointment_feedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(30, $excel_row, $row -> showroom_location);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(31, $excel_row, $row -> td_hv_date);
			//td hv date
			
					$object -> getActiveSheet()->setCellValueByColumnAndRow(31, $excel_row, '00/00/00'); 
						

			// DSE Information 
				if ($row -> assign_to_dse == 0) {
			
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(32, $excel_row, $row -> dsetl_fname . ' ' . $row -> dsetl_lname);
			} else {
			
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(32, $excel_row, $row -> dse_fname . ' ' . $row -> dse_lname);
			}
			
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(33, $excel_row, $row -> assign_to_dse_date);
			//DSE date
			//$assign_to_dse_date=$row->assign_to_dse_date;
					$object -> getActiveSheet()->setCellValueByColumnAndRow(33, $excel_row, $row->assign_to_dse_date); 
		
			/*if(!empty($assign_to_dse_date) && $assign_to_dse_date!='0000-00-00'){
			$PHPDateValue5 = strtotime($assign_to_dse_date);
			$ExcelDateValue5 = PHPExcel_Shared_Date::PHPToExcel($assign_to_dse_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(33, $excel_row, $ExcelDateValue5); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(33, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(33, $excel_row,  '00/00/00'); 
			}*/
			////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(34, $excel_row, $row -> assign_to_dse_time);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(35, $excel_row, $row -> dse_date);
			//DSE date
			//$dse_date=$row->dse_date;
			$object -> getActiveSheet()->setCellValueByColumnAndRow(35, $excel_row,$row->dse_date); 
		
		/*	if(!empty($dse_date) && $dse_date!='0000-00-00'){
			$PHPDateValue5 = strtotime($dse_date);
			$ExcelDateValue5 = PHPExcel_Shared_Date::PHPToExcel($dse_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(35, $excel_row, $ExcelDateValue5); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(35, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(35, $excel_row,  '00/00/00'); 
			}*/
			////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(36, $excel_row, $row -> dse_time);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(37, $excel_row, $row -> dsecontactibility);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(38, $excel_row, $row -> dsefeedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(39, $excel_row, $row -> dsenextAction);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(40, $excel_row, $row -> dse_comment);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(41, $excel_row, $row -> dse_nfd);
			
			//DSE nfd
			//$dse_nfd_date=$row->dse_nfd;
					$object -> getActiveSheet()->setCellValueByColumnAndRow(41, $excel_row,$row->dse_nfd); 
		
			/*	if(!empty($dse_nfd_date) && $dse_nfd_date!='0000-00-00'){
			$PHPDateValue6 = strtotime($dse_nfd_date);
			$ExcelDateValue = PHPExcel_Shared_Date::PHPToExcel($dse_nfd_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(41, $excel_row, $ExcelDateValue); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(41, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(41, $excel_row,  '00/00/00'); 
			}*/
			/////////////////////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(42, $excel_row, $row -> dse_nftime);

			$object -> getActiveSheet() -> setCellValueByColumnAndRow(43, $excel_row,  $row -> auditfname . ' ' . $row -> auditlname);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(44, $excel_row, $row -> auditor_date);
			//auditor Date
			//$auditor_date=$row->auditor_date;
				$object -> getActiveSheet()->setCellValueByColumnAndRow(44, $excel_row, $row->auditor_date); 
		
			/*	if(!empty($auditor_date) && $auditor_date!='0000-00-00'){
			$PHPDateValue6 = strtotime($auditor_date);
			$ExcelDateValue = PHPExcel_Shared_Date::PHPToExcel($auditor_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(44, $excel_row, $ExcelDateValue); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(44, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(44, $excel_row,  '00/00/00'); 
			}*/
			/////////////////////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(45, $excel_row, $row -> auditor_time);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(46, $excel_row, $row -> auditor_call_status);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(47, $excel_row, $row -> followup_pending);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(48, $excel_row, $row -> call_received);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(49, $excel_row, $row -> fake_updation);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(50, $excel_row, $row -> service_feedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(51, $excel_row, $row -> auditor_remark);
			
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(52, $excel_row, $row -> interested_in_finance);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(53, $excel_row, $row -> interested_in_accessories);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(54, $excel_row, $row -> interested_in_insurance);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(55, $excel_row, $row -> interested_in_ew);
			
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(56, $excel_row, $row -> buyer_type);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(57, $excel_row, $row -> new_model_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(58, $excel_row, $row -> variant_name);
			if($_SESSION['process_id']=='7'){
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(59, $excel_row, $row -> old_make);
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(60, $excel_row, $row -> old_model);
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(61, $excel_row, $row -> manf_year);
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(62, $excel_row, $row -> ownership);
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(63, $excel_row, $row -> km);
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(64, $excel_row, $row -> budget_from);
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(65, $excel_row, $row -> budget_to);
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(66, $excel_row, $row -> accidental_claim);
				
			}
			

			$excel_row++;

		}
		//print_r($object);

$filename = 'Tracker ' . $from_date . ' - ' . $to_date;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
	


		/*$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');*/
	/*	$filename1=$filename.'.xls';
		$this->load->library('zip');
		
 header('Content-Type: application/zip');
  header('Content-Disposition: attachment; filename="'.basename($filename).'"');
  header('Content-Length: ' . filesize($filename));

  flush();
  readfile($filename);
		*/
	
}
public function download_used_car()
{
	$from_date = $this -> input -> get('fromdate');
		$to_date = $this -> input -> get('todate');
		//$select_lead_dse= $this -> new_tracker_model ->select_lead_dse_download();
		//$select_lead_dse_lc=$this -> new_tracker_model ->select_lead_dse_lc_download();
		//$query = array_merge($select_lead_dse,$select_lead_dse_lc);
		$query = $this -> new_tracker_model -> select_lead_download();
	//	print_r($query);
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);

		$table_columns = array('Sr No', 'Lead Source', 'Assistance Required', 'Booking Within Days', 'Customer Location','Customer Name', 'Contact', 'Alternate Mobile Number','Address', 'Email', 'Lead Date', 'Showroom Location', 'CSE Name', 'CSE Call Date', 'CSE Feedback', 'CSE Next Action', 'CSE Comment', 'CSE NFD', 'CSE NFT', 'TD/HV Date', 'DSE Name', 'DSE Call Date', 'DSE Feedback', 'DSE Next Action', 'DSE Comment', 'DSE NFD','DSE NFT',
		 'Auditor Name',  'Auditor Followup Date', 'Followup Pending', 'Call Received from Showroom', 'Fake Updation', 'Service Feedback', 'Auditor Remark','Buyer Type', 'New Model Name', 'Variant Name','Exchange Make','Exchange Model','Manufacturing Year','Ownership','KM','Budget From','Budget To','Accidental Claim
');
		$column = 0;

		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}
		
		$excel_row = 2;

		foreach ($query as $row) {

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
			else if($row->lead_source=='Facebook')
			{
				$lead_source=$row->enquiry_for;
			}
			else { $lead_source = $row -> lead_source;
			}
		/*	if ($row -> cse_fname == '' and $row -> nextAction == 'Not Yet') {
				$status = "Unassigned";
			} else if ($row -> cse_fname != '' and $row -> nextAction == 'Not Yet') {
				$status = "Untouched";
			} else {
				$status = $row -> nextAction;
			}*/
			
			//Lead date
			$lead_date=$row->lead_date;
				if(!empty($lead_date) && $lead_date!='0000-00-00'){
			$PHPDateValue1 = strtotime($lead_date);
			
			$ExcelDateValue1 = PHPExcel_Shared_Date::PHPToExcel($lead_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $ExcelDateValue1); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(10, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, '00/00/00'); 
			}
			//CSE call date
			$cse_call_date=$row->cse_date;
			if(!empty($cse_call_date) && $cse_call_date!='0000-00-00'){
			$PHPDateValue2= strtotime($cse_call_date);
			$ExcelDateValue2 = PHPExcel_Shared_Date::PHPToExcel($cse_call_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $ExcelDateValue2); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(13, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, '00/00/00'); 
			}
			//CSE cse nfd
			$cse_nfd_date=$row->cse_nfd;
			if(!empty($cse_nfd_date) && $cse_nfd_date!='0000-00-00'){
			$PHPDateValue3 = strtotime($cse_nfd_date);
			$ExcelDateValue3 = PHPExcel_Shared_Date::PHPToExcel($cse_nfd_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, $ExcelDateValue3); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(17, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
						$object -> getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row,  '00/00/00'); 
				}
			//td hv date
			$td_hv_date=$row->td_hv_date;
			if(!empty($td_hv_date) && $td_hv_date!='0000-00-00' ){
			$PHPDateValue4 = strtotime($td_hv_date);
			$ExcelDateValue4 = PHPExcel_Shared_Date::PHPToExcel($td_hv_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, $ExcelDateValue4); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(19, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
					$object -> getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, '00/00/00'); 
					
			}
			//DSE date
			$dse_date=$row->dse_date;
			if(!empty($dse_date) && $dse_date!='0000-00-00'){
			$PHPDateValue5 = strtotime($dse_date);
			$ExcelDateValue5 = PHPExcel_Shared_Date::PHPToExcel($dse_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row, $ExcelDateValue5); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(21, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row,  '00/00/00'); 
			}
			//DSE nfd
			$dse_nfd_date=$row->dse_nfd;
				if(!empty($dse_nfd_date) && $dse_nfd_date!='0000-00-00'){
			$PHPDateValue6 = strtotime($dse_nfd_date);
			$ExcelDateValue = PHPExcel_Shared_Date::PHPToExcel($dse_nfd_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(25, $excel_row, $ExcelDateValue); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(25, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(25, $excel_row,  '00/00/00'); 
			}
			
				$auditor_name=$row -> auditfname . ' ' . $row -> auditlname ;
				//Auditor date
			$auditor_date=$row->auditor_date;
				if(!empty($auditor_date) && $auditor_date!='0000-00-00'){
			$PHPDateValue6 = strtotime($auditor_date);
			$ExcelDateValue = PHPExcel_Shared_Date::PHPToExcel($auditor_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(28, $excel_row, $ExcelDateValue); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(28, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(28, $excel_row,  '00/00/00'); 
			}
			
			$excel_row1 = $excel_row - 1;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $excel_row1);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $lead_source);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> assistance);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row, $row -> days60_booking);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(4, $excel_row, $row -> customer_location);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(5, $excel_row, $row -> name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $row -> contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $row -> alternate_contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, $row -> address);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $row -> email);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $row -> lead_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(11, $excel_row, $row -> showroom_location);

			// CSE Information 
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(12, $excel_row, $cse_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(12, $excel_row, $row -> cse_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, $row -> csefeedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> csenextAction);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> cse_comment);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> cse_nfd);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> cse_nftime);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> td_hv_date);
			

			// DSE Information 

			$object -> getActiveSheet() -> setCellValueByColumnAndRow(20, $excel_row, $dse_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(20, $excel_row, $row -> dse_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(22, $excel_row, $row -> dsefeedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(23, $excel_row, $row -> dsenextAction);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(24, $excel_row, $row -> dse_comment);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(24, $excel_row, $row -> dse_nfd);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(26, $excel_row, $row -> dse_nftime);
			
		
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(27, $excel_row,  $auditor_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(27, $excel_row, $row -> auditor_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(29, $excel_row, $row -> followup_pending);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(30, $excel_row, $row -> call_received);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(31, $excel_row, $row -> fake_updation);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(32, $excel_row, $row -> service_feedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(33, $excel_row, $row -> auditor_remark);
			
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(34, $excel_row, $row -> buyer_type);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(35, $excel_row, $row -> new_model_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(36, $excel_row, $row -> variant_name);
		

			$object -> getActiveSheet() -> setCellValueByColumnAndRow(37, $excel_row, $row ->  	old_make  );
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(38, $excel_row, $row -> old_model);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(39, $excel_row, $row -> manf_year );
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(40, $excel_row, $row -> ownership );
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(41, $excel_row, $row -> budget_from );
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(42, $excel_row, $row -> budget_to );
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(43, $excel_row, $row -> accidental_claim );
		
			

			$excel_row++;

		}

		$filename = 'Tracker ' . $from_date . ' - ' . $to_date;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
	
}

public function download_service()
{
	$from_date = $this -> input -> get('fromdate');
		$to_date = $this -> input -> get('todate');
		//$select_lead_dse= $this -> new_tracker_model ->select_lead_dse_download();
		//$select_lead_dse_lc=$this -> new_tracker_model ->select_lead_dse_lc_download();
		//$query = array_merge($select_lead_dse,$select_lead_dse_lc);
		$query = $this -> new_tracker_model -> select_lead_download();
	//	print_r($query);
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);

		$table_columns = array('Sr No', 'Lead Source', 'Assistance Required', 'Booking Within Days', 'Customer Location','Customer Name', 'Contact', 'Alternate Mobile Number','Address', 'Email', 'Lead Date', 'Showroom Location', 'CSE Name', 'CSE Call Date', 'CSE Feedback', 'CSE Next Action','Eagerness', 'CSE NFD', 'CSE NFT', 'CSE Comment',
		 'Auditor Name',  'Auditor Followup Date', 'Followup Pending', 'Call Received from Showroom', 'Fake Updation', 'Service Feedback', 'Auditor Remark',
		 'Car Model','Reg No','KM','Service Type','Pick up Required','Pick up Date');
		$column = 0;

		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}
		
		$excel_row = 2;

		foreach ($query as $row) {
			if ($row -> assign_to_cse == 0) {
				$cse_name = $row -> csetl_fname . ' ' . $row -> csetl_lname;
			} else {
				$cse_name = $row -> cse_fname . ' ' . $row -> cse_lname;
			}
			
			
		

			if ($row -> lead_source == '') { $lead_source = "Web";
			} 
			else if($row->lead_source=='Facebook')
			{
				$lead_source=$row->enquiry_for;
			}
			else { $lead_source = $row -> lead_source;
			}
		/*	if ($row -> cse_fname == '' and $row -> nextAction == 'Not Yet') {
				$status = "Unassigned";
			} else if ($row -> cse_fname != '' and $row -> nextAction == 'Not Yet') {
				$status = "Untouched";
			} else {
				$status = $row -> nextAction;
			}*/
			
			//Lead date
			$lead_date=$row->lead_date;
			if(!empty($lead_date) && $lead_date!='0000-00-00'){
			$PHPDateValue1 = strtotime($lead_date);
			$ExcelDateValue1 = PHPExcel_Shared_Date::PHPToExcel($lead_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $ExcelDateValue1); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(10, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, '00/00/00'); 
			}
			//CSE call date
			$cse_call_date=$row->cse_date;
			if(!empty($cse_call_date) && $cse_call_date!='0000-00-00'){
			$PHPDateValue2= strtotime($cse_call_date);
			$ExcelDateValue2 = PHPExcel_Shared_Date::PHPToExcel($cse_call_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $ExcelDateValue2); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(13, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, '00/00/00'); 
			}
			//CSE cse nfd
			$cse_nfd_date=$row->cse_nfd;
			if(!empty($cse_nfd_date) && $cse_nfd_date!='0000-00-00'){
			$PHPDateValue3 = strtotime($cse_nfd_date);
			$ExcelDateValue3 = PHPExcel_Shared_Date::PHPToExcel($cse_nfd_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, $ExcelDateValue3); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(17, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
						$object -> getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row,  '00/00/00'); 
				}
				
					//Auditor date
			$auditor_date=$row->auditor_date;
				if(!empty($auditor_date) && $auditor_date!='0000-00-00'){
			$PHPDateValue4 = strtotime($auditor_date);
			$ExcelDateValue4 = PHPExcel_Shared_Date::PHPToExcel($auditor_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row, $ExcelDateValue4); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(21, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row,  '00/00/00'); 
			}
			//td hv date
			$pick_up_date=$row->pick_up_date;
			if(!empty($pick_up_date) && $pick_up_date!='0000-00-00' ){
			$PHPDateValue5 = strtotime($pick_up_date);
			$ExcelDateValue5 = PHPExcel_Shared_Date::PHPToExcel($pick_up_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(32, $excel_row, $ExcelDateValue5); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(32, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
					$object -> getActiveSheet()->setCellValueByColumnAndRow(32, $excel_row, '00/00/00'); 
					
			}
			
				$auditor_name=$row -> auditfname . ' ' . $row -> auditlname ;
			$excel_row1 = $excel_row - 1;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $excel_row1);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $lead_source);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> assistance);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row, $row -> days60_booking);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(4, $excel_row, $row -> customer_location);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(5, $excel_row, $row -> name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $row -> contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $row -> alternate_contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, $row -> address);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $row -> email);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(10, $excel_row, $row -> lead_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(11, $excel_row, $row -> showroom_location);

			// CSE Information 
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(12, $excel_row, $cse_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(13, $excel_row, $row -> cse_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, $row -> csefeedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> csenextAction);
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> eagerness);
			
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $row -> cse_nfd);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> cse_nftime);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(19, $excel_row, $row -> cse_comment);
	
		
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(20, $excel_row,  $auditor_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(21, $excel_row, $row -> auditor_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(22, $excel_row, $row -> followup_pending);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(23, $excel_row, $row -> call_received);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(24, $excel_row, $row -> fake_updation);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(25, $excel_row, $row -> service_feedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(26, $excel_row, $row -> auditor_remark);
			
		
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(27, $excel_row, $row ->  	model_name  );
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(28, $excel_row, $row -> reg_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(29, $excel_row, $row -> km );
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(30, $excel_row, $row -> service_type );
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(31, $excel_row, $row -> pickup_required );
		//	$object -> getActiveSheet() -> setCellValueByColumnAndRow(32, $excel_row, $row -> pick_up_date );
	
			

			$excel_row++;

		}

		$filename = 'Tracker ' . $from_date . ' - ' . $to_date;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
}
public function download_accessories()
{
	$from_date = $this -> input -> get('fromdate');
		$to_date = $this -> input -> get('todate');
		//$select_lead_dse= $this -> new_tracker_model ->select_lead_dse_download();
		//$select_lead_dse_lc=$this -> new_tracker_model ->select_lead_dse_lc_download();
		//$query = array_merge($select_lead_dse,$select_lead_dse_lc);
		$query = $this -> new_tracker_model -> select_lead_download();
	//	print_r($query);
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);

		$table_columns = array('Sr No', 'Lead Source', 'Assistance Required', 'Booking Within Days', 'Customer Location','Customer Name', 'Contact', 'Alternate Mobile Number','Address', 'Email', 'Lead Date',  'CSE Name', 'CSE Call Date', 'CSE Feedback', 'CSE Next Action','Eagerness', 'CSE NFD', 'CSE NFT', 'CSE Comment',
		 'Auditor Name',  'Auditor Followup Date', 'Followup Pending', 'Call Received from Showroom', 'Fake Updation', 'Service Feedback', 'Auditor Remark',
		 'Car Model','Reg No','	Accessories List','	Accessories Price');
		$column = 0;

		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}
		
		$excel_row = 2;

		foreach ($query as $row) {
			if ($row -> assign_to_cse == 0) {
				$cse_name = $row -> csetl_fname . ' ' . $row -> csetl_lname;
			} else {
				$cse_name = $row -> cse_fname . ' ' . $row -> cse_lname;
			}
			
			
		

			if ($row -> lead_source == '') { $lead_source = "Web";
			} 
			else if($row->lead_source=='Facebook')
			{
				$lead_source=$row->enquiry_for;
			}
			else { $lead_source = $row -> lead_source;
			}
		/*	if ($row -> cse_fname == '' and $row -> nextAction == 'Not Yet') {
				$status = "Unassigned";
			} else if ($row -> cse_fname != '' and $row -> nextAction == 'Not Yet') {
				$status = "Untouched";
			} else {
				$status = $row -> nextAction;
			}*/
			
			//Lead date
			$lead_date=$row->lead_date;
			if(!empty($lead_date) && $lead_date!='0000-00-00'){
			$PHPDateValue1 = strtotime($lead_date);
			$ExcelDateValue1 = PHPExcel_Shared_Date::PHPToExcel($lead_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $ExcelDateValue1); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(10, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, '00/00/00'); 
			}
			//CSE call date
			$cse_call_date=$row->cse_date;
			if(!empty($cse_call_date) && $cse_call_date!='0000-00-00'){
			$PHPDateValue2= strtotime($cse_call_date);
			$ExcelDateValue2 = PHPExcel_Shared_Date::PHPToExcel($cse_call_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $ExcelDateValue2); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(12, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, '00/00/00'); 
			}
			//CSE cse nfd
			$cse_nfd_date=$row->cse_nfd;
			if(!empty($cse_nfd_date) && $cse_nfd_date!='0000-00-00'){
			$PHPDateValue3 = strtotime($cse_nfd_date);
			$ExcelDateValue3 = PHPExcel_Shared_Date::PHPToExcel($cse_nfd_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, $ExcelDateValue3); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(16, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
						$object -> getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row,  '00/00/00'); 
				}
				
					//Auditor date
			$auditor_date=$row->auditor_date;
				if(!empty($auditor_date) && $auditor_date!='0000-00-00'){
			$PHPDateValue4 = strtotime($auditor_date);
			$ExcelDateValue4 = PHPExcel_Shared_Date::PHPToExcel($auditor_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row, $ExcelDateValue4); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(20, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row,  '00/00/00'); 
			}
			
			
				$auditor_name=$row -> auditfname . ' ' . $row -> auditlname ;
		$excel_row1 = $excel_row - 1;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $excel_row1);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $lead_source);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> assistance);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row, $row -> days60_booking);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(4, $excel_row, $row -> customer_location);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(5, $excel_row, $row -> name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $row -> contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $row -> alternate_contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, $row -> address);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $row -> email);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(10, $excel_row, $row -> lead_date);
			

			// CSE Information 
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(11, $excel_row, $cse_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(12, $excel_row, $row -> cse_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(13, $excel_row, $row -> csefeedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, $row -> csenextAction);
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> eagerness);
			
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> cse_nfd);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $row -> cse_nftime);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> cse_comment);
	
	
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(19, $excel_row,  $auditor_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(20, $excel_row, $row -> auditor_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(21, $excel_row, $row -> followup_pending);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(22, $excel_row, $row -> call_received);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(23, $excel_row, $row -> fake_updation);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(24, $excel_row, $row -> service_feedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(25, $excel_row, $row -> auditor_remark);
		

			$object -> getActiveSheet() -> setCellValueByColumnAndRow(26, $excel_row, $row ->  	model_name  );
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(27, $excel_row, $row -> reg_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(28, $excel_row, $row -> accessoires_list );
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(29, $excel_row, $row -> assessories_price );

	
			

			$excel_row++;

		}

		$filename = 'Tracker ' . $from_date . ' - ' . $to_date;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
}
public function download_evaluation()
{
	$from_date = $this -> input -> get('fromdate');
		$to_date = $this -> input -> get('todate');
		//$select_lead_dse= $this -> new_tracker_model ->select_lead_dse_download();
		//$select_lead_dse_lc=$this -> new_tracker_model ->select_lead_dse_lc_download();
		//$query = array_merge($select_lead_dse,$select_lead_dse_lc);
		$query = $this -> new_tracker_model -> select_lead_download();
	//	print_r($query);
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);
		$table_columns = array('Sr No', 'Lead Source','Customer Name','Mobile Number','Alternate Mobile Number','Address','Email ID','Lead Date','Lead Time','Assistance Required','Booking within Days','Customer Location','Lead Assigned Date(CSE)','Lead Assigned Time(CSE)','CSE Name','CSE Call Date','CSE Call Time','CSE Call Status','CSE Feedback','CSE Next Action','CSE Remark','CSE NFD','CSE NFT','Appointment Type','Appointment Date','Appointment Time','Appointment Address','Appointment Status','Appointment Rating','Appointment Feeback','Showroom Location','TD/HV Date','Evaluator Name','Lead Assigned Date','Lead Assigned Time','Evaluator Call Date','Evaluator Call Time','Evaluator Call Status','Evaluator Feedback','Evaluator Next Action','Evaluator Remark','Evaluator NFD','Evaluator NFT','Auditor Name','Auditor call Date','Auditor call Time','Auditor call Status','Followup Pending','Call Received from Showroom','Fake Updation','Service Feedback','Auditor Remark','Buyer Type','Model','Variant');
		
				//print_r($table_columns);
		$column = 0;

		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}
		
		$excel_row = 2;

		foreach ($query as $row) {

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
			else if($row->lead_source=='Facebook')
			{
				$lead_source=$row->enquiry_for;
			}
			else { $lead_source = $row -> lead_source;
			}
		
				$auditor_name=$row -> auditfname . ' ' . $row -> auditlname ;
				//Auditor date
			$auditor_date=$row->auditor_date;
				if(!empty($auditor_date) && $auditor_date!='0000-00-00'){
			$PHPDateValue6 = strtotime($auditor_date);
			$ExcelDateValue = PHPExcel_Shared_Date::PHPToExcel($auditor_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(28, $excel_row, $ExcelDateValue); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(28, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(28, $excel_row,  '00/00/00'); 
			}
			
			$excel_row1 = $excel_row - 1;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $excel_row1);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $lead_source);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row, $row -> contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(4, $excel_row, $row -> alternate_contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(5, $excel_row, $row -> address);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $row -> email);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $row -> lead_date);
			//Lead date
			$lead_date=$row->lead_date;
				if(!empty($lead_date) && $lead_date!='0000-00-00'){
			$PHPDateValue1 = strtotime($lead_date);
			
			$ExcelDateValue1 = PHPExcel_Shared_Date::PHPToExcel($lead_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $ExcelDateValue1); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(7, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, '00/00/00'); 
			}
			/////////////////////////////////////////////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, $row -> created_time);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $row -> assistance);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(10, $excel_row, $row -> days60_booking);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(11, $excel_row, $row -> customer_location);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(12, $excel_row, $row -> assign_to_cse_date);
			//assign_to_cse_date
			$cse_assign_to_cse_date=$row->assign_to_cse_date;
			if(!empty($cse_assign_to_cse_date) && $cse_assign_to_cse_date!='0000-00-00'){
			$PHPDateValue2= strtotime($cse_assign_to_cse_date);
			$ExcelDateValue2 = PHPExcel_Shared_Date::PHPToExcel($cse_assign_to_cse_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $ExcelDateValue2); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(12, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, '00/00/00'); 
			}
			//////////////////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(13, $excel_row, $row -> assign_to_cse_time);
			
			
			// CSE Information 
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, $cse_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> cse_date);
			//CSE call date
			$cse_call_date=$row->cse_date;
			if(!empty($cse_call_date) && $cse_call_date!='0000-00-00'){
			$PHPDateValue2= strtotime($cse_call_date);
			$ExcelDateValue2 = PHPExcel_Shared_Date::PHPToExcel($cse_call_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $ExcelDateValue2); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(15, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, '00/00/00'); 
			}
			/////////////////////////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> cse_time);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $row -> csecontactibility);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> csefeedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(19, $excel_row, $row -> csenextAction);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(20, $excel_row, $row -> cse_comment);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(21, $excel_row, $row -> cse_nfd);
				//CSE cse nfd
			$cse_nfd_date=$row->cse_nfd;
			if(!empty($cse_nfd_date) && $cse_nfd_date!='0000-00-00'){
			$PHPDateValue3 = strtotime($cse_nfd_date);
			$ExcelDateValue3 = PHPExcel_Shared_Date::PHPToExcel($cse_nfd_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row, $ExcelDateValue3); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(21, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
						$object -> getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row,  '00/00/00'); 
				}
				////////////////////////////////
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(22, $excel_row, $row -> cse_nftime);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(23, $excel_row, $row -> appointment_type);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(24, $excel_row, $row -> appointment_date);
				//appointment_date
			$td_hv_date=$row->td_hv_date;
			if(!empty($td_hv_date) && $td_hv_date!='0000-00-00' ){
			$PHPDateValue4 = strtotime($td_hv_date);
			$ExcelDateValue4 = PHPExcel_Shared_Date::PHPToExcel($td_hv_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(24, $excel_row, $ExcelDateValue4); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(24, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
					$object -> getActiveSheet()->setCellValueByColumnAndRow(24, $excel_row, '00/00/00'); 
					
			}
			//////////////////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(25, $excel_row, $row -> appointment_time);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(26, $excel_row, $row -> appointment_address);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(27, $excel_row, $row -> appointment_status);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(28, $excel_row, $row -> appointment_rating);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(29, $excel_row, $row -> appointment_feedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(30, $excel_row, $row -> showroom_location);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(31, $excel_row, $row -> td_hv_date);
			//td hv date
			$td_hv_date=$row->td_hv_date;
			if(!empty($td_hv_date) && $td_hv_date!='0000-00-00' ){
			$PHPDateValue4 = strtotime($td_hv_date);
			$ExcelDateValue4 = PHPExcel_Shared_Date::PHPToExcel($td_hv_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(31, $excel_row, $ExcelDateValue4); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(31, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
					$object -> getActiveSheet()->setCellValueByColumnAndRow(31, $excel_row, '00/00/00'); 
					
			}

			// DSE Information 
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(32, $excel_row, $dse_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(33, $excel_row, $row -> assign_to_dse_date);
			//DSE date
			$assign_to_dse_date=$row->assign_to_dse_date;
			if(!empty($assign_to_dse_date) && $assign_to_dse_date!='0000-00-00'){
			$PHPDateValue5 = strtotime($assign_to_dse_date);
			$ExcelDateValue5 = PHPExcel_Shared_Date::PHPToExcel($assign_to_dse_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(33, $excel_row, $ExcelDateValue5); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(33, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(33, $excel_row,  '00/00/00'); 
			}
			////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(34, $excel_row, $row -> assign_to_dse_time);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(35, $excel_row, $row -> dse_date);
			//DSE date
			$dse_date=$row->dse_date;
			if(!empty($dse_date) && $dse_date!='0000-00-00'){
			$PHPDateValue5 = strtotime($dse_date);
			$ExcelDateValue5 = PHPExcel_Shared_Date::PHPToExcel($dse_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(35, $excel_row, $ExcelDateValue5); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(35, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(35, $excel_row,  '00/00/00'); 
			}
			////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(36, $excel_row, $row -> dse_time);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(37, $excel_row, $row -> dsecontactibility);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(38, $excel_row, $row -> dsefeedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(39, $excel_row, $row -> dsenextAction);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(40, $excel_row, $row -> dse_comment);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(41, $excel_row, $row -> dse_nfd);
			
			//DSE nfd
			$dse_nfd_date=$row->dse_nfd;
				if(!empty($dse_nfd_date) && $dse_nfd_date!='0000-00-00'){
			$PHPDateValue6 = strtotime($dse_nfd_date);
			$ExcelDateValue = PHPExcel_Shared_Date::PHPToExcel($dse_nfd_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(41, $excel_row, $ExcelDateValue); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(41, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(41, $excel_row,  '00/00/00'); 
			}
			/////////////////////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(42, $excel_row, $row -> dse_nftime);
			
		
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(43, $excel_row,  $auditor_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(44, $excel_row, $row -> auditor_date);
			//auditor Date
			$auditor_date=$row->auditor_date;
				if(!empty($auditor_date) && $auditor_date!='0000-00-00'){
			$PHPDateValue6 = strtotime($auditor_date);
			$ExcelDateValue = PHPExcel_Shared_Date::PHPToExcel($auditor_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(44, $excel_row, $ExcelDateValue); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(44, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(44, $excel_row,  '00/00/00'); 
			}
			/////////////////////////////////////////
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(45, $excel_row, $row -> auditor_time);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(46, $excel_row, $row -> auditor_call_status);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(47, $excel_row, $row -> followup_pending);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(48, $excel_row, $row -> call_received);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(49, $excel_row, $row -> fake_updation);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(50, $excel_row, $row -> service_feedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(51, $excel_row, $row -> auditor_remark);
		
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(52, $excel_row, $row -> buyer_type);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(53, $excel_row, $row -> new_model_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(54, $excel_row, $row -> variant_name);
			
			$excel_row++;

		}

		$filename = 'Tracker ' . $from_date . ' - ' . $to_date;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
	
}	
public function backup_data(){


// Backup your entire database and assign it to a variabl

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300); //120 seconds
$this->load->dbutil();
$backup=$this->create_csv();
	//$backup= $this->dbutil->csv_from_result($query,$delimiter,$newline);

// Load the download helper and send the file to your desktop
$this->load->helper('download');
force_download('mybackup.csv', $backup);
/*
$prefs = array(
        'tables'        => array('make_models'),   // Array of tables to backup.
        'ignore'        => array(),                     // List of tables to omit from the backup
        'format'        => 'zip',                       // gzip, zip, txt
        'filename'      => 'mybackup.xls',              // File name - NEEDED ONLY WITH ZIP FILES
        'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
        'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
        'newline'       => "\n"                         // Newline character used in backup file
);


$backup=$this->dbutil->backup($prefs);
// Load the download helper and send the file to your desktop
$this->load->helper('download');
force_download('mybackup.zip', $backup);*/
}
public function create_csv()
		{
$this->load->dbutil();
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300); //120 seconds
 $this->db->select('*');
			$this->db->from('download_tracker_view');
			$this->db->where('lead_date>','2018-06-01');
			
			
			
			$query=$this->db->get();
			
			
  $delimiter=",";
	$newline="\r\n";
	return $this->dbutil->csv_from_result($query,$delimiter,$newline);
$this->load->library('excel');
echo $this->dbutil->csv_from_result($query);
}
}
?>