<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_location extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('add_location_model');
		
	}
	
	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}
	
	public function index() 
	{
		$this->session();
		$query1=$this->add_location_model->select_location();
		$data['select_location']=$query1;
		$data['var']=site_url('add_location/insert_location');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('add_location_view.php',$data);
		$this->load->view('include/footer.php');
	
	}
	public function insert_location()
	{
		
		$location_name=$this->input->post('location_name');
		//echo $location_name;
		$this->add_location_model->insert_location($location_name);
		redirect('add_location');
		
	}
	public function edit_location($id)
	{
		$data['select_location']=$this->add_location_model->edit_location($id);
		$data['var']=site_url('add_location/edit_new_location');
		$this->load->view('include/admin_header.php');
		$this -> load -> view('edit_location_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function edit_new_location()
	{
		$id = $this -> input -> post('location_id');
		$location_name = $this -> input -> post('location_name');
		
		$this->add_location_model->edit_new_location($id,$location_name);
		redirect('add_location');
	}
	public function delete_location($id)
	{
		$this->add_location_model->delete_location($id);
		redirect('add_location');
	}
	

	}
?>