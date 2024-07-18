<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_call_center_tl extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('add_call_center_tl_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
		$query1=$this->add_call_center_tl_model->select_tl();
		$data['select_cse_tl']=$query1;
		$data['var']=site_url('add_tl/insert_tl');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('add_call_center_tl_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function insert_tl()
	{
		
		$call_center_tl_id=$this->input->post('call_center_tl_id');
		//echo $location_name;
		$this->add_call_center_tl_model->insert_tl($add_call_center_tl_id);
		//redirect('add_tl');
		
	}
	/*public function edit_process($id)
	{
		$data['select_process']=$this->add_process_model->edit_process($id);
		$data['var']=site_url('add_process/edit_new_process');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('edit_process_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function edit_new_process()
	{
		$id = $this -> input -> post('process_id');
		$process_name = $this -> input -> post('process_name');
		
		$this->add_process_model->edit_new_process($id,$process_name);
		redirect('add_process');
	}*/
	/*public function delete_process($id)
	{
		$this->add_process_model->delete_process($id);
		//redirect('add_process');
	}*/
	

	}
?>