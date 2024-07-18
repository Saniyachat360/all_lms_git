<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class unassign_leads extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model(array('unassigned_lead_model','new_lead_model', 'pending_model','today_followup_model','home_visit_model','showroom_visit_model','test_drive_model','evaluation_model'));
		$this->view= $this->session->userdata('view');
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function leads() {
		$this -> session();
		$data['enq'] = 'Unassigned';
		//get pending attened leads details
		$id_array=$this->input->get('id_array');
		if(isset($id_array)){
		$data['select_lead'] = $this -> unassigned_lead_model -> select_lead_location_wise();
		$data['unassign_count_lead'] = $this -> unassigned_lead_model -> select_lead_count_location_wise();
		}else{
			$data['select_lead'] = $this -> unassigned_lead_model -> select_lead_location();
		$data['unassign_count_lead'] = $this -> unassigned_lead_model -> select_lead_count_location();
		}
		$id=$data['id']=$this->input->get('id');
		$data['role']=$this->input->get('role');
		
		$this -> load -> view('include/admin_header.php');
		if ($this ->view[15]=='1' && $id=='') {
		$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('telecaller_lms_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function escalation_level1() {
		$this -> session();
		$data['enq'] = 'Escalation Level 1';	
		$feedback='esc_level1';	
		$feedback1='esc_level1_resolved';
		
		$data['select_lead'] = $this -> unassigned_lead_model -> select_escalation_level($feedback,$feedback1);
		$data['all_count_lead'] = $this -> unassigned_lead_model -> select_lead_count_escalation_level($feedback,$feedback1);		
		$id=$data['id']=$this->input->get('id');
		$data['role']=$this->input->get('role');		
		$this -> load -> view('include/admin_header.php');
		if ($this ->view[15]=='1' && $id=='') {
		$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('telecaller_lms_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function escalation_level2() {
		$this -> session();
		$data['enq'] = 'Escalation Level 2';	
		$feedback='esc_level2';		
		$feedback1='esc_level2_resolved';
		
		$data['select_lead'] = $this -> unassigned_lead_model -> select_escalation_level($feedback,$feedback1);
		$data['all_count_lead'] = $this -> unassigned_lead_model -> select_lead_count_escalation_level($feedback,$feedback1);		
		$id=$data['id']=$this->input->get('id');
		$data['role']=$this->input->get('role');		
		$this -> load -> view('include/admin_header.php');
		if ($this ->view[15]=='1' && $id='') {
		$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('telecaller_lms_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function escalation_level3() {
		$this -> session();
		$data['enq'] = 'Escalation Level 3';	
		$feedback='esc_level3';		
		$feedback1='esc_level3_resolved';
		
		$data['select_lead'] = $this -> unassigned_lead_model -> select_escalation_level($feedback,$feedback1);
		$data['all_count_lead'] = $this -> unassigned_lead_model -> select_lead_count_escalation_level($feedback,$feedback1);		
		$id=$data['id']=$this->input->get('id');
		$data['role']=$this->input->get('role');		
		$this -> load -> view('include/admin_header.php');
		if ($this ->view[15]=='1' && $id=='') {
		$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('telecaller_lms_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function downloadLeads()
	{
		$enq = $this -> input -> get('enq');
		if($enq =='New')
		{
			$filename="New Leads";
			$query = $this -> new_lead_model -> downloadLeads();	
		}
		else if($enq == 'Pending New')
		{
			$filename="Pending New Leads";
			$query = $this -> pending_model -> downloadLeadsPendingNew();			
		}
		else if($enq == 'Pending Followup')
		{
			$filename="Pending Followup Leads";
			$query = $this -> pending_model -> downloadLeadsPendingFollowup();
		
		}
		else if($enq == 'Today Followup')
		{
			$filename="Today Followup Leads";
			$query = $this -> today_followup_model -> downloadLeads();			
		}
		else if($enq == 'Unassigned')
		{
		$filename="Unassigned Leads";
		$query = $this -> unassigned_lead_model -> downloadLeads();			
		}
		else if($enq == 'Home Visit Today')
		{
		$filename="Home Visit Today Leads";
		$query = $this -> home_visit_model -> downloadLeads();			
		}
		else if($enq == 'Showroom Visit Today')
		{
		$filename="Showroom Visit Today Leads";
		$query = $this -> showroom_visit_model -> downloadLeads();			
		}
		else if($enq == 'Test Drive Today')
		{
		$filename="Test Drive Today Leads";
		$query = $this -> test_drive_model -> downloadLeads();			
		}
		else if($enq == 'Evaluation Today')
		{
		$filename="Evaluation Today Leads";
		$query = $this -> evaluation_model -> downloadLeads();			
		}
		else if($enq == 'Escalation Level 1')
		{
			$feedback='esc_level1';	
		$filename="Escalation Level 1 Leads";
		$query = $this -> unassigned_lead_model -> downloadLeads_e($feedback);			
		}
		else if($enq == 'Escalation Level 2')
		{
			$feedback='esc_level1';	
		$filename="Escalation Level 2 Leads";
		$query = $this -> unassigned_lead_model -> downloadLeads_e($feedback);			
		}
		else if($enq == 'Escalation Level 3')
		{
			$feedback='esc_level3';	
		$filename="Escalation Level 3 Leads";
		$query = $this -> unassigned_lead_model -> downloadLeads_e($feedback);			
		}
		else
		{
			$filename="Leads Not Found";
			$query = Array ( );		
		}
			
		$this -> load -> library("excel");
		$object = new PHPExcel();		
		$object -> setActiveSheetIndex(0);
		$table_columns = array('Sr No', 'Interested In', 'Name', 'Contact','Lead Date','Feedback Status', 'Next Action', 'Current User','Call Date', 'NFD', 'Remark');
		$column = 0;
		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}		
		$excel_row = 2;
		foreach ($query as $row) 
		{
			if ($row -> lead_source == '') { $lead_source = "Web";
			} 
			else if($row->lead_source=='Facebook')
			{
				$lead_source=$row->enquiry_for;
			}
			else { $lead_source = $row -> lead_source;
			}
			if($row->assign_to_dse!=0)
			{
				$currentUser=$row -> dse_fname.' '.$row -> dse_lname;
			}
			elseif($row->assign_to_dse_tl!=0 && $row->assign_to_dse==0)
			{ 
				$currentUser= $row -> dsetl_fname.' '.$row -> dsetl_lname; 
			}
			 elseif($row->assign_to_dse_tl==0 && $row->assign_to_dse==0)
			{
				$currentUser=  $row -> cse_fname.' '.$row -> cse_lname; 
			}
			else
			{
				$currentUser=	  $row -> csetl_fname.' '.$row -> csetl_lname; 
			}

			if($row->dse_followup_id == 0)
			{
				$callDate=$row -> cse_date; 
				$nfd=$row -> cse_nfd; 
				$comment = $row -> cse_comment;
			}
			else
			{
				$callDate=$row -> dse_date;
				$nfd= $row -> dse_nfd; 
				$comment = $row -> dse_comment;
			}
		
		
			$object->getActiveSheet()->getStyle('A1:AB1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('	#FFEFD5');
			//Lead date
			$lead_date=$row->created_date;
			$PHPDateValue1 = strtotime($lead_date);
			$ExcelDateValue1 = PHPExcel_Shared_Date::PHPToExcel($PHPDateValue1);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $ExcelDateValue1); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(4, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			//CSE call date
			$cse_call_date=$callDate;
			if(!empty($cse_call_date) && $cse_call_date!='0000-00-00'){
			$PHPDateValue2= strtotime($cse_call_date);
			$ExcelDateValue2 = PHPExcel_Shared_Date::PHPToExcel($PHPDateValue2);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $ExcelDateValue2); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(8, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
				$object -> getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, '00/00/00'); 
			}
			//CSE cse nfd
			$cse_nfd_date=$nfd;
			if(!empty($cse_nfd_date) && $cse_nfd_date!='0000-00-00'){
			$PHPDateValue3 = strtotime($cse_nfd_date);
			$ExcelDateValue3 = PHPExcel_Shared_Date::PHPToExcel($PHPDateValue3);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $ExcelDateValue3); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(9, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
				}else{
						$object -> getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row,  '00/00/00'); 
				}
			
			
			$excel_row1 = $excel_row - 1;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $excel_row1);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $lead_source);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row, $row -> contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(5, $excel_row, $row -> feedbackStatus);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $row -> nextAction);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $currentUser);
			
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(10, $excel_row, $comment);		
			$excel_row++;
		}
		//$filename = 'Unassigned Leads ';
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");	
		$object_writer -> save('php://output');
	}
/*************************************************** Complaint Functions **************************************/
	public function complaint() {
		$this -> session();
		$data['enq'] = 'Unassigned';
		//get pending attened leads details

		
		$data['select_lead'] = $this -> unassigned_lead_model -> select_lead_complaint();
		$data['unassign_count_lead'] = $this -> unassigned_lead_model -> select_lead_count_complaint();
		
		$id=$data['id']=$this->input->get('id');
		$data['role']=$this->input->get('role');
		
		$this -> load -> view('include/admin_header.php');
	if ($this ->view[15]=='1' && $id=='') {
		$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('complaint_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
public function search_complaint() {

		$this -> session();
	$data['enq'] = 'Unassigned';
		//get pending attened leads details

		
		$data['select_lead'] = $this -> unassigned_lead_model -> select_lead_complaint();
		$data['unassign_count_lead'] = $this -> unassigned_lead_model -> select_lead_count_complaint();
		
	$this -> load -> view('complaint_filter_view.php', $data);

	}
/***********************************************************************************************************/
	

}
?>