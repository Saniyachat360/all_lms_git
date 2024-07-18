<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lead_close extends CI_Controller {

		function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation','session'));
		$this -> load -> helper(array('form', 'url'));
		$this->load->model('lead_close_model');
		
	}
		public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}		
	public function leads()
	{
		$this->session();
		$data['enq']='All';
		$enq='All';
		$data['select_lead']=$this->lead_close_model->select_lead($enq);
		$data['all_count_lead']=$this->lead_close_model->select_lead_count($enq);
		
		$data['id']='';
		$data['role']='';
		$this -> load -> view('include/admin_header.php');
		
		//$this->load->view('telecaller_top_tab_view1.php',$data);
		$this->load->view('lead_close_view.php',$data);
		$this->load->view('include/footer.php');
	}
	public function mass_lead_lost()
	{
		//$this->lead_close_model->mass_lead_lost();
	}
}