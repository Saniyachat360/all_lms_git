<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Professional_type extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('professional_type_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
    	$query1=$this->professional_type_model->select_l_status();
		$data['select_login_status']=$query1;
		
		$data['var']=site_url('professional_type/insert_l_status');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('professional_t_view.php',$data);
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
		$this->professional_type_model->insert_l_status($login_status);
		
		redirect('professional_type');
		
	}
	

	public function edit_l_status($id)
	{
		$data['l_status']=$this->professional_type_model->edit_l_status($id);
		$data['var']=site_url('professional_type/update_l_status');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('professional_t_edit_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function update_l_status()
	{
		$login_status_id=$this->input->post('login_status_id');
		$reason_name=$this->input->post('reason_name');
		$loan_id=$this->input->post('loan_id');
		$this->professional_type_model->update_l_status($reason_name,$login_status_id);
		redirect('professional_type');
	}
	public function delete_l_status($id)
	{
		$this->professional_type_model->delete_l_status($id);
		redirect('professional_type');
	}

	

	}
?>
