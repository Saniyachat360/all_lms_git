<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CSE_reports extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model(array('CSE_reports_model'));
	
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {

		$this -> session();
		
		$data['select_cse']=$this -> CSE_reports_model -> select_cse();
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('report/cse_productivity_report_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	
	public function search_productivity()
	{
		$this -> session();
		$from_date=$this->input->post('from_date');
	$to_date=$this->input->post('to_date');
	$date_type=$this->input->post('date_type');
	if($date_type=='As on Date')
	{
		$to_date=$from_date;
		$from_date='2017-01-01';
	}
	$cse_id=$this->input->post('cse_id');
		$data['select_leads']=$this->CSE_reports_model->cse_productivity($cse_id,$from_date,$to_date); 
				$data['from_date']=$from_date;
				$data['to_date']=$to_date;
		$this -> load -> view('report/cse_productivity_filter_report_view.php', $data);
	
	
		
	}
	public function appointment_report() {

		$this -> session();
		
		$data['select_location']=$this -> CSE_reports_model -> select_location();	
		//print_r($data['select_location']);
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('report/cse_appointment_report_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function search_appointment()
	{
		$this -> session();
		$q=$data['select_leads']=$this -> CSE_reports_model -> search_appointment(); 

		$this -> load -> view('report/cse_appointment_filter_report_view.php', $data);
	
	
		
	}

	}
?>