<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holiday extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('holiday_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
    	$query1=$this->holiday_model->select_data();
		$data['select_data']=$query1;
		$data['var']=site_url('holiday/insert_data');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('holiday_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function insert_data()
	{
		$this->holiday_model->insert_data();
		redirect('holiday');
	}
	public function edit_data($id)
	{
		$data['edit_data']=$this->holiday_model->edit_data($id);
		$data['var']=site_url('holiday/update_data');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('holiday_edit_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function update_data()
	{
		$login_status_id=$this->input->post('login_status_id');
		$this->holiday_model->update_data($login_status_id);
		redirect('holiday');
	}
	public function delete_data($id)
	{
		$this->holiday_model->delete_data($id);
		redirect('holiday');
	}

	

	}
?>
