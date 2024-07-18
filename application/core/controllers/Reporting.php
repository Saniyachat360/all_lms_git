<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class reporting extends CI_Controller {

 public $process_name;
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('reporting_model');
		$this -> load -> model('new_tracker_model');
		$this->process_name=$_SESSION['process_name'];
		$this->process_id=$_SESSION['process_id'];
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
public function leads() {

		//$select_lead_dse= $this -> new_tracker_model ->select_lead_dse();
		//$select_lead_dse_lc=$this -> new_tracker_model ->select_lead_dse_lc();
		//$data['select_lead'] = array_merge($select_lead_dse,$select_lead_dse_lc);
		
		$this->session();
		
		$data['campaign_name'] = $this -> input -> get('campaign_name');
		$data['nextaction'] = $this -> input -> get('nextaction');
		$data['feedback'] = $this -> input -> get('feedback');
		$data['fromdate'] = $this -> input -> get('fromdate');
		$data['todate'] = $this -> input -> get('todate');
		$data['date_type'] = $this -> input -> get('date_type');
	/*	$data['select_lead'] = $this -> new_tracker_model -> select_lead_dse_test($this->process_name);
		$data['count_lead'] = $this -> new_tracker_model -> select_lead_dse_count_test($this->process_name);*/
		$data['select_lead'] = $this -> new_tracker_model -> select_leads();
		$data['count_lead'] = $this -> new_tracker_model -> select_leads_count();
			$data['process_id']=$this->process_id;
	
		$this -> load -> view('include/admin_header.php');
		$this->load->view('reporting_top_tab.php',$data);
		$this -> load -> view('tracker_with_dse_filter_new.php', $data);
		$this -> load -> view('include/footer.php');
	}

	/*public function leaddata() {
		$this -> session();
		$from_date = $this -> input -> get('fromdate');
		$to_date = $this -> input -> get('todate');
		$user_id = $this -> input -> get('user_id');
		$user_name = $this -> input -> get('user_name');
		ini_set('memory_limit', '-1');

		$query1 = $this ->reporting_model-> leadmaster($from_date, $to_date, $user_id, $user_name);
		$query2 = $this ->reporting_model-> leadmasterlc($from_date, $to_date, $user_id, $user_name);
		//print_r($query2);
		$query = array_merge($query1, $query2);
		//echo $this->db->last_query();
		$this -> load -> library("excel");
		$object = new PHPExcel();

		$object -> setActiveSheetIndex(0);

		$table_columns = array('Customer ID', 'Lead Source', 'Custmer Name', 'Contact', 'address', 'Email', 'Lead Date', 'Showroom Location', 'CSE  Name', 'CSE Date', 'CSE Nextaction', 'CSE Feedback', 'CSE Comment', 'CSE NFD', 'TD/HV Date', 'Booking Within Days', 'DSE Name', 'DSE Date', 'DSE Nextaction', 'DSE Feedback', 'DSE Comment', 'DSE NFD', 'Buyer Type', 'New Model  Name', 'Variant Name', 'Make Name', 'Old Model Name', 'Mfg Year');
		$column = 0;

		foreach ($table_columns as $field) {
			$object -> getActiveSheet() -> setCellValueByColumnAndRow($column, 1, $field);
			$column++;
		}

		$excel_row = 2;

		foreach ($query as $row) {
			$cse_name = $row -> cse_fname . ' ' . $row -> cse_lname;
			$dse_name = $row -> dse_fname . ' ' . $row -> dse_lname;
			if ($row -> lead_source == '') { $lead_source = "Website";
			} else { $lead_source = $row -> lead_source;
			}
			if ($row -> cse_fname == '' and $row -> nextAction == 'Not Yet') {
				$status = "Unassigned";
			} else if ($row -> cse_fname != '' and $row -> nextAction == 'Not Yet') {
				$status = "Untouched";
			} else {
				$status = $row -> nextAction;
			}
			$excel_row1 = $excel_row - 1;
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(0, $excel_row, $excel_row1);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(1, $excel_row, $lead_source);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(2, $excel_row, $row -> name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(3, $excel_row, $row -> contact_no);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(4, $excel_row, $row -> address);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(5, $excel_row, $row -> email);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(6, $excel_row, $row -> lead_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(7, $excel_row, $row -> showroom_location);

			$object -> getActiveSheet() -> setCellValueByColumnAndRow(8, $excel_row, $cse_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(9, $excel_row, $row -> cse_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(10, $excel_row, $row -> csenextAction);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(11, $excel_row, $row -> csefeedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(12, $excel_row, $row -> cse_comment);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(13, $excel_row, $row -> cse_nfd);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(14, $excel_row, $row -> td_hv_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(15, $excel_row, $row -> days60_booking);


			$object -> getActiveSheet() -> setCellValueByColumnAndRow(16, $excel_row, $dse_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(17, $excel_row, $row -> dse_date);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(18, $excel_row, $row -> dsenextAction);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(19, $excel_row, $row -> dsefeedback);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(20, $excel_row, $row -> dse_comment);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(21, $excel_row, $row -> dse_nfd);

			//$object -> getActiveSheet() -> setCellValueByColumnAndRow(22, $excel_row, $status);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(22, $excel_row, $row -> buyer_type);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(23, $excel_row, $row -> new_model_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(24, $excel_row, $row -> variant_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(25, $excel_row, $row -> make_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(26, $excel_row, $row -> old_model_name);
			$object -> getActiveSheet() -> setCellValueByColumnAndRow(27, $excel_row, $row -> manf_year);

			$excel_row++;

		}
		$date = date("Y-m-d");
		$filename = 'Tracker ' . $from_date . ' - ' . $to_date;
		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="' . $filename . ".xls");
		$object_writer -> save('php://output');
	}
*/
	

}
?>