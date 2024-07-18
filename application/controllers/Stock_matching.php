<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_matching extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('stock_macthing_model');
		$this->view= $this->session->userdata('view');
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function leads() {
		$this -> session();
		$data['enq'] = 'Stock Matching'; 
		//get pending attened leads details
		$id_array=$this->input->get('id_array');
		/*if(isset($id_array)){*/
		
		/*}else{
			$data['select_lead'] = $this -> home_visit_model -> select_lead_location();
		$data['unassign_count_lead'] = $this -> home_visit_model -> select_lead_count_location();
		}*/
		$id=$data['id']=$this->input->get('id');
		$data['role']=$this->input->get('role');

			$data['stock_match'] = $q = $this -> stock_macthing_model -> select_stock_matching();
			//print_r($data['stock_match']);
			$max_price = $q[0]->max_stock;
			$min_price = $q[0]->min_stock;

			//echo $max_price.$min_price;die;
			$data['select_lead'] = $this -> stock_macthing_model -> select_lead_location_wise($max_price,$min_price);

			//print_r($data['select_lead']);

		$data['stock_visit_count_lead'] = $this -> stock_macthing_model -> select_lead_count_location_wise($max_price,$min_price);
		$this -> load -> view('include/admin_header.php');
		if ($this ->view[15]=='1' && $id=='') {
		$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('stock_matching_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	}
?>