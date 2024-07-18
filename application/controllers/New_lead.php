<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class new_lead extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model(array('new_lead_model', 'pending_model', 'today_followup_model'));
	
	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function index() {

		$this -> session();
		$data['enq'] = 'New';
	
			$data['select_lead'] = $this -> new_lead_model -> select_lead_location();
			$data['new_count_lead'] = $this -> new_lead_model -> select_lead_count_location();
			$data['id'] = $this -> input -> get('id');
			$data['role'] = $this -> input -> get('role');
		
		/*	$data['select_lead'] = $this -> new_lead_model -> select_lead($this->role,$this->process_name,$this->user_id);
			
			$data['new_count_lead'] = $this -> new_lead_model -> select_lead_count($this->role,$this->process_name,$this->user_id);
			$data['id'] = '';
		}*/

		$this -> load -> view('include/admin_header.php');
		if ($this -> input -> get('id') == '' ) {
			$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('telecaller_lms_view.php', $data);
		$this -> load -> view('include/footer.php');
	}

	public function leads() {

		$this -> session();

		$data['enq'] = 'New';
		/*if ($this -> input -> get('id') != '') {*/
			$data['select_lead'] = $this -> new_lead_model -> select_lead_location();
			$data['new_count_lead'] = $this -> new_lead_model -> select_lead_count_location();
			$data['id'] = $this -> input -> get('id');
			$data['role'] = $this -> input -> get('role');
		/*} else {

			$data['select_lead'] = $this -> new_lead_model -> select_lead_location();
			$data['new_count_lead'] = $this -> new_lead_model -> select_lead_count_location();
			$data['id'] = '';
			//	$data['today_count_lead']=$this->today_followup_model->select_lead_count();
			//	$data['pending_f_count_lead']=$this->pending_model->select_lead_count();
			//	$data['pending_new_count_lead']=$this->pending_model->select_lead1_count();
		}*/

		$this -> load -> view('include/admin_header.php');
		if ($this -> input -> get('id') == '') {
			$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('telecaller_lms_view.php', $data);
		$this -> load -> view('include/footer.php');
	}

	public function search_new() {

		$this -> session();

		$data['enq'] = 'New';
		//if ($this -> input -> get('id') != '') {
			$data['select_lead'] = $this -> new_lead_model -> select_lead_location();
			$data['new_count_lead'] = $this -> new_lead_model -> select_lead_count_location();
			/*$data['id'] = $this -> input -> get('id');
		} else {

			$data['select_lead'] = $this -> new_lead_model -> select_lead();
			$data['new_count_lead'] = $this -> new_lead_model -> select_lead_count();
			$data['id'] = '';
			//	$data['today_count_lead']=$this->today_followup_model->select_lead_count();
			//	$data['pending_f_count_lead']=$this->pending_model->select_lead_count();
			//	$data['pending_new_count_lead']=$this->pending_model->select_lead1_count();
		}*/

		$this -> load -> view('telecaller_followup_view.php', $data);

	}
/************************************ Complaint Functions ************************************/
public function complaint() {

		$this -> session();
		$data['enq'] = 'New';
	
			$data['select_lead'] = $this -> new_lead_model -> select_lead_complaint();
			$data['new_count_lead'] = $this -> new_lead_model -> select_lead_count_complaint();
			$data['id'] = $this -> input -> get('id');
			$data['role'] = $this -> input -> get('role');
		
		/*	$data['select_lead'] = $this -> new_lead_model -> select_lead($this->role,$this->process_name,$this->user_id);
			
			$data['new_count_lead'] = $this -> new_lead_model -> select_lead_count($this->role,$this->process_name,$this->user_id);
			$data['id'] = '';
		}*/

		$this -> load -> view('include/admin_header.php');
		if ($this -> input -> get('id') == '' ) {
			$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('complaint_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function search_complaint() {

		$this -> session();

		$data['enq'] = 'New';
		
		$data['select_lead'] = $this -> new_lead_model -> select_lead_complaint();
			$data['new_count_lead'] = $this -> new_lead_model -> select_lead_count_complaint();
		
		$this -> load -> view('complaint_filter_view.php', $data);

	}
/********************************************************************************************/
}
?>