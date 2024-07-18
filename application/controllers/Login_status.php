<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_status extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('login_status_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
    	$query1=$this->login_status_model->select_l_status();
		$data['select_login_status']=$query1;
		
		$data['var']=site_url('login_status/insert_l_status');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('login_status_view.php',$data);
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
		$this->login_status_model->insert_l_status($login_status);
		
		//redirect('document');
		
	}
	

	public function edit_l_status($id)
	{
		$data['l_status']=$this->login_status_model->edit_l_status($id);
		$data['var']=site_url('login_status/update_l_status');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('login_status_edit_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function update_l_status()
	{
		$login_status_id=$this->input->post('login_status_id');
		$reason_name=$this->input->post('reason_name');
		$loan_id=$this->input->post('loan_id');
		$this->login_status_model->update_l_status($reason_name,$login_status_id);
		redirect('login_status');
	}
	public function delete_l_status($id)
	{
		$this->login_status_model->delete_l_status($id);
		redirect('login_status');
	}

	

	}
?>
