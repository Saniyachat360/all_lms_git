<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_default_close_lead_status extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('add_default_close_lead_status_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
		$process_id=$_SESSION['process_id'];
		$data['select_next_action_status']=$this->add_default_close_lead_status_model->select_next_action_status($process_id);
		$query1=$this->add_default_close_lead_status_model->select_defult_close_lead_status();
		$data['select_defult_close_lead_status']=$query1;
		$data['select_process']=$this->add_default_close_lead_status_model->select_process();
		$data['var']=site_url('Add_default_close_lead_status/insert_defult_close_lead_status');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('add_default_close_lead_status_view',$data);
		$this->load->view('include/footer.php');
	
	}
	public function insert_defult_close_lead_status()
	{
		
		$naction_name=$this->input->post('naction_name');
		$process_id=$this->input->post('process_id');
		//echo $location_name;
		$this->add_default_close_lead_status_model->insert_defult_close_lead_status($naction_name,$process_id);
		redirect('Add_default_close_lead_status');
		
	}
	
	public function delete_deafault_close_lead_status($id,$nextAction)
	{
		$this->add_default_close_lead_status_model->delete_deafault_close_lead_status($id,$nextAction);
		redirect('Add_default_close_lead_status');
	}
	

	}
?>