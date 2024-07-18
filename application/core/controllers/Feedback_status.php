<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback_status extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('Feedback_status_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
		$query1=$this->Feedback_status_model->select_feedback_status();
		$data['select_feedback_status']=$query1;
		$data['select_process']=$this->Feedback_status_model->select_process();
		$data['var']=site_url('Feedback_status/insert_feedback_status');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('feedback_status_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function insert_feedback_status()
	{
		
		$fstatus_name=$this->input->post('fstatus_name');
		$process_id=$this->input->post('process_id');
		//echo $location_name;
		$this->Feedback_status_model->insert_feedback_status($fstatus_name,$process_id);
		redirect('Feedback_status');
		
	}
	public function edit_feedback_status($id)
	{
		$data['select_feedback_status']=$this->Feedback_status_model->edit_feedback_status($id);
		$data['select_process']=$this->Feedback_status_model->select_process();
		$data['var']=site_url('Feedback_status/edit_new_feedback_status');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('edit_feedback_status_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function edit_new_feedback_status()
	{
		$fstatus_id = $this -> input -> post('fstatus_id');
		$fstatus_name = $this -> input -> post('fstatus_name');
		$process_id= $this -> input -> post('process_id');
		$this->Feedback_status_model->edit_new_feedback_status($fstatus_id,$fstatus_name,$process_id);
		redirect('Feedback_status');
	}
	public function delete_feedback_status($id)
	{
		$this->Feedback_status_model->delete_feedback_status($id);
		redirect('Feedback_status');
	}
	

	}
?>