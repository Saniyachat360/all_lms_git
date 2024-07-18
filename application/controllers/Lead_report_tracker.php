<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class lead_report_tracker extends CI_Controller {
	public $process_name;
	public $role;
	public $user_id;
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('lead_report_tracker_model');
		$this->process_name=$this->session->userdata('process_name');
		$this->role=$this->session->userdata('role');
		$this->user_id=$this->session->userdata('user_id');

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	function leads() {
		$this -> session();
		$source = $this -> input -> get('source');
		$fromdate=$this->input->get('fromdate');
		$todate=$this->input->get('todate');
		
		if($_SESSION['process_id']==1){
			$this->download_finance();
			//$source,$fromdate,$todate
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
			$this->download_used_car();
		}
	}
	public function download_new_car()
{
		$source = $this -> input -> get('source');
		$fromdate = $this -> input -> get('fromdate');
		$todate = $this -> input -> get('todate');
	
		$query = $this -> lead_report_tracker_model -> $source($fromdate,$todate);
		/*echo "<br>";
		echo count($query);
		echo "<br>";
		echo print_r($query);*/
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);

		$table_columns = array('Sr No', 'Lead Source', 'Assistance Required', 'Booking Within Days', 'Customer Location','Customer Name', 'Contact', 'Alternate Mobile Number','Address', 'Email', 'Lead Date', 'Showroom Location', 'CSE Name', 'CSE Call Date', 'CSE Feedback', 'CSE Next Action', 'CSE Comment', 'CSE NFD', 'CSE NFT', 'TD/HV Date', 'DSE Name', 'DSE Call Date', 'DSE Feedback', 'DSE Next Action', 'DSE Comment', 'DSE NFD','DSE NFT',
		 'Auditor Name',  'Auditor Followup Date', 'Followup Pending', 'Call Received from Showroom', 'Fake Updation', 'Service Feedback', 'Auditor Remark','Buyer Type', 'New Model Name', 'Variant Name');
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
			
			

			$excel_row++;

		}

		$filename = 'Tracker ' . $fromdate . ' - ' . $todate;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
	
}
public function download_used_car()
{
	$source = $this -> input -> get('source');
		$fromdate = $this -> input -> get('fromdate');
		$todate = $this -> input -> get('todate');
	
		$query = $this -> lead_report_tracker_model -> $source($fromdate,$todate);
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

		$filename = 'Tracker ' . $fromdate . ' - ' . $todate;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
	
}

public function download_service()
{
	$source = $this -> input -> get('source');
		$fromdate = $this -> input -> get('fromdate');
		$todate = $this -> input -> get('todate');
	
		$query = $this -> lead_report_tracker_model -> $source($fromdate,$todate);
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

		$filename = 'Tracker ' . $fromdate . ' - ' . $todate;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
}
public function download_accessories()
{
	$source = $this -> input -> get('source');
		$fromdate = $this -> input -> get('fromdate');
		$todate = $this -> input -> get('todate');
	
		$query = $this -> lead_report_tracker_model -> $source($fromdate,$todate);
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

		$filename = 'Tracker ' . $fromdate . ' - ' . $todate;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
}
	
	public function download_finance()
{
	$source = $this -> input -> get('source');
		$fromdate = $this -> input -> get('fromdate');
		$todate = $this -> input -> get('todate');
	
		$query = $this -> lead_report_tracker_model -> $source($fromdate,$todate);
			//$total_leads = $this -> lead_report_tracker_model -> $source($fromdate,$todate,$this->role,$this->process_name,$this->user_id);
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


		$filename = 'Tracker ' . $fromdate . ' - ' . $todate;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
	
	
}
	function old_leads()
	{
		
		$location_id = $this -> input -> get('location_id');
		
		
		$total_leads = $this -> lead_report_tracker_model -> $source($fromdate,$todate,$this->role,$this->process_name,$this->user_id);

		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);
		//$object->getActiveSheet()->setAutoFilter('A1:AB1');
		if($this->process_name=='Finance')
		{
			$table_columns = array('Sr No', 'Lead Source', 'Customer Name', 'Contact', 'Address', 'Email', 'Lead Date',  'Current User', 'Call Date', 'Feedback', 'Next Action', 'Comment', 'NFD', 'Model Name','Reg No', 'Bank Name', 'Loan Type', 'ROI','LOS No','Tenure', 'Amount', 'Dealer/DSA', 'Collection Executive Name', 'Pickup Date', 'Login Date', 'Loan Status','Approved Date','Disburse Date', 'Disburse Amount', 'Processing Fee', 'EMI');
		
		}
		else if($this->process_name=='Accessories')
		{
			$table_columns = array('Sr No', 'Lead Source', 'Customer Name', 'Contact', 'Address', 'Email', 'Lead Date',  'Current User', 'Call Date', 'Feedback', 'Next Action', 'Comment', 'NFD',' Model Name','Reg No', 'Accessories List', 'Accessories Price');
		
		}
else
	{
		$table_columns = array('Sr No', 'Lead Source', 'Customer Name', 'Contact', 'Address', 'Email', 'Lead Date', 'Current User', 'Call Date', 'Feedback', 'Next Action', 'Comment', 'NFD', 'Model Name', 'Reg No', 'KM', 'Service Type', 'Pick up Required','Pick up Date');
		
	}
		$column = 0;

		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$excel_row = 2;

		foreach ($total_leads as $row) {

			/*if ($row -> assign_to_cse == 0) {
				$cse_name = $row -> csetl_fname . ' ' . $row -> csetl_lname;
			} else {*/
				$cse_name = $row -> cse_fname . ' ' . $row -> cse_lname;
			/*}
			if ($row -> assign_to_dse == 0) {
				$dse_name = $row -> dsetl_fname . ' ' . $row -> dsetl_lname;
			} else {
				$dse_name = $row -> dse_fname . ' ' . $row -> dse_lname;
			}*/

			if ($row -> lead_source == '') { $lead_source = "Web";
			} else if ($row -> lead_source == 'Facebook') {
				$lead_source = $row -> enquiry_for;
			} else { $lead_source = $row -> lead_source;
			}
			/*	if ($row -> cse_fname == '' and $row -> nextAction == 'Not Yet') {
			 $status = "Unassigned";
			 } else if ($row -> cse_fname != '' and $row -> nextAction == 'Not Yet') {
			 $status = "Untouched";
			 } else {
			 $status = $row -> nextAction;
			 }*/

			$object -> getActiveSheet() -> getStyle('A1:AB1') -> getFill() -> setFillType(PHPExcel_Style_Fill::FILL_SOLID) -> getStartColor() -> setARGB('	#FFEFD5');
			//Lead date
			$lead_date = $row -> lead_date;
			$PHPDateValue1 = strtotime($lead_date);
			$ExcelDateValue1 = PHPExcel_Shared_Date::PHPToExcel($PHPDateValue1);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $ExcelDateValue1);
			$object -> getActiveSheet() -> getStyleByColumnAndRow(6, $excel_row) -> getNumberFormat() -> setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);

			//CSE call date
			$cse_call_date = $row -> call_date;
			if (!empty($cse_call_date) && $cse_call_date != '0000-00-00') {
				$PHPDateValue2 = strtotime($cse_call_date);
				$ExcelDateValue2 = PHPExcel_Shared_Date::PHPToExcel($PHPDateValue2);
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, $ExcelDateValue2);
				$object -> getActiveSheet() -> getStyleByColumnAndRow(8, $excel_row) -> getNumberFormat() -> setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);

			} else {
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, '00/00/00');
			}
			//CSE cse nfd
			$cse_nfd_date = $row -> nextfollowupdate;
			if (!empty($cse_nfd_date) && $cse_nfd_date != '0000-00-00') {
				$PHPDateValue3 = strtotime($cse_nfd_date);
				$ExcelDateValue3 = PHPExcel_Shared_Date::PHPToExcel($PHPDateValue3);
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(12, $excel_row, $ExcelDateValue3);
				$object -> getActiveSheet() -> getStyleByColumnAndRow(12, $excel_row) -> getNumberFormat() -> setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			} else {
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(12, $excel_row, '00/00/00');
			}
			//td hv date
			/*$td_hv_date = $row -> td_hv_date;
			if (!empty($td_hv_date) && $td_hv_date != '0000-00-00') {
				$PHPDateValue4 = strtotime($td_hv_date);
				$ExcelDateValue4 = PHPExcel_Shared_Date::PHPToExcel($PHPDateValue4);
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, $ExcelDateValue4);
				$object -> getActiveSheet() -> getStyleByColumnAndRow(14, $excel_row) -> getNumberFormat() -> setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);

			} else {
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, '00/00/00');

			}*/
			//DSE date
		/*	$dse_date = $row -> dse_date;
			if (!empty($dse_date) && $dse_date != '0000-00-00') {
				$PHPDateValue5 = strtotime($dse_date);
				$ExcelDateValue5 = PHPExcel_Shared_Date::PHPToExcel($PHPDateValue5);
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $ExcelDateValue5);
				$object -> getActiveSheet() -> getStyleByColumnAndRow(17, $excel_row) -> getNumberFormat() -> setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			} else {
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, '00/00/00');
			}
			//DSE nfd
			$dse_nfd_date = $row -> dse_nfd;
			if (!empty($dse_nfd_date) && $dse_nfd_date != '0000-00-00') {
				$PHPDateValue6 = strtotime($dse_nfd_date);
				$ExcelDateValue = PHPExcel_Shared_Date::PHPToExcel($PHPDateValue6);
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(21, $excel_row, $ExcelDateValue);
				$object -> getActiveSheet() -> getStyleByColumnAndRow(21, $excel_row) -> getNumberFormat() -> setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			} else {
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(21, $excel_row, '00/00/00');
			}*/

			$excel_row1 = $excel_row - 1;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $excel_row1);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $lead_source);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row, $row -> contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(4, $excel_row, $row -> address);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(5, $excel_row, $row -> email);
			//	$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $lead_date);

			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $row -> showroom_location);

			// CSE Information
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $cse_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $row -> cse_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $row -> feedbackStatus);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(10, $excel_row, $row -> nextAction);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(11, $excel_row, $row -> comment);
			

			// DSE Information

			

			
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(13, $excel_row, $row -> model_name);
			
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, $row -> reg_no);
			if($this->process_name=='Finance')
		{
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> bank_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> loan_type);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $row -> roi);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> los_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> tenure);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> loanamount);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $row -> dealer);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> executive_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> pick_up_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> file_login_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $row -> login_status_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> approved_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> disburse_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> disburse_amount);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $row -> process_fee);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> emi);
		}
		else if($this->process_name=='Accessories')
		{
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> accessoires_list);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> assessories_price);
			
		}
			else
				{
				$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> km);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $row -> service_type);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $row -> pickup_required);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> pick_up_date);	
				}
			

			$excel_row++;

		}
		$soruce1=ucwords(str_replace('_', ' ', $source));
		$filename = $soruce1.' Tracker';
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");

		$object_writer -> save('php://output');

	}

}
?>
