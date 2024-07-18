<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class new_tracker_close extends CI_Controller {
private  $process_id;
private $process_name;
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('new_tracker_close_model');
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
		$data['select_campaign'] = $this -> new_tracker_close_model -> select_campaign();
		$data['select_feedback'] = $this -> new_tracker_close_model -> select_feedback();
		$data['select_next_action'] = $this -> new_tracker_close_model -> select_next_action();
		$data['select_lead_source'] = $this -> new_tracker_close_model -> select_lead_source();
		$data['campaign_name'] = $this -> input -> get('campaign_name');
		
		// Get All Selected Values
		$data['nextaction'] = $this -> input -> get('nextaction');
		$data['feedback'] = $this -> input -> get('feedback');
		$data['fromdate'] = $this -> input -> get('fromdate');
		$data['todate'] = $this -> input -> get('todate');
		$data['date_type'] = $this -> input -> get('date_type');
		$data['process_id']=$this->process_id;
		
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('tracker_with_dse_tob_tab_view_new_close.php', $data);
		$this -> load -> view('tracker_with_dse_view_new_close.php', $data);
		$this -> load -> view('include/footer.php');
	}
public function select_next_action()
{
	$select_next_action=$this->new_tracker_close_model->select_next_action();
	?>
	 <select class="filter_s col-md-12 col-xs-12 form-control" id="nextaction" name="nextaction" >
											<option value="">Next Action</option>
										
											
											<?php foreach($select_next_action as $row)
									{?>
										<option value="<?php echo $row -> nextActionName; ?>"><?php echo $row -> nextActionName; ?></option>
								<?php } ?>
                                               
                                                </select>
	<?php
}

	public function tracker_dse_filter() {
		$this -> session();
		
		//Select Box Values
		$data['select_campaign'] = $this -> new_tracker_close_model -> select_campaign();
		$data['select_feedback'] = $this -> new_tracker_close_model -> select_feedback();
		$data['select_next_action'] = $this -> new_tracker_close_model -> select_next_action();
		$data['select_lead_source'] = $this -> new_tracker_close_model -> select_lead_source();
		
		// Get All Selected Values
		$data['campaign_name'] = $this -> input -> get('campaign_name');
		$data['nextaction'] = $this -> input -> get('nextaction');
		$data['feedback'] = $this -> input -> get('feedback');
		$data['fromdate'] = $this -> input -> get('fromdate');
		$data['todate'] = $this -> input -> get('todate');
		$data['date_type'] = $this -> input -> get('date_type');
		
		// selected values
		$data['select_lead'] = $this -> new_tracker_close_model -> select_leads();
		$data['count_lead'] = $this -> new_tracker_close_model -> select_leads_count();
		$data['process_id']=$this->process_id;
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('tracker_with_dse_tob_tab_view_new_close.php', $data);
		$this -> load -> view('tracker_with_dse_filter_new_close.php', $data);
		$this -> load -> view('include/footer.php');
	}
// complaint filter when click on search
	public function tracker_dse_filter_complaint() {
		$this -> session();
		
		//Select Box Values
		$data['select_campaign'] = $this -> new_tracker_close_model -> select_campaign();
		$data['select_feedback'] = $this -> new_tracker_close_model -> select_feedback();
		$data['select_next_action'] = $this -> new_tracker_close_model -> select_next_action();
		$data['select_lead_source'] = $this -> new_tracker_close_model -> select_lead_source();
		
		// Get All Selected Values
		$data['campaign_name'] = $this -> input -> get('campaign_name');
		$data['nextaction'] = $this -> input -> get('nextaction');
		$data['feedback'] = $this -> input -> get('feedback');
		$data['fromdate'] = $this -> input -> get('fromdate');
		$data['todate'] = $this -> input -> get('todate');
		$data['date_type'] = $this -> input -> get('date_type');
		
		// selected values
		$data['select_lead'] = $this -> new_tracker_close_model -> select_leads_complaint();
		$data['count_lead'] = $this -> new_tracker_close_model -> select_leads_count_complaint();
		$data['process_id']=$this->process_id;
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('tracker_with_dse_tob_tab_view_new.php', $data);
		$this -> load -> view('tracker_with_dse_filter_complaint.php', $data);
		$this -> load -> view('include/footer.php');
	}
public function tracker_sub_poc_purchase_filter() {
		$this -> session();
		
		//Select Box Values
		$data['select_campaign'] = $this -> new_tracker_close_model -> select_campaign();
		$data['select_feedback'] = $this -> new_tracker_close_model -> select_feedback();
		$data['select_next_action'] = $this -> new_tracker_close_model -> select_next_action();
		$data['select_lead_source'] = $this -> new_tracker_close_model -> select_lead_source();
		
		// Get All Selected Values
		$data['campaign_name'] = $this -> input -> get('campaign_name');
		$data['nextaction'] = $this -> input -> get('nextaction');
		$data['feedback'] = $this -> input -> get('feedback');
		$data['fromdate'] = $this -> input -> get('fromdate');
		$data['todate'] = $this -> input -> get('todate');
		$data['date_type'] = $this -> input -> get('date_type');
		
		
		// selected values
		$data['select_lead'] = $this -> new_tracker_close_model -> select_lead_evaluation();
		//print_r($data['select_lead']);
		$data['count_lead'] = $this -> new_tracker_close_model -> select_lead_evaluation_count();
		$data['process_id']=$this->process_id;
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('tracker_with_dse_tob_tab_view_new.php', $data);
		$this -> load -> view('tracker_with_sub_poc_purchase_filter_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function download_data() {

		
		if($_SESSION['process_id']==1){
			$this->download_finance();
		}
		else if($_SESSION['process_id']==4){
			$this->download_new_service();
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
			if($_SESSION['sub_poc_purchase']==2)
			{
				$this->download_poc_purchase_tracking();
			}
			else
			{
				$this->download_new_car();
			}
		}
		else if($_SESSION['process_id']==9){
			$this->download_complaint();
		}
	
	}
public function download_finance()
{
		$from_date = $this -> input -> get('fromdate');
		$to_date = $this -> input -> get('todate');
	
		$query = $this -> new_tracker_close_model -> select_lead_download_all();
		//print_r($query);
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);

		$table_columns = array('Sr No', 'Lead Source', 'Sub Lead Source', 'Booking Within Days', 'Customer Location','Customer Name', 'Contact Number', 'Alternate Mobile Number','Address', 'Email', 'Lead Date',  'CSE Name', 'CSE Call Date', 'CSE Feedback', 'CSE Next Action', 'Eagerness', 'CSE NFD', 'CSE NFT','CSE Comment',
		
		'Car Model','Reg No','Bank Name','Loan Type','ROI','LOS No','Tenure','Amount','Dealer/DSA','Collection Executive Name','Pickup Date','Login Date','Loan Status','Approved Date','Disburse Date','Disburse Amount','Processing Fee','EMI',
		'Auditor Name', 'Auditor Followup Date', 'Followup Pending', 'Call Received from Showroom', 'Fake Updation', 'Service Feedback', 'Auditor Remark'
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
			$object -> getActiveSheet()->setCellValueByColumnAndRow(38, $excel_row, $ExcelDateValue); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(38, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
			$object -> getActiveSheet()->setCellValueByColumnAndRow(38, $excel_row,  '00/00/00'); 
			}	
			//pickup date
			$pickup_date=$row->pick_up_date;
			if(!empty($pickup_date) && $pickup_date!='0000-00-00' ){
			$PHPDateValue4 = strtotime($pickup_date);
			$ExcelDateValue4 = PHPExcel_Shared_Date::PHPToExcel($pickup_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(29, $excel_row, $ExcelDateValue4); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(29, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			
			}else{
			$object -> getActiveSheet()->setCellValueByColumnAndRow(29, $excel_row, '00/00/00'); 
					
			}
			//Login date
			$login_date=$row->file_login_date;
			if(!empty($login_date) && $login_date!='0000-00-00'){
			$PHPDateValue5 = strtotime($login_date);
			$ExcelDateValue5 = PHPExcel_Shared_Date::PHPToExcel($login_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(30, $excel_row, $ExcelDateValue5); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(30, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
			$object -> getActiveSheet()->setCellValueByColumnAndRow(30, $excel_row,  '00/00/00'); 
			}
			//Approved Date
			$approved_date=$row->approved_date;
			if(!empty($approved_date) && $approved_date!='0000-00-00'){
			$PHPDateValue6 = strtotime($approved_date);
			$ExcelDateValue6 = PHPExcel_Shared_Date::PHPToExcel($approved_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(32, $excel_row, $ExcelDateValue6); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(32, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
			$object -> getActiveSheet()->setCellValueByColumnAndRow(32, $excel_row,  '00/00/00'); 
			}
			//Disburse Date
			$disburse_date=$row->disburse_date;
			if(!empty($disburse_date) && $disburse_date!='0000-00-00'){
			$PHPDateValue7 = strtotime($disburse_date);
			$ExcelDateValue7 = PHPExcel_Shared_Date::PHPToExcel($disburse_date);
			$object -> getActiveSheet()->setCellValueByColumnAndRow(33, $excel_row, $ExcelDateValue7); 
			$object -> getActiveSheet() -> getStyleByColumnAndRow(33, $excel_row)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DMYSLASH);
			}else{
			$object -> getActiveSheet()->setCellValueByColumnAndRow(33, $excel_row,  '00/00/00'); 
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
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> enquiry_for);
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
			
		
		
		// Other Information 

			$object -> getActiveSheet() -> setCellValueByColumnAndRow(19, $excel_row, $row->model_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(20, $excel_row, $row -> reg_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(21, $excel_row, $row -> bank_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(22, $excel_row, $row -> loan_type);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(23, $excel_row, $row -> roi);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(24, $excel_row, $row -> los_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(25, $excel_row, $row -> tenure);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(26, $excel_row, $row -> loanamount);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(27, $excel_row, $row -> dealer);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(28, $excel_row, $row -> executive_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(29, $excel_row, $row -> pickup_date);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(30, $excel_row, $row -> login_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(31, $excel_row, $row -> login_status_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(32, $excel_row, $row -> approved_date);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(33, $excel_row, $row -> disburse_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(34, $excel_row, $row -> disburse_amount);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(35, $excel_row, $row -> process_fee);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(36, $excel_row, $row -> emi);
			
				//Auditor Remark
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(37, $excel_row,  $auditor_name);
			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(38, $excel_row, $row -> auditor_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(39, $excel_row, $row -> followup_pending);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(40, $excel_row, $row -> call_received);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(41, $excel_row, $row -> fake_updation);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(42, $excel_row, $row -> service_feedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(43, $excel_row, $row -> auditor_remark);
			
			
			

			$excel_row++;

		}

		
		$filename = 'Tracker ' . $from_date . ' - ' . $to_date;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
	
	
}

public function download_new_car()
{
	
	$from_date = $this -> input -> get('fromdate');
		$to_date = $this -> input -> get('todate');
	
	$query = $this -> new_tracker_close_model -> select_lead_download();
	
	
	if($this->process_id==6){
			$csv= "Sr No,Lead Source,Sub Lead Source,Customer Name,Mobile Number,Alternate Mobile Number,Address,Email ID,Lead Date,Lead Time,Assistance Required,Booking within Days,Customer Location,Lead Assigned Date(CSE),Lead Assigned Time(CSE),CSE Name,CSE Call Date,CSE Call Time,CSE Call Status,CSE Feedback,CSE Next Action,CSE Remark,CSE NFD,CSE NFT,Overdue,Appointment Type,Appointment Date,Appointment Time,Appointment Status,Showroom Location,DSE TL Name,DSE Name,Lead Assigned Date,Lead Assigned Time,DSE Call Date,DSE Call Time,DSE Call Status,DSE Feedback,DSE Next Action,DSE Remark,DSE NFD,DSE NFT,Overdue,Appointment Type,Appointment Date,Appointment Time,Appointment Status,EDMS Booking ID,Interested in Finance,Interested in Accessories,Interested in Insurance,Interested in EW,Buyer Type,Model,Variant,Auditor Name,Auditor call Date,Auditor call Time,Auditor call Status,Followup Pending,Call Received from Showroom,Fake Updation,Service Feedback,Auditor Remark\n";

	}else if($this->process_id==7){
			$csv= "Sr No,Lead Source,Sub Lead Source,Customer Name,Mobile Number,Alternate Mobile Number,Address,Email ID,Lead Date,Lead Time,Assistance Required,Booking within Days,Customer Location,Lead Assigned Date(CSE),Lead Assigned Time(CSE),CSE Name,CSE Call Date,CSE Call Time,CSE Call Status,CSE Feedback,CSE Next Action,CSE Remark,CSE NFD,CSE NFT,Overdue,Appointment Type,Appointment Date,Appointment Time,Appointment Status,Showroom Location,DSE TL Name,DSE Name,Lead Assigned Date,Lead Assigned Time,DSE Call Date,DSE Call Time,DSE Call Status,DSE Feedback,DSE Next Action,DSE Remark,DSE NFD,DSE NFT,Overdue,Appointment Type,Appointment Date,Appointment Time,Appointment Status,EDMS Booking ID,Interested in Finance,Interested in Accessories,Interested in Insurance,Interested in EW,Buyer Type,Buy Make,Buy Model,Budget From,Budget To,Exchange Make,Exchange Model,Manufacturing Year,Ownership,KM,Accidental Claim,Auditor Name,Auditor call Date,Auditor call Time,Auditor call Status,Followup Pending,Call Received from Showroom,Fake Updation,Service Feedback,Auditor Remark\n";

	}else{
		
			$csv="Sr No,Lead Source,Sub Lead Source,Customer Name,Mobile Number,Alternate Mobile Number,Address,Email ID,Lead Date,Lead Time,Assistance Required,Booking within Days,Customer Location,Lead Assigned Date(CSE),Lead Assigned Time(CSE),CSE Name,CSE Call Date,CSE Call Time,CSE Call Status,CSE Feedback,CSE Next Action,CSE Remark,CSE NFD,CSE NFT,Overdue,Appointment Type,Appointment Date,Appointment Time,Appointment Status,Showroom Location,Evaluator TL Name,Evaluator Name,Lead Assigned Date(Evaluator),Lead Assigned Time(Evaluator),Evaluator Call Date,Evaluator Call Time,Evaluator Call Status,Evaluator Feedback,Evaluator Next Action,Evaluator Remark,Evaluator NFD,Evaluator NFT,Overdue,Exchange Make,Exchange Model,Manufacturing Year,	Ownership,KM,Accidental Claim,Evaluation within days,Fuel Type,Color,Registration Number,Quoted Price,Expected Price,Auditor Name,Auditor call Date,Auditor call Time,Auditor call Status,Followup Pending,Call Received from Showroom,Fake Updation,Service Feedback,Auditor Remark\n";
			
	}

		$i=0;
	foreach ($query as $row) {
		$i++;
		if ($row -> assign_to_cse == 0) {
				$cse_name = $row -> csetl_fname . ' ' . $row -> csetl_lname;
			} else {
				$cse_name = $row -> cse_fname . ' ' . $row -> cse_lname;
			}
				$dse_tl_name = $row -> dsetl_fname . ' ' . $row -> dsetl_lname;
			if ($row -> assign_to_dse == 0) {
				$dse_name = $row -> dsetl_fname . ' ' . $row -> dsetl_lname;
			} else {
				$dse_name = $row -> dse_fname . ' ' . $row -> dse_lname;
			}

			if ($row -> lead_source == '') { $lead_source = "Web";
			} 
			/*else if($row->lead_source=='Facebook')
			{
				$lead_source=$row->enquiry_for;
			}*/
			else { $lead_source = $row -> lead_source;
			}
			$cse_comment = preg_replace('#[^\w()/.%\-&]#'," ", $row->cse_comment);
			$dse_comment = preg_replace('#[^\w()/.%\-&]#'," ", $row->dse_comment);
			//CSE Overdue
			$cse_overdue='';
			$nfd=$row -> cse_nfd;
			if($nfd !='' && $nfd !='0000-00-00'){
			$today=strtotime(date('Y-m-d'));
			$nfd=strtotime($row -> cse_nfd);
			$overdue=$today-$nfd; 
			if($nfd < $today){
			$cse_overdue =($overdue)/60/60/24 ;
			 }
			}
			//DSE Overdue
			$dse_overdue='';
			$dnfd=$row -> dse_nfd;
			if($dnfd !='' && $dnfd !='0000-00-00'){
			$today=strtotime(date('Y-m-d'));
			$dnfd=strtotime($row -> dse_nfd);
			$doverdue=$today-$dnfd; 
			if($dnfd < $today){
			$dse_overdue =($doverdue)/60/60/24 ;
			 }
			}
		if($this->process_id==6){
			  $csv.= $i.',"'.$lead_source.'","'.$row->enquiry_for.'","'.$row->name.'","'.$row->contact_no.'","'.$row->alternate_contact_no.'","'.$row->address.'","'.$row->email.'","'.$row->lead_date.'","'.$row->created_time.'","'.$row->assistance.'","'.$row->days60_booking.'","'.$row->customer_location.'","'.$row->assign_to_cse_date.'","'.$row->assign_to_cse_time.'","'.$cse_name.'","'.$row->cse_date.'","'.$row->cse_time.'" ,"'.$row->csecontactibility.'","'.$row->csefeedback.'","'.$row->csenextAction.'","'.$cse_comment.'","'.$row->cse_nfd.'","'.$row->cse_nftime.'","'.$cse_overdue.'","'.$row->cappointment_type.'","'.$row->cappointment_date.'","'.$row->cappointment_time.'","'.$row -> cappointment_status.'","'.$row->showroom_location.'","'.$dse_tl_name.'","'.$dse_name.'","'.$row->assign_to_dse_date.'","'.$row -> assign_to_dse_time.'","'.$row->dse_date.'","'.$row -> dse_time.'","'.$row -> dsecontactibility.'","'.$row -> dsefeedback.'","'.$row -> dsenextAction.'","'.$dse_comment.'","'.$row->dse_nfd.'","'.$row -> dse_nftime.'","'.$dse_overdue.'","'.$row->dappointment_type.'","'.$row->dappointment_date.'","'.$row->dappointment_time.'","'.$row -> dappointment_status.'","'.$row->edms_booking_id .'","'.$row -> interested_in_finance.'","'.$row -> interested_in_accessories.'","'. $row -> interested_in_insurance.'","'.$row -> interested_in_ew.'","'. $row -> buyer_type.'","'. $row -> new_model_name.'","'.$row -> variant_name .'","'.$row -> auditfname . ' ' . $row -> auditlname .'","'.$row->auditor_date.'","'.$row -> auditor_time.'","'.$row -> auditor_call_status.'","'.$row -> followup_pending.'","'.$row -> call_received.'","'.$row -> fake_updation.'","'.$row -> service_feedback.'","'.$row -> auditor_remark.'"'."\n";

		}elseif($this->process_id==7){
			  $csv.= $i.',"'.$lead_source.'","'.$row->enquiry_for.'","'.$row->name.'","'.$row->contact_no.'","'.$row->alternate_contact_no.'","'.$row->address.'","'.$row->email.'","'.$row->lead_date.'","'.$row->created_time.'","'.$row->assistance.'","'.$row->days60_booking.'","'.$row->customer_location.'","'.$row->assign_to_cse_date.'","'.$row->assign_to_cse_time.'","'.$cse_name.'","'.$row->cse_date.'","'.$row->cse_time.'","'.$row->csecontactibility.'","'.$row->csefeedback.'","'.$row->csenextAction.'","'.$row->cse_comment.'","'.$row->cse_nfd.'","'.$row->cse_nftime.'","'.$cse_overdue.'","'.$row->cappointment_type.'","'.$row->cappointment_date.'","'.$row->cappointment_time.'","'.$row -> cappointment_status.'","'.$row->showroom_location.'","'.$dse_tl_name.'","'.$dse_name.'","'.$row->assign_to_dse_date.'","'.$row -> assign_to_dse_time.'","'.$row->dse_date.'","'.$row -> dse_time.'","'.$row -> dsecontactibility.'","'.$row -> dsefeedback.'","'.$row -> dsenextAction.'","'.$row -> dse_comment.'","'.$row->dse_nfd.'","'.$row -> dse_nftime.'","'.$dse_overdue.'","'.$row->dappointment_type.'","'.$row->dappointment_date.'","'.$row->dappointment_time.'","'.$row -> dappointment_status.'","'.$row->edms_booking_id.'","'.$row -> interested_in_finance.'","'.$row -> interested_in_accessories.'","'. $row -> interested_in_insurance.'","'.$row -> interested_in_ew.'","'. $row -> buyer_type.'","'. $row -> buy_make_name.'","'.$row -> buy_model_name.'","'.$row -> budget_from.'","'.$row -> budget_to.'","'.$row->old_make.'","'. $row -> old_model.'","'.$row -> manf_year.'","'.$row -> ownership.'","'.$row -> km.'","'.$row -> accidental_claim.'","'.$row -> auditfname . ' ' . $row -> auditlname .'","'.$row->auditor_date.'","'.$row -> auditor_time.'","'.$row -> auditor_call_status.'","'.$row -> followup_pending.'","'.$row -> call_received.'","'.$row -> fake_updation.'","'.$row -> service_feedback.'","'.$row -> auditor_remark.'"'."\n";

		}else{
			 $csv.= $i.',"'.$lead_source.'","'.$row->enquiry_for.'","'.$row->name.'","'.$row->contact_no.'","'.$row->alternate_contact_no.'","'.$row->address.'","'.$row->email.'","'.$row->lead_date.'","'.$row->created_time.'","'.$row->assistance.'","'.$row->days60_booking.'","'.$row->customer_location.'","'.$row->assign_to_cse_date.'","'.$row->assign_to_cse_time.'","'.$cse_name.'","'.$row->cse_date.'","'.$row->cse_time.'","'.$row->csecontactibility.'","'.$row->csefeedback.'","'.$row->csenextAction.'","'.$row->cse_comment.'","'.$row->cse_nfd.'","'.$row->cse_nftime.'","'.$cse_overdue.'","'.$row->appointment_type.'","'.$row->appointment_date.'","'.$row->appointment_time.'","'.$row -> appointment_status.'","'.$row->showroom_location.'","'.$dse_tl_name.'","'.$dse_name.'","'.$row->assign_to_dse_date.'","'.$row -> assign_to_dse_time.'","'.$row->dse_date.'","'.$row -> dse_time.'","'.$row -> dsecontactibility.'","'.$row -> dsefeedback.'","'.$row -> dsenextAction.'","'.$row -> dse_comment.'","'.$row->dse_nfd.'","'.$row -> dse_nftime.'","'.$dse_overdue.'","'.$row->old_make.'","'. $row -> old_model.'","'.$row -> manf_year.'","'.$row -> ownership.'","'.$row -> km.'","'.$row -> accidental_claim.'","'.$row -> evaluation_within_days.'","'.$row -> fuel_type.'","'. $row -> color.'","'. $row -> reg_no.'","'. $row -> quotated_price.'","'. $row -> expected_price .'","'.$row -> auditfname . ' ' . $row -> auditlname .'","'.$row->auditor_date.'","'.$row -> auditor_time.'","'.$row -> auditor_call_status.'","'.$row -> followup_pending.'","'.$row -> call_received.'","'.$row -> fake_updation.'","'.$row -> service_feedback.'","'.$row -> auditor_remark.'"'."\n";
		
			
		}
  
            }
$csv_handler = fopen ('tracker.csv','w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);	

$this->load->helper('download');
$filename = 'Tracker ' . $from_date . ' - ' . $to_date.'.csv';
    $data = file_get_contents('https://www.autovista.in/all_lms/tracker.csv'); // Read the file's contents
    
        force_download($filename, $data);
	
}

public function download_new_service()
{
	
	$from_date = $this -> input -> get('fromdate');
		$to_date = $this -> input -> get('todate');
	
	$query = $this -> new_tracker_close_model -> select_lead_download_all();
	
	
			$csv="Sr No,Lead Source,Sub Lead Source,Customer Name,Mobile Number,Alternate Mobile Number,Address,Email ID,Lead Date,Lead Time,Car Model,Reg No,KM,Service Location,Service Type,Pick up Required,Pick up Date,Assistance Required,Booking within Days,Customer Location,Lead Assigned Date(CSE),Lead Assigned Time(CSE),CSE Name,CSE Call Date,CSE Call Time,CSE Call Status,CSE Feedback,CSE Next Action,Eagerness,CSE Remark,CSE NFD,CSE NFT,Auditor Name,Auditor call Date,Auditor call Time,Auditor call Status,Followup Pending,Call Received from Showroom,Fake Updation,Service Feedback,Auditor Remark\n";
		
		$i=0;
	foreach ($query as $row) {
		$i++;
		if ($row -> assign_to_cse == 0) {
				$cse_name = $row -> csetl_fname . ' ' . $row -> csetl_lname;
			} else {
				$cse_name = $row -> cse_fname . ' ' . $row -> cse_lname;
			}
			

			if ($row -> lead_source == '') { $lead_source = "Web";
			} 
			
			else { $lead_source = $row -> lead_source;
			}
			$cse_comment = preg_replace('#[^\w()/.%\-&]#'," ", $row->cse_comment);
			
		
			 $csv.= $i.',"'.$lead_source.'","'.$row->enquiry_for.'","'.$row->name.'","'.$row->contact_no.'","'.$row->alternate_contact_no.'","'.$row->address.'","'.$row->email.'","'.$row->lead_date.'","'.$row->created_time.'",'.$row->model_name.','.$row->reg_no.',"'.$row->km.'",'.$row->service_center.','.$row->service_type.','.$row->pickup_required.','.$row->pick_up_date.','.$row->assistance.','.$row->days60_booking.',"'.$row->customer_location.'",'.$row->assign_to_cse_date.','.$row->assign_to_cse_time.','.$cse_name.','.$row->cse_date.','.$row->cse_time.','.$row->csecontactibility.',"'.$row->csefeedback.'","'.$row->csenextAction.'","'.$row->eagerness.'","'.$row->cse_comment.'",'.$row->cse_nfd.','.$row->cse_nftime.',"'.$row -> auditfname . ' ' . $row -> auditlname .'",'.$row->auditor_date.','.$row -> auditor_time.','.$row -> auditor_call_status.','.$row -> followup_pending.','.$row -> call_received.','.$row -> fake_updation.','.$row -> service_feedback.','.$row -> auditor_remark."\n";
		
		
		
  
            }
$csv_handler = fopen ('tracker.csv','w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);	

$this->load->helper('download');
$filename = 'Tracker ' . $from_date . ' - ' . $to_date.'.csv';
    $data = file_get_contents('https://www.autovista.in/all_lms/tracker.csv'); // Read the file's contents
    
        force_download($filename, $data);
	
}

public function download_service()
{
	$from_date = $this -> input -> get('fromdate');
		$to_date = $this -> input -> get('todate');
		//$select_lead_dse= $this -> new_tracker_close_model ->select_lead_dse_download();
		//$select_lead_dse_lc=$this -> new_tracker_close_model ->select_lead_dse_lc_download();
		//$query = array_merge($select_lead_dse,$select_lead_dse_lc);
		$query = $this -> new_tracker_close_model -> select_lead_download_all();
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
		//$select_lead_dse= $this -> new_tracker_close_model ->select_lead_dse_download();
		//$select_lead_dse_lc=$this -> new_tracker_close_model ->select_lead_dse_lc_download();
		//$query = array_merge($select_lead_dse,$select_lead_dse_lc);
		$query = $this -> new_tracker_close_model -> select_lead_download_all();
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
		//$select_lead_dse= $this -> new_tracker_close_model ->select_lead_dse_download();
		//$select_lead_dse_lc=$this -> new_tracker_close_model ->select_lead_dse_lc_download();
		//$query = array_merge($select_lead_dse,$select_lead_dse_lc);
		$query = $this -> new_tracker_close_model -> select_lead_download();
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
public function download_complaint()
{
	
	$from_date = $this -> input -> get('fromdate');
		$to_date = $this -> input -> get('todate');
		
		$query = $this -> new_tracker_close_model -> select_lead_download_complaint();
		$csv="Sr No,Lead Source,Complaint Type,Customer Name,Mobile Number,Alternate Mobile Number,Address,Email ID,Lead Date,Lead Time,Service Center,Customer Comment,Lead Assigned Date(CSE),Lead Assigned Time(CSE),CSE Name,CSE Call Date,CSE Call Time,CSE Call Status,CSE Feedback,CSE Next Action,CSE Remark,CSE NFD,CSE NFT,Registration No,Complaint location,Auditor Name,Auditor call Date,Auditor call Time,Auditor call Status,Followup Pending,Call Received from Showroom,Fake Updation,Service Feedback,Auditor Remark\n";
			
	

		$i=0;
	foreach ($query as $row) {
		$i++;
		
				$cse_name = $row -> cse_fname . ' ' . $row -> cse_lname;
			

			if ($row -> lead_source == '') { $lead_source = "Web";
			} 
			
			else { $lead_source = $row -> lead_source;
			}
			$cse_comment = preg_replace('#[^\w()/.%\-&]#'," ", $row->cse_comment);
			
			$csv.= $i.',"'.$lead_source.'","'.$row->business_area.'","'.$row->name.'","'.$row->contact_no.'","'.$row->alternate_contact_no.'","'.$row->address.'","'.$row->email.'","'.$row->lead_date.'","'.$row->lead_time.'",'.$row->service_center.',"'.$row->comment.'",'.$row->assign_to_cse_date.','.$row->assign_to_cse_time.','.$cse_name.','.$row->cse_date.','.$row->cse_time.','.$row->csecontactibility.',"'.$row->csefeedback.'","'.$row->csenextAction.'","'.$row->cse_comment.'",'.$row->cse_nfd.','.$row->cse_nftime.',"'.$row->reg_no.'","'.$row->location.'","'.$row -> auditfname . ' ' . $row -> auditlname .'",'.$row->auditor_date.','.$row -> auditor_time.','.$row -> auditor_call_status.','.$row -> followup_pending.','.$row -> call_received.','.$row -> fake_updation.','.$row -> service_feedback.','.$row -> auditor_remark."\n";
		
			
		
  
            }
$csv_handler = fopen ('tracker.csv','w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);	

$this->load->helper('download');
$filename = 'Tracker ' . $from_date . ' - ' . $to_date.'.csv';
    $data = file_get_contents('https://www.autovista.in/all_lms/tracker.csv'); // Read the file's contents
    
        force_download($filename, $data);
}	
public function download_poc_purchase_tracking()
{
	$from_date = $this -> input -> get('fromdate');
	$to_date = $this -> input -> get('todate');
	
	$query = $this -> new_tracker_close_model -> select_poc_lead_download();
	
	$csv="Sr No., Lead Source, Sub Lead Source, Customer Name, Mobile Number, Alternate Mobile Number, Address, Email ID, Lead Date, Lead Time, Booking within Days, Customer Location, Lead Assigned Date(CSE), Lead Assigned Time(CSE), CSE Name, CSE Call Date,CSE Call Time, CSE Call Status, CSE Feedback, CSE Next Action, CSE Remark, CSE NFD, CSE NFT, Overdue,Appointment Type, Appointment Date, Appointment Time, Appointment Status,	Showroom Location, Team Lead Name, Evaluator Name, Lead Assigned Date(Evaluator),	Lead Assigned Time(Evaluator), Evaluator Call Date, Evaluator Call Time, Evaluator Call Status, Evaluator Feedback, Evaluator Next Action, Evaluator Remark, Evaluator NFD, Evaluator NFT, Overdue,Evaluation No, Outright/Exchange, Vehicle Sale Category Customer\Dealer, Exchange Make, Exchange Model, Sub Model, Manufacturing Year, Fuel Type, Color, Registration No, Year of Regn, KM, Ownership, Old Car Owner Name, HP, Finacier Name, Insurance Type, Insurance Co Name, Insurance Validity date, Photo Uploaded, Type of Vehicle - Pvt\T permit, Vehicle Accidental, Accidental Details, Tyre conditon, Engine work, body work, Battery, Mechanical, Tyre, Other, Price Offered, Customer Expectation, Difference, Refurbish cost Bodyshop,Price With RF & commission, Agent Commission Payable, Total RF, Expected Selling Price, Expected Date of Sale, Bought at Price, Bought Date, Payment date, Payment mode, Payment Made to\n";

	$i=0;
	foreach ($query as $row) 
	{
		$i++;
		if ($row -> assign_to_cse == 0) 
		{
			$cse_name = $row -> csetl_fname . ' ' . $row -> csetl_lname;
		} 
		else 
		{
			$cse_name = $row -> cse_fname . ' ' . $row -> cse_lname;
		}
			
		

		if ($row -> lead_source == '')
		{ 
			$lead_source = "Web";
		} 
		else 
		{ 
			$lead_source = $row -> lead_source;
		}
			
		$cse_comment = preg_replace('#[^\w()/.%\-&]#'," ", $row->cse_comment);
		$evaluator_comment = preg_replace('#[^\w()/.%\-&]#'," ", $row->evaluator_comment);
		$difference = ($row->expected_price) - ($row->quotated_price);
		
		//CSE Overdue
			$cse_overdue='';
			$nfd=$row -> cse_nfd;
			if($nfd !='' && $nfd !='0000-00-00'){
			$today=strtotime(date('Y-m-d'));
			$nfd=strtotime($row -> cse_nfd);
			$overdue=$today-$nfd; 
			if($nfd < $today){
			$cse_overdue =($overdue)/60/60/24 ;
			 }
			}
			//DSE Overdue
			$dse_overdue='';
			$dnfd=$row -> evaluator_nfd;
			if($dnfd !='' && $dnfd !='0000-00-00'){
			$today=strtotime(date('Y-m-d'));
			$dnfd=strtotime($row -> evaluator_nfd);
			$doverdue=$today-$dnfd; 
			if($dnfd < $today){
			$dse_overdue =($doverdue)/60/60/24 ;
			 }
			}
		
		$csv.= $i.',"'.$lead_source.'","'.$row->enquiry_for.'","'.$row->name.'","'.$row->contact_no.'","'.$row->alternate_contact_no.'","'.$row->address.'","'.$row->email.'","'.$row->lead_date.'","'.$row->lead_time.'","'.$row->days60_booking.'","'.$row->customer_location.'","'.$row->assign_to_cse_date.'","'.$row->assign_to_cse_time.'","'.$cse_name.'","'.$row->cse_date.'","'.$row->cse_time.'","'.$row->csecontactibility.'","'.$row->csefeedback.'","'.$row->csenextAction.'","'.$cse_comment.'","'.$row->cse_nfd.'","'.$row->cse_nftime.'","'.$cse_overdue.'","'.$row->appointment_type.'","'.$row->appointment_date.'","'.$row->appointment_time.'","'.$row->appointment_status.'","'.$row->showroom_location.'","'.$row -> tlfname . ' ' . $row -> tllname .'","'.$row->fname.' '.$row->lname.'","'.$row->assign_to_e_exe_date.'","'.$row->assign_to_e_exe_time.'","'.$row->evaluator_date.'","'.$row->evaluator_time.'","'.$row->evaluatorcontactibility.'","'.$row->evaluatorfeedback.'","'.$row->evaluatornextAction.'","'.$evaluator_comment.'","'.$row->evaluator_nfd.'","'.$row->evaluator_nftime.'","'.$dse_overdue.'","'.$row->enq_id.'","'.$row->outright.'","'.$row->vechicle_sale_category.'","'.$row->make_name.'","'.$row->model_name.'","'.$row->variant_name.'","'.$row->manf_year.'","'.$row->fuel_type.'","'.$row->color.'","'.$row->reg_no.'","'.$row->reg_year.'","'.$row->km.'","'.$row->ownership.'","'.$row->old_car_owner_name.'","'.$row->hp.'","'.$row->financier_name.'","'.$row->insurance_type.'","'.$row->insurance_company.'","'.$row->insurance_validity_date.'","'.$row->photo_uploaded.'","'.$row->type_of_vehicle.'","'.$row->accidental_details.'","'.$row->accidental_details.'","'.$row->tyre_conditon.'","'.$row->engine_work.'","'.$row->body_work.'","'.$row->refurbish_cost_battery.'","'.$row->refurbish_cost_mecahanical.'","'.$row->refurbish_cost_tyre.'","'.$row->refurbish_other.'","'.$row->quotated_price.'","'.$row->expected_price.'","'.$difference.'","'.$row->refurbish_cost_bodyshop.'","'.$row->price_with_rf_and_commission.'","'.$row->agent_commision_payable.'","'.$row->total_rf.'","'.$row->selling_price.'","'.$row->expected_date_of_sale.'","'.$row->bought_at.'","'.$row->bought_date.'","'.$row->payment_date.'","'.$row->payment_mode.'","'.$row->payment_made_to.'"'."\n";

	}
	$csv_handler = fopen ('tracker.csv','w');
	fwrite ($csv_handler,$csv);
	fclose ($csv_handler);	

	$this->load->helper('download');
	$filename = 'Tracker ' . $from_date . ' - ' . $to_date.'.csv';
    $data = file_get_contents('https://www.autovista.in/all_lms/tracker.csv'); // Read the file's contents
    
    force_download($filename, $data);

}

}
?>