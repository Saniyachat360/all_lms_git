<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Showroom_visit extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model('showroom_visit_model');
		$this->view= $this->session->userdata('view');
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function leads() {
		$this -> session();
		$data['enq'] = 'Showroom Visit Today';
		//get pending attened leads details
		$id_array=$this->input->get('id_array');
		/*if(isset($id_array)){*/
		$data['select_lead'] = $this -> showroom_visit_model -> select_lead_location_wise();
		$data['showroom_visit_count_lead'] = $this -> showroom_visit_model -> select_lead_count_location_wise();
		/*}else{
			$data['select_lead'] = $this -> home_visit_model -> select_lead_location();
		$data['unassign_count_lead'] = $this -> home_visit_model -> select_lead_count_location();
		}*/
		$data['id']=$this->input->get('id');
		$data['role']=$this->input->get('role');
		
		$this -> load -> view('include/admin_header.php');
		if ($this ->view[15]=='1') {
		$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('telecaller_lms_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	}
?>