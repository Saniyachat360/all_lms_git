<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pending extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this -> load -> library(array('table', 'form_validation', 'session'));
		$this -> load -> helper(array('form', 'url'));
		$this -> load -> model(array('pending_model'));
		
		

	}

	public function session() {
		if ($this -> session -> userdata('username') == "") {
			redirect('login/logout');
		}
	}

	public function telecaller_leads() {
		$this -> session();
		$data['enq'] = 'Pending Followup';
		//get pending attened leads details
		//if ($this -> input -> get('id') != '') {
			$data['select_lead'] = $this -> pending_model -> select_lead_location();
			$data['pending_f_count_lead'] = $this -> pending_model -> select_lead_count_location();
			$data['id'] = $this -> input -> get('id');
			$data['role'] = $this -> input -> get('role');
	/*	} else {
			$data['select_lead'] = $this -> pending_model -> select_lead($this->role,$this->process_name,$this->user_id);
			$data['pending_f_count_lead'] = $this -> pending_model -> select_lead_count($this->role,$this->process_name,$this->user_id);
			$data['id'] = '';
		}*/

		$this -> load -> view('include/admin_header.php');
		if ($this -> input -> get('id') == '') {
			$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('telecaller_lms_view.php', $data);
		$this -> load -> view('include/footer.php');
	}


	public function telecaller_leads_not_attended() {
		$this -> session();
		$data['enq'] = "Pending New";

		//get pending Not attened leads details
		//if ($this -> input -> get('id') != '') {
			$data['select_lead'] = $this -> pending_model -> select_lead1_location();
			$data['pending_new_count_lead'] = $this -> pending_model -> select_lead1_count_location();
			//print_r($data['pending_new_count_lead']);
			$data['id'] = $this -> input -> get('id');
			$data['role'] = $this -> input -> get('role');
		/*} else {
			$data['select_lead'] = $this -> pending_model -> select_lead1($this->role,$this->process_name,$this->user_id);
			$data['pending_new_count_lead'] = $this -> pending_model -> select_lead1_count($this->role,$this->process_name,$this->user_id);
			$data['id'] = '';
		}*/

		$this -> load -> view('include/admin_header.php');
		if ($this -> input -> get('id') == '') {
			$this -> load -> view('notification_view.php', $data);
		}
		$this -> load -> view('telecaller_lms_view.php', $data);
		$this -> load -> view('include/footer.php');
	}
	public function search_pending_new() {
		$this -> session();
		$data['enq'] = "Pending New";

		//get pending Not attened leads details
	
			$data['select_lead'] = $this -> pending_model -> select_lead1_location();
			$data['pending_new_count_lead'] = $this -> pending_model -> select_lead1_count_location();
			$data['id'] = $this -> input -> get('id');
	

		
		$this -> load -> view('telecaller_followup_view.php', $data);
	
	}
public function search_pending_followup() {
		$this -> session();
		$data['enq'] = 'Pending Followup';
		//get pending attened leads details
	
			$data['select_lead'] = $this -> pending_model -> select_lead_location();
			$data['pending_f_count_lead'] = $this -> pending_model -> select_lead_count_location();
			$data['id'] = $this -> input -> get('id');
		
		
		$this -> load -> view('telecaller_followup_view.php', $data);
		
	}
		public function complaint_not_attended() {
			$this -> session();
			
			$data['enq'] = "Pending New";
			
			//get pending Not attened leads details
		
			$data['select_lead'] = $this -> pending_model -> select_lead_complaint_new();
			$data['pending_new_count_lead'] = $this -> pending_model -> select_lead_count_complaint_new();
			$data['id'] = $this -> input -> get('id');
			$data['role'] = $this -> input -> get('role');
			$this -> load -> view('include/admin_header.php');
			
			if ($this -> input -> get('id') == '') {
				$this -> load -> view('notification_view.php', $data);
			}
			$this -> load -> view('complaint_view.php', $data);
			$this -> load -> view('include/footer.php');
	}
		public function complaint_attended() {
			$this -> session();
			
			$data['enq'] = "Pending Followup";
			
			//get pending Not attened leads details
		
			$data['select_lead'] = $this -> pending_model -> select_lead_complaint_followup();
			$data['pending_f_count_lead'] = $this -> pending_model -> select_lead_count_complaint_followup();
			$data['id'] = $this -> input -> get('id');
			$data['role'] = $this -> input -> get('role');
			$this -> load -> view('include/admin_header.php');
			
			if ($this -> input -> get('id') == '') {
				$this -> load -> view('notification_view.php', $data);
			}
			$this -> load -> view('complaint_view.php', $data);
			$this -> load -> view('include/footer.php');
	}
		public function search_complaint_new() {

		$this -> session();
		$data['enq'] = "Pending New";
			
			//get pending Not attened leads details
		
			$data['select_lead'] = $this -> pending_model -> select_lead_complaint_new();
			$data['pending_new_count_lead'] = $this -> pending_model -> select_lead_count_complaint_new();
	$this -> load -> view('complaint_filter_view.php', $data);

	}
		public function search_complaint() {

		$this -> session();
	$data['enq'] = "Pending Followup";
			
	$data['select_lead'] = $this -> pending_model -> select_lead_complaint_followup();
			$data['pending_f_count_lead'] = $this -> pending_model -> select_lead_count_complaint_followup();
		
	$this -> load -> view('complaint_filter_view.php', $data);

	}
}
?>