<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Next_action extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('next_action_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
		$query1=$this->next_action_model->select_next_action_status();
		$data['select_next_action_status']=$query1;
		$data['select_process']=$this->next_action_model->select_process();
		$data['var']=site_url('Next_action/insert_next_action_status');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('next_action_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function insert_next_action_status()
	{
		
		$naction_name=$this->input->post('naction_name');
		$process_id=$this->input->post('process_id');
		//echo $location_name;
		$this->next_action_model->insert_next_action_status($naction_name,$process_id);
		redirect('Next_action');
		
	}
	public function edit_next_action_status($id)
	{
		$data['select_next_action_status']=$q=$this->next_action_model->edit_next_action_status($id);
		$data['select_process']=$this->next_action_model->select_process();
		//print_r($q);
		$data['var']=site_url('Next_action/edit_new_next_action_status');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('edit_new_next_action_status_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function edit_new_next_action_status()
	{
		$naction_name = $this -> input -> post('naction_name');
		$naction_id = $this -> input -> post('naction_id');
		$process_id=$this->input->post('process_id');
		$this->next_action_model->edit_new_next_action_status($naction_id,$naction_name,$process_id);
		redirect('Next_action');
	}
	public function delete_next_action_status($id)
	{
		$this->next_action_model->delete_next_action_status($id);
		redirect('Next_action');
	}
	

	}
?>