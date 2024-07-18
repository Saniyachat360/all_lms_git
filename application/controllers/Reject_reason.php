<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reject_reason extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('reject_reason_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
    	$query1=$this->reject_reason_model->select_l_status();
		$data['select_login_status']=$query1;
		
		$data['var']=site_url('reject_reason/insert_l_status');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('reject_reason_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function insert_l_status()
	{
		
	//	$leadsource=$this->input->post('leadsource');
		$login_status=$this->input->post('scheme_name');
		$loan_id=$this->input->post('loan_id');
		print_r($loan_id);
	//	$leadsource_value="Manual%23".$leadsource_val;
		//echo $location_name;
		$this->reject_reason_model->insert_l_status($login_status);
		
		redirect('reject_reason');
		
	}
	

	public function edit_l_status($id)
	{
		$data['l_status']=$this->reject_reason_model->edit_l_status($id);
		$data['var']=site_url('reject_reason/update_l_status');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('reject_reason_edit_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function update_l_status()
	{
		$document_id=$this->input->post('r_reason_id');
		$document=$this->input->post('reason_name');
		$loan_id=$this->input->post('loan_id');
		$this->reject_reason_model->update_l_status($document,$document_id);
		redirect('reject_reason');
	}
	public function delete_l_status($id)
	{
		$this->reject_reason_model->delete_l_status($id);
		redirect('reject_reason');
	}

	

	}
?>
