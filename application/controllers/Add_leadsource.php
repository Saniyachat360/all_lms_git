<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_leadsource extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('Add_leadsource_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
		$query1=$this->Add_leadsource_model->select_leadsource();
		$data['select_leadsource']=$query1;
		$data['select_process']=$this->Add_leadsource_model->select_process();
		$data['var']=site_url('Add_leadsource/insert_leadsource');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('add_leadsource_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function insert_leadsource()
	{
		
		$leadsource=$this->input->post('leadsource');
		$leadsource_val=$this->input->post('leadsource');
		$process_id=$this->input->post('process_id');
		$leadsource_value="Manual%23".$leadsource_val;
		//echo $location_name;
		$this->Add_leadsource_model->insert_leadsource($leadsource,$leadsource_value,$process_id);
		
		redirect('Add_leadsource');
		
	}
	public function edit_leadsource($id)
	{
		$data['select_leadsource']=$this->Add_leadsource_model->edit_leadsource($id);
		$data['select_process']=$this->Add_leadsource_model->select_process();
		$data['var']=site_url('Add_leadsource/edit_new_leadsource');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('edit_leadsource_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function edit_new_leadsource()
	{
		$id=$this->input->post('leadsource_id');
		$leadsource=$this->input->post('leadsource');
		$leadsource_val=$this->input->post('leadsource');
		$leadsource_value="Manual%23".$leadsource_val;
		$process_id=$this->input->post('process_id');
		$this->Add_leadsource_model->edit_new_leadsource($leadsource,$leadsource_value,$id,$process_id);
		redirect('Add_leadsource');
	}
	public function delete_leadsource($id)
	{
		$this->Add_leadsource_model->delete_leadsource($id);
		redirect('Add_leadsource');
	}
		public function add_sub_lead_source() 
	{
		$this->session();
		
		$data['select_sub_lead_source']=$this->Add_leadsource_model->select_sub_leadsource();
		$data['select_process']=$this->Add_leadsource_model->select_process();
		$data['select_lead_source']=$this->Add_leadsource_model->select_leadsource();
		$data['var']=site_url('Add_leadsource/insert_sub_lead_source');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('add_sub_lead_source_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function insert_sub_lead_source()
	{
		
		$this->Add_leadsource_model->insert_sub_lead_source();
		redirect('Add_leadsource/add_sub_lead_source');
		
	}
	public function edit_sub_lead_source($id)
	{
		$data['select_sub_lead_source']=$this->Add_leadsource_model->select_sub_leadsource($id);
		$data['select_process']=$this->Add_leadsource_model->select_process();
		$data['select_lead_source']=$this->Add_leadsource_model->select_leadsource();
		$data['var']=site_url('Add_leadsource/edit_new_sub_lead_source');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('edit_sub_lead_source_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function edit_new_sub_lead_source()
	{
		
		$this->Add_leadsource_model->edit_new_sub_lead_source();
		redirect('Add_leadsource/add_sub_lead_source');
	}
	public function delete_sub_lead_source($id)
	{
		$this->Add_leadsource_model->delete_sub_lead_source($id);
		redirect('Add_leadsource/add_sub_lead_source');
	}

	}
?>