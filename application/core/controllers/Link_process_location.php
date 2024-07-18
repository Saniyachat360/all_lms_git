<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Link_process_location extends CI_Controller {
	private $process_id;
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('link_process_location_model');
		$this -> load -> model('Add_leadsource_model');
		
		$this->process_id=$_SESSION['process_id'];
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	function index() {
		$this -> session();
		$map_id='';
		$data['select_location']=$this->link_process_location_model->select_location();
		$data['select_process']=$this->link_process_location_model->select_process();
		$data['select_table']=$this->link_process_location_model->select_table($map_id);
		$data['var']=site_url('Link_process_location/insert_link_process_location');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('link_process_location_view.php', $data);
		$this -> load -> view('include/footer.php');

	}
	public function insert_link_process_location(){
		$this->link_process_location_model->insert_link_process_location();
		redirect('link_process_location');
	}
	public function link_process_location($map_id){
		$this -> session();
		$data['select_location']=$this->link_process_location_model->select_location();
		//$data['select_process']=$this->link_process_location_model->select_process();
		$data['select_table']=$this->link_process_location_model->select_table($map_id);
		//print_r($data['select_table']);
		$data['var']=site_url('Link_process_location/edit_link_process_location');
		$this -> load -> view('include/admin_header.php');
		$this -> load -> view('edit_link_location_process_view.php', $data);
		$this -> load -> view('include/footer.php');

		//$this->link_process_location_model->edit_link_process_location($map_id);
		//redirect('link_process_location');
	}
	public function edit_link_process_location(){
	$this->link_process_location_model->edit_link_process_location();
		redirect('link_process_location');
	}
	public function delete_link_process_location($map_id){
	$this->link_process_location_model->delete_link_process_location($map_id);
		redirect('link_process_location');
	}
	
}
?>